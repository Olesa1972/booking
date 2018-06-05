<?php

namespace backend\controllers;

use Yii;
use common\models\Applications;
use common\models\ApplicationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ApplicationsController implements the CRUD actions for Applications model.
 */
class ApplicationsController extends Controller
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
     * Метод, который отображает список заказов в админке
     * Lists all Applications models.
     * @return mixed
     */
    public function actionIndex()
    {
        //Создаем объект поиска заказов
        $searchModel = new ApplicationsSearch();
        // Загружаем пользовательские фильтры из запроса
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Отображаем страничку с отфильтрованными данными
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Метод для отображения одного заказа
     *
     * Displays a single Applications model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $keys
     * @param $type
     */
    public function actionChange($keys, $type)
    {
        if ($keys && $type) {
            $keys = explode(',', $keys);
            if ($keys) {
                $result = Applications::updateAll(['status' => (int)$type], ['id' => $keys]);
            }
        }
    }

    /**
     * Метод для удаления заказа
     *
     * Deletes an existing Applications model.
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
     * Finds the Applications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Applications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Applications::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
