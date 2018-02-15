<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\admin\models\users\CreateUserForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавить пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Start Main Container -->
<div class="container zerogrid">

    <div class="col-full page-conainer">
        <div class="wrap-col">
            <div class="post-margin">
                <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

                <!-- Start Entry -->
                <p>Пожалуйста, заполните следующие поля для добавления:</p>

                <div class="row">
                    <div class="col-lg-5">
                        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'password_confirm')->passwordInput() ?>

                        <?= $form->field($model, 'role')->dropDownList($model->roleList()) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
                <!-- End Entry -->

            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>
<!-- End Main Container -->