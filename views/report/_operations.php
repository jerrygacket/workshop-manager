<?php
if (!empty($data)) {?>
    <div class="row">
        <div class="col-12">
            <table id="reportTable<?= $tableId ?>" class="table table-striped table-bordered table-sm reportTable">
                <thead>
                <tr>
                    <th><?= Yii::t('app', 'ID') ?></th>
                    <th><?= Yii::t('app', 'User') ?></th>
                    <th><?= Yii::t('app', 'Operation') ?></th>
                    <th><?= Yii::t('app', 'Comment') ?></th>
                    <th><?= Yii::t('app', 'Created On') ?></th>
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
                        <td><?= $item->comment ?></td>
                        <td><?= $item->created_on ?></td>
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