<?php

namespace backend\modules\invoice\controllers;

use Yii;
use common\models\GenerateInvoice;
use common\models\GenerateInvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\InvoiceGenerateDetails;
use common\models\OnAccountOf;
use common\models\Contacts;

/**
 * GenerateInvoiceController implements the CRUD actions for GenerateInvoice model.
 */
class GenerateInvoiceController extends Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
        if (Yii::$app->session['post']['admin'] != 1) {
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
     * Lists all GenerateInvoice models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new GenerateInvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->queryParams['GenerateInvoiceSearch']['status'] != '') {
            $dataProvider->query->andWhere(['status' => Yii::$app->request->queryParams['GenerateInvoiceSearch']['status']]);
        } else {
            $dataProvider->query->andWhere(['status' => 1]);
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GenerateInvoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GenerateInvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new GenerateInvoice();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->SetValues->Attributes($model);
            $last_invoice = GenerateInvoice::find()->orderBy(['id' => SORT_DESC])->one();
            $last = $last_invoice->id + 1;
            $last_invoice_data = GenerateInvoice::find()->orderBy(['invoice_id' => SORT_DESC])->one();
            if (empty($last_invoice_data)) {
                $model->invoice_id = 1;
            } else {
                $model->invoice_id = $last_invoice_data->invoice_id + 1;
            }
            $on_account = OnAccountOf::findOne(['id' => $model->on_account_of]);
            $model->invoice_number = 'GI/' . date('m') . '/' . date('Y') . '/' . (sprintf('%04d', $model->invoice_id));
            $model->doc_no = $on_account->code . $last;
            $model->bank_details = $_POST['bank_details'];
            if ($model->save())
                return $this->redirect(['/invoice/generate-invoice/add', 'id' => $model->id]);
            else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function GenerateDoc($data) {
        if ($data == 1) {
            $doc_start = 'CG';
        } elseif ($data == 2) {
            $doc_start = 'CC';
        } elseif ($data == 3) {
            $doc_start = 'EH';
        } elseif ($data == 4) {
            $doc_start = 'TC';
        }
        return $doc_start;
    }

    public function actionAdd($id, $invoice_details_id = NULL) {
        $invoice_details = InvoiceGenerateDetails::findAll(['invoice_id' => $id]);
        $invoice_data = GenerateInvoice::findOne(['id' => $id]);
        if (!isset($invoice_details_id)) {
            $model = new InvoiceGenerateDetails();
        } else {
            $model = InvoiceGenerateDetails::find()->where(['id' => $invoice_details_id])->one();
        }
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $model->total = $model->qty * $model->unit_price;
            $model->invoice_id = $id;
            $tax_data = \common\models\TaxMaster::find()->where(['id' => $model->tax])->one();
            if (!empty($tax_data) && $tax_data->value > 0) {
                $model->tax_amount = ($tax_data->value / 100) * $model->total;
           //     $model->total = $model->tax_amount + $model->total;
            } else {
                $model->tax_amount = 0;
            }
            if ($model->save()) {
                return $this->redirect(['add', 'id' => $id]);
            }
        }

        return $this->render('add', [
                    'model' => $model,
                    'invoice_details' => $invoice_details,
                    'id' => $id,
                    'invoice_data' => $invoice_data,
        ]);
    }

    /**
     * Updates an existing GenerateInvoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $doc_start = $this->GenerateDoc($model->on_account_of);
            $model->doc_no = $doc_start . $id;
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GenerateInvoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GenerateInvoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GenerateInvoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = GenerateInvoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionInvoiceAddress() {
        if (Yii::$app->request->isAjax) {
            $invoice_id = $_POST['invoice_id'];
           
            $invoice_address = \common\models\Debtor::find()->where(['id' => $invoice_id])->one();
            return $invoice_address->invoicing_address;
        }
    }

    public function actionSupplierAddress() {
        if (Yii::$app->request->isAjax) {
            $supplier_id = $_POST['supplier_id'];
            $supplier_address = Contacts::find()->where(['id' => $supplier_id])->one();
            return $supplier_address->address;
        }
    }

    public function actionReports($id) {
        $invoice = GenerateInvoice::find()->where(['id' => $id])->one();
        $invoice_details = InvoiceGenerateDetails::findAll(['invoice_id' => $id]);
        echo $this->renderPartial('report', [
            'invoice' => $invoice,
            'invoice_details' => $invoice_details,
            'id' => $id,
        ]);
        exit;
    }

    public function actionDeleteInvoice($id) {
        $invoice = InvoiceGenerateDetails::findOne(['id' => $id]);
        $invoice->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCalculateTax() {
        if (Yii::$app->request->isAjax) {
            $tax_id = $_POST['tax'];
            $amount = $_POST['total'];
            $tax_data = \common\models\TaxMaster::find()->where(['id' => $tax_id])->one();
            if (!empty($tax_data) && $tax_data->value > 0) {
                $res = ($tax_data->value / 100) * $amount;
                $result = $res + $amount;
            } else {
                $res = '';
                $result = $amount;
            }
            $arr_variable2 = array('total-amount' => $result, 'tax-amount' => $res);
            $data['result'] = $arr_variable2;
            echo json_encode($data);
        }
    }

}
