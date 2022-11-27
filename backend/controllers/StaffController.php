<?php

namespace backend\controllers;

use Yii;
use soft\web\SoftController;

class StaffController extends SoftController
{

    public function actionSalary()
    {
        return $this->render("_salary");
    }
}
