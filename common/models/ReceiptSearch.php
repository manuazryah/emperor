<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Receipt;

/**
 * ReceiptSearch represents the model behind the search form about `common\models\Receipt`.
 */
class ReceiptSearch extends Receipt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'CB', 'UB'], 'integer'],
            [['receipt_no', 'date', 'appointment_no', 'received_from_name', 'cheque_no', 'bank_name', 'cheque_date', 'being', 'vessel_name', 'port', 'DOC', 'DOU'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Receipt::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'date' => $this->date,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'receipt_no', $this->receipt_no])
            ->andFilterWhere(['like', 'appointment_no', $this->appointment_no])
            ->andFilterWhere(['like', 'received_from_name', $this->received_from_name])
            ->andFilterWhere(['like', 'cheque_no', $this->cheque_no])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'cheque_date', $this->cheque_date])
            ->andFilterWhere(['like', 'being', $this->being])
            ->andFilterWhere(['like', 'vessel_name', $this->vessel_name])
            ->andFilterWhere(['like', 'port', $this->port]);

        return $dataProvider;
    }
}
