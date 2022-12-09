<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Products;

class ProductsStoreSearch extends Products
{

    public function rules()
    {
        return [
            [['id', 'is_deleted', 'deleted_at', 'deleted_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'safe'],
            [['price_usd'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($query = null, $defaultPageSize = 20, $params = null)
    {

        if ($params == null) {
            $params = Yii::$app->request->queryParams;
        }
        if ($query == null) {
            $query = Products::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith("productToStores");

        $query->andWhere([">", 'product_imports.quantity', 0]);

        $query->andFilterWhere([
            'id' => $this->id,
            'price_usd' => $this->price_usd,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
