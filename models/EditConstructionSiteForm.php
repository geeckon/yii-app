<?php

namespace app\models;

use Yii;
use yii\base\Model;

class EditConstructionSiteForm extends Model
{
    public $name;
    public $address;
    public $size;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'address', 'size'], 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['address', 'string', 'min' => 2, 'max' => 255],
            ['size', 'number', 'min' => 1],
        ];
    }

    public function updateConstructionSite($id)
    {
        $constructionSite = ConstructionSite::findOne($id);
        $constructionSite->name = $this->name;
        $constructionSite->address = $this->address;
        $constructionSite->size = $this->size;
        return $constructionSite->save();
    }
}
