<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class AccessLevel extends ActiveRecord
{
    public static function tableName()
    {
        return '{{access_levels}}';
    }

    public function getConstructionSites() {
        return $this->hasMany( ConstructionSite::class, ['id' => 'construction_site_id'])
            ->viaTable('{{%construction_site_access_level}}', ['access_level_id' => 'id']);
    }

    public function getEmployees() {
        return $this->hasMany( Employee::class, ['id' => 'employee_id'])
            ->viaTable('{{%employee_access_level}}', ['access_level_id' => 'id']);
    }
}
