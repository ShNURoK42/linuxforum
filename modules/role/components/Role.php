<?php

namespace role\components;

/**
 * @property integer $id Идентификационный номер
 */
class Role extends Item
{
    /**
     * @inheritdoc
     */
    public $type = self::TYPE_ROLE;
}