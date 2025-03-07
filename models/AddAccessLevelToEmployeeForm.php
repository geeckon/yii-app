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
class AddAccessLevelToEmployeeForm extends Model
{
    public $employee_id;
    public $access_level_id;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['employee_id', 'access_level_id'], 'required'],
        ];
    }

    public function addAccessLevelToEmployee()
    {
        Yii::$app->db->createCommand("
            INSERT IGNORE INTO employee_access_level (employee_id, access_level_id)
            VALUES ('$this->employee_id', '$this->access_level_id');
        ")->execute();

        return true;
    }
}
