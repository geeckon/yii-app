<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ConstructionSite extends ActiveRecord
{
    public static function tableName()
    {
        return '{{construction_sites}}';
    }

    public function getAccessLevels() {
        return $this->hasMany( AccessLevel::class, ['id' => 'access_level_id'])
            ->viaTable('{{%construction_site_access_level}}', ['construction_site_id' => 'id']);
    }

    public function getWorkAssignments()
    {
        return $this->hasMany(WorkAssignment::class, ['construction_site_id' => 'id']);
    }
}
