<?php

use yii\db\Migration;

class m171020_183943_user_role extends Migration
{

    public function safeUp()
    {
        $this->execute(
            file_get_contents(
                \Yii::getAlias('@yii/rbac/migrations/schema-mysql.sql')
            )
        );
    }

    public function safeDown()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        if ($this->isMSSQL()) {
            $this->execute('DROP TRIGGER dbo.trigger_auth_item_child;');
        }

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171020_183943_user_role cannot be reverted.\n";

        return false;
    }
    */
}
