<?php

namespace backend\controllers;

use common\models\Debts;
use common\models\PartnerFeePays;
use common\models\PartnerShopPays;
use common\models\PaymentTypes;
use common\models\PaymentTypesSearch;
use common\models\Products;
use Faker\Provider\Payment;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use soft\helpers\ArrayHelper;
use Yii;
use common\models\PartnerShops;
use common\models\PartnerShopsSearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class FeeController extends SoftController
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
        $searchModel = new PaymentTypesSearch();
        $searchModel->type = PaymentTypes::TYPE_HAMKOR;
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
        $model = PaymentTypes::findOne($id);

        $params = [];
        $viewParams = [];

        $params['view'] = "_payDebt";

        if ($model->load($request->post())) {

            $payFee = new PartnerFeePays([
                "partner_id" => $model->id,
                "amount" => $model->payed_amount_fee
            ]);

            $payFee->save();

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

    public function actionExportData()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $query = PaymentTypes::find()->andWhere(['type' => PaymentTypes::TYPE_HAMKOR]);

//        $query->joinWith("productToStores");
//        $query->andWhere([">", 'product_imports.quantity', 0]);

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setCellValue("A1", "Nomi");
        $sheet->setCellValue("B1", "Haqdorlik");
        $sheet->setCellValue("C1", "To'langan");
        $sheet->setCellValue("D1", "Hamkor qarzi");
        $i = 2;
        foreach ($query->all() as $item) {
            $sheet->setCellValue("A{$i}", $item->name);
            $sheet->setCellValue("B{$i}", Yii::$app->formatter->asSum($item->allSale));
            $sheet->setCellValue("C{$i}", Yii::$app->formatter->asSum($item->allPayed));
            $sheet->setCellValue("D{$i}", Yii::$app->formatter->asSum($item->allSale - $item->allPayed));
            $i++;
        }

//        dd($query->all());

        $writer = new Xlsx($spreadsheet);
        $writer->save('export.xlsx');

        return Yii::$app->response->sendFile("export.xlsx");
    }
}
