<?php
namespace frontend\models;

use yii\base\Model;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;

/**
 * Signup form
 */
class RegistrationForm extends BaseRegistrationForm
{
    public $password_confirm;

    public function rules() {
        $rules = parent::rules();

        $rules['passwordConfirmRequired']   = ['password_confirm', 'required'];
        $rules['passwordConfirmLength']     = ['password', 'string', 'min' => 6];
        $rules['passwordConfirmCompare']    = ['password_confirm', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['password_confirm'] = \Yii::t('user', 'Password confirm');
        return $labels;
    }
}
