<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Queue;

class QueueSearch extends Queue
{

    public function rules()
    {
        return [
            [['id', 'doctor_id', 'patient_id', 'gender', 'province_id', 'region_id', 'type', 'sale', 'old_price', 'price', 'is_payed', 'status'], 'integer'],
            [['date', 'time', 'first_name', 'last_name', 'father_name', 'birth_date', 'address', 'phone', 'description'], 'safe'],
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
            $query = Queue::find();
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

        $query->andFilterWhere([
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'patient_id' => $this->patient_id,
            'date' => $this->date,
            'time' => $this->time,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'province_id' => $this->province_id,
            'region_id' => $this->region_id,
            'type' => $this->type,
            'sale' => $this->sale,
            'old_price' => $this->old_price,
            'price' => $this->price,
            'is_payed' => $this->is_payed,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'father_name', $this->father_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
