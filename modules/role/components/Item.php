<?php

namespace role\components;

class Item extends \yii\base\Object
{
    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;

    /**
     * @var integer item type, must be [[TYPE_ROLE]] or [[TYPE_PERMISSION]].
     */
    public $type;
    /**
     * @var string item name, must be unique.
     */
    public $name;
    /**
     * @var string rule name.
     */
    public $ruleName;
    /**
     * @var integer created time in UNIX timestamp format.
     */
    public $createdAt;
    /**
     * @var integer updateed time in UNIX timestamp format.
     */
    public $updatedAt;
}