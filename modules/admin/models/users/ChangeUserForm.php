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
 * Time: 16:21
 */

namespace app\modules\admin\models\users;


use app\models\users\SystemUsersRecord;
use yii\base\Model;

class ChangeUserForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $status;
    public $role;
    /**
     * @var SystemUsersRecord;
     */
    private $_user;

    const USER_MIN = 3;
    const PASSWORD_MIN = 6;
    const USER_MAX = 255;


    public function __construct($id, $config = [])
    {
        $this->_user = SystemUsersRecord::findOne($id);
        if (!$this->_user) {
            throw new \DomainException('Немогу найти пользователя!');
        }
        $this->id = $this->_user->id;
        $this->username = $this->_user->username;
        $this->email = $this->_user->email;
        $this->status = $this->_user->status;
        parent::__construct($config);
    }
    /**сов
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            [
                'username',
                'unique',
                'targetClass' => 'app\models\users\SystemUsersRecord',
                'filter' => ['<>', 'id', $this->_user->id],
                'message' => 'Этот Логин занят.'
            ],
            ['username', 'string', 'min' => self::USER_MIN, 'max' => self::USER_MAX],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => self::USER_MAX],//
            [
                'email',
                'unique',
                'targetClass' => 'app\models\users\SystemUsersRecord',
                'filter' => ['<>', 'id', $this->_user->id],
                'message' => 'Этот E-mail занят.'
            ],

            ['role', 'string'],
            ['status', 'string'],
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

    public function statusList(): array
    {
        return [
            '0' => 'Заблокирован',
            '10' => 'Активен',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'email' => 'E-mail',
            'status' => 'Статус',
            'role' => 'Привилегии',
        ];
    }
}