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
 * User: Max
 * Date: 10.02.2018
 * Time: 0:01
 */

namespace app\controllers;

use app\services\UserServices;
use Yii;
use app\models\users\PasswordResetRequestForm;
use app\models\users\ResetPasswordForm;
use app\models\users\SignupForm;
use app\models\users\LoginForm;
use yii\web\BadRequestHttpException;
use yii\helpers\Html;

class UsersController extends BaseController
{
    private $services;

    public function __construct($id, $module, UserServices $services, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->services = $services;
    }

    public function actionIndex()
    {
        $this->redirect('/user/login');
    }
    //
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('success', 'Добро пожаловать <b>'.Yii::$app->user->identity->username . '</b> Вход выполнен успешно.');
            return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->login()) {
            Yii::$app->session->setFlash('success', 'Добро пожаловать <b>'.Yii::$app->user->identity->username . '</b> Вход выполнен успешно.');
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $form,
        ]);
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    //
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        try{
            $form = new SignupForm();

            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $user = $this->services->createUser($form);
                Yii::$app->session->setFlash(
                    'success',
                    "На ваш E-mail \"".
                    Html::encode($user->email)
                    ."\" выслано письмо, для подтверждения! Срок действия, неделя!"
                );
                return $this->redirect(['login']);
            }
        }catch (\DomainException $e){
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->refresh();
        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }

    public function actionActivate($token)
    {
        try{
            $user = $this->services->findByEmailConfirmToken($token);
            $this->services->resetEmailConfirmToken($user);
            Yii::$app->getUser()->login($user);
            Yii::$app->session->setFlash(
                'success',
                "Добро пожаловать {$user->username}, активация прошла успешно!"
            );
            return $this->redirect(['site/index']);
        }catch (\DomainException $e){
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->redirect(['login']);
        }
    }
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        try{
            $form = new PasswordResetRequestForm();

            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                if ($this->services->sendPasswordResetEmail($form->email)) {
                    Yii::$app->session->setFlash('success', 'Проверьте вашу электронную почту для получения дальнейших инструкций.');
                    return $this->goHome();
                } else {
                    Yii::$app->session->setFlash('error', 'Произошла ошибка! Письмо не было отправлено.');
                }
            }
        }catch (\DomainException $e){
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->refresh();
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $form,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try{
            $form = new ResetPasswordForm();
            $user = $this->services->findByPasswordResetToken($token);
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $this->services->resetPassword($form->password, $user);
                Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');
                return $this->redirect(['login']);
            }
        }catch (\DomainException $e){
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->redirect(['login']);
        }

        return $this->render('resetPassword', [
            'model' => $form,
        ]);
    }
}