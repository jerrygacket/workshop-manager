<?php


namespace app\controllers;


use app\models\ReportModel;
use Yii;
use yii\web\Controller;

class ReportController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }

        $model = new ReportModel();
        if (Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
        }

        return $this->render('common', [
            'model' => $model,
            'dayData' => $model->getDayReport(),
            'yesterdayData' => $model->getYesterdayReport(),
            'weekData' => $model->getWeekReport(),
            'monthData' => $model->getMonthReport(),
        ]);
    }
}