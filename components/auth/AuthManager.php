<?php

namespace app\components\auth;

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;

class AuthManager extends \yii\base\Component
{
    /**
     * @var Connection|string
     */
    public $db = 'db';
    /**
     * @var string Имя таблицы хранящей связи между ролями и привилегиями.
     */
    public $assignmentTable = '{{%auth_assignment}}';
    /**
     * @var string Имя таблицы хранящей список ролей и привилегий.
     */
    public $itemTable = '{{%auth_item}}';
    /**
     * @var array permission list of current user role.
     */
    private $_permissions;
    /**
     * @var Role current user role.
     */
    private $_currentRole;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }

    /**
     * Проверка прав доступа к заданной операции.
     *
     * @param $userRole
     * @param $permissionName
     * @param array $params
     * @return boolean
     */
    public function checkAccess($userRole, $permissionName, array $params = [])
    {
        if ($userRole === null) {
            $userRole = $this->defaultRole;
        }

        if ($userRole == $permissionName) {
            if (!$this->_currentRole instanceof Role) {
                $this->_currentRole = $this->getItem($userRole);
            }

            return $this->executeRule($this->_currentRole, $params);
        }

        $permissions = $this->getPermissions($userRole);
        foreach ($permissions as $permission) {
            if ($permission->name == $permissionName) {
                return $this->executeRule($permission, $params);
            }
        }

        return false;
    }

    /**
     * Запуск правила.
     *
     * @param Item $item
     * @param array $params Параметры правила.
     * @return boolean
     */
    protected function executeRule($item, array $params = [])
    {
        if ($item->ruleName === null) {
            return true;
        }

        $object = new Rules;
        $method = $item->ruleName . 'Rule';

        if (method_exists($object, $method)) {
            return call_user_func_array([$object, $method], [$item, $params]);
        } else {
            throw new InvalidConfigException("Method '$method' not found in $object.");
        }
    }

    /**
     * Возвращает сущность по заданному имени.
     *
     * @param $name
     * @return array|boolean|null
     */
    public function hasItem($name)
    {
        $row = (new Query)->from($this->itemTable)
            ->where(['name' => $name])
            ->one($this->db);

        if ($row === false) {
            return false;
        }

        return true;
    }

    /**
     * Добавление новой сущности в систему.
     *
     * @param Permission|Role $object
     * @return boolean
     */
    protected function addItem($object)
    {
        $time = time();
        if ($object->createdAt === null) {
            $object->createdAt = $time;
        }
        if ($object->updatedAt === null) {
            $object->updatedAt = $time;
        }

        $this->db->createCommand()
            ->insert($this->itemTable, [
                'name' => $object->name,
                'type' => $object->type,
                'rule_name' => $object->ruleName,
                'created_at' => $object->createdAt,
                'updated_at' => $object->updatedAt,
            ])->execute();

        return true;
    }

    /**
     * Создание новой роли.
     * Созданный объект роли не добавляется сразу в систему.
     * Необходимо передать созданный объект привилегии в метод [[addRole()]] для добавления ее в систему.
     *
     * @param string $name Имя привилегии.
     * @return Role Новый объект привилегии.
     */
    public function createRole($name)
    {
        $role = new Role;
        $role->name = $name;
        return $role;
    }

    /**
     * Добавление роли с систему ролей.
     *
     * @param Role $role
     * @return boolean
     */
    public function addRole(Role $role)
    {
        if ($this->hasItem($role->name)) {
            throw new InvalidParamException("Cannot add a role with name: $role->name, because it isn't unique.");
        }

        $this->addItem($role);

        return true;
    }

    /**
     * Возвращает роль по заданому имени.
     *
     * @param string $name
     * @return Role|Permission
     */
    public function getItem($name)
    {
        $row = (new Query)->select('*')
            ->from($this->itemTable)
            ->where(['name' => $name])
            ->one($this->db);

        if ($row === false) {
            return false;
        }

        $item = new Item();
        $item->name = $row['name'];
        $item->type = $row['type'];
        $item->ruleName = $row['ruleName'];
        $item->createdAt = $row['createdAt'];
        $item->updatedAt = $row['updatedAt'];

        return $item;
    }

    /**
     * Создание нового объекта привилегии.
     * Созданный объект привилегии не добавляется сразу в систему.
     * Необходимо передать созданный объект привилегии в метод [[addPermission()]] для добавления ее в систему.
     *
     * @param string $name Имя привилегии.
     * @return Permission Новый объект привилегии.
     */
    public function createPermission($name)
    {
        $permission = new Permission();
        $permission->name = $name;
        return $permission;
    }

    /**
     * Добавление привилегии с систему ролей.
     *
     * @param Permission $permission
     * @return boolean
     */
    public function addPermission(Permission $permission)
    {
        if ($this->hasItem($permission->name)) {
            throw new InvalidParamException("Cannot add a permission with name: $permission->name, because it isn't unique.");
        }

        $this->addItem($permission);

        return true;
    }

    /**
     * Связвание между собой роли и привилегии.
     *
     * @param Role $role
     * @param Permission $permission
     * @return boolean
     */
    public function assign($role, $permission)
    {
        $this->db->createCommand()
            ->insert($this->assignmentTable, [
                'role' => $role->name,
                'permission' => $permission->name,
                'created_at' => time(),
            ])->execute();

        return true;
    }

    /**
     * Возвращает привилегии по заданной роли.
     *
     * @param $roleName
     * @return array
     */
    public function getPermissions($roleName)
    {
        if (empty($roleName)) {
            return [];
        }

        if (isset($this->_permissions)) {
            return $this->_permissions;
        }

        $query = (new Query)->select('b.*')
            ->from(['a' => $this->assignmentTable, 'b' => $this->itemTable])
            ->where('{{a}}.[[permission]]={{b}}.[[name]]')
            ->andWhere(['{{a}}.[[role]]' => (string) $roleName]);

        $this->_permissions = [];
        foreach ($query->all($this->db) as $row) {
            $this->_permissions[] = new Permission([
                'type' => $row['type'],
                'name' => $row['name'],
                'ruleName' => $row['rule_name'],
                'createdAt' => $row['created_at'],
                'updatedAt' => $row['updated_at'],
            ]);
        }

        return $this->_permissions;
    }

    /**
     * Удаление всех сущностей по заданному типу.
     *
     * @param integer $type тип сущности, должен быть Item::TYPE_PERMISSION или Item::TYPE_ROLE
     */
    protected function removeAllItems($type)
    {
        $this->db->createCommand()
            ->delete($this->itemTable, ['type' => $type])
            ->execute();
    }

    /**
     * Удаление всех ролей из системы.
     */
    public function removeAllRoles()
    {
        $this->removeAllItems(Item::TYPE_ROLE);
    }

    /**
     * Удаление всех привилегий из системы.
     */
    public function removeAllPermissions()
    {
        $this->removeAllItems(Item::TYPE_PERMISSION);
    }

    /**
     * Удаление всех данных из системы ролей.
     */
    public function removeAll()
    {
        $this->removeAllAssignments();
        $this->db->createCommand()->delete($this->itemTable)->execute();
    }

    /**
     * Удаление все связей (роль-привилегия) в системе.
     */
    public function removeAllAssignments()
    {
        $this->db->createCommand()->delete($this->assignmentTable)->execute();
    }
}