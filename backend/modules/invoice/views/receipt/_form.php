<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Receipt */
/* @var $form yii\widgets\ActiveForm */
if ($model->isNewRecord) {
    $last_record = \common\models\Receipt::find()->orderBy(['id' => SORT_DESC])->one();
    if (empty($last_record)) {
        $num = sprintf("%04d", 1);
    } else {
        $num = sprintf("%04d", $last_record + 1);
    }
    $model->receipt_no = $num . '/' . date('Y');
}
?>
<div class="receipt-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'receipt_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
                'value' => date('Y-m-d'),
                'options' => ['class' => 'form-control']
            ])
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'appointment_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'received_from_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'cheque_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'cheque_date')->widget(\yii\jui\DatePicker::classname(), [
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
                'value' => date('Y-m-d'),
                'options' => ['class' => 'form-control']
            ])
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'being')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'vessel_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'port')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
