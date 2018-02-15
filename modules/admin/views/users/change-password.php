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
 * Date: 02.11.17
 * Time: 18:50
 */

/* @var $this yii\web\View */
/* @var $model \app\modules\admin\models\users\ChangePasswordForm */
/* @var $form ActiveForm */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Изменить пароль: ' . $model->user;
?>
<div class="user-change-password">

    <h1><?= Html::encode($this->title)?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'new_password')->passwordInput() ?>

    <?= $form->field($model, 'password_confirm')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>