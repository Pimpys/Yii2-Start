<?php

/* @var $this yii\web\View */
/* @var $model app\models\users\SystemUsersRecord */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['users/activate', 'token' => $model->email_confirm]);
?>
Привет <?= $model->username ?>,

Перейдите по ссылке, чтоб активировать ваш аккаунт:

<?= $resetLink ?>
