<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fda_report".
 *
 * @property integer $id
 * @property integer $appointment_id
 * @property string $estimate_id
 * @property integer $principal_id
 * @property string $report_id
 * @property string $invoice_number
 * @property string $sub_invoice
 * @property string $report
 * @property string $date
 * @property string $amount
 * @property string $tax_amount
 * @property string $total_amount
 * @property string $customer
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class FdaReport extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'fda_report';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['appointment_id', 'principal_id', 'status', 'CB', 'UB'], 'integer'],
            [['report'], 'string'],
            [['date', 'DOC', 'DOU'], 'safe'],
            [['amount', 'tax_amount', 'total_amount'], 'number'],
            [['estimate_id', 'report_id'], 'string', 'max' => 100],
            [['invoice_number', 'sub_invoice'], 'string', 'max' => 50],
            [['customer'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'estimate_id' => 'Estimate ID',
            'principal_id' => 'Principal ID',
            'report_id' => 'Report ID',
            'invoice_number' => 'Invoice Number',
            'sub_invoice' => 'Sub Invoice',
            'report' => 'Report',
            'date' => 'Date',
            'amount' => 'Amount',
            'tax_amount' => 'Tax Amount',
            'total_amount' => 'Total Amount',
            'customer' => 'Customer',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    public static function getPrincip($id) {

        $princip = explode(',', $id);
        $result = '';
        $i = 0;
        if (!empty($princip)) {
            foreach ($princip as $val) {

                if ($i != 0) {
                    $result .= ',';
                }
                $principals = Debtor::findOne($val);
                $result .= $principals->principal_id;
                $i++;
            }
        }

        return $result;
    }

    public static function getVessel($id) {

        $vessels = explode(',', $id);
        $result = '';
        $i = 0;
        if (!empty($vessels)) {
            foreach ($vessels as $val) {

                if ($i != 0) {
                    $result .= ',';
                }
                $vessel_data = Vessel::findOne($val);
                $result .= $vessel_data->vessel_name;
                $i++;
            }
        }

        return $result;
    }

}
