<?php

/** @var yii\web\View $this */

use app\models\WorkItem;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Work Items';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => WorkItem::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

?>
<div class="site-work-items">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ]
        ]
    ]);

    ?>

    <?= Html::a('Add work item', ['/work-item/add'], ['class'=>'btn btn-primary']) ?>


</div>
