<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */
$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;

$bundle = frontend\assets\AdminLteCustomAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="login-box"><?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>
                <div class="row">
                    <!-- Login Left Side -->
                    <div class="col-md-6">
                        <div class="model-intro">
                            <h3>Parsing</h3>
                            <p></p>
                        </div>
                    </div>
                    <!-- Login Right Side -->
                    <div class="col-md-6">
                        <div class="card card-container">
                            <img id="profile-img" class="profile-img-card" src="<?= $bundle->baseUrl . '/images/user-icon.png' ?>">
                            <p id="profile-name" class="profile-name-card"><?= Html::encode($this->title) ?></p>
                            <div id="login-form-div">
                                <?php
                                $form = ActiveForm::begin([
                                            'id' => 'login-form',
                                            'enableAjaxValidation' => true,
                                            'enableClientValidation' => false,
                                            'validateOnBlur' => false,
                                            'validateOnType' => false,
                                            'validateOnChange' => false,
                                            'options' => [
                                                'class' => 'form-signin'
                                            ]
                                        ])
                                ?>

                                <?php if ($module->debug): ?>
                                    <?=
                                    $form->field($model, 'login', [
                                        'inputOptions' => [
                                            'autofocus' => 'autofocus',
                                            'class' => 'form-control',
                                            'placeholder' => $model->getAttributeLabel('login'),
                                            'tabindex' => '1']])->dropDownList(LoginForm::loginList())->label(false);
                                    ?>

                                <?php else: ?>

                                    <?=
                                    $form->field($model, 'login', ['inputOptions' => [
                                            'autofocus' => 'autofocus',
                                            'placeholder' => $model->getAttributeLabel('login'),
                                            'class' => 'form-control',
                                            'tabindex' => '1']]
                                    )->label(false);
                                    ?>

                                <?php endif ?>

                                <?php if ($module->debug): ?>
                                    <div class="alert alert-warning">
                                        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                                    </div>
                                <?php else: ?>
                                    <?=
                                    $form->field(
                                            $model, 'password', ['inputOptions' => [
                                            'class' => 'form-control',
                                            'placeholder' => $model->getAttributeLabel('password'),
                                            'tabindex' => '2'
                                        ]
                                    ])->passwordInput()->label(false);
                                    ?>
                                <?php endif ?>

                                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3', 'class' => 'checkbox-custom-label']) ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?=
                                        ($module->enablePasswordRecovery ?
                                                Html::a(
                                                        Yii::t('user', 'Forgot password?'), ['/user/recovery/request'], ['tabindex' => '5']
                                                ) : '');
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?=
                                        Html::submitButton(
                                                Yii::t('user', 'Sign in'), ['class' => 'btn btn-primary btn-block', 'tabindex' => '4']
                                        )
                                        ?>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>

                            <div class="new-user-div">
                                <?php if ($module->enableConfirmation): ?>
                                    <p class="text-center">
                                        <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
                                    </p>
                                <?php endif ?>
                                <?php if ($module->enableRegistration): ?>
                                    <p class="text-center">
                                        <?= Html::a(Yii::t('user', 'New User Register'), ['/user/registration/register'], ['class' => 'btn btn-block btn-signin']) ?>
                                    </p>
                                <?php endif ?>
                                <?=
                                Connect::widget([
                                    'baseAuthUrl' => ['/user/security/auth'],
                                ])
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>