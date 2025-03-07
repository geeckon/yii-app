<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\AddEmployeeForm $model */

use app\models\Employee;
use app\models\Role;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Add Employee';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'add-employee-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'name')->textInput() ?>
            <?= $form->field($model, 'surname')->textInput() ?>
            <?= $form->field($model, 'birthday')->widget(\yii\jui\DatePicker::class,
                ['options' => ['class' => 'form-control'], 'clientOptions' => ['dateFormat' => 'YYYY-MM-DD']]) ?>

            <?= Html::activeLabel($model, 'role_id', ['label'=>'Role', 'class'=>'col-lg-6 col-form-label mr-lg-6']) ?>
            <?= Html::activeDropDownList($model, 'role_id', ArrayHelper::map(Role::find()->all(), 'id', 'name'),
                ['class'=>'form-control']) ?>

            <?= Html::activeLabel($model, 'manager_id', ['label'=>'Manager', 'class'=>'col-lg-6 col-form-label mr-lg-6']) ?>
            <?= Html::activeDropDownList($model, 'manager_id',
                ArrayHelper::map(Employee::find()->joinWith('role')->where(['roles.name' => 'Manager'])->all(), 'id', 'name'),
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
