<?php

namespace frontend\models;

use Yii;
use Yii\helpers\Html;
use common\components\CommonUtility;

/**
 * This is the model class for table "ndd_output_master".
 *
 * @property int $id
 * @property string $hostname
 * @property string $loopback0_ipv4
 * @property string $loopback999_ipv6
 * @property string $sap_id
 */
class NddOutputMaster extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ndd_output_master';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['hostname', 'loopback0_ipv4', 'loopback999_ipv6', 'sap_id'], 'required'],
            [['hostname', 'loopback0_ipv4', 'sap_id'], 'string', 'max' => 30],
            [['loopback999_ipv6'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hostname' => 'Host Name',
            'loopback0_ipv4' => 'Loopback0 Ipv4',
            'loopback999_ipv6' => 'Loopback999 Ipv6',
            'sap_id' => 'Sap ID',
        ];
    }

    public function parseTextFile($content = '') {
        $read_file = $content;
        $rows = explode("\r\n", $read_file);
        if (count($rows) < 2) {
            $rows = explode(PHP_EOL, $read_file);
            if (count($rows) < 2) {
                $rows = explode("\n", $read_file);
            }
        } else {
            $rows = explode("\n", $read_file);
        }
        return $rows;
    }

    public function getNddModel($id) {
        $model = NddOutputMaster::find()->alias("eopm")
                ->where(['eopm.id' => $id])
                ->andWhere(['eopm.is_active' => '1'])
                ->one();
        return $model;
    }

    public function getNIPDownload($model) {
        $url = Html::a('Download', ['generatenip', 'id' => $model->id], ['class' => 'label label-success']);
        return $url;

        if ($model->pdf_done) {
            $url = Html::a('Download', ['generatenip', 'id' => $model->id], ['class' => 'label label-success']);
            return $url;
        } else if ($model->pdf_ready) {
            return "<span class='label label-info'>Processing</span>";
        } else {
            return "<span class='label label-warning'>Pending</span>";
        }
    }

    
    /*
     * Author : Swati Chavan
     * Function : Generate NIP for Optus device
     * Para : $id , $version
     * return : Array for NIP text and fileName
     */

    public function generateNIP($id, $version = '20.8') {
        if (!empty($id)) {
            $NIPArray = array();
            $textContent = '';
            $modelObj = new NddOutputMaster();
            $model = $modelObj->getNddModel($id);
            $policyMapObj = new NddPolicyMapDetails();
            $policyModel = $policyMapObj->getPolicyMapDtl($id); 
            $mplsObj = new NddMplsLdpDetails();
            $mplsModel = $mplsObj->getMplsLdpDtl($id); 
            $suffix = $model->id . '-' . $model->sapid . '-' . $model->hostname;

            if ($version == '20.8') {
                $reportFilename = 'NIP_Showrun_Report_' . $suffix . '_V20_8.txt';
            } else {
                $reportFilename = 'NIP_Showrun_Report_' . $suffix . '.txt';
            }
            $textContent = Yii::$app->controller->renderPartial('//ndd-output-master/reports/' . $version . '/_showrun_report_nip_html', array('model' => $model,'policyModel' => $policyModel,'mplsModel'=>$mplsModel), true);
            $NIPArray['textContent'] = $textContent;
            $NIPArray['fileName'] = $reportFilename;
            return $NIPArray;
        }
    }

    public function getNIPShowRunReportsDownloadDirPath() {
        return dirname(\Yii::$app->basePath) . DIRECTORY_SEPARATOR . 'downloads' . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . 'optus-nip-showrun';
    }

    public static function getShowLinks($model, $fields) {
        $button = "<div class='btn-wrapper'>";
        if (!empty($model))
            $button .= Html::Button('<i class="fa fa-search" aria-hidden="true"></i>', ['onclick' => "getForm(" . $model->id . ",'$model->showrun_path',0);", 'rel' => $fields, 'class' => 'edit-icon ecr-built-button', 'data-toggle' => 'tooltip', 'data-placement' => 'top']);
        //if (!empty($file_name))
            //$button .= Html::a('<i class="fa fa-file-code-o" aria-hidden="true"></i>', ['ndd-output-master/get-file?id='.$model->id.'&fileName=' . $model->showrun_path.'&flag=1'], ['class' => 'ecr-built-file-link', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => $model->hostname, 'target' => '_blank']);
        $button .= "</div>";
        return $button;
    }
    
    
    

}
