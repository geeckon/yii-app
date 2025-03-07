<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%construction_site_access_level}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%construction_site}}`
 * - `{{%access_level}}`
 */
class m250306_144235_create_junction_table_for_construction_site_and_access_level_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%construction_site_access_level}}', [
            'construction_site_id' => $this->integer(),
            'access_level_id' => $this->integer(),
            'PRIMARY KEY(construction_site_id, access_level_id)',
        ]);

        // creates index for column `construction_site_id`
        $this->createIndex(
            '{{%idx-construction_site_access_level-construction_site_id}}',
            '{{%construction_site_access_level}}',
            'construction_site_id'
        );

        // add foreign key for table `{{%construction_site}}`
        $this->addForeignKey(
            '{{%fk-construction_site_access_level-construction_site_id}}',
            '{{%construction_site_access_level}}',
            'construction_site_id',
            '{{%construction_sites}}',
            'id',
            'CASCADE'
        );

        // creates index for column `access_level_id`
        $this->createIndex(
            '{{%idx-construction_site_access_level-access_level_id}}',
            '{{%construction_site_access_level}}',
            'access_level_id'
        );

        // add foreign key for table `{{%access_level}}`
        $this->addForeignKey(
            '{{%fk-construction_site_access_level-access_level_id}}',
            '{{%construction_site_access_level}}',
            'access_level_id',
            '{{%access_levels}}',
            'id',
            'CASCADE'
        );

        $this->insert('{{%construction_site_access_level}}', [
            'construction_site_id' => 1,
            'access_level_id' => 1,
        ]);

        $this->insert('{{%construction_site_access_level}}', [
            'construction_site_id' => 2,
            'access_level_id' => 1,
        ]);

        $this->insert('{{%construction_site_access_level}}', [
            'construction_site_id' => 2,
            'access_level_id' => 2,
        ]);

        $this->insert('{{%construction_site_access_level}}', [
            'construction_site_id' => 3,
            'access_level_id' => 1,
        ]);

        $this->insert('{{%construction_site_access_level}}', [
            'construction_site_id' => 3,
            'access_level_id' => 3,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%construction_site}}`
        $this->dropForeignKey(
            '{{%fk-construction_site_access_level-construction_site_id}}',
            '{{%construction_site_access_level}}'
        );

        // drops index for column `construction_site_id`
        $this->dropIndex(
            '{{%idx-construction_site_access_level-construction_site_id}}',
            '{{%construction_site_access_level}}'
        );

        // drops foreign key for table `{{%access_level}}`
        $this->dropForeignKey(
            '{{%fk-construction_site_access_level-access_level_id}}',
            '{{%construction_site_access_level}}'
        );

        // drops index for column `access_level_id`
        $this->dropIndex(
            '{{%idx-construction_site_access_level-access_level_id}}',
            '{{%construction_site_access_level}}'
        );

        $this->dropTable('{{%construction_site_access_level}}');
    }
}
