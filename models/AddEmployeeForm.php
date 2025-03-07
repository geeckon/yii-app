<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Employee|null $employee
 *
 */
class AddEmployeeForm extends Model
{
    public $login;
    public $password;
    public $name;
    public $surname;
    public $birthday;
    public $role_id;
    public $manager_id;


    private $_employee = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // login and password are both required
            [['login', 'password', 'name', 'surname', 'birthday', 'role_id'], 'required'],
            ['manager_id', 'required', 'when' => function ($model) {
                return $model->role_id == 3;
            }],
            ['login', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6, 'max' => 20],
            ['name', 'string', 'min' => 2, 'max' => 50],
            ['surname', 'string', 'min' => 2, 'max' => 50],
            ['role_id', 'integer', 'min' => 1],
        ];
    }

    public function addEmployee()
    {
        $employee = new Employee();
        $employee->login = $this->login;
        $employee->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $employee->name = $this->name;
        $employee->surname = $this->surname;
        $employee->setBirthdayText($this->birthday);
        $employee->role_id = $this->role_id;
        if ($this->manager_id) {
            $employee->manager_id = $this->manager_id;
        }
        return $employee->save();
    }
}
