<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ndd_bdi_details".
 *
 * @property int $id
 * @property int $output_master_id
 * @property string $hostname
 * @property int $eth_trunk
 * @property int $bdi
 * @property string $description
 * @property int $dot1q_termination_vid
 * @property string $ip_address
 * @property int $ospf_cost
 * @property string $ospf_network_type
 * @property string $created_at
 */
class NddBdiDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ndd_bdi_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['output_master_id', 'eth_trunk', 'bdi', 'dot1q_termination_vid', 'ospf_cost', 'created_at'], 'required'],
            [['output_master_id', 'eth_trunk', 'bdi', 'dot1q_termination_vid', 'ospf_cost'], 'integer'],
            [['created_at'], 'safe'],
            [['hostname', 'ip_address', 'ospf_network_type'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'output_master_id' => 'Output Master ID',
            'hostname' => 'Hostname',
            'eth_trunk' => 'Eth Trunk',
            'bdi' => 'Bdi',
            'description' => 'Description',
            'dot1q_termination_vid' => 'Dot1q Termination Vid',
            'ip_address' => 'Ip Address',
            'ospf_cost' => 'Ospf Cost',
            'ospf_network_type' => 'Ospf Network Type',
            'created_at' => 'Created At',
        ];
    }
}
