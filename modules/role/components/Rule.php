<?php

namespace role\components;

abstract class Rule extends \yii\base\Object
{
    /**
     * @var string Имя правила.
     */
    public $name;
    /**
     * @var integer Время создания в формате UNIX timestamp
     */
    public $createdAt;
    /**
     * @var integer Время обновления записи в формате UNIX timestamp
     */
    public $updatedAt;


    /**
     * Executes the rule.
     */
    abstract public function execute($item, $params);
}
