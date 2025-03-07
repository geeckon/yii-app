<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read WorkItem|null $workItem
 *
 */
class AddWorkItemForm extends Model
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

    public function addWorkItem()
    {
        $workItem = new WorkItem();
        $workItem->name = $this->name;
        return $workItem->save();
    }
}
