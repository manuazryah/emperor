<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

Pjax::begin();
/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminPostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Report';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <div class="panel-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Appointment</th>
                            <th>Principal</th>
                            <th>Vessel</th>
                            <th>Total Amount</th>
                            <th>View Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?=
                        $dataProvider->totalcount > 0 ? ListView::widget([
                                    'dataProvider' => $dataProvider,
                                    'itemView' => '_view',
                                    'options' => [
                                        'tag' => 'div',
                                        'class' => 'row'
                                    ],
//                                        'itemOptions' => [
//                                            'tag' => 'div',
//                                            'class' => 'col-lg-4 col-md-6'
//                                        ],
                                    'pager' => [
                                        'options' => ['class' => 'pagination'],
                                        'prevPageLabel' => '<', // Set the label for the "previous" page button
                                        'nextPageLabel' => '>', // Set the label for the "next" page button
                                        'firstPageLabel' => '<<', // Set the label for the "first" page button
                                        'lastPageLabel' => '>>', // Set the label for the "last" page button
                                        'nextPageCssClass' => '>', // Set CSS class for the "next" page button
                                        'prevPageCssClass' => '<', // Set CSS class for the "previous" page button
                                        'firstPageCssClass' => '<<', // Set CSS class for the "first" page button
                                        'lastPageCssClass' => '>>', // Set CSS class for the "last" page button
                                        'maxButtonCount' => 5, // Set maximum number of page buttons that can be displayed
                                    ],
                                ]) : 'No Result Found !';
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>