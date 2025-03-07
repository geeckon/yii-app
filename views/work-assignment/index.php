<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Work Assignments';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-work-assignments">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'label' => 'Manager',
                'value' => function($model) {
                    return $model->manager->name . ' ' . $model->manager->surname;
                }
            ],
            [
                'label' => 'Employee',
                'value' => function($model) {
                    return $model->employee->name . ' ' . $model->employee->surname;
                }
            ],
            [
                'label' => 'Construction site',
                'value' => function($model) {
                    return $model->constructionSite->name;
                },
            ],
            [
                'label' => 'Work item',
                'value' => function($model) {
                    return $model->workItem->name;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ]
        ]
    ]);

    ?>

    <?= Html::a('Add work assignment', ['/work-assignment/add'], ['class'=>'btn btn-primary']) ?>


</div>
