<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Applications */

$this->title = Yii::t('app', 'Создать заказ');
$this->params['breadcrumbs'][] = $this->title;
$foramtter = new \yii\i18n\Formatter();

?>
<div class="applications-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row" >
        <div class="col-lg-4">
            <h2><?= $apartment->name ?></h2>

            <p><img width="100px" src="<?= $apartment->getCover() ?>" alt=""></p>
            <p><?= $foramtter->asDecimal($apartment->amount) ?> руб. за сутки</p>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'apartment' => $apartment,
    ]) ?>

</div>
