<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NddOutputMaster */

$this->title = 'Create Ndd Output Master';
$this->params['breadcrumbs'][] = ['label' => 'Ndd Output Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ndd-output-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
