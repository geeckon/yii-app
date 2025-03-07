<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roles}}`.
 */
class m250306_134403_create_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%roles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->unique(),
        ]);

        $this->insert('roles', [
            'name' => 'admin',
        ]);
        $this->insert('roles', [
            'name' => 'manager',
        ]);
        $this->insert('roles', [
            'name' => 'employee',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%roles}}');
    }
}
