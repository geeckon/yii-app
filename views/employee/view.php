<?php

/** @var yii\web\View $this */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

$parentTitle = 'Employees';
$this->title = $model->name;
$this->params['breadcrumbs'][] = $parentTitle;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="employees-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'surname',
            'birthday',
            [
                'label' => 'Role',
                'value' => function($model) {
                    return $model->role->name;
                },
            ],
            [
                'label' => 'Manager',
                'value' => function($model) {
                    if ($model->manager) {
                        return $model->manager->name . ' ' . $model->manager->surname;
                    } else {
                        return null;
                    }
                }
            ],
        ],
    ]);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $accessLevelModel) use ($model) {
                        if ($accessLevelModel->id) {
                            return Html::a('Remove', 'remove-access-level?employeeId=' . $model->id . '&accessLevelId=' . $accessLevelModel->id);
                        } else {
                            return null;
                        }
                    }
                ]
            ]
        ]
    ]);

    echo Html::a('Add access level', ["/employee/add-access-level?employeeId=$model->id"], ['class' => 'btn btn-primary'])

    ?>

</div>
