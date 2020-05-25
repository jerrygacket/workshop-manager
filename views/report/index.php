<?php

/**
 * @var $data \app\models\TaskLogger[]
 */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Отчет - ' . Yii::$app->name;
?>
<div class="row">
    <div class="col-md-6 col-12">
        <?=$this->render('_report-form', ['model' => $model,])?>
    </div>
    <div class="col-md-6 col-12">
        <?php if (!empty($total['operations'])) { ?>
            <h3>Итоги по операциям</h3>
            <table id="totalTable" class="table table-striped table-bordered table-sm">
                <thead>
                <tr>
                    <th><?= Yii::t('app', 'Operation') ?></th>
                    <th><?= Yii::t('app', 'Total') ?></th>
                    <th><?= Yii::t('app', 'Done') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($total['operations'] as $key => $item) {
                    ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= $item['total'] ?></td>
                        <td><?= $item['done'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
    <hr>
<?php
if (!empty($data)) {?>
    <div class="row">
        <div class="col-12">
            <table id="reportTable" class="table table-striped table-bordered table-sm">
                <thead>
                <tr>
                    <th><?= Yii::t('app', 'ID') ?></th>
                    <th><?= Yii::t('app', 'User') ?></th>
                    <th><?= Yii::t('app', 'Operation') ?></th>
                    <th><?= Yii::t('app', 'Tech Card Number') ?></th>
                    <th><?= Yii::t('app', 'Order Number') ?></th>
                    <th><?= Yii::t('app', 'Total') ?></th>
                    <th><?= Yii::t('app', 'Done') ?></th>
                    <th><?= Yii::t('app', 'Total Done') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($data as $itemKey => $item) {
                        ?>
                        <tr>
                            <td><?= $item->id ?></td>
                            <td><?= $item->getUser() ?></td>
                            <td><?= $item->getOperation() ?></td>
                            <td><?= $item->techCardNumber ?></td>
                            <td><?= $item->orderNumber ?></td>
                            <td><?= $item->total ?></td>
                            <td><?= $item->done ?></td>
                            <td><?= $item->totalDone ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}
?>