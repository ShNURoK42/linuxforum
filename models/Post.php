<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use app\helpers\MarkdownParser;

/**
 * This is the model class for table "posts".
 *
 * @property string $id
 * @property string $poster
 * @property string $poster_id
 * @property string $poster_ip
 * @property string $poster_email
 * @property string $message
 * @property integer $hde_smilies
 * @property string $posted
 * @property string $edited
 * @property string $edited_by
 * @property string $topic_id
 *
 * @property User $user
 * @property Topic $topic
 * @property string $parsedMessage
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'poster_id'])
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
    public function getParsedMessage()
    {
        $parsedown = new MarkdownParser();

        return $parsedown->text($this->message);
    }
}
