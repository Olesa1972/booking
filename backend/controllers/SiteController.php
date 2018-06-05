<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     *
     *  Метод логина пользователя
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        // Если не гость, то перекидываем его на главную
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        // Загружаем данные из запроса в модель формы логина и пытаемся пройти авторизацию
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Если успешно, то возвращаемся на страницу, которую запросили ранее
            return $this->goBack();
        } else {
            // Иначе обнуляем пароль для безопасности
            $model->password = '';

            // Показывем форму логина
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Метод выхода
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        // Получаем пользователя из сессии и делаем выход
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
