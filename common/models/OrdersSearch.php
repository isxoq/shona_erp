<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;

class OrdersSearch extends Orders
{

    public $phone;

    public function rules()
    {
        return [
            ['phone', 'string'],
            [['id', 'payment_type', 'client_id', 'delivery_type', 'network_id', 'status', 'order_type', 'partner_order_id', 'is_deleted', 'deleted_at', 'deleted_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'client_fullname', 'client_phone', 'client_address', 'credit_file'], 'safe'],
            [['amount', 'delivery_price'], 'number'],
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
            $query = Orders::find();
        }

        $query->joinWith('client');


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

        $query->andFilterWhere([
            'id' => $this->id,
            'payment_type' => $this->payment_type,
            'client_id' => $this->client_id,
            'amount' => $this->amount,
            'delivery_type' => $this->delivery_type,
            'delivery_price' => $this->delivery_price,
            'network_id' => $this->network_id,
            'status' => $this->status,
            'order_type' => $this->order_type,
            'partner_order_id' => $this->partner_order_id,
            'is_deleted' => $this->is_deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'client_fullname', $this->client_fullname])
            ->andFilterWhere(['like', 'client_phone', $this->client_phone])
            ->andFilterWhere(['like', 'client_address', $this->client_address])
            ->andFilterWhere(['like', 'credit_file', $this->credit_file])
            ->andFilterWhere(['like', 'client.phone', $this->phone]);

        return $dataProvider;
    }
}
