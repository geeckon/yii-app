<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%work_items}}`.
 */
class m250306_145649_create_work_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%work_items}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);

        $this->insert('{{%work_items}}', [
            'name' => 'Ieliet pamatus'
        ]);
        $this->insert('{{%work_items}}', [
            'name' => 'Salabot jumtu'
        ]);
        $this->insert('{{%work_items}}', [
            'name' => 'Uzpridzināt ēku'
        ]);
        $this->insert('{{%work_items}}', [
            'name' => 'Izvest būvgružus'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%work_items}}');
    }
}
