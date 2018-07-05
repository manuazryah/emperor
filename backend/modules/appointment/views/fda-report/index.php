<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Appointment;
use common\models\Vessel;
use common\models\Debtor;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FdaReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fda Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fda-report-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body">
                    <button class="btn btn-white" id="search-option" style="float: right;">
                        <i class="linecons-search"></i>
                        <span>Search</span>
                    </button>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                            [
                                'attribute' => 'appointment_id',
                                'label' => 'Appointment No',
                                'format' => 'raw',
                                'filter' => Html::activeDropDownList($searchModel, 'appointment_id', ArrayHelper::map(Appointment::find()->all(), 'id', 'appointment_no'), ['class' => 'form-control', 'id' => 'name', 'prompt' => '']),
                                'filterOptions' => array('id' => "app_no_search"),
                                'value' => function ($data) {
                                    return Appointment::findOne($data->appointment_id)->appointment_no;
                                },
                            ],
//                            'estimate_id',
                            [
                                'attribute' => 'principal_id',
                                'label' => 'Principal',
                                'value' => function($data, $key, $index, $column) {
                                    return $data->getPrincip($data->principal_id);
                                },
                                'filter' => ArrayHelper::map(Debtor::find()->asArray()->all(), 'id', 'principal_id'),
                                'filterOptions' => array('id' => "principal_search"),
                            ],
//                            'principal_id',
//                            'report_id',
                            'invoice_number',
                            // 'sub_invoice',
                            // 'report:ntext',
                            [
                                'attribute' => 'date',
                                'value' => function($data) {
                                    if (isset($data->date)) {
                                        return $data->date;
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            [
                                'attribute' => 'amount',
                                'value' => function($data) {
                                    if (isset($data->amount)) {
                                        return $data->amount;
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            [
                                'attribute' => 'tax_amount',
                                'value' => function($data) {
                                    if (isset($data->tax_amount)) {
                                        return $data->tax_amount;
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            [
                                'attribute' => 'total_amount',
                                'value' => function($data) {
                                    if (isset($data->total_amount)) {
                                        return $data->total_amount;
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            [
                                'attribute' => 'customer',
                                'value' => function($data, $key, $index, $column) {
                                    return $data->getVessel($data->customer);
                                },
                                'filter' => ArrayHelper::map(Vessel::find()->asArray()->all(), 'id', 'vessel_name'),
                                'filterOptions' => array('id' => "vessel_search"),
                            ],
                        // 'status',
                        // 'CB',
                        // 'UB',
                        // 'DOC',
                        // 'DOU',
//                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#app_no_search select').attr('id', 'app_search_no');
        $('#principal_search select').attr('id', 'principal');
        $('#vessel_search select').attr('id', 'search_vessel');
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
        /*********** Script for dropdown search widget start ********************/

        $("#app_search_no").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#principal").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#search_vessel").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

        /*********** Script for dropdown search widget end ********************/
    });
</script>


