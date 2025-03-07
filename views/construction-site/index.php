<?php

/** @var yii\web\View $this */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Construction Sites';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => \app\models\ConstructionSite::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

?>
<div class="employees">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'address',
            'size',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ]
        ]
    ]);

    ?>

    <?= Html::a('Add construction site', ['/construction-site/add'], ['class'=>'btn btn-primary']) ?>


</div>
