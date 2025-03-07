<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employees}}`.
 */
class m250306_140602_create_employees_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employees}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'name' => $this->string(50)->notNull(),
            'surname' => $this->string(50)->notNull(),
            'birthday' => $this->date()->notNull(),
            'role_id' => $this->integer()->notNull(),
            'manager_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-employees-role_id',
            'employees',
            'role_id'
        );

        $this->addForeignKey(
            'fk-employees-role_id',
            'employees',
            'role_id',
            'roles',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-employees-manager_id',
            'employees',
            'manager_id'
        );

        $this->addForeignKey(
            'fk-employees-manager_id',
            'employees',
            'manager_id',
            'employees',
            'id',
            'CASCADE'
        );

        $this->insert('employees', [
            'login' => 'admin',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'name' => 'John',
            'surname' => 'Smith',
            'birthday' => '1990-01-01',
            'role_id' => 1,
        ]);
        $this->insert('employees', [
            'login' => 'manager',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('manager'),
            'name' => 'Roger',
            'surname' => 'Stewart',
            'birthday' => '1995-11-22',
            'role_id' => 2,
        ]);
        $this->insert('employees', [
            'login' => 'billy',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('billy'),
            'name' => 'Billy',
            'surname' => 'Arrington',
            'birthday' => '1981-05-12',
            'role_id' => 3,
            'manager_id' => 2,
        ]);
        $this->insert('employees', [
            'login' => 'franklin',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('franklin'),
            'name' => 'Franklin',
            'surname' => 'Lanham',
            'birthday' => '2000-06-18',
            'role_id' => 3,
            'manager_id' => 2,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-employees-manager_id',
            'employees'
        );
        $this->dropIndex(
            'idx-employees-manager_id',
            'employees'
        );
        $this->dropForeignKey(
            'fk-employees-role_id',
            'employees'
        );
        $this->dropIndex(
            'idx-employees-role_id',
            'employees'
        );
        $this->dropTable('{{%employees}}');
    }
}
