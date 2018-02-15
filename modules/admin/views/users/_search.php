<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\modules\admin\models\users\SystemUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-user-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'global')->textInput([
        'placeholder' => 'Введите "Логин" или "E-mail" и нажмите Enter...'
    ])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
