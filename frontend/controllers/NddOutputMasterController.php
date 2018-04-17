<?php

namespace frontend\controllers;

use Yii;
use frontend\models\NddOutputMaster;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\BuiltMasterNew;
use common\components\CommonUtility;
use frontend\models\NddPolicyMapDetails;
use frontend\models\NddMplsLdpDetails;
use frontend\models\NddInterfaceData;
use yii\web\UploadedFile;
use frontend\models\NddBdiDetails;
use frontend\models\NddVsiDetails;

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
            'query' => NddOutputMaster::find()->andWhere(['is_active' => 1]),
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

    public function actionUpload() {
        $model = new NddOutputMaster();
        if (!empty(Yii::$app->request->isPost)) {
            $contents = "";
            $model->showrun_path = UploadedFile::getInstance($model, 'showrun_path');
            if (!empty($model->showrun_path)) {
                $basePath = Yii::$app->basePath . "/uploads/showruns/";
                $file_name = $model->showrun_path->baseName . "_" . time() . "." . $model->showrun_path->extension;
                $model->showrun_path->saveAs($basePath . $file_name);
                if (file_exists($basePath . $file_name)) {
                    $contents = file_get_contents($basePath . $file_name);
                }
            }
            $model->load(Yii::$app->request->post());
            if (empty($contents)) {
                Yii::$app->db->createCommand()
                        ->update('ndd_output_master', ['is_active' => 0], ['user_hostname' => $model->user_hostname])
                        ->execute();
                $model->is_active = 1;
                $post = Yii::$app->request->post('NddOutputMaster');
                $topology_type = $post['topology_type'];

                if ($topology_type == 'Ring') {
                    $model->scenario = NddOutputMaster::SCENARIO_RING;
                }
                if ($topology_type == 'Spur') {
                    $model->scenario = NddOutputMaster::SCENARIO_SPUR;
                }
                if ($model->validate()) {
                    if ($model->save()) {
                        return $this->redirect(['index']);
                    }
                }
                echo "<pre/>", print_r($model->getErrors());
                die;
            }
            $qos_policy = [];
            $data = [];
            $mpls_ldp = [];
            $interfaces = $bdis = [];
            if (!empty($contents)) {
                $rows = $model->parseTextFile($contents);
                $dnsServer = 1;
                foreach ($rows as $key => $value) {
                    if (preg_match("/^sysname/", $rows[$key])) {
                        $model->hostname = BuiltMasterNew::getHostname($rows[$key]);
                    } elseif (preg_match("/^dns server/", $rows[$key]) && !preg_match("/^dns server source-ip /", $rows[$key])) {
                        $model->{'dns_server_' . $dnsServer} = BuiltMasterNew::getReplacedValue($rows[$key], "dns server");
                        $dnsServer++;
                    } elseif (preg_match("/^interface LoopBack0/", $rows[$key])) {
                        $key++;
                        $model->loopback0_ipv4 = BuiltMasterNew::getLoopback($rows[$key]);
                    } elseif (preg_match("/^info-center loghost/", $rows[$key])) {
                        $model->loghost = BuiltMasterNew::getReplacedValue($rows[$key], "info-center loghost");
                    } elseif (preg_match("/^qos-profile/", $rows[$key])) {
                        $qos_profile = BuiltMasterNew::getReplacedValue($rows[$key], "qos-profile");
                        $key++;
                        $policies = BuiltMasterNew::getPolicyCir($rows[$key]);
                        $policies['police_name'] = $qos_profile;
                        $qos_policy[$qos_profile] = $policies;
                    } elseif (preg_match("/hwtacacs-server authentication/", $rows[$key]) && preg_match("/secondary/", $rows[$key])) {
                        $model->tacacs_secondary = BuiltMasterNew::getReplacedValue($rows[$key], "hwtacacs-server authentication");
                        $model->tacacs_secondary = BuiltMasterNew::getReplacedValue($model->tacacs_secondary, "secondary");
                    } elseif (preg_match("/hwtacacs-server authentication/", $rows[$key]) && !preg_match("/secondary/", $rows[$key])) {
                        $model->tacacs_primary = BuiltMasterNew::getReplacedValue($rows[$key], "hwtacacs-server authentication");
                    } elseif (preg_match("/mpls ldp remote-peer/", $rows[$key])) {
                        $hostname = BuiltMasterNew::getReplacedValue($rows[$key], "mpls ldp remote-peer");
                        $temp['remote_hostname'] = $hostname;
                        $key++;
                        $ip = BuiltMasterNew::getReplacedValue($rows[$key], "remote-ip");
                        $temp['remote_ip'] = $ip;
                        $mpls_ldp[] = $temp;
                        $temp = [];
                    } elseif (preg_match("/^interface GigabitEthernet/", $rows[$key]) OR preg_match("/^interface TenGigabitEthernet/", $rows[$key])) {
                        $interface = BuiltMasterNew::getInterfaceData($rows, $key);
                        $interfaces[] = $interface;
                    } elseif (preg_match("/^dns domain/", trim($rows[$key]))) {
                        $model->dns_domain_name = BuiltMasterNew::getReplacedValue($rows[$key], "dns domain");
                    } elseif (preg_match("/^hwtacacs-server source-ip/", trim($rows[$key]))) {
                        $model->tacacs_source_ip = BuiltMasterNew::getIp($rows[$key]);
                    } elseif (preg_match("/^dns server source-ip/", trim($rows[$key]))) {
                        $model->dns_server_source_ip = BuiltMasterNew::getIp($rows[$key]);
                    } elseif (preg_match("/^hwtacacs-server shared-key cipher/", trim($rows[$key]))) {
                        $model->tacacs_server_key = BuiltMasterNew::getReplacedValue($rows[$key], "hwtacacs-server shared-key cipher");
                    } elseif (preg_match("/interface Eth-Trunk/", $rows[$key])) {
                        $bdis[] = BuiltMasterNew::getBdiData($rows, $key);
                    } elseif (preg_match("/^vsi/", $rows[$key]) AND preg_match("/static/", $rows[$key])) {
                        $vsi[] = BuiltMasterNew::getVsiData($rows, $key);
                    }
                }
            }
            $model->showrun_path = $file_name;
            Yii::$app->db->createCommand()
                    ->update('ndd_output_master', ['is_active' => 0], ['hostname' => $model->hostname])
                    ->execute();
            if (!empty($model->user_hostname)) {
                Yii::$app->db->createCommand()
                        ->update('ndd_output_master', ['is_active' => 0], ['user_hostname' => $model->user_hostname])
                        ->execute();
            }
            if (!empty($model->hostname) AND ! empty($model->loopback0_ipv4)) {
                $model->is_active = 1;
                $model->created_at = date("Y-m-d H:i:s");
                if ($model->save(false)) {
                    if (!empty($qos_policy)) {
                        foreach ($qos_policy as $qos_policy_dtl) {
                            $policy_map_model = new NddPolicyMapDetails();
                            foreach ($qos_policy_dtl as $key => $value) {
                                $policy_map_model->$key = $value;
                            }
                            $policy_map_model->output_master_id = $model->id;
                            $policy_map_model->hostname = $model->hostname;
                            $policy_map_model->created_at = date("Y-m-d H:i:s");
                            $policy_map_model->save(false);
                        }
                    }
                    if (!empty($mpls_ldp)) {
                        foreach ($mpls_ldp as $qos_policy_dtl) {
                            $mpls_ldp_model = new NddMplsLdpDetails();
                            foreach ($qos_policy_dtl as $key => $value) {
                                $mpls_ldp_model->$key = $value;
                            }
                            $mpls_ldp_model->output_master_id = $model->id;
                            $mpls_ldp_model->hostname = $model->hostname;
                            $mpls_ldp_model->created_at = date("Y-m-d H:i:s");
                            $mpls_ldp_model->save(false);
                        }
                    }
                    if (!empty($interfaces)) {
                        foreach ($interfaces as $interfaces_dtl) {
                            $nddInterfaceModel = new NddInterfaceData();
                            foreach ($interfaces_dtl as $key => $value) {
                                $nddInterfaceModel->$key = $value;
                            }
                            $nddInterfaceModel->output_master_id = $model->id;
                            $nddInterfaceModel->hostname = $model->hostname;
                            $nddInterfaceModel->created_at = date("Y-m-d H:i:s");
                            $nddInterfaceModel->save(false);
                        }
                    }
                    if (!empty($bdis)) {
                        foreach ($bdis as $bdis_dtl) {
                            if (!isset($bdis_dtl['ip_address']))
                                continue;
                            $nddBdiModel = new NddBdiDetails();
                            foreach ($bdis_dtl as $key => $value) {
                                $nddBdiModel->$key = $value;
                            }
                            $nddBdiModel->output_master_id = $model->id;
                            $nddBdiModel->hostname = $model->hostname;
                            $nddBdiModel->created_at = date("Y-m-d H:i:s");
                            $nddBdiModel->save(false);
                        }
                    }
                    if (!empty($vsi)) {
                        foreach ($vsi as $vsi_dtl) {
                            $nddVsiModel = new NddVsiDetails();
                            foreach ($vsi_dtl as $key => $value) {
                                $nddVsiModel->$key = $value;
                            }
                            $nddVsiModel->output_master_id = $model->id;
                            $nddVsiModel->hostname = $model->hostname;
                            $nddVsiModel->created_at = date("Y-m-d H:i:s");
                            $nddVsiModel->save(false);
                        }
                    }
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('upload', [
                        'model' => $model,
            ]);
        }

        echo "Done";
    }

    public function actionGeneratenip($id, $outputMode = 'F', $version = '20.8') {
        if (!empty($id)) {
            $modelObj = new NddOutputMaster();
            $model = $modelObj->getNddModel($id);
            //get Nip and File name
            $NIPArray = $modelObj->generateNIP($id, $version = '20.8');

            $textContent = $NIPArray['textContent'];
            $reportFilename = $NIPArray['fileName'];

            if ($outputMode == 'S') {
                return $textContent;
            }
            $textContent = Yii::$app->CommonUtility->convertCSSNIPHtmlToText($textContent, $model->sapid, 'ISO-8859-1');

            if (!is_dir($modelObj->getNIPShowRunReportsDownloadDirPath())) {
                @mkdir($modelObj->getNIPShowRunReportsDownloadDirPath(), 0777, true);
            }
            $reportFilepath = $modelObj->getNIPShowRunReportsDownloadDirPath() . DIRECTORY_SEPARATOR . $reportFilename;

            if ($outputMode == 'F') {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($reportFilepath));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . strlen($textContent) + 5);
                echo $textContent;
                exit();
            }
        }
    }

    public function actionGetFile($id, $fileName, $flag = 1) {
        $showrunPath = Yii::$app->basePath . "/uploads/showruns/$fileName";
        $contents = "";
        if (file_exists($showrunPath)) {
            $contents = file_get_contents($showrunPath);
        } else {
            echo 'File Not Found';
        }

        if ($flag == 1) {
            return $this->render("view_file", [
                        'contents' => $contents]);
        } else {
            return $this->renderPartial("view_file", [
                        'contents' => $contents]);
        }
    }

    public function actionUpload1() {
        $model = new NddOutputMaster();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post('NddOutputMaster');
            $topology_type = $post['topology_type'];

            if ($topology_type == 'Ring') {
                $model->scenario = NddOutputMaster::SCENARIO_RING;
            }
            if ($topology_type == 'Spur') {
                $model->scenario = NddOutputMaster::SCENARIO_SPUR;
            }

            if ($model->validate()) {
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('upload', [
                    'model' => $model,
        ]);
    }

}
