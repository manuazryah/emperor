<?php

namespace backend\modules\reports\controllers;

use Yii;
use common\models\AppointmentSearch;

class InvoicesController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
