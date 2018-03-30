<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;

$bundle = frontend\assets\AdminLteCustomAsset::register($this);
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="login-box">
                <div class="row">
                    <div class="col-md-12">
                        <img id="profile-img" class="profile-img-card" src="<?= $bundle->baseUrl.'/images/user-icon.png'?>">
                        <p id="profile-name" class="profile-name-card"><?= Html::encode($this->title) ?></p>

                        <?php $form = ActiveForm::begin([
                            'id' => 'registration-form',
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'options' => [
                                'class' => 'form-signin'
                            ]
                        ]); ?>

                        <div class="row">
                            <div class="col-xs-6">
                                <?= $form->field($model, 'email',
                                    ['inputOptions' => [
                                        'autofocus' => 'autofocus',
                                        'placeholder' => $model->getAttributeLabel('email'),
                                        'class' => 'form-control',
                                        'tabindex' => '1'
                                        ]
                                    ]
                                )->label(false); ?>
                            </div>
                            <div class="col-xs-6">
                                <?= $form->field($model, 'username',
                                    ['inputOptions' => [
                                        'autofocus' => 'autofocus',
                                        'placeholder' => $model->getAttributeLabel('username'),
                                        'class' => 'form-control',
                                        'tabindex' => '2'
                                        ]
                                    ])->label(false); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                            </div>
                            <div class="col-xs-6">
                            </div>
                        </div>

                        <?php if ($module->enableGeneratingPassword == false): ?>
                        <div class="row">
                            <div class="col-xs-6">
                            <?= $form->field($model, 'password',
                                    ['inputOptions' => [
                                        'autofocus' => 'autofocus',
                                        'placeholder' => $model->getAttributeLabel('passwordInput'),
                                        'class' => 'form-control',
                                        'tabindex' => '3'
                                        ]
                                    ])->passwordInput()->label(false); ?>
                            </div>
                            <div class="col-xs-6">
                            <?= $form->field($model, 'password_confirm',
                                    ['inputOptions' => [
                                        'autofocus' => 'autofocus',
                                        'placeholder' => 'Confirm Password',
                                        'class' => 'form-control',
                                        'tabindex' => '4'
                                        ]
                                    ])->passwordInput()->label(false); ?>
                            </div>
                        </div>
                        <?php endif ?>

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-4"><?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?></div>
                            <div class="col-md-2"><?= Html::a(Yii::t('user', 'User Login'), ['/user/security/login'],['class' => 'btn btn-lg btn-block new-user']) ?></div>
                            <div class="col-md-3"></div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
