<?php

namespace app\models;

use Yii;
use yii\base\Model;

class EditWorkAssignmentForm extends Model
{
    public $employee_id;
    public $manager_id;
    public $construction_site_id;
    public $work_item_id;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // login and password are both required
            [['employee_id', 'construction_site_id', 'work_item_id'], 'required'],
            ['employee_id', 'integer', 'min' => 1],
            ['construction_site_id', 'integer', 'min' => 1],
            ['work_item_id', 'integer', 'min' => 1],
        ];
    }

    public function updateWorkAssignment($id)
    {
        $workAssignment = WorkAssignment::findOne($id);
        $workAssignment->manager_id = Yii::$app->user->getId();
        $workAssignment->employee_id = $this->employee_id;
        $workAssignment->construction_site_id = $this->construction_site_id;
        $workAssignment->work_item_id = $this->work_item_id;
        return $workAssignment->save();
    }
}
