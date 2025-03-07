<?php

namespace app\controllers;

use app\models\AddAccessLevelToEmployeeForm;
use app\models\AddEmployeeForm;
use app\models\AddWorkItemForm;
use app\models\EditEmployeeForm;
use app\models\EditWorkItemForm;
use app\models\Employee;
use app\models\Role;
use app\models\WorkItem;
use MongoDB\BSON\PackedArray;
use Yii;
use yii\data\ActiveDataProvider;

class WorkItemController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if (!$this->isAdminOrManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        return $this->render('index');
    }

    public function actionView($id)
    {
        if (!$this->isAdminOrManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = WorkItem::findOne($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {
        if (!$this->isAdmin()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = new AddWorkItemForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->addWorkItem()) {
                Yii::$app->session->setFlash('success', 'Work item ' . $model->name . ' added successfully!');
                return $this->render('index');
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$this->isAdmin()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $workItem = WorkItem::findOne($id);

        if (!$workItem) {
            Yii::$app->session->setFlash('danger', 'Work item not found!');
            return $this->redirect(['index']);
        }

        $model = new EditWorkItemForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->updateWorkItem($id)) {
                Yii::$app->session->setFlash('success', 'Work item ' . $model->name . ' edited successfully!');
                return $this->redirect('index');
            }
        }
        $model->name = $workItem->name;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        if (!$this->isAdmin()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = WorkItem::findOne($id);

        if (!$model) {
            Yii::$app->session->setFlash('danger', 'Work item not found!');
            return $this->redirect(['index']);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Work item deleted successfully!');
        return $this->redirect(['index']);
    }
}
