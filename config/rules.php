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
 * Date: 09.02.2018
 * Time: 23:27
 */
return [
    '/' => 'site/index',
    'view/<id:\d+>' => 'site/view',
    'login' => '/users/login',
    'sign-up' => 'users/signup',
    'logout' => 'users/logout',

    'admin' => 'admin/welcome/index',
    'admin/<_c:[\w\-]+>' => 'admin/<_c>/index',
    'admin/<_c:[\w\-]+>/<id:\d+>' => 'admin/<_c>/view',
    'admin/<_c:[\w\-]+>/<_a:[\w-]+>/<id:\d+>' => 'admin/<_c>/<_a>',
    'admin/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'admin/<_c>/<_a>',

    '<_c:[\w\-]+>' => '<_c>/index',
    '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
    '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
    '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
];