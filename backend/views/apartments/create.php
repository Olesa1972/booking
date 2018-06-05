<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Apartments */

$this->title = Yii::t('app', 'Создать номер');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Номера'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
