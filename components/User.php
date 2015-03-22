<?php

namespace app\components;

use Yii;
use app\models\Group;

/**
 * @property \app\models\User|\yii\web\IdentityInterface|null $identity
 * @property integer $groupID current user group identificator.
 * @property boolean $isAdmMod
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
}