<?php

namespace app\components;

use Yii;
use yii\base\InvalidConfigException;
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
     * @var @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     */
    public $db = 'db';
    /**
     * @var string config table name.
     */
    public $configTable = '{{%config}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }

    /**
     * Returns configuration value.
     * @param string $name name of the key config data.
     * @return string value of configuration
     * @throws InvalidConfigException
     */
    public function get($name)
    {
        $data = Yii::$app->cache->get('config');

        if ($data === false) {
            $rows = (new Query)->select('*')
                ->from($this->configTable)
                ->all($this->db);
            $data = ArrayHelper::map($rows, 'conf_name', 'conf_value');
            Yii::$app->cache->set('config', $data);
        }

        if (empty($data[$name])) {
            throw new InvalidConfigException('The key ' . $name . ' not found in table ' . $this->configTable . '.');
        }

        return $data[$name];
    }
}