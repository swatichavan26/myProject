<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\NddOutputMaster */
/* @var $form ActiveForm */
$displayRing = $displaySpur = '';
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
}
?>
<h1>Create IP Pool</h1>
<div class="upload_form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group"><?= $form->field($model, 'user_hostname') ?></div>
            <div class="form-group"><?= $form->field($model, 'user_loopback0') ?></div>
            <div class="form-group"><?= $form->field($model, 'enterprise_type')->dropDownList(['Yes' => 'Yes', 'No' => 'No'], ['id' => 'enterprise_type', 'prompt' => 'Select']); ?></div>
            <div id='entNo'><div class="form-group"><?= $form->field($model, 'showrun_path')->fileInput() ?></div></div>
        </div>
        
        <div id='entYes'>
        <div class="col-lg-8">
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
                <div class="col-lg-6">            
                    <div class="form-group"><?= $form->field($model, 'east_da_hostname') ?></div>
                    <div class="form-group"><?= $form->field($model, 'east_da_loopback') ?></div>
                </div>
                <div class="col-lg-6">            
                    <div class="form-group"><?= $form->field($model, 'west_da_hostname') ?></div>
                    <div class="form-group"><?= $form->field($model, 'west_da_loopback') ?></div>
                </div>
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
            } else {
                $('#ringDiv').hide();
                $('#SpurDiv').show();
            }
        });

        $(document.body).on('change', '#enterprise_type', function () {
            var val1 = $('#enterprise_type').val();
            //alert(val1);
            if (val1 == 'Yes') {
                $('#entYes').show();
                $('#entNo').hide();
            } else {
                $('#entYes').hide();
                $('#entNo').show();
            }
        });
    });

</script> 
