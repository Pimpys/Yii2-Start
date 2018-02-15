<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\users\SystemUsersRecord */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['users/activate', 'token' => $model->email_confirm]);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @var $user \app\models\users\SystemUsersRecord
 */
 ?>

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">

            <div class="content">
                <table>
                    <tr>
                        <td>
                            <h3><?= 'Привет ' . Html::encode($model->username) . '.'; ?></h3>

                            <p class="lead">Вы получили это письмо, потому Вы (возможно, что кто-то)
                                создал аккаунт на сайте "<?=Yii::$app->name?>" </p>
                            <p>
                                для активации пользователя <b><?= Html::encode($model->username); ?></b>,
                                зарегистрированного с вашим адресом электронной почты <?= Html::encode($model->email) . '.'; ?>
                                Необходимо перейти по ссылке:
                            </p>
                            <!-- Callout Panel -->
                            <p class="callout">
                                <?= Html::a(Html::encode($resetLink), $resetLink) ?>
                            </p><!-- /Callout Panel -->

                            <p>
                                Если это были не вы,
                                просто проигнорируйте это письмо и продолжайте жить в свое удовольствие. Спасибо.
                            </p>

                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table>
