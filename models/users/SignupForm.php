<?php
namespace app\models\users;

use yii\base\Model;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_confirm;
    public $verifyCode;
    public $role = 'user';
    const USER_MIN = 3;
    const PASSWORD_MIN = 6;
    const USER_MAX = 255;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\users\SystemUsersRecord', 'message' => 'Этот Логин занят.'],
            ['username', 'string', 'min' => self::USER_MIN, 'max' => self::USER_MAX],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => self::USER_MAX],
            ['email', 'unique', 'targetClass' => 'app\models\users\SystemUsersRecord', 'message' => 'Этот E-mail занят.'],

            [['password', 'password_confirm'], 'required'],
            [['password', 'password_confirm'], 'string', 'min' => self::PASSWORD_MIN],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
            ['verifyCode', 'captcha', 'captchaAction' => 'users/captcha'],

            ['role', 'string'],
            ['role', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'password_confirm' => 'Подтвердите пароль',
            'verifyCode' => 'Проверочный код',
        ];
    }
}
