<?php

namespace backend\controllers;

use api\components\Phone;
use common\models\Clients;
use common\models\Order;
use common\models\ProductSales;
use soft\helpers\ArrayHelper;
use Yii;
use common\models\Orders;
use common\models\OrdersSearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class OrdersController extends SoftController
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
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();

        $searchModel->order_type = Order::TYPE_SIMPLE;
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
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
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Orders();

        $request = Yii::$app->request;

        if ($model->load($request->post())) {

            if (!$model->client_id) {
                $client = Clients::findOne(['phone' => Phone::clear($model->client_phone)]);
                if (!$client) {
                    $client = new Clients([
                        "full_name" => $model->client_fullname,
                        "phone" => Phone::clear($model->client_phone),
                        "address" => $model->client_address,
                    ]);
                    $client->save();
                }
                $model->client_id = $client->id;
            }

            $model->order_type = Orders::TYPE_SIMPLE;
            $model->client_phone = Phone::clear($model->client_phone);
            $model->save();

//            dd($model->order_products);

            $model->createProductSales();

            $returnUrl = ['view', 'id' => $model->id];
            return $this->redirect($returnUrl);
        }

        return $this->render("create", [
            'model' => $model
        ]);

    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->order_products = $model->salesProducts;
        $request = Yii::$app->request;

        if ($model->load($request->post())) {


            if (!$model->client_id) {
                $client = Clients::findOne(['phone' => Phone::clear($model->client_phone)]);
                if (!$client) {
                    $client = new Clients([
                        "full_name" => $model->client_fullname,
                        "phone" => Phone::clear($model->client_phone),
                        "address" => $model->client_address,
                    ]);
                    $client->save();
                }
                $model->client_id = $client->id;
            }

            $model->order_type = Orders::TYPE_SIMPLE;
            $model->client_phone = Phone::clear($model->client_phone);
            $model->save();

            ProductSales::deleteAll(['order_id' => $model->id]);
            $model->createProductSales();


            $returnUrl = ['view', 'id' => $model->id];
            return $this->redirect($returnUrl);
        }

        return $this->render("update", [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Orders model.
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
     * Delete multiple existing Orders model.
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
     * @return Orders
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Orders::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }

    public function actionGetClientInfo($id)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        return Clients::findOne($id);
    }

    public function actionChangeStatus($id)
    {

        $request = Yii::$app->request;

        $model = $this->findModel($id);
        $params = [];
        $viewParams = [];

        $params['view'] = "_changeStatus";

        if ($model->load($request->post()) && $model->save()) {

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
