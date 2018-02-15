<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\modules\admin\models\users\ChangeUserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-user-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'role')->dropDownList($model->roleList()) ?>

    <?= (Yii::$app->user->identity->username === $model->username) ?
        '' : $form->field($model, 'status')->dropDownList($model->statusList()) ?>

    <div class="form-group">
        <?= Html::a('Изменить пароль', ['users/password', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
