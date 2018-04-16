<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Upload Showrun';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="all-devices-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="all-devices-form">

        <?php $form = ActiveForm::begin(['options' => array('enctype' => 'multipart/form-data')]); ?>

        <?= $form->field($model, 'showrun_path')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
