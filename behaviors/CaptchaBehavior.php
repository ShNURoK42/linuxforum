<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\Model;
use yii\db\Connection;
use yii\di\Instance;

/**
 * @property boolean $isShow
 * @property boolean $isNeedValidate
 */
class CaptchaBehavior extends Behavior
{
    /**
     * @var Model
     */
    public $owner;
    /**
     * @var string table name.
     */
    public $table = '{{%spy_entry}}';
    /**
     * @var string
     */
    public $attribute = 'verifyCode';
    /**
     * @var integer
     */
    public $attemptsLimit = 3;
    /**
     * @var Connection
     */
    public $db = 'db';
    /**
     * @var integer
     */
    private $_attemptsCount;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Model::EVENT_AFTER_VALIDATE => 'afterValidate',
        ];
    }
    /**
     * @return boolean
     */
    public function getIsShow()
    {
        if ($this->getCountAttempts() >= $this->attemptsLimit) {
            return true;
        }

        return false;
    }

    /**
      * @return boolean
     */
    public function getIsNeedValidate()
    {
        if ($this->getCountAttempts() > $this->attemptsLimit) {
            return true;
        }

        return false;
    }

    /**
     * @return boolean
     */
    public function addAttempt()
    {
        $this->db->createCommand()
            ->insert($this->table, [
                'ip' => ip2long(Yii::$app->getRequest()->getUserIP()),
                'form' => $this->owner->formName(),
                'created_at' => time(),
            ])->execute();

        return true;
    }

    /**
     * @return integer
     */
    public function removeAttempts()
    {
        $ip = ip2long(Yii::$app->getRequest()->getUserIP());
        $this->db->createCommand()
            ->delete($this->table, ['ip' => $ip])
            ->execute();
    }

    /**
     * @return integer
     */
    protected function getCountAttempts()
    {
        if (!isset($this->_attemptsCount)) {
            $sql = "SELECT COUNT(*) FROM $this->table WHERE form='" . $this->owner->formName() ."'";
            $this->_attemptsCount = $this->db->createCommand($sql)
                ->queryScalar();
        }

        return $this->_attemptsCount;
    }

    /**
     * @param Event $event event parameter.
     */
    public function afterValidate($event)
    {
        if (!$this->getIsNeedValidate()) {
            $this->owner->clearErrors($this->attribute);
        }

        if ($this->owner->hasErrors()) {
            $this->addAttempt();
        } else {
            $this->removeAttempts();
        }
    }
}
