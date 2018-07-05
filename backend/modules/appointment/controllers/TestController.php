<?php

namespace backend\modules\appointment\controllers;

use Yii;
use common\models\Test;
use common\models\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
        if (Yii::$app->session['post']['appointments'] != 1) {
            Yii::$app->getSession()->setFlash('exception', 'You have no permission to access this page');
            $this->redirect(['/site/exception']);
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Test model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Test();

        if ($model->load(Yii::$app->request->post())) {
            $this->dateformat($model, $_POST['Test']);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $this->dateformat($model);

            $model->save();
            $model = $this->dateformat($model);

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            $model = $this->dateformat($model);
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function DateFormat($model) {
        if (!empty($model)) {
            $a = ['additional_info', 'comments', 'status'];
            foreach ($model->attributes as $key => $dta) {
                if (!in_array($key, $a)) {
                    if (strpos($dta, '-') == false) {

                        if (strlen($dta) < 16 && strlen($dta) >= 8 && $dta != NULL)
                            $model->$key = $this->ChangeFormat($dta);
                        //echo $model->$key;exit;
                    }else {
                        $year = substr($dta, 0, 4);
                        $month = substr($dta, 5, 2);
                        $day = substr($dta, 8, 2);
                        $hour = substr($dta, 11, 2) == '' ? '00' : substr($dta, 11, 2);
                        $min = substr($dta, 14, 2) == '' ? '00' : substr($dta, 14, 2);
                        $sec = substr($dta, 17, 2) == '' ? '00' : substr($dta, 17, 2);

                        if ($hour != '00' && $min != '00' && $sec != '00') {
                            $model->$key = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':' . $sec;
                        } elseif ($hour != '00' && $min != '00') {
                            $model->$key = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min;
                        } elseif ($hour != '00') {
                            $model->$key = $year . '-' . $month . '-' . $day . ' ' . $hour . ':00';
                        } else {
                            $model->$key = $year . '-' . $month . '-' . $day;
                        }
                    }
                }
            }
            return $model;
        }
    }

    public function ChangeFormat($data) {

        $day = substr($data, 0, 2);
        $month = substr($data, 2, 2);
        $year = substr($data, 4, 4);
        $hour = substr($data, 9, 2) == '' ? '00' : substr($data, 9, 2);
        $min = substr($data, 11, 2) == '' ? '00' : substr($data, 11, 2);
        $sec = substr($data, 13, 2) == '' ? '00' : substr($data, 13, 2);
        if ($hour != '00' && $min != '00' && $sec != '00') {
            //echo '1';exit;
            return $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':' . $sec;
        } elseif ($hour != '00' && $min != '00') {
            //echo '2';exit;
            return $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min;
        } elseif ($hour != '00') {
            //echo '3';exit;
            return $year . '-' . $month . '-' . $day . ' ' . $hour . ':00';
        } else {

            return $year . '-' . $month . '-' . $day;
        }
    }

    /**
     * Deletes an existing Test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCrone() {
        date_default_timezone_set("Asia/Dubai");
        $time = strtotime(date("H:i:s"));
        $current_date = date("Y-m-d H:i:s");
        $before_date = date('Y-m-d H:i:s', strtotime('-30 days'));
        $startTime = date("Y-m-d H:i:s", strtotime('-31 minutes', $time));
        $endTime = date("Y-m-d H:i:s", strtotime('+31 minutes', $time));
        $arr = [0, 6, 12, 24];
        foreach ($arr as $val) {
            if ($val == 0) {
                $eta_datas = \common\models\PortCallData::find()->where(['<', 'eta', $current_date])->andWhere(['>', 'eta', $before_date])->andWhere(['not', ['cast_off' => null]])->andWhere(['not', ['cast_off' => '0000-00-00 00:00:00']])->all();
                $cast_off_datas = \common\models\PortCallData::find()->where(['<', 'cast_off', $current_date])->andWhere(['>', 'eta', $before_date])->andWhere(['not', ['cast_off' => null]])->andWhere(['not', ['cast_off' => '0000-00-00 00:00:00']])->all();
                if (!empty($eta_datas)) {
                    $this->AddNotification($eta_datas, 0);
                }
                if (!empty($cast_off_datas)) {
                    $this->AddCastOfNotification($cast_off_datas, 0);
                }
            } elseif ($val == 6) {
                $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +6 hour'));
                $end = date('Y-m-d H:i:s', strtotime($endTime . ' +6 hour'));
                $eta_datas = \common\models\PortCallData::find()->where(['<=', 'eta', $end])->andWhere(['>=', 'eta', $begin])->all();
                $cast_off_datas = \common\models\PortCallData::find()->where(['<=', 'cast_off', $end])->andWhere(['>=', 'cast_off', $begin])->all();
                if (!empty($eta_datas)) {
                    $this->AddNotification($eta_datas, 6);
                }
                if (!empty($cast_off_datas)) {
                    $this->AddCastOfNotification($cast_off_datas, 6);
                }
            } elseif ($val == 12) {
                $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +12 hour'));
                $end = date('Y-m-d H:i:s', strtotime($endTime . ' +12 hour'));
                $eta_datas = \common\models\PortCallData::find()->where(['<=', 'eta', $end])->andWhere(['>=', 'eta', $begin])->all();
                $cast_off_datas = \common\models\PortCallData::find()->where(['<=', 'cast_off', $end])->andWhere(['>=', 'cast_off', $begin])->all();
                if (!empty($eta_datas)) {
                    $this->AddNotification($eta_datas, 12);
                }
                if (!empty($cast_off_datas)) {
                    $this->AddCastOfNotification($cast_off_datas, 12);
                }
            } elseif ($val == 24) {
                $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +1 day'));
                $end = date('Y-m-d H:i:s', strtotime($endTime . ' +1 day'));
                $eta_datas = \common\models\PortCallData::find()->where(['<=', 'eta', $end])->andWhere(['>=', 'eta', $begin])->all();
                $cast_off_datas = \common\models\PortCallData::find()->where(['<=', 'cast_off', $end])->andWhere(['>=', 'cast_off', $begin])->all();
                if (!empty($eta_datas)) {
                    $this->AddNotification($eta_datas, 24);
                }
                if (!empty($cast_off_datas)) {
                    $this->AddCastOfNotification($cast_off_datas, 24);
                }
            }
        }
    }

    public function AddCastOfNotification($eta_datas, $hour) {
        foreach ($eta_datas as $value) {
            $appointment = \common\models\Appointment::find()->where(['id' => $value->appointment_id, 'status' => 0, 'stage' => 5])->one();
            if (empty($appointment)) {
                $data_exist = \common\models\Notification::find()->where(['appointment_id' => $value->appointment_id, 'notification_type' => 2])->one();
                $app_no = \common\models\Appointment::findOne(['id' => $value->appointment_id])->appointment_no;
                if ($hour == 0) {
                    $diff_in_hrs = $this->CalculateDateDiff($value->eta);
                    $msg = 'Castof for appointment <span class="appno-highlite">' . $app_no . '</span> is over about more than almost <span class="appno-highlite">' . $diff_in_hrs . '<span>';
                    $msg1 = 'Castof for appointment ' . $app_no . ' is over about more than almost ' . $diff_in_hrs;
                } else {
                    $msg = 'Castof for appointment <span class="appno-highlite">' . $app_no . '</span> in <span class="appno-highlite">' . $hour . '</span> hour';
                    $msg1 = 'Castof for appointment ' . $app_no . ' in ' . $hour . ' hour';
                }
                if (empty($data_exist)) {
                    $model = new \common\models\Notification();
                    $model->notification_type = 2;
                    $model->appointment_id = $value->appointment_id;
                    $model->appointment_no = $app_no;
                    $model->content = $msg;
                    $model->message = $msg1;
                    $model->status = 1;
                    $model->date = date("Y-m-d H:i:s");
                    $model->save();
                } else {
                    $data_exist->status = 1;
                    $data_exist->content = $msg;
                    $data_exist->message = $msg1;
                    $data_exist->date = date("Y-m-d H:i:s");
                    $data_exist->save();
                }
            }
        }
        return;
    }

    public function AddNotification($eta_datas, $hour) {
        foreach ($eta_datas as $value) {
            $data_exist = \common\models\Notification::find()->where(['appointment_id' => $value->appointment_id, 'notification_type' => 1])->one();
            $app_no = \common\models\Appointment::findOne(['id' => $value->appointment_id])->appointment_no;
            if ($hour == 0) {
                $diff_in_hrs = $this->CalculateDateDiff($value->eta);
                $msg = 'ETA for Appointment <span class="appno-highlite">' . $app_no . '</span> is over <span class="appno-highlite">' . $diff_in_hrs . '</span> ago';
                $msg1 = 'ETA for Appointment ' . $app_no . ' is over ' . $diff_in_hrs . ' ago';
            } else {
                $msg = 'ETA for Appointment <span class="appno-highlite">' . $app_no . '</span> in <span class="appno-highlite">' . $hour . '</span> hour ';
                $msg1 = 'ETA for Appointment ' . $app_no . ' in ' . $hour . ' hour ';
            }
            if (empty($data_exist)) {
                $model = new \common\models\Notification();
                $model->notification_type = 1;
                $model->appointment_id = $value->appointment_id;
                $model->appointment_no = $app_no;
                $model->content = $msg;
                $model->message = $msg1;
                $model->status = 1;
                $model->date = date("Y-m-d H:i:s");
                $model->save();
            } else {
                $data_exist->status = 1;
                $data_exist->content = $msg;
                $data_exist->message = $msg1;
                $data_exist->date = date("Y-m-d H:i:s");
                $data_exist->save();
            }
        }
        return;
    }

    public function CalculateDateDiff($eta) {
        $start_date = $eta;
        $end_date = date("Y-m-d H:i:s");
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        if ($years > 0) {
            $new_date = $years . ' Years ' . $months . ' Month ' . $days . ' Days ' . $hours . ' Hours';
        } elseif ($years < 0 && $months > 0) {
            $new_date = $months . ' Month ' . $days . ' Days ' . $hours . ' Hours';
        } elseif ($years < 0 && $months < 0 && $days > 0) {
            $new_date = $days . ' Days ' . $hours . ' Hours';
        } else {
            $new_date = $hours . ' Hours';
        }
        return $new_date;
    }

    public function actionCroneTask() {
        date_default_timezone_set("Asia/Dubai");
        $current_date = date("Y-m-d");
        $after_date = date('Y-m-d', strtotime('+1 days'));
        $users = \common\models\Task::find()->select('assigned_to')->distinct()->all();
        $arr = [0, 1];

        foreach ($arr as $value) {
            if ($value == 0) {
                foreach ($users as $user) {
                    $pendind_tasks = \common\models\Task::find()->where(['<', 'date', $current_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(['assigned_to' => $user->assigned_to])->all();
                    if (!empty($pendind_tasks)) {
                        $this->AddTask($pendind_tasks, 2);
                        $this->SendEmail($pendind_tasks, 2, $user->assigned_to);
                    }
                }
            } elseif ($value == 1) {
                foreach ($users as $user) {
                    $pendind_tasks = \common\models\Task::find()->where(['>', 'date', $current_date])->andWhere(['<=', 'date', $after_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(['assigned_to' => $user->assigned_to])->all();
                    if (!empty($pendind_tasks)) {
                        $this->AddTask($pendind_tasks, 3);
                        $this->SendEmail($pendind_tasks, 3, $user->assigned_to);
                    }
                }
            }
        }
    }

    public function AddTask($task_datas, $status) {

        foreach ($task_datas as $val) {
            $data_exist = \common\models\Task::find()->where(['id' => $val->id])->one();
            if (!empty($data_exist)) {
                $data_exist->status = $status;
                $data_exist->save();
            }
        }
        return;
    }

    public function actionMail1() {
        date_default_timezone_set("Asia/Dubai");
        $time = strtotime(date("H:i:s"));
        $current_date = date("Y-m-d H:i:s");
        $startTime = date("Y-m-d H:i:s", strtotime('-31 minutes', $time));
        $endTime = date("Y-m-d H:i:s", strtotime('+31 minutes', $time));
        $users = \common\models\Employee::find()->where(['status' => 1])->all();
        $super_users = \common\models\Employee::find()->where(['post_id' => 1])->all();
        foreach ($users as $user) {
//            $pending = \common\models\Task::find()->where(['>', 'date', $current_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(['assigned_to' => $user->id])->all();
            $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +1 day'));
            $end = date('Y-m-d H:i:s', strtotime($endTime . ' +1 day'));
            $upcoming = \common\models\Task::find()->where(['<=', 'date', $end])->andWhere(['>=', 'date', $begin])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(['assigned_to' => $user->id])->all();
//            $upcoming_followers = \common\models\Task::find()->where(['<=', 'date', $end])->andWhere(['>=', 'date', $begin])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(new Expression('FIND_IN_SET(:follow_up, follow_up)'))->addParams([':follow_up' => $user->id])->all();
            $over_due = \common\models\Task::find()->where(['<', 'date', $current_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(['assigned_to' => $user->id])->all();
            $over_due_followers = \common\models\Task::find()->where(['<', 'date', $current_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(new Expression('FIND_IN_SET(:follow_up, follow_up)'))->addParams([':follow_up' => $user->id])->all();
            if (!empty($upcoming)) {
                $this->AddTask($upcoming, 2);
                $this->SendEmail($upcoming, $user, 2);
            }
            if (!empty($over_due)) {
                $this->AddTask($over_due, 3);
                $this->SendEmail($over_due, $user, 3);
                foreach ($super_user as $super_user) {
                    $this->SendEmail($over_due, $super_user, 3);
                }
            }
            if (!empty($over_due_followers)) {
                $this->SendEmail($over_due_followers, $user, 3);
            }
        }
    }

    public function SendEmail($task_datas, $user, $status) {
        $user_info = \common\models\Employee::findOne(['id' => $user]);

        $to = $user_info->email;
// subject
        if ($status == 2) {
            $task_name = 'Upcoming';
        } elseif ($status == 3) {
            $task_name = 'Overdue';
        }
        $subject = ' Attenssion : ' . $user_info->name . 'Updated Tasks in dxb.esl-da.com';
        $message = '<html><head></head><body><h4>Hi ' . $user_info->name . ',</h4><p><b>Here are some updates on tasks</b></p><p style="color: #b92f2f;font-size: 20px;"><b>Emperror Shipping Lines LL.C</b></p><table style="border-collapse: collapse;border: 1px solid black;">';
        foreach ($task_datas as $task_data) {
            $assigned_from = \common\models\Employee::findOne($task_data->assigned_from)->name;
            $assigned_to = \common\models\Employee::findOne($task_data->assigned_to)->name;
//            $message .= "<tr><td style='border: 1px solid black;padding: 5px 12px;  '><span style='background: #FFC107;padding: 3px;'>" . $task_name . "</span><span style='color: #2196F3;padding: 0px 15px;'>" . $task_data->follow_up_msg . "</span><span>" . $assigned_from . "  assigned to " . $assigned_to . "</span></td></tr>";
            $message .= "<tr style='border: 1px solid;'><td style='padding: 5px;'><span style='background: #FFC107;padding: 3px;'>" . $task_name . "</span></td><td style=''><span style='color: #2196F3;padding: 0px 15px;font-size: 12px;'>" . $task_data->follow_up_msg . "</span></td><td style='padding: 5px 12px;'><span>" . $assigned_from . "  assigned to " . $assigned_to . "</span></td></tr>";
        }
        $message .= '</table></body></html>';
        echo $message;
        exit;
// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                "From: 'no-reply@emperror.com";
        mail($to, $subject, $message, $headers);


        return true;
    }

}
