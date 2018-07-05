<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property integer $assigned_from
 * @property integer $assigned_to
 * @property string $follow_up_msg
 * @property string $date
 * @property integer $appointment_id
 * @property string $follow_up
 * @property integer $status
 */
class Task extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['assigned_from', 'assigned_to', 'status'], 'integer'],
            [['follow_up_msg', 'assigned_to'], 'required'],
            [['follow_up_msg'], 'string'],
            [['date', 'follow_up', 'completed_date', 'appointment_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'assigned_from' => 'Assigned From',
            'assigned_to' => 'Assigned To',
            'follow_up_msg' => 'Task',
            'date' => ' Assigned Date',
            'appointment_id' => 'Appointment ID',
            'follow_up' => 'Follow Up',
            'status' => 'Status',
        ];
    }

    public function getEmployeeName($emp_id) {
        $data = Employee::findOne(['id' => $emp_id]);
        return $data->name;
    }

    public function getAppointmentNo($app_id) {
        $data = Appointment::findOne(['id' => $app_id]);
        return $data->appointment_no;
    }

    public function getAppointment() {
        return $this->hasOne(Appointment::className(), ['id' => 'appointment_id']);
    }

}
