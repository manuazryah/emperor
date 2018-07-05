<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AccountsMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounts-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'aoointment_id') ?>

    <?= $form->field($model, 'debtor_id') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?php // echo $form->field($model, 'payment_type') ?>

    <?php // echo $form->field($model, 'bank_account') ?>

    <?php // echo $form->field($model, 'reference_id') ?>

    <?php // echo $form->field($model, 'credit_amount') ?>

    <?php // echo $form->field($model, 'debit_amount') ?>

    <?php // echo $form->field($model, 'journal_type') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'date') ?>

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
