<?php

use yii\db\Migration;
/*
 * Пароль для admin - administrator
 * Пароль для user - user
 * */
class m171019_184641_update_user extends Migration
{
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `system_users` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'fgM2988iwW-Qit96Ekb75aIjuQ0kW5FC', '$2y$13\$e2IttSNaoOf501o9E.xeuu.PU990AFXwG8NtQhJ1AshBWnVFDuTeK', NULL, 'admin@admin.ru', 10, 1509916236, 1509916236),
(2, 'user', 'MUEJkcdPwqIrefLmvTZtx7cFKj6VSEbD', '$2y$13\$Tm69n/FhkMlwhjtYV8yGTO0HZKt6VHOEyoug0D3K5EE8EL0HrXiVu', NULL, 'user@user.ru', 10, 1508364333, 1509919082);
        ");
    }

    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171019_184641_update_files_table cannot be reverted.\n";

        return false;
    }
    */
}
