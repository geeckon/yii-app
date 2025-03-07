<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\AddAccessLevelToConstructionSiteForm $model */

use app\models\AccessLevel;
use app\models\Role;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Add Access Level';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-add">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'add-construction-site-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= Html::activeLabel($model, 'access_level_id', ['label'=>'Access Levels', 'class'=>'col-lg-6 col-form-label mr-lg-6']) ?>
            <?= Html::activeDropDownList($model, 'access_level_id', ArrayHelper::map(AccessLevel::find()->all(), 'id', 'name'),
                ['prompt'=> '', 'class'=>'form-control']) ?>

            <?= $form->field($model, 'construction_site_id')->hiddenInput(['value' => $model->construction_site_id])->label(false) ?>

            <?= $form->errorSummary($model) ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
