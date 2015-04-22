<?php

namespace role\commands;

use Yii;

class RoleController extends \yii\console\Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;
        $authManager->removeAll();

        /**
         * Создание ролей.
         */
        // administrator
        $administrator = $authManager->createRole('administrator');
        $authManager->addRole($administrator);
        // user
        $user = $authManager->createRole('user');
        $authManager->addRole($user);


        /**
         * Описание привилегий.
         */
        // Редактирование сообщения
        $updatePost = $authManager->createPermission('updatePost');
        $updatePost->ruleName = 'updatePost';
        $authManager->addPermission($updatePost);
        // Редактирование профиля
        $updateProfile = $authManager->createPermission('updateProfile');
        $updateProfile->ruleName = 'updateProfile';
        $authManager->addPermission($updateProfile);

        /**
         * Связывание привилегий с ролями.
         */
        // Привилегии пользователя.
        $authManager->assign($user, $updatePost);
        $authManager->assign($user, $updateProfile);
        $authManager->assign($administrator, $updatePost);
        $authManager->assign($administrator, $updateProfile);
    }
}