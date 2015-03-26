<?php

namespace app\components;

use Yii;
use app\models\Group;

/**
 * @property integer $groupID current user group identificator.
 * @property \app\models\User|\yii\web\IdentityInterface|null $identity
 *
 * @method \app\models\User|\yii\web\IdentityInterface|null getIdentity()
 */
class User extends \yii\web\User
{
    /**
     * @inheritdoc
     */
    protected function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);

        // first user log in.
        $user = $this->getIdentity();
        if ($user->role_id == Group::GROUP_UNVERIFIED) {
            $user->role_id = Group::GROUP_USER;
            $user->save();
        }
    }

    /**
     * Return group identificator.
     * @return integer
     */
    public function getGroupID()
    {
        return $this->isGuest ? Group::GROUP_GUEST : $this->getIdentity()->role_id;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->getIsGuest() ? Yii::$app->authManager->defaultRole : $this->getIdentity()->role;
    }

    /**
     * @inheritdoc
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if (!$this->getIsGuest()) {
            $auth = Yii::$app->getAuthManager();
            $role = $this->getIdentity()->role;

            return $auth->checkAccess($role, $permissionName, $params);
        }

        return false;
    }
}