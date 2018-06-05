<?php

/* @var $this yii\web\View */

$this->title = 'Бронирование номеров';
$i = 0;
$div = false;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Бронирование номеров</h1>
    </div>

    <div class="body-content">
        <?php
        /** @var \common\models\Apartments[] $apartments */
        // Выводим номера
        foreach ($apartments as $key => $apartment) : ?>

            <?php
            // Если счетчик ноль, то выводим начало строки
            if ($i == 0) {
                $div = true;
                echo '<div class="row">';
            } ?>
            <div class="col-lg-4">
                <h2><?= $apartment->name ?></h2>

                <p><img width="200px" src="<?= $apartment->getCover() ?>" alt=""></p>
                <p>Тип <?= $apartment->getType() ?></p>
                <p><?= $apartment->amount ?> руб. за сутки</p>

                <p><a class="btn btn-default" href="/applications/create?id=<?= $apartment->id ?>">
                        Забронировать
                    </a>
                </p>
            </div>
            <?php
            // Прибавляем к счетчика + 1 и проверяем, если набролось 3, то рисуем тег конца строки и обнуляем счетчик
            $i++;
            if (($i == 3) || (($key + 1) == count($apartments))) {
                $i = 0;
                if ($div) {
                    $div = false;
                    echo '</div>';
                }
            } ?>
        <?php endforeach; ?>
    </div>

</div>

