<?php

/* @var $this yii\web\View */
/* @var $model app\models\users\SystemUsersRecord */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['users/reset-password', 'token' => $model->password_reset_token]);
?>
Привет <?= $model->username ?>,

Следуйте ссылке ниже, чтобы сбросить пароль:

<?= $resetLink ?>
