<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ndd_interface_data".
 *
 * @property int $id
 * @property int $output_master_id
 * @property string $interface
 * @property string $bdi
 * @property string $description
 * @property string $dot1q_termination
 * @property int $is_deleted
 */
class NddInterfaceData extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ndd_interface_data';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['output_master_id', 'is_deleted'], 'required'],
            [['interface', 'bdi'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 200],
            [['hostname'], 'string', 'max' => 50],
            [['dot1q_termination'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'output_master_id' => 'Output Master ID',
            'interface' => 'Interface',
            'bdi' => 'Bdi',
            'description' => 'Description',
            'dot1q_termination' => 'Dot1q Termination',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function getInterface($output_master_id) {
        $data = NddInterfaceData::find()->select('hostname,interface,bdi,description,dot1q_termination')
                ->where(['output_master_id' => $output_master_id])
                ->andWhere('bdi IS NULL') 
                ->all();
        return $data;        
    }
    public function getInterfaceBDI($output_master_id,$interface) {
        $data = NddInterfaceData::find()->select('hostname,interface,bdi,description,dot1q_termination')
                ->where(['output_master_id' => $output_master_id])
                ->andWhere(['interface'=>$interface])
                ->andWhere('bdi IS NOT NULL') 
                ->all();
        return $data;        
    }
    
    public function getBDIL2($output_master_id) {
        $data = NddBdiDetails::find()->select('hostname,eth_trunk,bdi,description,dot1q_termination_vid,ip_address,ospf_cost,ospf_network_type')
                ->where(['output_master_id' => $output_master_id])
                ->andWhere(['!=', 'bdi', 0])
                ->all();
        return $data;         
    }
    public function getBDIL3($output_master_id) {
        $data = NddBdiDetails::find()->select('hostname,eth_trunk,bdi,description,dot1q_termination_vid,ip_address,ospf_cost,ospf_network_type')
                ->where(['output_master_id' => $output_master_id])
                ->andWhere(['bdi' => 0])
                ->all();
        return $data;         
    }
    

}
