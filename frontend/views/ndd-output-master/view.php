<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NddOutputMaster */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ndd Output Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ndd-output-master-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'hostname',
            'loopback0_ipv4',
            'loopback999_ipv6',
            'sapid',
        ],
    ]) ?>

</div>
