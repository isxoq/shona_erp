<?php

namespace backend\controllers;

use common\models\Client;
use common\models\Clients;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Response;

class SearchController extends \soft\web\SoftController
{

    public function actionClients($q)
    {


        $query = (new Query())
            ->from('clients') // Replace 'clients' with your actual table name
            ->orFilterWhere(['like', 'phone', $q])
            ->orFilterWhere(['like', 'full_name', $q]);

        // Create an ActiveDataProvider with pagination
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30, // Set the number of items per page
            ],
        ]);

// Get the paginated results
        $clients = $dataProvider->getModels();
// Get the total count
        $totalCount = $dataProvider->totalCount;
        // Set the response format to JSON
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            "total_count" => $totalCount,
            "items" => $clients
        ];
    }

    public function actionProducts($q)
    {


        $query = (new Query())
            ->from('products') // Replace 'clients' with your actual table name
            ->andFilterWhere(['like', 'name', $q]);

        // Create an ActiveDataProvider with pagination
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30, // Set the number of items per page
            ],
        ]);

// Get the paginated results
        $clients = $dataProvider->getModels();
// Get the total count
        $totalCount = $dataProvider->totalCount;
        // Set the response format to JSON
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            "total_count" => $totalCount,
            "items" => $clients
        ];
    }
}