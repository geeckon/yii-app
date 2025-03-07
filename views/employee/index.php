<?php

/** @var yii\web\View $this */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-employees">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ]
        ]
    ]);

    ?>

    <?= Html::a('Add employee', ['/employee/add'], ['class'=>'btn btn-primary']) ?>


</div>
