<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NddOutputMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ndd-output-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'host_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loopback0_ipv4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loopback999_ipv6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sap_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
