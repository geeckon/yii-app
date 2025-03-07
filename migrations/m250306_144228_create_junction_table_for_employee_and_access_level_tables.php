<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee_access_level}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%employee}}`
 * - `{{%access_level}}`
 */
class m250306_144228_create_junction_table_for_employee_and_access_level_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee_access_level}}', [
            'employee_id' => $this->integer(),
            'access_level_id' => $this->integer(),
            'PRIMARY KEY(employee_id, access_level_id)',
        ]);

        // creates index for column `employee_id`
        $this->createIndex(
            '{{%idx-employee_access_level-employee_id}}',
            '{{%employee_access_level}}',
            'employee_id'
        );

        // add foreign key for table `{{%employee}}`
        $this->addForeignKey(
            '{{%fk-employee_access_level-employee_id}}',
            '{{%employee_access_level}}',
            'employee_id',
            '{{%employees}}',
            'id',
            'CASCADE'
        );

        // creates index for column `access_level_id`
        $this->createIndex(
            '{{%idx-employee_access_level-access_level_id}}',
            '{{%employee_access_level}}',
            'access_level_id'
        );

        // add foreign key for table `{{%access_level}}`
        $this->addForeignKey(
            '{{%fk-employee_access_level-access_level_id}}',
            '{{%employee_access_level}}',
            'access_level_id',
            '{{%access_levels}}',
            'id',
            'CASCADE'
        );

        $this->insert('{{%employee_access_level}}', [
            'employee_id' => 3,
            'access_level_id' => 1,
        ]);

        $this->insert('{{%employee_access_level}}', [
            'employee_id' => 3,
            'access_level_id' => 2,
        ]);

        $this->insert('{{%employee_access_level}}', [
            'employee_id' => 4,
            'access_level_id' => 1,
        ]);

        $this->insert('{{%employee_access_level}}', [
            'employee_id' => 4,
            'access_level_id' => 3,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%employee}}`
        $this->dropForeignKey(
            '{{%fk-employee_access_level-employee_id}}',
            '{{%employee_access_level}}'
        );

        // drops index for column `employee_id`
        $this->dropIndex(
            '{{%idx-employee_access_level-employee_id}}',
            '{{%employee_access_level}}'
        );

        // drops foreign key for table `{{%access_level}}`
        $this->dropForeignKey(
            '{{%fk-employee_access_level-access_level_id}}',
            '{{%employee_access_level}}'
        );

        // drops index for column `access_level_id`
        $this->dropIndex(
            '{{%idx-employee_access_level-access_level_id}}',
            '{{%employee_access_level}}'
        );

        $this->dropTable('{{%employee_access_level}}');
    }
}
