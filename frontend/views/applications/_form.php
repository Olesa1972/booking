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
    cost.text(XFormatPrice(cost.attr("data-cost") * $(this).val()));
});

function XFormatPrice(_number) 
{
    var decimal=0;
    var separator=\' \';
    var decpoint = \',\';
    var format_string = \'# руб.\';
 
    var r=parseFloat(_number)
 
    var exp10=Math.pow(10,decimal);// приводим к правильному множителю
    r=Math.round(r*exp10)/exp10;// округляем до необходимого числа знаков после запятой
 
    rr=Number(r).toFixed(decimal).toString().split(\'.\');
 
    b=rr[0].replace(/(\d{1,3}(?=(\d{3})+(?:\.\d|\b)))/g,"\$1"+separator);
 
    r=(rr[1]?b+ decpoint +rr[1]:b);
    return format_string.replace(\'#\', r);
}

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
