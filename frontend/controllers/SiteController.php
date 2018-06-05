<?php

namespace frontend\controllers;

use common\models\Apartments;
use common\models\Products;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
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
     * Метод, который отображает главную страницу.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'apartments' => Apartments::find()->all() // Получение всех номеров
        ]);
    }


}
