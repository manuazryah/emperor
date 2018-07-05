<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FdaReport;

/**
 * FdaReportSearch represents the model behind the search form about `common\models\FdaReport`.
 */
class FdaReportSearch extends FdaReport
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'appointment_id', 'principal_id', 'status', 'CB', 'UB'], 'integer'],
            [['estimate_id', 'report_id', 'invoice_number', 'sub_invoice', 'report', 'date', 'customer', 'DOC', 'DOU'], 'safe'],
            [['amount', 'tax_amount', 'total_amount'], 'number'],
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
        $query = FdaReport::find();

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
            'appointment_id' => $this->appointment_id,
            'principal_id' => $this->principal_id,
            'date' => $this->date,
            'amount' => $this->amount,
            'tax_amount' => $this->tax_amount,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'estimate_id', $this->estimate_id])
            ->andFilterWhere(['like', 'report_id', $this->report_id])
            ->andFilterWhere(['like', 'invoice_number', $this->invoice_number])
            ->andFilterWhere(['like', 'sub_invoice', $this->sub_invoice])
            ->andFilterWhere(['like', 'report', $this->report])
            ->andFilterWhere(['like', 'customer', $this->customer]);

        return $dataProvider;
    }
}
