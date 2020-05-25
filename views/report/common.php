<?php

/**
 * @var $data \app\models\TaskLogger[]
 * @var $this yii\web\View
 */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Общий отчет - ' . Yii::$app->name;
?>
<div class="row">
    <div class="col-12">
        <p>
            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Фильры
            </button>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <?=$this->render('_report-form', ['model' => $model,])?>
            </div>
        </div>
    </div>
</div>
    <hr>
<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="day-tab" data-toggle="tab" href="#day" role="tab" aria-controls="day"
                        aria-selected="true">Сегодня</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="yesterday-tab" data-toggle="tab" href="#yesterday" role="tab" aria-controls="yesterday"
                        aria-selected="true">Вчера</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="week-tab" data-toggle="tab" href="#week" role="tab" aria-controls="week"
                        aria-selected="false">Неделя</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="month"
                        aria-selected="false">Месяц</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="day" role="tabpanel" aria-labelledby="day-tab">
                <?php
                $userOps = \app\models\ReportModel::groupByUser($dayData);
                if (empty($userOps)) {
                    echo '<h3>Нет данных</h3>';
                }
                foreach (\app\models\User::getAllUsers() as $user) {
                    if (!empty($userOps[$user['id']])) {
                        echo '<h3>'.$user['username'].'</h3>';
                        echo $this->render('_operations', [
                            'data' => $userOps[$user['id']],
                            'tableId' => 'day'.$user['id'],
                        ]);
                        echo '<hr>'.PHP_EOL;
                    }
                }
                ?>
            </div>
            <div class="tab-pane fade" id="yesterday" role="tabpanel" aria-labelledby="yesterday-tab">
                <?php
                $userOps = \app\models\ReportModel::groupByUser($yesterdayData);
                if (empty($userOps)) {
                    echo '<h3>Нет данных</h3>';
                }
                foreach (\app\models\User::getAllUsers() as $user) {
                    if (!empty($userOps[$user['id']])) {
                        echo '<h3>'.$user['username'].'</h3>';
                        echo $this->render('_operations', [
                            'data' => $userOps[$user['id']],
                            'tableId' => 'day'.$user['id'],
                        ]);
                        echo '<hr>'.PHP_EOL;
                    }
                }
                ?>
            </div>
            <div class="tab-pane fade" id="week" role="tabpanel" aria-labelledby="week-tab">
                <?php
                $userOps = \app\models\ReportModel::groupByUser($weekData);
                if (empty($userOps)) {
                    echo '<h3>Нет данных</h3>';
                }
                foreach (\app\models\User::getAllUsers() as $user) {
                    if (!empty($userOps[$user['id']])) {
                        echo '<h3>'.$user['username'].'</h3>';
                        echo $this->render('_operations', [
                            'data' => $userOps[$user['id']],
                            'tableId' => 'week'.$user['id'],
                        ]);
                        echo '<hr>'.PHP_EOL;
                    }
                }
                ?>
            </div>
            <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                <?php
                $userOps = \app\models\ReportModel::groupByUser($monthData);
                if (empty($userOps)) {
                    echo '<h3>Нет данных</h3>';
                }
                foreach (\app\models\User::getAllUsers() as $user) {
                    if (!empty($userOps[$user['id']])) {
                        echo '<h3>'.$user['username'].'</h3>';
                        echo $this->render('_operations', [
                            'data' => $userOps[$user['id']],
                            'tableId' => 'month'.$user['id'],
                        ]);
                        echo '<hr>'.PHP_EOL;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>