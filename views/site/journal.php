<?php
$this->title = 'Журнал - ' . Yii::$app->name;
?>

<?=\yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => [
        'class' => 'table table-striped table-bordered',
        'id' => 'journalTable',
    ],
    'columns' => [
        'id:html',
        'operation:html',
//        'user:html',
        [
            'attribute'=>'user',
            'contentOptions' =>function ($model, $key, $index, $column){
                return ['class' => 'name'];
            },
            'content' => function($data){
                return \yii\helpers\Html::a($data->getUser(), '?user='.$data->userId, ['style' => 'text-decoration:underline; text-decoration-style:dashed;']);
            }
        ],
        'techCardNumber:html',
        'orderNumber:html',
        'total:html',
        'done:html',
        'totalDone:html',
        [
            'attribute' => 'created_on',
            'format' =>  ['date', 'HH:mm:ss dd.MM.Y'],
        ],
    ],
    'pager' => [
        'options'=>['class'=>'pagination pg-teal justify-content-center'],   // set class name used in ui list of pagination
        'disabledPageCssClass' => 'disabled',
        'disabledListItemSubTagOptions' => [
            'tag' => 'a',
            'class' => 'page-link',
        ],
        'linkContainerOptions' => [
            'class' => 'page-item',
        ],
        'prevPageLabel' => '<',   // Set the label for the “previous” page button
        'nextPageLabel' => '>',   // Set the label for the “next” page button
        'firstPageLabel'=>'<<',   // Set the label for the “first” page button
        'lastPageLabel'=>'>>',    // Set the label for the “last” page button
//        'nextPageCssClass'=>'page-item',    // Set CSS class for the “next” page button
//        'prevPageCssClass'=>'page-item',    // Set CSS class for the “previous” page button
//        'firstPageCssClass'=>'page-item',    // Set CSS class for the “first” page button
//        'lastPageCssClass'=>'page-item',    // Set CSS class for the “last” page button
        'maxButtonCount'=>10,    // Set maximum number of page buttons that can be displayed
        'linkOptions' => [
            'class' => 'page-link'
        ]
    ],
])
?>
<?php if (!empty($model->id)) {
    echo '<h3>' . \yii\helpers\Html::encode($model->id) . '</h3>';

    echo \yii\widgets\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'description:html',
            'created_on:date',
        ],
    ]);
}
?>