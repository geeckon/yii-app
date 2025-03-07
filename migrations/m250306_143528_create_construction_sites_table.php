<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%construction_sites}}`.
 */
class m250306_143528_create_construction_sites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%construction_sites}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'address' => $this->string()->notNull(),
            'size' => $this->decimal()->notNull()->defaultValue(0)
        ]);

        $this->insert('{{%construction_sites}}', [
            'name' => 'Āgenskalna tirgus',
            'address' => 'Nometņu iela 64, Rīga',
            'size' => 2000
        ]);

        $this->insert('{{%construction_sites}}', [
            'name' => 'Riga waterfront',
            'address' => 'Eksporta iela 3A, Rīga',
            'size' => 4000
        ]);

        $this->insert('{{%construction_sites}}', [
            'name' => 'Vecais tornis, kuru jāspridzina',
            'address' => 'Rīgas iela 2, Aizkraukle',
            'size' => 12.5
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%construction_sites}}');
    }
}
