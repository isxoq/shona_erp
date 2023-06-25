<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserRevenue;

class UserRevenueSearch extends UserRevenue
{

    public function rules()
    {
        return [
            ['created_at', 'safe'],
            [['id', 'order_id', 'user_id', 'type', 'status', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['comment'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($query=null, $defaultPageSize = 20, $params=null)
    {

        if($params == null){
            $params = Yii::$app->request->queryParams;
        }
        if($query == null){
            $query = UserRevenue::find();
        }

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

            $query->andWhere(['>=', "created_at", $start])
                ->andWhere(['<=', "created_at", $end]);
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'type' => $this->type,
            'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
