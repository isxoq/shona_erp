<?php

namespace backend\controllers;

use common\models\ProductImports;
use soft\helpers\ArrayHelper;
use Yii;
use common\models\Products;
use common\models\ProductsSearch;
use soft\web\SoftController;
use yii\base\DynamicModel;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ProductsController extends SoftController
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
        $searchModel = new ProductsSearch();
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
     * @return string
     */
    public function actionCreate()
    {
        $model = new Products();
        return $this->ajaxCrud->createAction($model);
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

    public function actionImport()
    {

        ini_set("memory_limit", -1);
        $request = Yii::$app->request;
        $params = [
            'view' => "import"
        ];
        $viewParams = [];
        $file = null;
        $store_id = null;
        $model = new DynamicModel(compact('file', "store_id"));

        $model->addRule('file', 'string');
        $model->addRule('store_id', 'integer');

        if ($this->isAjax) {

            if ($model->load($request->post())) {


                $inputFileName = Yii::getAlias("@frontend/web{$model->file}");
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($inputFileName);

                $activeSheet = $spreadsheet->getActiveSheet();

                /*
                 * array[]
                 * 'row' int
                 * 'column' String
                 */

                $rowsCols = $activeSheet->getHighestRowAndColumn();
                $arrayValues = [];

                for ($rowIndex = 2; $rowIndex <= $rowsCols['row']; $rowIndex++) {

                    $nameValue = $activeSheet->getCellByColumnAndRow(1, $rowIndex)->getValue();
                    $priceValue = $activeSheet->getCellByColumnAndRow(2, $rowIndex)->getValue();
                    $quantityValue = $activeSheet->getCellByColumnAndRow(3, $rowIndex)->getValue();
                    $ikpu = $activeSheet->getCellByColumnAndRow(4, $rowIndex)->getValue();
                    $package = $activeSheet->getCellByColumnAndRow(5, $rowIndex)->getValue();

                    $product = Products::findOne(['name' => $nameValue]);

                    if (!$product) {
                        $product = new Products([
                            "name" => $nameValue,
                            "price_usd" => (int)$priceValue,
                        ]);
                    }
                    $product->price_usd = (int)$priceValue;
                    $product->ikpu = $ikpu;
                    $product->package = $package;
                    $product->save();

                    ProductImports::deleteAll(['product_id' => $product->id, "partner_id" => $store_id]);

                    $newIMportProduct = new ProductImports([
                        "product_id" => $product->id,
                        "partner_id" => $model->store_id,
                        "quantity" => $quantityValue,
                    ]);
                    $newIMportProduct->save();
                }

                return $this->ajaxCrud->closeModal();
            } else {
                return $this->ajaxCrud->createModal($model, $params, $viewParams);
            }

        } else {

            if ($model->load($request->post()) && $model->save()) {

                dd($model);
                if (isset($params['returnUrl'])) {
                    $returnUrl = $params['returnUrl'];
                } else {
                    $returnUrl = ['view', 'id' => $model->id];
                }
                return $this->controller->redirect($returnUrl);
            }

            $view = ArrayHelper::getValue($params, 'view', 'import');
            $viewParams['model'] = $model;
            return $this->render($view, $viewParams);
        }

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
}
