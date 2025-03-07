<?php

namespace app\controllers;

use app\models\AddAccessLevelToConstructionSiteForm;
use app\models\AddConstructionSiteForm;
use app\models\ConstructionSite;
use app\models\EditConstructionSiteForm;
use Yii;
use yii\data\ActiveDataProvider;

class ConstructionSiteController extends Controller
{
    public function actionIndex()
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }

        return $this->render('index');
    }

    public function actionView($id)
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }

        $model = ConstructionSite::findOne($id);

        $dataProvider = new ActiveDataProvider([
            'query' => ConstructionSite::find()
                ->select('access_levels.*')
                ->leftJoin('construction_site_access_level', 'construction_site_access_level.construction_site_id = construction_sites.id')
                ->leftJoin('access_levels', 'access_levels.id = construction_site_access_level.access_level_id')
                ->where(['construction_sites.id' => $id])
        ]);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isAdmin()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = new AddConstructionSiteForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->addConstructionSite()) {
                Yii::$app->session->setFlash('success', 'Construction site ' . $model->name . ' added successfully!');
                return $this->render('index');
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
        if (!$this->isAdmin()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $constructionSite = ConstructionSite::findOne($id);

        if (!$constructionSite) {
            Yii::$app->session->setFlash('danger', 'Construction site not found!');
            return $this->redirect(['index']);
        }

        $model = new EditConstructionSiteForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->updateConstructionSite($id)) {
                Yii::$app->session->setFlash('success', 'Construction site ' . $model->name . ' edited successfully!');
                return $this->redirect('index');
            }
        }
        $model->name = $constructionSite->name;
        $model->address = $constructionSite->address;
        $model->size = $constructionSite->size;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isAdmin()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = ConstructionSite::findOne($id);

        if (!$model) {
            Yii::$app->session->setFlash('danger', 'Construction site not found!');
            return $this->redirect(['index']);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Construction site deleted successfully!');
        return $this->redirect(['index']);
    }

    public function actionAddAccessLevel($constructionSiteId)
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isAdminOrManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = new AddAccessLevelToConstructionSiteForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->addAccessLevelToConstructionSite()) {
                Yii::$app->session->setFlash('success', 'Access level added successfully!');
                return $this->redirect(['view', 'id' => $model->construction_site_id]);
            }
        }

        $model->construction_site_id = $constructionSiteId;

        return $this->render('addAccessLevel', [
            'model' => $model,
        ]);
    }

    public function actionRemoveAccessLevel($constructionSiteId, $accessLevelId)
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isAdminOrManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        Yii::$app->db->createCommand("
            DELETE FROM construction_site_access_level 
            WHERE construction_site_id = '$constructionSiteId' 
            AND access_level_id = '$accessLevelId'
        ")->execute();

        Yii::$app->session->setFlash('success', 'Access level removed successfully!');
        return $this->redirect(['view', 'id' => $constructionSiteId]);
    }

    public function actionCheckEmployees($id)
    {
        $constructionSite = ConstructionSite::findOne($id);
        if (!$constructionSite) {
            return $this->asJson([
                'error' => true,
                'message' => 'Construction site not found!',
            ]);
        }

        $addedManagers = [];
        $addedEmployees = [];

        $response = [
            'error' => false,
            'constructionSite' => $constructionSite->name,
            'managers' => [],
            'employees' => [],
        ];

        $workAssignments = $constructionSite->workAssignments;
        foreach ($workAssignments as $workAssignment) {
            $employee = $workAssignment->employee;
            $manager = $workAssignment->manager;

            if (!in_array($manager->id, $addedManagers)) {
                $addedManagers[] = $manager->id;
                $response['managers'][] = [
                    'name' => $manager->name,
                    'surname' => $manager->surname,
                ];
            }

            if (!in_array($employee->id, $addedEmployees)) {
                $addedEmployees[] = $employee->id;
                $response['employees'][] = [
                    'name' => $employee->name,
                    'surname' => $employee->surname,
                ];
            }
        }

        return $this->asJson($response);
    }
}
