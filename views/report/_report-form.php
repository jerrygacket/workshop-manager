<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$usersList = \yii\helpers\ArrayHelper::map(
    \app\models\User::getAllUsers(),
    'id',
    'username');

$form = ActiveForm::begin([
    'id' => 'reportForm',
    'action' => '/report',
    'method' => 'post',
]);
?>
<div class="row">
    <div class="col-md-6 col-12">
        <?php
        echo $form->field($model, 'userId')->dropdownList(
            $usersList,
            ['prompt'=>'Пользователь...']
        );

        echo $form->field($model, 'order')->textInput();
        echo $form->field($model, 'techCard')->textInput();
        ?>
    </div>
    <div class="col-md-6 col-12">
        <?php
        echo $form->field($model, 'dateFrom')->textInput(['type' => 'date']);
        echo $form->field($model, 'dateTo')->textInput(['type' => 'date']);
        echo Html::submitButton('Применить', ['class' => 'btn btn-secondary', 'name' => 'filter-button']);
        echo Html::a('Сбросить', 'report', ['class' => 'btn btn-info', 'name' => 'filter-button']);
        ?>
    </div>
</div>
<?php

ActiveForm::end();