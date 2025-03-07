<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Employee extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
    public static function tableName()
    {
        return '{{employees}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return Employee::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return Employee::findOne(['accessToken' => $token]);
    }

    /**
     * Finds employee by login
     *
     * @param string $login
     * @return static|null
     */
    public static function findByLogin($login)
    {
        return Employee::findOne(['login' => $login]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current employee
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function getBirthdayText()
    {
        return date('Y/m/d', $this->birthday);
    }

    public function setBirthdayText($value)
    {
        $this->birthday = date('y-m-d', strtotime($value));
    }

    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    public function getManager()
    {
        return $this->hasOne(Employee::class, ['id' => 'manager_id']);
    }

    public function getEmployees()
    {
        return $this->hasMany(Employee::class, ['manager_id' => 'id']);
    }

    public function getAccessLevels() {
        return $this->hasMany( AccessLevel::class, ['id' => 'access_level_id'])
            ->viaTable('{{%employee_access_level}}', ['employee_id' => 'id']);
    }
}
