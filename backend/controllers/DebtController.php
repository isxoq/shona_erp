<?php

namespace backend\controllers;

use common\models\PartnerShopPays;
use soft\helpers\ArrayHelper;
use Yii;
use common\models\PartnerShops;
use common\models\PartnerShopsSearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DebtController extends SoftController
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
     * Lists all PartnerShops models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PartnerShopsSearch();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PartnerShops model.
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
     * Creates a new PartnerShops model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string
     */
    public function actionCreate()
    {
        $model = new PartnerShops();
        return $this->ajaxCrud->createAction($model);
    }

    /**
     * Updates an existing PartnerShops model.
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
     * Deletes an existing PartnerShops model.
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
     * Delete multiple existing PartnerShops model.
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
     * @return PartnerShops
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = PartnerShops::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }


    public function actionPayDebt($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);
        $params = [];
        $viewParams = [];

        $params['view'] = "_payDebt";

        if ($model->load($request->post())) {

            $partnerShopPays = new PartnerShopPays([
                "partner_shop_id" => $model->id,
                "amount" => $model->pay_amount
            ]);

            $partnerShopPays->save();

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
