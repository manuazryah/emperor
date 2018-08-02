<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receipts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Receipt', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'receipt_no',
            'amount',
            'date',
            'appointment_no',
            // 'received_from_name',
            // 'cheque_no',
            // 'bank_name',
            // 'cheque_date',
            // 'being',
            // 'vessel_name',
            // 'port',
            // 'status',
            // 'CB',
            // 'UB',
            // 'DOC',
            // 'DOU',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
