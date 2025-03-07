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
class AddAccessLevelToConstructionSiteForm extends Model
{
    public $construction_site_id;
    public $access_level_id;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['construction_site_id', 'access_level_id'], 'required'],
        ];
    }

    public function addAccessLevelToConstructionSite()
    {
        Yii::$app->db->createCommand("
            INSERT IGNORE INTO construction_site_access_level (construction_site_id, access_level_id)
            VALUES ('$this->construction_site_id', '$this->access_level_id');
        ")->execute();

        return true;
    }
}
