<?php

/** @var yii\web\View $this */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

$parentTitle = 'Construction Sites';
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
            'address',
            'size',
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
                            return Html::a('Remove', 'remove-access-level?constructionSiteId=' . $model->id . '&accessLevelId=' . $accessLevelModel->id);
                        } else {
                            return null;
                        }
                    }
                ]
            ]
        ]
    ]);

    echo Html::a('Add access level', ["/construction-site/add-access-level?constructionSiteId=$model->id"], ['class' => 'btn btn-primary'])

    ?>

</div>
