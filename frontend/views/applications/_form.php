<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Applications */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(' 
$("#quantity").on("keyup", function() {
    var cost = $("#cost");
    cost.text(cost.attr("data-cost") * $(this).val() + " руб.");
});
', View::POS_READY);

?>

<div class="applications-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apartment_id')->hiddenInput([
        'maxlength' => true,
        'value' => $apartment->id
    ])->label(false) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'quantity')->textInput([
        'maxlength' => true,
        'id' => 'quantity'
    ]) ?>

    <p>Стоимость <span data-cost="<?= $apartment->amount ?>" id="cost"></span></p>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Создать'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
