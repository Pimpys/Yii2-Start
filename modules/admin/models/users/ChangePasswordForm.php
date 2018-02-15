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
 * Date: 02.11.17
 * Time: 18:55
 */

namespace app\modules\admin\models\users;


use app\models\users\SystemUsersRecord;
use yii\base\Model;

/**
 * This is the model class for table "system_users".
 *
 * @property string $id
 * @property string $user
 * @property string $new_password
 * @property string $password_confirm
 */

class ChangePasswordForm extends Model
{
    public $user;
    public $new_password;
    public $password_confirm;
    /**
     * @var SystemUsersRecord;
     */
    private $_user;
    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = [])
    {
        $this->_user = SystemUsersRecord::findIdentity($id);
        if (!$this->_user) {
            throw new \DomainException('Пользователь заблокирован, изменение пароля не возможно!');
        }
        $this->user = $this->_user->username;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['new_password', 'password_confirm'], 'required'],
            [['new_password', 'password_confirm'], 'string', 'max' => 25],
            ['password_confirm', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'password_confirm' => 'Подтвердите пароль',
            'new_password' => 'Новый пароль',
        ];
    }
    /**
     * Changes password.
     *
     * @return boolean if password was changed.
     */
    public function changePassword()
    {
        $user = $this->_user;
        $user->setPassword($this->new_password);
        if (!$user->save())
            throw new \DomainException('Ошибка, пароль не сохранен!');
        return true;
    }
}