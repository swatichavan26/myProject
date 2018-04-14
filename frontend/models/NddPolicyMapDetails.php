<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ndd_policy_map_details".
 *
 * @property int $id
 * @property string $output_master_id
 * @property string $hostname
 * @property string $police_name
 * @property string $cir
 * @property string $pir
 * @property string $pbs
 * @property string $cbs
 * @property string $created_at
 */
class NddPolicyMapDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ndd_policy_map_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['output_master_id', 'hostname', 'police_name', 'cir', 'pir', 'pbs', 'cbs', 'created_at'], 'required'],
            [['output_master_id', 'hostname', 'police_name'], 'string', 'max' => 30],
            [['cir', 'pir', 'pbs', 'cbs', 'created_at'], 'string', 'max' => 50],
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
            'police_name' => 'Police Name',
            'cir' => 'Cir',
            'pir' => 'Pir',
            'pbs' => 'Pbs',
            'cbs' => 'Cbs',
            'created_at' => 'Created At',
        ];
    }
    public function getPolicyMapDtl($output_master_id) {
        $data = NddPolicyMapDetails::find()->select('police_name,cir,pir,pbs,cbs')
                ->where(['output_master_id' => $output_master_id])
                ->all();
        return $data;
    }
    
}
