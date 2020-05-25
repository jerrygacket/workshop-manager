<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<!-- Collapse buttons -->
<div>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseFilter"
        aria-expanded="false" aria-controls="collapseFilter">
        Фильтры
    </button>
</div>
<!-- / Collapse buttons -->

<!-- Collapsible element -->
<div class="collapse" id="collapseFilter">
    <div class="mt-3">
        <?php
        $form = ActiveForm::begin([
            'id' => 'filter-form',
            'action' => '/site/journal',
            'method' => 'get',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]);
        $usersList = \yii\helpers\ArrayHelper::map(
            \app\models\User::getAllUsers(),
            'id',
            'username');
        //$ordersList =
        ?>
        <?= \yii\helpers\Html::dropDownList('user',null,
            $usersList,
            [
                'prompt' => 'Пользователь...',
            ]
        )?>
        <?= Html::submitButton('Применить', ['class' => 'btn btn-secondary', 'name' => 'filter-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<!-- / Collapsible element -->