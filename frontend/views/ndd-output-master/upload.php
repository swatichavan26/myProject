<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\NddOutputMaster */
/* @var $form ActiveForm */
$displayRing = $displaySpur = $displayHotSwap = $displayParallelBuild = $displayRingPic =  $displaySpurPic = '' ;
if (isset($model->topology_type)) {
    if ($model->topology_type == 'Ring') {
        $displayRing = 'display:block;';
        $displaySpur = 'display:none;';
    } else {
        $displayRing = 'display:none;';
        $displaySpur = 'display:block;';
    }
} else {
    $displaySpur = 'display:none;';
    $displayRing = 'display:none;';
}
if (isset($model->enterprise_type)) {
    $displayEnt = 'display:block;';
}else{
    $displayEnt = 'display:none;';
    $displaySpur = 'display:none;';
    $displayRing = 'display:none;';
    $displayHotSwap = 'display:none;';
    $displayParallelBuild = 'display:none;';
    $displayRingPic = 'display:none;';
    $displaySpurPic = 'display:none;';
}
$bundle = frontend\assets\AdminLteCustomAsset::register($this);

?>
<h1>Create IP Pool</h1>
<div class="upload_form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->errorSummary($model); ?>
    <div class="row">
        
        <div class="col-lg-3">
            <div class="form-group"><?= $form->field($model, 'enterprise_type')->dropDownList(['Yes' => 'Yes', 'No' => 'No'], ['id' => 'enterprise_type', 'prompt' => 'Select']); ?></div>
            <div id='entuser' style="<?php echo $displaySpur; ?>">
                <div class="form-group"><?= $form->field($model, 'user_hostname') ?></div>
                <div class="form-group"><?= $form->field($model, 'user_loopback0') ?></div>            
                <div class="form-group"><?= $form->field($model, 'showrun_path')->fileInput() ?></div>
            </div>
        </div>
            
        
        <div id='entYes' style="<?php echo $displaySpur; ?>">
        <div class="col-lg-6">
            <div class="row" id='topologyDiv'>
                <div class="col-lg-6">
                    <div class="form-group"><?= $form->field($model, 'topology_type')->dropDownList(['Ring' => 'Ring', 'Spur' => 'Spur'], ['id' => 'topology', 'prompt' => 'Select']); ?></div>
                </div>
            </div>
            
            <div class="row" id='ringDiv'>
                <div class="col-lg-6">
                    <div class="form-group"><?= $form->field($model, 'east_ngbr_hostname') ?></div>
                    <div class="form-group"><?= $form->field($model, 'east_ngbr_loopback') ?></div>
                    <div class="form-group"><?= $form->field($model, 'east_ptp_ip') ?></div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group"><?= $form->field($model, 'west_ngbr_hostname') ?></div>
                    <div class="form-group"><?= $form->field($model, 'west_ngbr_loopback') ?></div>
                    <div class="form-group"><?= $form->field($model, 'west_ptp_ip') ?></div>
                </div>
            </div>
            
            <div class="row" id='SpurDiv' style="<?php echo $displaySpur; ?>">
                <div class="col-lg-6">
                    <div class="form-group"><?= $form->field($model, 'takeoff_hostname') ?></div>
                    <div class="form-group"><?= $form->field($model, 'takeoff_loopback') ?></div>
                    <div class="form-group"><?= $form->field($model, 'takeoff_ptp_ip') ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" id='EastDADiv' >            
                    <div class="form-group"><?= $form->field($model, 'east_da_hostname') ?></div>
                    <div class="form-group"><?= $form->field($model, 'east_da_loopback') ?></div>
                </div>
                <div class="col-lg-6" id='WestDADiv' >            
                    <div class="form-group"><?= $form->field($model, 'west_da_hostname') ?></div>
                    <div class="form-group"><?= $form->field($model, 'west_da_loopback') ?></div>
                </div>
            </div>
        </div>
        
        </div>
        
        <div class="col-lg-3">
            <div>
                <div class="image-wrapper1" id="hotSwap" style="<?php echo $displayHotSwap; ?>" >
                    <img src="<?= $bundle->baseUrl . '/images/pic1.png' ?>">
                    <span class="img-point1">Nokia<br />7750</span>
                    <span class="img-point2">Nokia<br />7750</span>

                    <span class="img-point-gb1">10Gb</span>
                    <span class="img-point-gb2">10Gb</span>

                    <span class="img-point-bottom">Huawei AA<br />X1/X2</span>
                </div>

                <div class="image-wrapper2" id="RingPic" style="<?php echo $displayRingPic; ?>">
                    <img src="<?= $bundle->baseUrl . '/images/pic2.png' ?>">
                    <span class="img2-point1">Nokia<br />7750</span>
                    <span class="img2-point2">Nokia<br />7750</span>

                    <span class="img2-point-gb1">10Gb</span>
                    <span class="img2-point-gb2">10Gb</span>
                    <span class="img2-point-gb3">10Gb</span>

                    <span class="img2-point-bottom1">Huawei AA<br />X1/X2</span>
                    <span class="img2-point-bottom2">ASR 903</span>
                </div>
                
                <div class="image-wrapper2" id="SpurPic" style="<?php echo $displaySpurPic; ?>">
                    <img src="<?= $bundle->baseUrl . '/images/pic3.png' ?>">
<!--                    <span class="img2-point1">Nokia<br />7750</span>
                    <span class="img2-point2">Nokia<br />7750</span>

                    <span class="img2-point-gb1">10Gb</span>
                    <span class="img2-point-gb2">10Gb</span>
                    <span class="img2-point-gb3">10Gb</span>

                    <span class="img2-point-bottom1">Huawei AA<br />X1/X2</span>
                    <span class="img2-point-bottom2">ASR 903</span>-->
                </div>
                
            </div>
        </div>
    </div>
    <div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $(document.body).on('change', '#topology', function () {
            var val = $('#topology').val();
            if (val == 'Ring') {
                $('#ringDiv').show();
                $('#SpurDiv').hide();
                $('#RingPic').show();
                $('#SpurPic').hide();
                $('#WestDADiv').show();
                
            } else {
                $('#ringDiv').hide();
                $('#SpurDiv').show();
                $('#RingPic').hide();
                $('#SpurPic').show();
                $('#WestDADiv').hide();
                
            }
        });

        $(document.body).on('change', '#enterprise_type', function () {
            var val1 = $('#enterprise_type').val();
            //alert(val1);
            if (val1 == 'Yes') {
                $('#entYes').show();
                $('#entuser').show();
                $('#entNo').hide();
                $('#hotSwap').hide();
                //$('#parallelBuild').show();
            } else {
                $('#entYes').hide();
                $('#entNo').show();
                $('#entuser').show();
                $('#hotSwap').show();
                $('#RingPic').hide();
                $('#SpurPic').hide();
            }
        });
        
        $('#nddoutputmaster-east_ngbr_hostname').change(function () {
            var valueDaHost = $('#nddoutputmaster-east_ngbr_hostname').val() ; 
            $('#nddoutputmaster-east_da_hostname').val(valueDaHost);            
    });

        $('#nddoutputmaster-east_ngbr_loopback').change(function () {
            var valueDaLoopback = $('#nddoutputmaster-east_ngbr_loopback').val() ;
            $('#nddoutputmaster-east_da_loopback').val(valueDaLoopback);            
        });
    });

</script> 
