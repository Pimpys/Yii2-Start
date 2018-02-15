<?php
/**
 *Copyright (c)
 *http://maxsuccess.ru/
 *https://vk.com/pimpys
 *https://www.facebook.com/the.web.lessons/
 *Веб разработка на Yii2 Framework
 * +7-978-051-57-37
 * Created by PhpStorm.
 * User: pimpys
 * Date: 03.11.17
 * Time: 16:22
 */

namespace app\modules\admin\models\users;

use yii\base\Model;

class CreateUserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_confirm;
    public $role;
    const USER_MIN = 3;
    const PASSWORD_MIN = 6;
    const USER_MAX = 255;


    /**
     * @inheritdoc
     */
    public function rules(): array
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

            ['role', 'string'],
            ['role', 'safe'],
        ];
    }

    public function roleList(): array
    {
        return [
            'user' => 'Пользователь',
            'admin' => 'Администратор',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'password_confirm' => 'Подтвердите пароль',
            'role' => 'Привилегии',
        ];
    }
}