<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\helpers\Markdown;

//$this->params['operationsCount'] = $operationsCount;
$this->title = Yii::$app->name;
?>
<h1>ТехКарты</h1>
    <table id="techCardTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th class="th-sm">Название
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cards as $card) {
            if (!$card['reference']) {
                continue;
            }
            ?>
            <tr>
                <td>
                    <?= str_replace(' - ', '<br>', $card['title']) ?>
                    <br>
                    <!-- Button trigger modal -->
                    <a href="#" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#modal<?= $card['id'] ?>">
                        Описание
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="modal<?= $card['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?= $card['id'] ?>"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel<?= $card['id'] ?>"><?= $card['title'] ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?= Markdown::process($card['description']) ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php if (isset($card['files'])) {
                        foreach ($card['files'] as $file) {
                            $path_parts = pathinfo($file['name']);
                            $ext = strtolower($path_parts['extension']);
                            ?>
                            <a class="btn btn-light btn-sm mb-3 mr-3" target="_blank"
                                href="http://kanboard.fdp/?controller=FileViewerController&action=<?=$ext == 'jpg' ? 'image' : 'browser'?>&task_id=<?= $card['id'] ?>&project_id=<?= $card['project_id'] ?>&file_id=<?= $file['id'] ?>">
                                <?= $file['name'] ?>
                            </a>
                        <?php }
                    }?>
                    <br>
                    <?= Html::a('Операции', ['#'], ['class' => 'btn btn-info ajaxLink mb-3', 'id' => 'link'.$card['id'], 'data-uuid' => $card['reference'] ?? '']) ?>
                    <div id="result<?= $card['reference'] ?>"></div>
                </td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
