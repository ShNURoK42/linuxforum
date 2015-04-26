<?php

namespace post\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use app\helpers\MarkdownParser;
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
 * @property \yii\data\ActiveDataProvider $dataProvider
 * @property boolean $isTopicAuthor
 */
class Post extends \yii\db\ActiveRecord
{
    private $_isTopicAuthor;

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
        /** @var NotifyModule $notify */
        $notify = Yii::$app->getModule('notify');
        $notify->mentionHandler($this);

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
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }

    /**
     * @param $id
     * @return ActiveDataProvider
     */
    public static function getDataProviderByTopic($id)
    {
        $query = static::find()
            ->where(['topic_id' => $id])
            ->with('user')
            ->orderBy(['created_at' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeLimit' => false,
                'defaultPageSize' => Yii::$app->config->get('display_posts_count'),
            ],
        ]);

        return $dataProvider;
    }

    public function getIsTopicAuthor()
    {
        if (isset($this->_isTopicAuthor)) {
            return $this->_isTopicAuthor;
        }

        return false;
    }

    public function setIsTopicAuthor($value)
    {
        $this->_isTopicAuthor = (bool) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayMessage()
    {
        $parsedown = new MarkdownParser();

        return $parsedown->parse($this->message);
    }
}
