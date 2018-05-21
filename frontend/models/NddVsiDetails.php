<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ndd_vsi_details".
 *
 * @property int $id
 * @property int $output_master_id
 * @property string $hostname
 * @property string $vsi_name
 * @property string $description
 * @property int $vsi_id
 * @property string $peer
 * @property string $created_at
 */
class NddVsiDetails extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ndd_vsi_details';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['output_master_id', 'created_at'], 'required'],
            [['output_master_id', 'vsi_id'], 'integer'],
            [['created_at'], 'safe'],
            [['hostname', 'vsi_name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
            [['peer'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'output_master_id' => 'Output Master ID',
            'hostname' => 'Hostname',
            'vsi_name' => 'Vsi Name',
            'description' => 'Description',
            'vsi_id' => 'Vsi ID',
            'peer' => 'Peer',
            'created_at' => 'Created At',
        ];
    }

    public function getVsi($output_master_id) {
        $data = NddVsiDetails::find()->select('*')
                ->where(['output_master_id' => $output_master_id])
                ->all();
        return $data;
    }

    public function getBridgeDomain($vsi_name = '', $output_master_id) {
        $sql = "select distinct  bdi from ndd_interface_data where l2_binding_vsi='$vsi_name' AND output_master_id='$output_master_id' AND bdi IS NOT NULL";
        $result = Yii::$app->db->createCommand($sql)->queryOne();
        if (!empty($result)) {
            return $result['bdi'];
        }
        return "";
    }

}
