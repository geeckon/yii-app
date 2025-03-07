<?php

namespace app\models;

use Yii;
use yii\base\Model;

class EditWorkItemForm extends Model
{
    public $name;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    public function updateWorkItem($id)
    {
        $workItem = WorkItem::findOne($id);
        $workItem->name = $this->name;
        return $workItem->save();
    }
}
