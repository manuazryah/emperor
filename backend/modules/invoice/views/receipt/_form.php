<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

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

        <div class="col-md-3 col-sm-6 col-sx-12">
            <?= $form->field($model, 'receipt_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-sx-12">
            <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-sx-12">
            <?=
            $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
                'value' => date('Y-m-d'),
                'options' => ['class' => 'form-control']
            ])
            ?>
        </div>
        <div class="col-md-3 col-sm-6 col-sx-12">
            <?= $form->field($model, 'appointment_no')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <?php $contacts = ArrayHelper::map(\common\models\Contacts::findAll(['status' => 1]), 'name', 'name'); ?>
        <div class="col-md-3 col-sm-6 col-sx-12">
            <?= $form->field($model, 'received_from_name')->dropDownList($contacts, ['prompt' => '- Choose -']) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-sx-12">
            <?= $form->field($model, 'cheque_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-sx-12">
            <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-sx-12">
            <?=
            $form->field($model, 'cheque_date')->widget(\yii\jui\DatePicker::classname(), [
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
                'value' => date('Y-m-d'),
                'options' => ['class' => 'form-control']
            ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-sx-12">
            <?= $form->field($model, 'being')->dropDownList(['Bunker Coordination Charge – Bulk' => 'Bunker Coordination Charge – Bulk', 'Bunker / DG Approval  – Drum' => 'Bunker / DG Approval  – Drum', 'Permit to Work Charges (PTW)' => 'Permit to Work Charges (PTW)', 'DG Approval – Chemical / Cylinder / Battery etc' => 'DG Approval – Chemical / Cylinder / Battery etc', 'CID Clearance Charge' => 'CID Clearance Charge', 'Agent Coordination Charge' => 'Agent Coordination Charge', 'Settlement Against Invoice' => 'Settlement Against Invoice']) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-sx-12">
            <?= $form->field($model, 'vessel_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-sx-12">
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
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#receipt-received_from_name").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#receipt-being").select2({
            //placeholder: 'Select your country...',
            allowClear: true
        }).on('select2-open', function ()
        {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
    });
</script>
