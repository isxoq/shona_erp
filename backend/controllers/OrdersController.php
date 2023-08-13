<?php

namespace backend\controllers;

use api\components\Phone;
use backend\modules\usermanager\models\User;
use common\components\Statistics;
use common\models\Clients;
use common\models\Order;
use common\models\OrderStates;
use common\models\PartnerShops;
use common\models\Products;
use common\models\ProductSales;
use common\models\UserFine;
use common\models\UserRevenue;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use soft\helpers\ArrayHelper;
use Yii;
use common\models\Orders;
use common\models\OrdersSearch;
use soft\web\SoftController;
use yii\db\Expression;
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


    public function actionCalculateSalary()
    {
        ;
        $searchModel = new OrdersSearch();

        $searchModel->order_type = Order::TYPE_SIMPLE;

        $dataProvider = $searchModel->search(null, 10, Yii::$app->request->queryParams[1] ?? []);


        $orders = $dataProvider->query->all();

        foreach ($orders as $order) {
            Orders::runSalaryCalculate($order, $order->created_at);
        }

        return $this->back();


    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {


        $searchModel = new OrdersSearch();

        $searchModel->order_type = Order::TYPE_SIMPLE;

        if (Yii::$app->user->identity->checkRoles(["Operator", "Diller"])) {
            $searchModel->operator_diller_id = Yii::$app->user->id;
        }


        if (Yii::$app->user->identity->checkRoles(["Ta'minotchi"])) {
            $searchModel->taminotchi_id = Yii::$app->user->id;
        }


        $dataProvider = $searchModel->search();

        $filterSales = Statistics::calculateOrdersSales($dataProvider->query->all());
        $filterBenefit = Statistics::calculateOrdersBenefits($dataProvider->query->all());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'filterSales' => $filterSales,
            'filterBenefit' => $filterBenefit,
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
            $model->operator_diller_id = Yii::$app->user->id;
            $model->save();


            $model->createPartnerFees();
            $model->createProductSales();

            $returnUrl = ['index'];
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
        $model->partner_fees = $model->partnerFees;
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


//            foreach ($model->order_products as $item) {
//                if ($item['product_id'] && $item['product_source'] && $item['count']) {
//                    $partnerShop = PartnerShops::findOne($item['product_source']);
//                    if ($partnerShop->is_main) {
//                        $productModel = Products::findOne($item['product_id']);
//                        $mainStoreCount = $productModel->getProductToStores()->sum("quantity") - $productModel->salesCountWithoutOrder($model->id);
//                        if ($mainStoreCount < $item['count']) {
//                            $model->addError("order_products", "Mahsulotlar asosiy omborda yetarli emas!");
//                            return $this->render("update", [
//                                'model' => $model
//                            ]);
//                        }
//                    }
//                } else {
//                    $model->addError("order_products", "Mahsulotlar soni 0 dan katta bo'lishi kerak!");
//                    return $this->render("update", [
//                        'model' => $model
//                    ]);
//                }
//            }


            $model->save();
            ProductSales::deleteAll(['order_id' => $model->id]);

            $model->createPartnerFees();
            $model->createProductSales();

            $returnUrl = ['index'];
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

            Orders::runSalaryCalculate($model);

            $state = new OrderStates([
                "order_id" => $model->id,
                "user_id" => user("id"),
                "state_id" => $model->status,
            ]);
            $state->save();


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

    public function actionAcceptOrder($id)
    {
        $request = Yii::$app->request;
        $order = $this->findModel($id);
        $params = [];
        $viewParams = [];
        if ($order->taminotchi_id != null) {
            Yii::$app->session->setFlash("alreadyAccepted", "Ushbu buyurtma boshqa taminotchi tomonidan qabul qilib bo'lingan!");
            return $this->ajaxCrud->viewAction($order, ['footer' => $this->afterCreateFooter(), 'forceReload' => '#crud-datatable-pjax']);
        }

        $order->taminotchi_id = Yii::$app->user->id;
        $order->save();
        Yii::$app->session->setFlash("successfullyAccepted", "Muvaffaqiyatli qabul qilindi!");
        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionExportData()
    {

        $searchModel = new OrdersSearch();
        $searchModel->order_type = Order::TYPE_SIMPLE;
        $dataProvider = $searchModel->search(null, 10, Yii::$app->request->queryParams[1] ?? []);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

//        $query = Products::find();
//        $query->joinWith("productToStores");
//        $query->andWhere([">", 'product_imports.quantity', 0]);

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setCellValue("A1", "ID");
        $sheet->setCellValue("B1", "Yaratildi");
        $sheet->setCellValue("C1", "Operator/Diller");
        $sheet->setCellValue("D1", "Ta'minotchi");
        $sheet->setCellValue("E1", "Mijoz telefoni");
        $sheet->setCellValue("F1", "Address");
        $sheet->setCellValue("G1", "Miqdor");
        $sheet->setCellValue("H1", "Yetkazish");
        $sheet->setCellValue("I1", "Foyda");
        $sheet->setCellValue("J1", "To'lov turi");
        $sheet->setCellValue("K1", "Mahsulotlar");
        $sheet->setCellValue("L1", "Hamkordan to'lovlar");
        $sheet->setCellValue("M1", "Status");
        $i = 2;

        foreach ($dataProvider->query->all() as $item) {
            if ($item->delivery) {
                $delivery = $item->delivery->name . PHP_EOL . Yii::$app->formatter->asSum($item->delivery_price);
            } else {
                $delivery = "";
            }
            $sheet->setCellValue("A{$i}", $item->id);
            $sheet->setCellValue("B{$i}", date("d.m.Y", $item->created_at));
            $sheet->setCellValue("C{$i}", $item->operatorFullName);
            $sheet->setCellValue("D{$i}", $item->taminotchiFullName);
            $sheet->setCellValue("E{$i}", "+" . $item->client_phone);
            $sheet->setCellValue("F{$i}", $item->client_address);
            $sheet->setCellValue("G{$i}", $item->amount);
            $sheet->setCellValue("H{$i}", $delivery);
            $sheet->setCellValue("I{$i}", $item->benefit);
            $sheet->setCellValue("J{$i}", $item->paymentType->name);

            $text = "";
            foreach ($item->salesProducts as $salesProduct) {
                $text .= "{$salesProduct->product?->name} {$salesProduct->count} ta. {$salesProduct->sold_price} UZS. {$salesProduct->partnerShop?->name} - {$salesProduct->partner_shop_price} UZS " . PHP_EOL;
            }

            $sheet->setCellValue("K{$i}", $text);


            $partnerFeeText = "";
            foreach ($item->partnerFees as $partnerFee) {
                $partnerFeeText .= "{$partnerFee->partner?->name} - {$partnerFee->amount} UZS " . PHP_EOL;
            }
            $sheet->setCellValue("L{$i}", $partnerFeeText);


            $sheet->setCellValue("M{$i}", $item->statusBtn);

//            $sheet->setCellValue("C{$i}", "Dokon");
//            $sheet->setCellValue("D{$i}", $item->getProductToStores()->sum("quantity") - $item->salesCount);
            $i++;
        }

//        dd($query->all());

        $writer = new Xlsx($spreadsheet);
        $writer->save('export.xlsx');

        return Yii::$app->response->sendFile("export.xlsx");
    }

    public function actionFaktura($id)
    {
        $order = Orders::findOne($id);
        return $this->renderAjax("faktura", [
            'order' => $order
        ]);
    }

    public function runSalaryCalculate(Orders $order)
    {
        switch ($order->status) {
            case Orders::STATUS_DELIVERED:
            {

                // Operatorga oylik va zarar yozish
                $revenue = UserRevenue::find()
                    ->andWhere(['order_id' => $order->id])
                    ->andWhere(['user_id' => $order->operator_diller_id])
                    ->one();
                if (!$revenue) {
                    $revenue = new UserRevenue([
                        "order_id" => $order->id,
                        "user_id" => $order->operator_diller_id
                    ]);
                }

                if ($order->benefit > 0) {
                    $revenueAmount = $order->benefit;
                    $prePriceAmount = $order->buyPrice;

                    if ($prePriceAmount) {
                        $percent = ($revenueAmount / $prePriceAmount) * 100;
                    }


                    if ($prePriceAmount <= 5) {
                        $bonus = $revenueAmount * 0.05;
                    } elseif ($percent > 5 && $percent < 20) {
                        $bonus = $revenueAmount * 0.08;
                    } elseif ($percent >= 20) {
                        $bonus = $revenueAmount * 0.15;
                    }
                    $revenue->amount = $bonus;
                    $revenue->comment = "Zakaz foyda bilan muvaffaqiyatli tugatilgani uchun";
                    $revenue->save();

                } else {
                    $fine = $order->benefit;

                    $userFine = UserFine::find()
                        ->andWhere(['order_id' => $order->id])
                        ->andWhere(['user_id' => $order->operator_diller_id])
                        ->one();
                    if (!$userFine) {
                        $userFine = new UserFine([
                            "order_id" => $order->id,
                            "user_id" => $order->operator_diller_id
                        ]);
                    }
                    $userFine->amount = $fine;
                    $userFine->comment = "Zakazda foyda bo'lmagani uchun";
                    $userFine->save();
                }


                //Ta'minotchiga oylik va jarima yozish

                $revenueAmount = $order->benefit;
                $bonus = $revenueAmount * \Yii::$app->params['salary']['taminotchi'] / 100;

                $revenue = UserRevenue::find()
                    ->andWhere(['order_id' => $order->id])
                    ->andWhere(['user_id' => $order->taminotchi_id])
                    ->one();
                if (!$revenue) {
                    $revenue = new UserRevenue([
                        "order_id" => $order->id,
                        "user_id" => $order->taminotchi_id
                    ]);
                }
                $revenue->amount = $bonus;
                $revenue->comment = "Zakaz foyda bilan muvaffaqiyatli tugatilgani uchun";
                $revenue->save();

            }
        }
    }

    public function actionCancelOrder($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);
        $params = [];
        $viewParams = [];

        $params['view'] = "_cancelOrder";
        $model->cancel_user_id = \user("id");
        $model->status = Orders::STATUS_CANCELLED;

        if ($model->load($request->post()) && $model->save()) {

            Orders::runSalaryCalculate($model);

            $state = new OrderStates([
                "order_id" => $model->id,
                "user_id" => user("id"),
                "state_id" => $model->status,
            ]);
            $state->save();


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
