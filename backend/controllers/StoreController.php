<?php

namespace backend\controllers;

use common\models\PartnerShops;
use common\models\ProductImports;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use soft\helpers\ArrayHelper;
use Yii;
use common\models\Products;
use common\models\ProductsStoreSearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class StoreController extends SoftController
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsStoreSearch();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new ProductImports();
        $params = [];
        $viewParams = [];
        $request = Yii::$app->request;

        if ($this->isAjax) {

            if ($model->load($request->post())) {

                $partner = PartnerShops::findOne($model->partner_id);
                $model->import_price_uzs = $model->import_price * $partner->currency;
                $model->currency_price = $partner->currency;
                $model->save();

                $forceClose = ArrayHelper::getValue($params, 'forceClose', true);
                if ($forceClose) {
                    return $this->ajaxCrud->closeModal();
                } else {
                    return $this->ajaxCrud->viewAction($model, ['footer' => $this->ajaxCrud->afterCreateFooter(), 'forceReload' => '#crud-datatable-pjax']);
                }

            } else {
                return $this->ajaxCrud->createModal($model, $params, $viewParams);
            }

        }
    }

    /**
     * Updates an existing Products model.
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
     * Deletes an existing Products model.
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
     * Delete multiple existing Products model.
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
     * @return Products
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Products::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }

    public function actionExportData()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $query = Products::find();
        $query->joinWith("productToStores");
        $query->andWhere([">", 'product_imports.quantity', 0]);

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setCellValue("A1", "Mahsulot nomi");
        $sheet->setCellValue("B1", "Ombor");
        $sheet->setCellValue("C1", "Qolgan mahsulot soni");
        $i = 2;
        foreach ($query->all() as $item) {
            $sheet->setCellValue("A{$i}", $item->name);
            $sheet->setCellValue("B{$i}", "Dokon");
            $sheet->setCellValue("C{$i}", $item->getProductToStores()->sum("quantity") - $item->salesCount);
            $i++;
        }

//        dd($query->all());

        $writer = new Xlsx($spreadsheet);
        $writer->save('export.xlsx');

        return Yii::$app->response->sendFile("export.xlsx");
    }
}
