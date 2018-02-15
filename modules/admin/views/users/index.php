<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\users\SystemUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-user-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Здесь можно добавить нового пользователя, удалить/заблокировать существующего.
    </p>
    <p>
        Вы не можете узнать пароль существующего пользователя, так как он шифруется необратимо,
        однако вы можете назначить ему новый пароль!
    </p>

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->getStatus();
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'created_at',
                'format' => 'html',
                'value' => function($model){
                    return $model->getDateCreateUser();
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'html',
                'value' => function($model){
                        return $model->getDateUpdateUser();
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
