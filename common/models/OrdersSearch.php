<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;
use yii\db\Expression;

class OrdersSearch extends Orders
{

    public $phone;

    public function rules()
    {
        return [
            ['phone', 'string'],
            [['id', 'payment_type', 'operator_diller_id', 'taminotchi_id', 'client_id', 'delivery_type', 'network_id', 'status', 'order_type', 'partner_order_id', 'is_deleted', 'deleted_at', 'deleted_by', 'updated_at'], 'integer'],
            [['name', 'client_fullname', 'client_phone', "delivery_code", 'client_address', 'credit_file'], 'safe'],
            [['amount', 'delivery_price'], 'number'],
            ['created_at', 'safe']
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
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
            ],
        ]);

        $this->load($params);


        if (!$this->validate()) {
            return $dataProvider;
        }


        if ($this->created_at) {
            $dates = explode("   -   ", $this->created_at);
            $start = strtotime($dates[0]);
            $end = strtotime($dates[1]) + 86399;

            $query->andWhere(['>=', "orders.created_at", $start])
                ->andWhere(['<=', "orders.created_at", $end]);
        }


        $query->andFilterWhere([
            'orders.id' => $this->id,
            'orders.payment_type' => $this->payment_type,
            'orders.client_id' => $this->client_id,
            'orders.amount' => $this->amount,
            'orders.delivery_type' => $this->delivery_type,
            'orders.delivery_price' => $this->delivery_price,
            'orders.network_id' => $this->network_id,
            'orders.status' => $this->status,
            'orders.order_type' => $this->order_type,
            'orders.partner_order_id' => $this->partner_order_id,
            'orders.is_deleted' => $this->is_deleted,
            'orders.deleted_at' => $this->deleted_at,
            'orders.deleted_by' => $this->deleted_by,
            'orders.updated_at' => $this->updated_at,
            'orders.operator_diller_id' => $this->operator_diller_id,
        ]);


        if (Yii::$app->user->identity->checkRoles(["Ta'minotchi"])) {
            $query->orWhere(['=', "orders.taminotchi_id", user("id")]);
            $query->orWhere(['IS', "orders.taminotchi_id", new Expression("NULL")]);
        }

        $query->andFilterWhere(['like', 'orders.name', $this->name])
            ->andFilterWhere(['like', 'orders.client_fullname', $this->client_fullname])
            ->andFilterWhere(['like', 'orders.client_phone', $this->client_phone])
            ->andFilterWhere(['like', 'orders.client_address', $this->client_address])
            ->andFilterWhere(['like', 'orders.credit_file', $this->credit_file])
            ->andFilterWhere(['like', 'orders.delivery_code', $this->delivery_code])
            ->andFilterWhere(['like', 'orders.client.phone', $this->phone]);

        return $dataProvider;
    }
}
