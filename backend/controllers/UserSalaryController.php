<?php

namespace backend\controllers;

use common\models\Orders;
use common\models\OrderStates;
use common\models\PartnerShopPays;
use common\models\UserSalaryPayment;
use soft\helpers\ArrayHelper;
use Yii;
use common\models\UserSalary;
use common\models\UserSalarySearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserSalaryController extends SoftController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'bulk-delete' => ['POST'],
                ],
            ],
            /*'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ]*/
        ];
    }

    /**
     * Lists all UserSalary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSalarySearch();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserSalary model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud->viewAction($model);
    }

    /**
     * Creates a new UserSalary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string
     */
    public function actionCreate()
    {
        $model = new UserSalary();
        return $this->ajaxCrud->createAction($model);
    }

    /**
     * Updates an existing UserSalary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud->updateAction($model);
    }

    /**
     * Deletes an existing UserSalary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->ajaxCrud->closeModalResponse();
    }

    /**
     * Delete multiple existing UserSalary model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful,
     * the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }
        return $this->ajaxCrud->closeModalResponse();
    }

    /**
     * Finds a single model for crud actions
     * @param $id
     * @return UserSalary
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = UserSalary::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }

    public function actionCalculateSalary()
    {

        UserSalary::calculate();

        $returnLink = Yii::$app->request->referrer ?? ['index'];
        return $this->redirect($returnLink);
    }

    public function actionPay($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);
        $params = [];
        $viewParams = [];

        $params['view'] = "_pay";

        if ($model->load($request->post())) {


            $userSalaryPayment = new UserSalaryPayment([
                "salary_id" => $model->id,
                "user_id" => $model->user_id,
                "comment" => $model->pay_comment,
                "payment_type" => $model->pay_type,
                "amount" => $model->pay_amount
            ]);

            $userSalaryPayment->save();

            $forceClose = ArrayHelper::getValue($params, 'forceClose', true);
            if ($forceClose) {
                return $this->ajaxCrud->closeModal();
            } else {
                return $this->ajaxCrud->viewAction($model, ['footer' => $this->afterCreateFooter(), 'forceReload' => '#crud-datatable-pjax']);
            }

        } else {
            return $this->ajaxCrud->createModal($model, $params, $viewParams);
        }
    }
}
