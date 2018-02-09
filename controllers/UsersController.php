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

use Yii;
class UsersController extends BaseController
{
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest)
            return $this->redirect(['site/index']);
        $form = [];
        return $this->render('login', [
            'model' => $form
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}