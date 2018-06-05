<?php

namespace backend\controllers;

use Yii;
use common\models\Apartments;
use common\models\ApartmentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ApartmentsController implements the CRUD actions for Apartments model.
 */
class ApartmentsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Метод, которые рисует страницу со списком номеров
     * Lists all Apartments models.
     * @return mixed
     */
    public function actionIndex()
    {
        // Создаем модель номера
        $searchModel = new ApartmentsSearch();
        // Фильтруем по параметрам из запроса
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Подключаем файл из папки views (в данном случае views/apartment/index.php)
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Метод, который рисует страницу одного номера по ID
     * Displays a single Apartments model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            // Находим номер и передаем его модель в файл представления view.php
            // Который находится в views/apartments/view.php
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Метод создания номера
     * Creates a new Apartments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // Создаем модель номера
        $model = new Apartments();

        // Заполняем данные из запроса в млдель
        if ($model->load(Yii::$app->request->post())) {

            // Грузим изображение из запроса
            $model->imageFile = UploadedFile::getInstance($model, 'cover');
            //Если есть изображение
            if ($model->imageFile) {
                //Сохраняем
                $model->upload();
            }
            // Сохраняем номер
            $model->save();

            // Делаем редирект на страницу этого номера
            return $this->redirect(['view', 'id' => $model->id]);
        }

        // Или отображаем форму
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Метод обновления номера по id
     * Updates an existing Apartments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Метод удаления номера по id
     * Deletes an existing Apartments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Метод поиска номера по id
     * Finds the Apartments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apartments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apartments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
