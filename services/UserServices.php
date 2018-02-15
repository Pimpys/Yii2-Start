<?php
/**
 *Copyright (c)
 *http://maxsuccess.ru/
 *https://vk.com/pimpys
 *https://www.facebook.com/the.web.lessons/
 *Веб разработка на Yii2 Framework
 * +7-978-051-57-37
 * Кодируй так, как будто человек,
 * поддерживающий твой код, - буйный психопат,
 * знающий, где ты живешь.
 * Created by PhpStorm.
 * User: pimpys
 * Date: 11.02.18
 * Time: 15:44
 */
namespace app\services;

use Yii;
use app\models\users\SystemUsersRecord;
use app\modules\admin\models\users\ChangeUserForm;
use yii\base\Model;

class UserServices
{
    private $user;

    public function __construct(SystemUsersRecord $user)
    {
        $this->user = $user;
    }

    private function findUser($condition): SystemUsersRecord
    {
        if (($user = $this->user::findOne($condition)) !== null)
            return $user;
        throw new \DomainException('Немогу найти пользователя!');
    }
    /* admin start */
    public function updateUser(ChangeUserForm $form): SystemUsersRecord
    {
        $user = $this->findUser($form->id);
        if (!$user->updateUser($form->username, $form->email, $form->status))
            throw new \DomainException('Ошибка при сохранении данных о пользователе!');
        $this->updateUserRole($user->id, $form->role);
        return $user;
    }

    private function updateUserRole(int $userId, string $role) : bool
    {
        $rbac = Yii::$app->authManager;
        $user = $rbac->createRole($role);
        $rbac->revokeAll($userId);
        $rbac->assign($user, $userId);
        return true;
    }

    public function createUser(Model $form): SystemUsersRecord
    {
        $user = $this->user::create(
            $form->username,
            $form->email,
            $form->password
        );

        if (!$user->save())
            throw new \DomainException('Ошибка при сохранении пользователя!');

        $this->createUserRole($user->id, $form->role);

        $this->sendSignUpEmail($form->email);

        return $user;
    }

    private function createUserRole(int $userId, string $role): bool
    {
        $rbac = Yii::$app->authManager;
        $user = $rbac->createRole($role);
        $rbac->assign($user, $userId);
        return true;
    }

    /* admin and */

    /* site start */
    public function sendSignUpEmail($email): bool
    {
        /* @var $user SystemUsersRecord */
        $user = $this->findUser([
            'status' => SystemUsersRecord::STATUS_WAIT,
            'email' => $email,
        ]);

        if (!$this->user::isEmailConfirmTokenValid($user->email_confirm)) {
            $user->generateEmailConfirmToken();
            if (!$user->save())
                throw new \DomainException('Ошибка при создании маркера, для регистрации.');
        }

        return $this->send(
            $email,
            ['html' => 'emailConfirm-html', 'text' => 'emailConfirm-text'],
            $user,
            'Активация аккаунта на сайте:'
        );
    }
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendPasswordResetEmail($email): bool
    {
        /* @var $user SystemUsersRecord */
        $user = $this->findUser([
            'status' => SystemUsersRecord::STATUS_ACTIVE,
            'email' => $email,
        ]);

        if (!$this->user::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save())
                throw new \DomainException('Ошибка при создании маркера, для сброса пароля.');
        }

        return $this->send(
            $email,
            ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
            $user
        );
    }

    private function send($email, $layouts, $params, $text = 'Вы получили письмо с сайта:'): bool
    {
        $send = new EmailServices([
            'email' => $email,
            'layouts' => $layouts,
            'params' => $params,
            'text' => $text
        ]);
        return $send->send() ? true : false;
    }

    public function findByPasswordResetToken($token): SystemUsersRecord
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Маркер сброса пароля не может быть пустым.');
        }

        $user = $this->user::findByPasswordResetToken($token);
        if (!$user) {
            throw new \DomainException('Неверный маркер сброса пароля.');
        }

        return $user;
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword($password, SystemUsersRecord $user): bool
    {
        $user->setPassword($password);
        $user->removePasswordResetToken();
        if (!$user->save(false))
            throw new \DomainException('Ошибка при сохранении пароля!');
        return true;
    }

    public function resetEmailConfirmToken(SystemUsersRecord $user): bool
    {
        $user->removeEmailConfirmToken();
        if (!$user->save(false))
            throw new \DomainException('Ошибка при активации!');
        return true;
    }

    public function findByEmailConfirmToken($token): SystemUsersRecord
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Маркер активации не может быть пустым.');
        }

        $user = $this->user::findEmailConfirmToken($token);
        if (!$user) {
            throw new \DomainException('Неверный маркер активации аккаунта.');
        }

        return $user;
    }
    /* site end*/

}