<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\User;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/css/all.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="/css/mdb.min.css">

    <!-- Docs for tables -> https://datatables.net-->
    <link rel="stylesheet" href="/css/addons/datatables.min.css">

    <link rel="stylesheet" href="/css/site.css">
</head>
<body>

<?php NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark blue-gradient',
    ],
]);

$menuItems = [];
if (Yii::$app->user->isGuest) {
    echo '';
} else {
    $menuItems = [
        '<li class="nav-item">'
        .Html::a('<i class="fas fa-home"></i>', [Yii::$app->homeUrl],
            [
                'class' => 'nav-link waves-effect waves-light',
                'title' => 'На главную',
                'data-toggle' => 'tooltip',
            ])
        . '</li>'
    ];
    if ( in_array(Yii::$app->user->id, User::VIEW_REPORT)) {
//        $menuItems[] = '<li class="nav-item">'
//            .Html::a('<i class="fas fa-cogs"></i>', ['/site/about'],
//                [
//                    'class' => 'nav-link waves-effect waves-light',
//                    'title' => 'Настройки',
//                    'data-toggle' => 'tooltip',
//                ])
//            . '</li>';
//        $menuItems[] = '<li class="nav-item">'
//            .Html::a('<i class="fas fa-users"></i>', ['/users/index'],
//                [
//                    'class' => 'nav-link waves-effect waves-light',
//                    'title' => 'Пользователи',
//                    'data-toggle' => 'tooltip',
//                ])
//            . '</li>';
        $menuItems[] = '<li class="nav-item">'
            .Html::a('<i class="fas fa-book"></i>', ['/site/journal'],
                [
                    'class' => 'nav-link waves-effect waves-light',
                    'title' => 'Журнал',
                    'data-toggle' => 'tooltip',
                ])
            . '</li>';
        $menuItems[] = '<li class="nav-item">'
            .Html::a('<i class="far fa-file-alt"></i>', ['/report'],
                [
                    'class' => 'nav-link waves-effect waves-light',
                    'title' => 'Отчеты',
                    'data-toggle' => 'tooltip',
                ])
            . '</li>';
    }
    if ($hasOperations = (isset($this->params['operationsCount']) && $this->params['operationsCount'] > 0)){
        $menuItems[] = '<li class="nav-item">'
            .Html::a(
                '<i class="fas fa-shopping-cart"></i>'
                .($hasOperations
                    ? '<span id="operationsCount" class="badge badge-danger ml-2">'.$this->params['operationsCount'].'</span">'
                    : ''
                ),
                ['/site/cart'],
                [
                    'class' => 'nav-link waves-effect waves-light',
                    'title' => 'Мои операции',
                    'data-toggle' => 'tooltip',
                ])
            . '</li>';
    }
    $menuItems[] = '<li class="nav-item">'
        .Html::a(
            '('. Yii::$app->user->identity->username .')'.'<i class="fas fa-sign-out-alt"></i>',
            ['/site/logout'],
            [
                'class' => 'nav-link waves-effect waves-light',
                'title' => 'Выход',
                'data-toggle' => 'tooltip',
            ])
        . '</li>';
}
echo \yii\bootstrap4\Nav::widget([
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => $menuItems,
]);

\yii\bootstrap4\NavBar::end();
?>

<div class="container mt-3 mb-3">
    <?= $content ?>
</div>
<footer class="page-footer font-small blue">
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© <?=date('Y') == '2020' ? '2020' : '2020 - '.date('Y') ?> Copyright:
        My Copyright
    </div>
    <!-- Copyright -->

</footer>

<!-- jQuery -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="/js/mdb.min.js"></script>

<!-- Docs for tables -> https://datatables.net-->
<script type="text/javascript" src="/js/addons/datatables.min.js"></script>
<script type="text/javascript" src="/js/addons/datatables-select.min.js"></script>
<script type="text/javascript" src="/js/tableSort.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/sender.js"></script>
<script type="text/javascript" src="/js/actions.js"></script>
</body>
</html>
<?php $this->endPage() ?>
