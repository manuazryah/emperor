<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "receipt".
 *
 * @property integer $id
 * @property string $receipt_no
 * @property string $amount
 * @property string $date
 * @property string $appointment_no
 * @property string $received_from_name
 * @property string $cheque_no
 * @property string $bank_name
 * @property string $cheque_date
 * @property string $being
 * @property string $vessel_name
 * @property string $port
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class Receipt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'receipt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['date', 'DOC', 'DOU'], 'safe'],
            [['status', 'CB', 'UB'], 'integer'],
            [['receipt_no', 'appointment_no', 'received_from_name', 'cheque_no', 'bank_name', 'cheque_date', 'vessel_name', 'port'], 'string', 'max' => 100],
            [['being'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receipt_no' => 'Receipt No',
            'amount' => 'Amount',
            'date' => 'Date',
            'appointment_no' => 'Appointment No',
            'received_from_name' => 'Received From Name',
            'cheque_no' => 'Cheque No',
            'bank_name' => 'Bank Name',
            'cheque_date' => 'Cheque Date',
            'being' => 'Being',
            'vessel_name' => 'Vessel Name',
            'port' => 'Port',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
