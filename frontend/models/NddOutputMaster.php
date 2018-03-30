<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ndd_output_master".
 *
 * @property int $id
 * @property string $host_name
 * @property string $loopback0_ipv4
 * @property string $loopback999_ipv6
 * @property string $sap_id
 */
class NddOutputMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ndd_output_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['host_name', 'loopback0_ipv4', 'loopback999_ipv6', 'sap_id'], 'required'],
            [['host_name', 'loopback0_ipv4', 'sap_id'], 'string', 'max' => 30],
            [['loopback999_ipv6'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'host_name' => 'Host Name',
            'loopback0_ipv4' => 'Loopback0 Ipv4',
            'loopback999_ipv6' => 'Loopback999 Ipv6',
            'sap_id' => 'Sap ID',
        ];
    }
}
