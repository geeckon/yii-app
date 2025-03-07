<?php

/** @var yii\web\View $this */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Work assignment';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="work-items-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]);

    ?>

</div>
