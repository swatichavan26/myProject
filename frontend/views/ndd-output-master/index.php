<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use common\models\BuiltMasterCommands;
use yii\helpers\Url;
use kartik\dialog\Dialog;
use yii\bootstrap\Modal;

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
            'sapid',
            'hostname',
            'loopback0_ipv4',
            'loopback999_ipv6',            
            [
                'header' => 'Showrun',
                'format' => 'raw',
                'value' => function ($model) {
                    return \frontend\models\NddOutputMaster::getShowLinks($model, 'ndd_output_master');
                },
            ],
            [
                'header' => 'NIP',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getNIPDownload($model);
                },
            ],
            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn','template'=>'{view} {update}' ] 
        ],
    ]);
    ?>
</div>
<?php
Modal::begin([
    'id' => 'myModal',
    'size' => 'modal-lg',
]);
?>
<div class="ecrDialog">

</div>
<?php
Modal::end();
?>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
    $(".showDetails").css('margin-left', 'auto');
            function getForm(id, file_name, flag = 0) {
//        $('div.custom-loader').show();
            var url = "<?php echo \Yii::$app->getUrlManager()->createUrl('ndd-output-master/get-file') ?>";

            var details = 'id=' + id + '&fileName=' + file_name + '&flag=' + flag;
            jQuery.ajax({
            url: url,
                    type: 'GET',
                    data: details,
                    success: function (data)
                    {
                        $('#myModal').modal('show');
                        $(".ecrDialog").html(data);
                        return false;
                    }
            });
                    return false;
            }

</script>
