<?php

use yii\db\Migration;
use yii\helpers\Console;
use common\models\User;

/**
 * Class m211113_111426_add_admin_user
 */
class m211113_111426_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();
        $user->setPassword('123');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->username = 'admin';
        $user->email = 'admin@gmail.com';
        $user->status = User::STATUS_ACTIVE;

        $user->validate() && $user->save()
            ? Console::output('Success inserting admin!')
            : Console::output('Failed inserting admin!');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        User::deleteAll(['username' => 'admin']);
    }
}
