<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use app\helpers\MarkdownParser;

/**
 * @property integer $id
 * @property integer $topic_id
 * @property integer $user_id
 * @property integer $user_ip
 * @property string $message
 * @property integer $created_at
 * @property integer $edited_at
 * @property integer $edited_by
 * @property integer $status
 *
 * @property User $user
 * @property Topic $topic
 * @property string $dysplayMessage
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
            $this->user_ip = ip2long(Yii::$app->getRequest()->getUserIP());
            $this->user_id = Yii::$app->getUser()->getIdentity()->getId();
        }

        return parent::beforeSave($insert);
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
     * @return string
     */
    public function getDisplayMessage()
    {
        $parsedown = new MarkdownParser();
        $text = $parsedown->text($this->text);

        return $text;
    }
}
