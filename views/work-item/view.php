<?php

/** @var yii\web\View $this */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

$parentTitle = 'Work items';
$this->title = $model->name;
$this->params['breadcrumbs'][] = $parentTitle;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="work-items-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]);

    ?>

</div>
