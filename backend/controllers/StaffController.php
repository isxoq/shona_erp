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

    public function actionTotalSalary()
    {
        return $this->render("_total_salary");
    }


}
