<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ndd Output Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ndd-output-master-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Upload Showrun', ['upload'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'host_name',
            'loopback0_ipv4',
            'loopback999_ipv6',
            'sap_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
