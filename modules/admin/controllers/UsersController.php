<?php
/**
 *Copyright (c)
 *http://maxsuccess.ru/
 *https://vk.com/pimpys
 *https://www.facebook.com/the.web.lessons/
 *Веб разработка на Yii2 Framework
 * +7-978-051-57-37
 * Кодируй так, как будто человек,
 * поддерживающий твой код, - буйный психопат,
 * знающий, где ты живешь.
 * Created by PhpStorm.
 * User: pimpys
 * Date: 11.02.18
 * Time: 0:30
 */

namespace app\modules\admin\controllers;

use app\modules\admin\models\users\ChangePasswordForm;
use app\modules\admin\models\users\ChangeUserForm;
use app\modules\admin\models\users\CreateUserForm;
use app\services\UserServices;
use Yii;
use app\models\users\SystemUsersRecord;
use app\modules\admin\models\users\SystemUserSearch;
use yii\web\NotFoundHttpException;

/**
 * UsersController implements the CRUD actions for SystemUsersRecord model.
 */
class UsersController extends DefaultController
{
    private $services;

    public function __construct($id, $module, UserServices $services, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->services = $services;
    }
    /**
     * Lists all SystemUsersRecord models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SystemUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SystemUsersRecord model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SystemUsersRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        try{
            $form = new CreateUserForm();
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $user = $this->services->createUser($form);
                Yii::$app->session->setFlash('success', 'Данные успешно добавлены.');
                return $this->redirect(['view', 'id' => $user->id]);
            }
        }catch (\DomainException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing SystemUsersRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        try{
            $form = new ChangeUserForm($id);
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $user = $this->services->updateUser($form);
                Yii::$app->session->setFlash('success', 'Данные успешно изменены.');
                return $this->redirect(['view', 'id' => $user->id]);
            }
        }catch (\DomainException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * Deletes an existing SystemUsersRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->identity->getId() === $model->id){
            Yii::$app->session->setFlash(
                'success',
                'Абсурд! Этого просто не может быть! Нет, я отказываюсь в это верить...'
            );
            return $this->redirect(['index']);
        }

        if($model->blockUser()){
            Yii::$app->session->setFlash(
                'danger',
                'Пользователей удалять нельзя! Поэтому система его заблокировала.'
            );
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash(
                'warning',
                'Произошла ошибка! Для её устранения свяжитесь с Администратором.'
            );
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the SystemUsersRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SystemUsersRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SystemUsersRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }

    public function actionPassword($id)
    {
        try {
            $form = new ChangePasswordForm($id);
            if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->changePassword())
            {
                Yii::$app->session->setFlash('success', 'Пароль успешно изменен!');
                return $this->actionView($id);
            }
        }catch (\DomainException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('change-password', [
            'model' => $form,
        ]);
    }
}
