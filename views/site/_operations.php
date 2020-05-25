<?php
/**
 * @var $operations \app\models\UserOperations[]
 */
?>
<div class="alert alert-dark" role="alert">
    <?php foreach ($operations as $operation) {
        if ($operation->description == 'Верстка') {
            continue;
        }
        $del = $operation->done == $operation->total;
        echo '<p>'.($del ? '<del>' : '');
        echo $operation->description . ': выполнено ' . $operation->done . ' из ' . $operation->total . '<br>';
        if (!$del) {
            echo \yii\helpers\Html::textInput('comment', '', [
                'id' => 'comment'.$operation->id,
                'placeholder' => 'Комментарий',
            ]);
            echo \yii\helpers\Html::input('number', 'inputDone'.$operation->id, 0, [
                'id' => 'inputDone'.$operation->id,
                'min' => 0,
                'max' => ($operation->total - $operation->done),
            ]);
            echo \yii\helpers\Html::button('Выполнил', [
                'onclick' => 'addOperation(this)',
                'class' => 'btn btn-secondary btn-sm',
                'data-total' => $operation->total,
                'data-techCardUuid' => $operation->techCardUuid,
                'data-operationUuid' => $operation->operationUuid,
                'data-operationId' => $operation->id,
                'data-description' => $operation->description,
            ]);
        }
        echo ($del ? '</del>' : '').'</p>';
    } ?>
</div>
