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
        <?= Html::a('Upload Showrun', ['upload-showrun'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'hostname',
            'loopback0_ipv4',
            'loopback999_ipv6',
            'sapid',
            [
                'header' => 'Showrun',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getShowrunDownload($model);
                },
            ],
            [
                'header' => 'NIP',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getNIPDownload($model);
                },
            ],
            [
                'header' => 'Preview',
                'format' => 'raw',
                'value' => function ($model) {
                    return \frontend\models\NddOutputMaster::getShowLinks($model, 'ndd_output_master', 'NddOutputMaster', 'preview', 'showrun');
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
    $(".showDetails").css('margin-left', 'auto');
    function getForm(id, status, modelName, header, file_name) {
//        $('div.custom-loader').show();
        var url = "<?php echo \Yii::$app->getUrlManager()->createUrl('built-router-ecr-master/get-router-data') ?>";

        var details = 'id=' + id + '&status=' + status + "&modelName=" + modelName + "&header=" + header + '&name=' + file_name;
        jQuery.ajax({
            url: url,
            type: 'POST',
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
