<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CashInHandSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-in-hand-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'transaction_type') ?>

    <?= $form->field($model, 'payment_type') ?>

    <?php // echo $form->field($model, 'check_no') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'balance') ?>

    <?php // echo $form->field($model, 'appointment_id') ?>

    <?php // echo $form->field($model, 'debtor_id') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'CB') ?>

    <?php // echo $form->field($model, 'UB') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <?php // echo $form->field($model, 'DOU') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
