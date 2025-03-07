<?php

namespace app\controllers;

use app\models\AddAccessLevelToEmployeeForm;
use app\models\AddEmployeeForm;
use app\models\EditEmployeeForm;
use app\models\Employee;
use app\models\Role;
use Yii;
use yii\data\ActiveDataProvider;

class EmployeeController extends Controller
{
    public function actionIndex()
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isAdminOrManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        if ($this->isManager()) {
            $query = Employee::find()->where(['manager_id' => Yii::$app->user->getId()])->with(['role', 'manager']);
        } else {
            $query = Employee::find()->with(['role', 'manager']);
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
        if (!$this->isAdminOrManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = Employee::findOne($id);

        $dataProvider = new ActiveDataProvider([
            'query' => Employee::find()
                ->select('access_levels.*')
                ->leftJoin('employee_access_level', 'employee_access_level.employee_id = employees.id')
                ->leftJoin('access_levels', 'access_levels.id = employee_access_level.access_level_id')
                ->where(['employees.id' => $id])
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

        $model = new AddEmployeeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $employeeRole = Role::find()->where(['name' => 'employee'])->one();
            if ($model->role_id == $employeeRole->id && !$model->manager_id) {
                Yii::$app->session->setFlash('danger', 'An employee needs a manager!');
                return $this->render('add', [
                    'model' => $model,
                ]);
            } else if ($model->role_id != $employeeRole->id && $model->manager_id) {
                Yii::$app->session->setFlash('danger', 'Only an employee needs a manager!');
                return $this->render('add', [
                    'model' => $model,
                ]);
            }

            if ($model->addEmployee()) {
                Yii::$app->session->setFlash('success', 'Employee ' . $model->name . ' added successfully!');
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

        $employee = Employee::findOne($id);

        if (!$employee) {
            Yii::$app->session->setFlash('danger', 'Employee not found!');
            return $this->redirect(['index']);
        }

        $model = new EditEmployeeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $employeeRole = Role::find()->where(['name' => 'employee'])->one();
            if ($model->role_id == $employeeRole->id && !$model->manager_id) {
                Yii::$app->session->setFlash('danger', 'An employee needs a manager!');
                return $this->render('add', [
                    'model' => $model,
                ]);
            } else if ($model->role_id != $employeeRole->id && $model->manager_id > 0) {
                Yii::$app->session->setFlash('danger', 'Only an employee needs a manager!');
                return $this->render('add', [
                    'model' => $model,
                ]);
            }

            if ($model->updateEmployee($id)) {
                Yii::$app->session->setFlash('success', 'Employee ' . $model->name . ' edited successfully!');
                return $this->redirect('index');
            }
        }
        $model->login = $employee->login;
        $model->name = $employee->name;
        $model->surname = $employee->surname;
        $model->birthday = $employee->birthday;
        $model->role_id = $employee->role_id;
        $model->manager_id = $employee->manager_id;

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

        $model = Employee::findOne($id);

        if (!$model) {
            Yii::$app->session->setFlash('danger', 'Employee not found!');
            return $this->redirect(['index']);
        }

        if (!Yii::$app->user->isGuest && Yii::$app->user->id == $id) {
            Yii::$app->session->setFlash('danger', 'Cannot delete yourself!');
            return $this->redirect(['index']);
        }

        if ($model->employees) {
            Yii::$app->session->setFlash('danger', 'Cannot delete manager that has employees!');
            return $this->redirect(['index']);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Employee deleted successfully!');
        return $this->redirect(['index']);
    }

    public function actionAddAccessLevel($employeeId)
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isAdminOrManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        $model = new AddAccessLevelToEmployeeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->addAccessLevelToEmployee()) {
                Yii::$app->session->setFlash('success', 'Access level added successfully!');
                return $this->redirect(['view', 'id' => $model->employee_id]);
            }
        }

        $model->employee_id = $employeeId;

        return $this->render('addAccessLevel', [
            'model' => $model,
        ]);
    }

    public function actionRemoveAccessLevel($employeeId, $accessLevelId)
    {
        if (!$this->isAuth()) {
            return $this->redirect('/site/login');
        }
        if (!$this->isAdminOrManager()) {
            Yii::$app->session->setFlash('danger', 'You don\'t have access to this page.');
            return $this->goHome();
        }

        Yii::$app->db->createCommand("
            DELETE FROM employee_access_level 
            WHERE employee_id = '$employeeId' 
            AND access_level_id = '$accessLevelId'
        ")->execute();

        Yii::$app->session->setFlash('success', 'Access level removed successfully!');
        return $this->redirect(['view', 'id' => $employeeId]);
    }
}
