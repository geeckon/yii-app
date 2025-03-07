<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class WorkAssignment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{work_assignments}}';
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    public function getManager()
    {
        return $this->hasOne(Employee::class, ['id' => 'manager_id']);
    }

    public function getConstructionSite()
    {
        return $this->hasOne(ConstructionSite::class, ['id' => 'construction_site_id']);
    }

    public function getWorkItem()
    {
        return $this->hasOne(WorkItem::class, ['id' => 'work_item_id']);
    }
}
