<?php

namespace app\controllers;

use Yii;
use yii\web\Controller as BaseController;

class Controller extends BaseController
{
    public function isAuth()
    {
        return !Yii::$app->user->isGuest;
    }
    public function isAdmin()
    {
        return $this->isAuth() && Yii::$app->user->getIdentity()->role->name == 'admin';
    }
    public function isManager()
    {
        return $this->isAuth() && Yii::$app->user->getIdentity()->role->name == 'manager';
    }
    public function isAdminOrManager()
    {
        return $this->isAdmin() || $this->isManager();
    }
    public function isEmployee()
    {
        return $this->isAuth() && Yii::$app->user->getIdentity()->role->name == 'employee';
    }
}
