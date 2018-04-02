<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ndd_mpls_ldp_details".
 *
 * @property int $id
 * @property string $output_master_id
 * @property string $hostname
 * @property string $remote_hostname
 * @property string $remote_ip
 * @property string $created_at
 */
class NddMplsLdpDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ndd_mpls_ldp_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['output_master_id', 'hostname', 'remote_hostname', 'remote_ip', 'created_at'], 'required'],
            [['output_master_id', 'hostname', 'remote_hostname'], 'string', 'max' => 30],
            [['remote_ip', 'created_at'], 'string', 'max' => 50],
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
            'remote_hostname' => 'Remote Hostname',
            'remote_ip' => 'Remote Ip',
            'created_at' => 'Created At',
        ];
    }
}
