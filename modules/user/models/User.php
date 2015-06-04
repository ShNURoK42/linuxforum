<?php

namespace user\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

use post\models\Post;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $role
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_change_token
 * @property integer $password_changed_at
 * @property string $username
 * @property string $email
 * @property boolean $email_status
 * @property string $about
 * @property integer $last_posted_at
 * @property integer $last_visited_at
 * @property integer $number_posts
 * @property double $timezone
 * @property boolean notify_mention_email
 * @property boolean notify_mention_web
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Post[] $posts
 * @property string $displayAbout
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const EMAIL_STATUS_ACTIVE = 1;
    const EMAIL_STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
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
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return string
     */
    public function getDisplayAbout()
    {
        $text = Yii::$app->formatter->asNtext($this->about);

        return $text;
    }
}
