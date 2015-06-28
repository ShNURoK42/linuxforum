<?php

namespace common\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

/**
 * Class Config
 */
class Config extends \yii\base\Component
{
    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     */
    public $db = 'db';
    /**
     * @var string config table name.
     */
    public $configTable = '{{%config}}';
    /**
     * @var Cache|string the cache object or the application component ID of the cache object.
     */
    public $cache = 'cache';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());

        if (is_string($this->cache)) {
            $this->cache = Yii::$app->get($this->cache, false);
        }
    }

    /**
     * Returns configuration value.
     * @param string $name name of the key config data.
     * @return string value of configuration
     */
    public function get($name)
    {
        if ($this->cache instanceof Cache) {
            $key = __CLASS__;
            if (($data = $this->cache->get($key)) == false ) {
                $data = $this->getData();
                $this->cache->set($key, $data);
            }
        } else {
            $data = $this->getData();
        }

        if (empty($data[$name])) {
            throw new InvalidConfigException('The key ' . $name . ' not found in table ' . $this->configTable . '.');
        }

        return $data[$name];
    }

    /**
     * Returns configuration data.
     * @return array
     */
    protected function getData()
    {
        $rows = (new Query)
            ->select('*')
            ->from($this->configTable)
            ->all($this->db);

        return ArrayHelper::map($rows, 'name', 'value');
    }
}