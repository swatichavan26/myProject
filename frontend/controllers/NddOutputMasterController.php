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
        $qos_policy = [];
        $data = [];
        $mpls_ldp = [];
        if (!empty($contents)) {
            $rows = $model->parseTextFile($contents);
            $dnsServer = 1;
            foreach ($rows as $key => $value) {
                if (preg_match("/^sysname/", $rows[$key])) {
                    $data['host_name'] = BuiltMasterNew::getHostname($rows[$key]);
                } elseif (preg_match("/^dns server/", $rows[$key]) && !preg_match("/^dns server source-ip /", $rows[$key])) {
                    $data['dns_server_' . $dnsServer] = BuiltMasterNew::getReplacedValue($rows[$key], "dns server");
                    $dnsServer++;
                } elseif (preg_match("/^info-center loghost/", $rows[$key])) {
                    $data['loghost'] = BuiltMasterNew::getReplacedValue($rows[$key], "info-center loghost");
                } elseif (preg_match("/^qos-profile/", $rows[$key])) {
                    $qos_profile = BuiltMasterNew::getReplacedValue($rows[$key], "qos-profile");
                    $key++;
                    $policies = BuiltMasterNew::getPolicyCir($rows[$key]);
                    $qos_policy[$qos_profile] = $policies;
                } elseif (preg_match("/hwtacacs-server authentication/", $rows[$key]) && preg_match("/secondary/", $rows[$key])) {
                    $data['tacacs_secondary'] = BuiltMasterNew::getReplacedValue($rows[$key], "hwtacacs-server authentication");
                    $data['tacacs_secondary'] = BuiltMasterNew::getReplacedValue($data['tacacs_secondary'], "secondary");
                } elseif (preg_match("/hwtacacs-server authentication/", $rows[$key]) && !preg_match("/secondary/", $rows[$key])) {
                    $data['tacacs_primary'] = BuiltMasterNew::getReplacedValue($rows[$key], "hwtacacs-server authentication");
                } elseif (preg_match("/mpls ldp remote-peer/", $rows[$key])) {
                    $hostname = BuiltMasterNew::getReplacedValue($rows[$key], "mpls ldp remote-peer");
                    $temp['remote_hostname'] = $hostname;
                    $key++;
                    $ip = BuiltMasterNew::getReplacedValue($rows[$key], "remote-ip");
                    $temp['remote_ip'] = $ip;
                    $mpls_ldp[] = $temp;
                    $temp = [];
                }
            }
        }
        echo "<pre/>";
        print_r($mpls_ldp);
        die;
    }

}
