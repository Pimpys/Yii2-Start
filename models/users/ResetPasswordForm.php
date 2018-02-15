<?php
namespace app\models\users;

use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_confirm;
    const PASSWORD_MIN = 6;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['password', 'password_confirm'], 'required'],
            [['password', 'password_confirm'], 'string', 'min' => self::PASSWORD_MIN],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'password' => 'Пароль',
            'password_confirm' => 'Подтвердите пароль',
        ];
    }
}
