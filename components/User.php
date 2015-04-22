<?php

namespace app\components;

use Yii;

/**
 * @property integer $groupID current user group identificator.
 * @property \user\models\User|\yii\web\IdentityInterface|null $identity
 *
 * @method \user\models\User|\yii\web\IdentityInterface|null getIdentity()
 */
class User extends \yii\web\User
{
    /**
     * @inheritdoc
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if (!$this->getIsGuest()) {
            $auth = Yii::$app->getAuthManager();
            $user = $this->getIdentity();

            return $auth->checkAccess($user->role, $permissionName, $params);
        }

        return false;
    }
}