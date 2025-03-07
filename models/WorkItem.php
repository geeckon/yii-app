<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class WorkItem extends ActiveRecord
{
    public static function tableName()
    {
        return '{{work_items}}';
    }
}
