<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "users".
 *
 * @property string $id user identificator.
 * @property string $group_id user group.
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $title
 * @property string $realname
 * @property string $url
 * @property string $facebook
 * @property string $twitter
 * @property string $linkedin
 * @property string $skype
 * @property string $jabber
 * @property string $icq
 * @property string $msn
 * @property string $aim
 * @property string $yahoo
 * @property string $location
 * @property string $signature
 * @property integer $email_setting
 * @property integer $notify_with_post
 * @property integer $auto_notify
 * @property integer $show_smilies
 * @property integer $show_img
 * @property integer $show_img_sig
 * @property integer $show_avatars
 * @property integer $show_sig
 * @property integer $access_keys
 * @property double $timezone
 * @property string $language
 * @property string $style
 * @property string $num_posts
 * @property string $last_post
 * @property string $last_search
 * @property string $last_email_sent
 * @property string $registered
 * @property string $registration_ip
 * @property string $last_visit
 * @property string $activate_string
 * @property string $activate_key
 * @property integer $pun_pm_new_messages
 * @property integer $pun_pm_long_subject
 * @property integer $avatar
 * @property integer $avatar_width
 * @property integer $avatar_height
 * @property integer $stick_favorites
 * @property integer $enable_pm_email
 * @property string $birthday
 * @property integer $bday_email
 *
 * @property Group $group
 * @property Post[] $posts
 *
 * @property string $displayTitle
 * @property integer $commonTimezone
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
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

    /**
     * @return string
     */
    public function getDisplayTitle()
    {
        $formatter = Yii::$app->formatter;
        if (isset($this->title)) {
            $title = $formatter->asText($this->title);
        } elseif (isset($this->group->g_user_title)) {
            $title = $formatter->asText($this->group->g_user_title);
        } elseif ($this->group_id == 2) {
            $title = Yii::t('app/common', 'Guest');
        } else {
            $title = Yii::t('app/common', 'Member');
        }

        return $title;
    }

    /**
     * @return integer
     */
    public function getCommonTimezone()
    {
        if (!isset($this->timezone)) {
            return Yii::$app->config->get('o_default_timezone');
        }

        return $this->timezone;
    }
}
