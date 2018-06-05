<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ApplicationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Заказы');
$this->params['breadcrumbs'][] = $this->title;

// Регистрируем JS-код. Он добавится в конце страницы при отрисовке
$this->registerJs(' 
// JS-код. 
// Ловим событие, когда пользователь нажмет на кнопку "Ожидает"
$("#wait").on("click", function() {

    // Получаем все id выбранных галочек
    var keys = $(\'#grid\').yiiGridView(\'getSelectedRows\');
    if (keys) {
        // Отправляем их на метод изменения статуса
        $.get( "/applications/change?keys=" + keys.join(",") + "&type=20", function( data ) {
            window.location="/applications";
        });
    }
});

// Ловим событие, когда пользователь нажмет на кнопку "Выполнено"
$("#success").on("click", function() {
    // Получаем все id выбранных галочек
    var keys = $(\'#grid\').yiiGridView(\'getSelectedRows\');
    if (keys) {
        // Отправляем их на метод изменения статуса
        $.get( "/applications/change?keys=" + keys.join(",") + "&type=10", function( data ) {
            window.location="/applications";
        });
    }
});
', View::POS_READY);

?>
<div class="applications-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

<!--    Кнопка Ожидает -->
    <?= Html::button('Ожидает', [
        'class' => 'btn btn-warning',
        'id' => 'wait'
    ]) ?>

    <!--    Кнопка Выполнено -->
    <?= Html::button('Выполнено', [
        'class' => 'btn btn-success',
        'id' => 'success'
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        // Ставим настройки для строчек
        'rowOptions' => function ($model) {
        // Если статус "выполнено", то красим в зеленый
            if ($model->status == \common\models\Applications::DONE_STATUS) {
                return ['class' => 'success'];
            }
            // Если статус "ожидает", то красим в желтый
            if ($model->status == \common\models\Applications::WAIT_STATUS) {
                return ['class' => 'warning'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\CheckboxColumn',
                // you may configure additional properties here
            ],
            'id',
            'first_name',
            'last_name',
            'phone',
            // Добавляем свой поле в таблицу - ссылка на номер
            [
                'attribute' => 'apartment',
                'format' => 'raw',
                'value' => /**
                 * @param \common\models\Applications $data
                 * @return mixed
                 */
                    function ($data) {
                        $id = $data->getApartment()->one()->id;
                        $name = $data->getApartment()->one()->name;
                        return "<a href='/apartments/view?id={$id}'>$name</a>";
                    },
            ],
            'created_at',
            'cost',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
