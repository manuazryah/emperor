<?php

use common\models\Vessel;
use common\models\FdaReport;
use yii\helpers\Html;

$principArray = explode(',', $model->principal);
if (!empty($principArray)) {
    foreach ($principArray as $value) {
        if ($value != '') {
            ?>
            <tr>
                <td><?= $model->appointment_no ?></td>
                <td>
                    <?php
                    $principals = \common\models\Debtor::findOne($value);
                    echo $principals->principal_id;
                    ?>
                </td>
                <td>
                    <?php
                    if ($model->vessel_type == 1) {
                        echo 'T -' . Vessel::findOne($model->tug)->vessel_name . ' / B -' . Vessel::findOne($model->barge)->vessel_name;
                    } else {
                        if (isset($model->vessel)) {
                            echo Vessel::findOne($model->vessel)->vessel_name;
                        }
                    }
                    ?>
                </td>
                <td></td>
                <td>
                    <?php
                    $fda_report = FdaReport::find()->where(['appointment_id' => $model->id, 'principal_id' => $value])->all();
                    $result = '';
                    $i = 0;
                    if (!empty($fda_report)) {
                        foreach ($fda_report as $value) {
                            if ($i != 0) {
                                $result .= ',<br>';
                            }
                            $result .= \yii\helpers\Html::a($value->invoice_number, ['/appointment/close-estimate/show-all-report', 'id' => $value->id], ['target' => '_blank','style'=>'width: 100%;display: contents;']);
                            $i++;
                        }
                    }
                    ?>
                    <?= $result; ?>
                </td>
            </tr>
            <?php
        }
    }
}
?>