<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        В то время как веб-сервер обрабатывал ваш запрос. Произошла ошибка <?= Html::encode($this->title) ?> и сломалась кофеварка...
    </p>
    <p>
        Пожалуйста, <?= Html::a('свяжитесь', ['site/contact']) ?> с нами, если вы считаете, что это ошибка сервера. Спасибо.
    </p>
</div>
