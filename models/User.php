<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use app\helpers\MarkdownParser;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $registration_ip
 * @property string $about
 * @property float $timezone
 * @property integer $number_posts
 * @property integer $last_posted_at
 * @property integer $last_email_sent
 * @property integer $created_at
 * @property integer $last_visited_at
 * @property string $activate_string
 * @property string $activate_key
 * @property integer $updated_at
 *
 * @property Group $group
 * @property Post[] $posts
 * @property string $displayAbout
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['g_id' => 'group_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['topic_id' => 'id'])
            ->inverseOf('user');
    }

    /**
     * Finds user model by the given email.
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user model by the given username.
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return sha1($this->salt);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function incrementPost()
    {
        $this->number_posts = $this->number_posts + 1;
    }

    public function decrementPost()
    {
        $this->number_posts = $this->number_posts - 1;
    }

    /**
     * @return string
     */
    public function getDisplayAbout()
    {
        $parsedown = new MarkdownParser();
        $text = $parsedown->text($this->about);

        return $text;
    }
}
