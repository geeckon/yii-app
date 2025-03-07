<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%work_assignments}}`.
 */
class m250306_150207_create_work_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%work_assignments}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer()->notNull(),
            'manager_id' => $this->integer()->notNull(),
            'construction_site_id' => $this->integer()->notNull(),
            'work_item_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-work_assignments-employee_id}}',
            '{{%work_assignments}}',
            'employee_id',
        );
        $this->addForeignKey(
            '{{%fk-work_assignments-employee_id}}',
            '{{%work_assignments}}',
            'employee_id',
            '{{%employees}}',
            'id',
            'CASCADE',
        );
        $this->createIndex(
            '{{%idx-work_assignments-manager_id}}',
            '{{%work_assignments}}',
            'manager_id',
        );
        $this->addForeignKey(
            '{{%fk-work_assignments-manager_id}}',
            '{{%work_assignments}}',
            'manager_id',
            '{{%employees}}',
            'id',
            'CASCADE',
        );
        $this->createIndex(
            '{{%idx-work_assignments-construction_site_id}}',
            '{{%work_assignments}}',
            'construction_site_id',
        );
        $this->addForeignKey(
            '{{%fk-work_assignments-construction_site_id}}',
            '{{%work_assignments}}',
            'construction_site_id',
            '{{%construction_sites}}',
            'id',
            'CASCADE',
        );
        $this->createIndex(
            '{{%idx-work_assignments-work_item_id}}',
            '{{%work_assignments}}',
            'work_item_id'
        );
        $this->addForeignKey(
            '{{%fk-work_assignments-work_item_id}}',
            '{{%work_assignments}}',
            'work_item_id',
            '{{%work_items}}',
            'id',
            'CASCADE'
        );

        $this->insert('{{%work_assignments}}', [
            'employee_id' => 3,
            'manager_id' => 2,
            'construction_site_id' => 1,
            'work_item_id' => 2,
        ]);
        $this->insert('{{%work_assignments}}', [
            'employee_id' => 3,
            'manager_id' => 2,
            'construction_site_id' => 1,
            'work_item_id' => 4,
        ]);
        $this->insert('{{%work_assignments}}', [
            'employee_id' => 4,
            'manager_id' => 2,
            'construction_site_id' => 3,
            'work_item_id' => 3,
        ]);
        $this->insert('{{%work_assignments}}', [
            'employee_id' => 3,
            'manager_id' => 2,
            'construction_site_id' => 3,
            'work_item_id' => 4,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%work_assignments}}');
    }
}
