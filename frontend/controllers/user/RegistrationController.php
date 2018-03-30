<?php

/*
 * This file is part of the Enterprise project.
 *
 * (c) Enterprise project <https://github.com/infinity-labs-dev/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace frontend\controllers\user;

use dektrium\user\Finder;
use dektrium\user\models\RegistrationForm;
use dektrium\user\models\ResendForm;
use dektrium\user\models\User;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

/**
 * RegistrationController is overridden controller which responsible for overriding varoius registration process,
 * provided by base module controller which includes registration of a new account,
 * resending confirmation tokens, email confirmation and registration via social networks.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Prashant Swami <prashant.s@infinitylabs.in>
 */

class RegistrationController extends BaseRegistrationController
{
    /**
     * Overridden function to display login page.
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise
     * redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var RegistrationForm $model */
        $model = \Yii::createObject(RegistrationForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            $this->trigger(self::EVENT_AFTER_REGISTER, $event);

             // Get Registered user details
            $user =  User::find()->select('id')->where(['email' => $model->email])->one();

            // Assign default role and permissions
            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole('circle');
            $auth->assign($authorRole, $user->id);

            \Yii::$app->getSession()->setFlash('success',"Thank You for registration. Please use login using your credentials.");

            /*
            return $this->render('/message', [
                'title'  => \Yii::t('user', 'Your account has been created'),
                'module' => $this->module,
            ]);
            */
        }

        $this->layout = '/main-login';
        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}
