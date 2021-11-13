<?php

namespace backend\controllers;

use backend\models\ImportProductJob;
use backend\models\StoreImportForm;
use common\models\StoreProduct;
use console\queue\StoreProductImportJob;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StoreProductController implements the CRUD actions for StoreProduct model.
 */
class StoreProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all StoreProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoreProduct();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $importForm = new StoreImportForm();
        if ($importForm->load(\Yii::$app->request->post()) && $importForm->validate()) {
            $importForm->fileMove('file', $fileName = 'store-file-' . time());

            $jobData = [
                'extension' => $importForm->_file->getExtension(),
                'store_id' => $importForm->store_id,
                'fileName' => $fileName,
            ];

            ImportProductJob::saveLog($importForm->store_id, ImportProductJob::STATUS_NEW, $jobData);

            \Yii::$app->queue->push(new StoreProductImportJob($jobData));

            \Yii::$app->session->setFlash('success-message', 'Please wait! File is already in the queue!');

            $this->redirect(['import-product-job/index']);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'importForm' => $importForm,
        ]);
    }

    /**
     * Displays a single StoreProduct model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StoreProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StoreProduct();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StoreProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StoreProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StoreProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StoreProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StoreProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
