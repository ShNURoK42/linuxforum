<?php

namespace post\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use common\helpers\MarkdownParser;
use topic\models\Topic;
use user\models\User;
use notify\Module as NotifyModule;


/**
 * @property integer $id
 * @property integer $topic_id
 * @property integer $user_id
 * @property integer $user_ip
 * @property string $message
 * @property integer $created_at
 * @property integer $edited_at
 * @property integer $edited_by
 *
 * @property \user\models\User $user
 * @property \topic\models\Topic $topic
 * @property string $displayMessage
 * @property boolean $isTopicAuthor
 * @property boolean $isFirstPost
 */
class Post extends \yii\db\ActiveRecord
{
    const EVENT_CREATE_POST = 'createPost';

    private $_isTopicAuthor;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->on(self::EVENT_CREATE_POST, [$this, 'sendMail']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
            $this->user_ip = ip2long(Yii::$app->getRequest()->getUserIP());
            $this->user_id = Yii::$app->getUser()->getIdentity()->getId();

            $currentUser = Yii::$app->getUser()->getIdentity();
            $currentUser->updateCounters(['number_posts' => 1]);
            $currentUser->last_posted_at = time();
            $currentUser->save();
        } else {
            
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->topic_id > 0) {
            /** @var NotifyModule $notify */
            $notify = Yii::$app->getModule('notify');
            $notify->mentionHandler($this);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->inverseOf('posts');
    }

    /**
     * @return ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id'])
            ->inverseOf('posts');
    }

    public function getIsFirstPost()
    {
        return $this->topic->firstPost->id == $this->id;
    }

    public function getIsTopicAuthor()
    {
        return $this->topic->first_post_user_id == $this->user_id;
    }

    /**
     * @return string
     */
    public function getDisplayMessage()
    {
        $parsedown = new MarkdownParser();

        return $parsedown->parse($this->message);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDataProvider($params)
    {
        $query = Post::find()
            ->with('user', 'topic')
            ->orderBy(['created_at' => SORT_ASC]);

        if($params['topic_id']) {
            $query->andWhere(['topic_id' => $params['topic_id']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'route' => '/topic/default/view',
                'params' => [
                    'id' => $params['topic_id'],
                    'page' => $params['page'],
                ],
                'forcePageParam' => false,
                'pageSizeLimit' => false,
                'defaultPageSize' => Yii::$app->config->get('display_posts_count'),
            ],
        ]);

        $dataProvider->prepare();

        return $dataProvider;
    }
}
