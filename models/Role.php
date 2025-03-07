<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Role extends ActiveRecord
{
    public static function tableName()
    {
        return '{{roles}}';
    }

    public function getEmployees()
    {
        return $this->hasMany(Employee::class, ['role_id' => 'id']);
    }
}
