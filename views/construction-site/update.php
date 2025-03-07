<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\EditEmployeeForm $model */

use app\models\AccessLevel;
use app\models\Employee;
use app\models\Role;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Update Construction Site';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-update">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'edit-employee-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'address')->textInput() ?>
            <?= $form->field($model, 'size', ['inputOptions' => ['value' => Yii::$app->formatter->asDecimal($model->size)]]) ?>

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
