<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            Yii::$app->user->isGuest ? (

            [
                'label' => '<span class="glyphicon glyphicon-user"></span> Вход',
                'items' => [
                    '<li class="dropdown-header">Вход</li>',
                    ['label' => '<span class="glyphicon glyphicon-log-in"></span> Войти', 'url' => ['/users/login']],
                    '<li class="divider"></li>',
                    '<li class="dropdown-header">Зарегистрироваться</li>',
                    ['label' => '<span class="glyphicon glyphicon-log-in"></span> Регистрация', 'url' => ['/users/signup']],
                ],
            ]

            ) : (

                Yii::$app->user->can('admin') ? (
                    [
                        'label' => '<span class="glyphicon glyphicon-user"></span> Меню',
                        'items' => [
                            '<li class="dropdown-header">Выход</li>',
                            Html::beginForm(['/users/logout'], 'post')
                            . Html::submitButton(
                                '<span class="glyphicon glyphicon-log-out"></span> Выйти',
                                ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm(),
                            '<li class="divider"></li>',
                            '<li class="dropdown-header">Администрирование</li>',
                            ['label' => '<span class="glyphicon glyphicon-log-in"></span> Перейти', 'url' => ['/admin']],
                        ],
                    ]
                ) : (
                    [
                        'label' => '<span class="glyphicon glyphicon-user"></span> Меню',
                        'items' => [
                            '<li class="dropdown-header">Выход</li>',
                            Html::beginForm(['/users/logout'], 'post')
                            . Html::submitButton(
                                '<span class="glyphicon glyphicon-log-out"></span> Выйти',
                                ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm(),
                        ],
                    ]
                )
            ),
        ],
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
