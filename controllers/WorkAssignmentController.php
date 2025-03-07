<?php

namespace app\controllers;

use app\models\AccessLevel;
use app\models\AddWorkAssignmentForm;
use app\models\ConstructionSite;
use app\models\EditWorkAssignmentForm;
use app\models\EditWorkItemForm;
use app\models\Employee;
use app\models\WorkAssignment;
use app\models\WorkItem;
use Yii;
use yii\data\ActiveDataProvider;

class WorkAssignmentController extends Controller
{
    public function actionIndex()
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if ($this->isAdminOrManager()) {
            $query = WorkAssignment::find()->with(['employee', 'manager', 'constructionSite', 'workItem']);
        } else {
            $query = WorkAssignment::find()->where(['employee_id' => Yii::$app->user->getId()])
                ->with(['employee', 'manager', 'constructionSite', 'workItem']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id)
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }

        $model = WorkAssignment::findOne($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = new AddWorkAssignmentForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $employee = Employee::findOne($model->employee_id);
            if ($employee->manager_id != Yii::$app->user->getId()) {
                Yii::$app->session->setFlash('danger', 'You are not this employee\'s manager!');
            }

            $constructionSite = ConstructionSite::findOne($model->construction_site_id);
            $neededAccessLevels = array_map(function ($accessLevel) { return $accessLevel->id; }, $constructionSite->accessLevels);
            $availableAccessLevels = array_map(function ($accessLevel) { return $accessLevel->id; }, $employee->accessLevels);
            $missingAccessLevels = array_diff($neededAccessLevels, $availableAccessLevels);
            if (count($missingAccessLevels) > 0) {
                $missingAccessLevelNames = array_map(function ($id) {
                    return AccessLevel::findOne($id)->name;
                }, $missingAccessLevels);

                Yii::$app->session->setFlash('danger',
                    'Employee is missing the following access levels for this construction site: ' .
                    implode(', ', $missingAccessLevelNames));
                return $this->render('add', [
                    'model' => $model,
                ]);
            }

            if ($model->addWorkAssignment()) {
                Yii::$app->session->setFlash('success', 'Work assignment added successfully!');
                return $this->redirect('index');
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $workAssignment = WorkAssignment::findOne($id);

        if (!$workAssignment) {
            Yii::$app->session->setFlash('danger', 'Work assignment not found!');
            return $this->redirect(['index']);
        }

        $model = new EditWorkAssignmentForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $employee = Employee::findOne($model->employee_id);
            if ($employee->manager_id != Yii::$app->user->getId()) {
                Yii::$app->session->setFlash('danger', 'You are not this employee\'s manager!');
            }

            $constructionSite = ConstructionSite::findOne($model->construction_site_id);
            $neededAccessLevels = array_map(function ($accessLevel) { return $accessLevel->id; }, $constructionSite->accessLevels);
            $availableAccessLevels = array_map(function ($accessLevel) { return $accessLevel->id; }, $employee->accessLevels);
            $missingAccessLevels = array_diff($neededAccessLevels, $availableAccessLevels);
            if (count($missingAccessLevels) > 0) {
                $missingAccessLevelNames = array_map(function ($id) {
                    return AccessLevel::findOne($id)->name;
                }, $missingAccessLevels);

                Yii::$app->session->setFlash('danger',
                    'Employee is missing the following access levels for this construction site: ' .
                    implode(', ', $missingAccessLevelNames));
                return $this->render('add', [
                    'model' => $model,
                ]);
            }

            if ($model->updateWorkAssignment($id)) {
                Yii::$app->session->setFlash('success', 'Work assignment edited successfully!');
                return $this->redirect('index');
            }
        }
        $model->employee_id = $workAssignment->employee_id;
        $model->construction_site_id = $workAssignment->construction_site_id;
        $model->work_item_id = $workAssignment->work_item_id;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isAdminOrManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = WorkAssignment::findOne($id);

        if (!$model) {
            Yii::$app->session->setFlash('danger', 'Work assignment not found!');
            return $this->redirect(['index']);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Work assignment deleted successfully!');
        return $this->redirect(['index']);
    }
}
