<?php

namespace app\components;

use Yii;
use yii\db\ActiveRecord;
use app\models\Group;
use yii\helpers\ArrayHelper;

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
        if ($user->group_id == Group::GROUP_UNVERIFIED) {
            $user->group_id = Group::GROUP_USER;
            $user->save();
        }
    }

    /**
     * Return group identificator.
     * @return integer
     */
    public function getGroupID()
    {
        return $this->isGuest ? Group::GROUP_GUEST : $this->getIdentity()->group_id;
    }
}