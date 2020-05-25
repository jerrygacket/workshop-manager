<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;

$this->title = Yii::$app->name.' - Вход';
$this->params['breadcrumbs'][] = 'Вход';
?>
<div class="site-login">
    <h1>Вход</h1>

    <?= $this->render('_login-form', ['model' => $model]) ?>

</div>
