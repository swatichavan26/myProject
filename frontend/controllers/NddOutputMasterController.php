<?php

namespace frontend\controllers;

use Yii;
use frontend\models\NddOutputMaster;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\BuiltMasterNew;

/**
 * NddOutputMasterController implements the CRUD actions for NddOutputMaster model.
 */
class NddOutputMasterController extends Controller {

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
     * Lists all NddOutputMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => NddOutputMaster::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NddOutputMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new NddOutputMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new NddOutputMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing NddOutputMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing NddOutputMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the NddOutputMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NddOutputMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = NddOutputMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUploadShowrun() {
        $model = new NddOutputMaster();
        $fileName = "showrun.txt";
        $showrunPath = Yii::$app->basePath . "/uploads/showruns/$fileName";
        $contents = '';
        if (file_exists($showrunPath)) {
            $contents = file_get_contents($showrunPath);
        }
        $data = [];
        if (!empty($contents)) {
            $rows = $model->parseTextFile($contents);
            foreach ($rows as $key => $value) {
                if (preg_match("/^sysname/", $rows[$key])) {
                    $data['host_name'] = BuiltMasterNew::getHostname($rows[$key]);
                } elseif (preg_match("/^dns server/", $rows[$key]) && !preg_match("/^dns server source-ip /", $rows[$key])) {
                    $dns_server = BuiltMasterNew::getDnsServer($rows[$key]);
                    if (isset($data['dns_server']) && !empty($data['dns_server'])) {
                        $data['dns_server'] .= "," . $dns_server;
                    } else {
                        $data['dns_server'] = $dns_server;
                    }
                } elseif (preg_match("/^dns server source-ip /", $rows[$key])) {
                    $dns_server_source_ip = BuiltMasterNew::getDnsServerSourceIp($rows[$key]);
                    if (isset($data['dns_server_source_ip']) && !empty($data['dns_server_source_ip'])) {
                        $data['dns_server_source_ip'] .= "," . $dns_server_source_ip;
                    } else {
                        $data['dns_server_source_ip'] = $dns_server_source_ip;
                    }
                } elseif (preg_match("/^qos-profile/", $rows[$key])) {
                    $data['policy_name'] = BuiltMasterNew::getDnsServerSourceIp($rows[$key]);
                    
                }
            }
        }
        echo "<pre/>";
        print_r($data);
        die;
    }

}
