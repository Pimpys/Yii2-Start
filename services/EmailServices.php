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
 * Date: 27.11.17
 * Time: 2:14
 */

namespace app\services;

use Yii;
class EmailServices
{
    /*
     * Пример использования класса.
     *
        <?php
            $send = new \app\models\services\EmailServices([
                'email' => 'max@mail.com',
                'layouts' => 'template',
                'params' => $_SESSION,
                'text' => 'Вы получили письмо с сайта:'
            ]);
        ?>
     */
    //Емеил куда отправляеться письмо!
    private $email;
    //Масив параметров, которые передаються в шаблон письма
    private $params = [];
    //Шаблон письма.
    private $layouts;
    //Текст в заголовке письма
    private $text;
    //Конструктор класса
    public function __construct( array $config)
    {
        self::configure($this, $config);
    }
    //Забиваем поля данными
    private static function configure($object, $properties)
    {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }

    public function send()
    {
        return Yii::$app
            ->mailer
            ->compose($this->layouts, ['model' => $this->params])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ', отправил робот'])
            ->setTo($this->email)
            ->setSubject($this->text . ' "' . Yii::$app->name . '"')
            ->send();
    }
}