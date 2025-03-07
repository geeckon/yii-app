<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%access_levels}}`.
 */
class m250306_142842_create_access_levels_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%access_levels}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
        ]);

        $this->insert('access_levels', [
            'name' => 'Drīkst vilkt ķiveri',
        ]);

        $this->insert('access_levels', [
            'name' => 'Drīkst strādāt netālu no ēdiena',
        ]);

        $this->insert('access_levels', [
            'name' => 'Drīkst uzspridzināt lietas',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%access_levels}}');
    }
}
