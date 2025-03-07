<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\EditWorkItemForm $model */

use app\models\ConstructionSite;
use app\models\Role;
use app\models\WorkItem;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Work Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'edit-work-item-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= Html::activeLabel($model, 'employee_id', ['label'=>'Employee', 'class'=>'col-lg-6 col-form-label mr-lg-6']) ?>
            <?= Html::activeDropDownList($model, 'employee_id', ArrayHelper::map(Role::find()->where(['name' => 'employee'])->one()->employees, 'id', 'name'),
                ['prompt'=> '', 'class'=>'form-control']) ?>

            <?= Html::activeLabel($model, 'construction_site_id', ['label'=>'Construction Site', 'class'=>'col-lg-6 col-form-label mr-lg-6']) ?>
            <?= Html::activeDropDownList($model, 'construction_site_id', ArrayHelper::map(ConstructionSite::find()->all(), 'id', 'name'),
                ['prompt'=> '', 'class'=>'form-control']) ?>

            <?= Html::activeLabel($model, 'work_item_id', ['label'=>'Work Item', 'class'=>'col-lg-6 col-form-label mr-lg-6']) ?>
            <?= Html::activeDropDownList($model, 'work_item_id', ArrayHelper::map(WorkItem::find()->all(), 'id', 'name'),
                ['prompt'=> '', 'class'=>'form-control']) ?>

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
