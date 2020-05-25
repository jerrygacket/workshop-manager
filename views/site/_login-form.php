<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'login-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],
]);
$usersList = \yii\helpers\ArrayHelper::map(
    \app\models\User::getAllUsers(),
    'username',
    'username');
?>

<?php // $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'username')->dropDownList(
    $usersList,
    [
        'autofocus' => true,
        'prompt' => '',
        //'id' => 'operatorSelect',
        'class' => 'browser-default custom-select'
    ]) ?>

<?= $form->field($model, 'password')->passwordInput() ?>

    <div>
        <!-- Remember me -->
        <div class="custom-control custom-checkbox">
            <?= $form->field($model, 'rememberMe', ['options' => ['tag' => false,]])
                ->checkbox([
                    'template' => '{input}{label}',
                    'class' => 'custom-control-input'
                ], false)
                ->label('Запомнить меня', ['class' => 'custom-control-label']); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>