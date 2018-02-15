<?php

use yii\db\Migration;

class m171020_184729_user_role_add extends Migration
{
    public function Up()
    {
        $rbac = \Yii::$app->authManager;
        $guest = $rbac->createRole('guest');
        $guest->description = 'Гость! Имеет ряд ограничений!';
        $rbac->add($guest);
        //
        $user = $rbac->createRole('user');
        $user->description = 'Пользователь сайта, может что-то делать.';
        $rbac->add($user);
        //
        $admin = $rbac->createRole('admin');
        $admin->description = 'Администратор сайта, может абсолютно всё!';
        $rbac->add($admin);
        //
        $rbac->addChild($admin, $user);
        $rbac->addChild($user, $guest);
        //$rbac->assign($admin, \app\models\user\UserRecord::findOne(['username' => 'тут ваш юзер']));
        $rbac->assign($admin, \app\models\users\SystemUsersRecord::findOne(['username' => 'admin'])->id);
        $rbac->assign($user, \app\models\users\SystemUsersRecord::findOne(['username' => 'user'])->id);
    }

    public function safeDown()
    {
        $drop = Yii::$app->authManager;
        $drop->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171020_184729_user_role_add cannot be reverted.\n";

        return false;
    }
    */
}
