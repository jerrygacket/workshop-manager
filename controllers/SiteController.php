<?php

namespace app\controllers;

use app\models\TaskLogger;
use app\models\TaskLoggerSearch;
use app\models\TechCard;
use app\models\UserOperations;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['get'], //['post']
//                ],
//            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->actionLogin();
        }

        $TechCard = new TechCard();
        //$userOperationsCount = UserOperations::find()->where(['userId' => Yii::$app->user->id])->count();

        return $this->render('index', [
            'cards' => $TechCard->getAllCards('KB', true),
            //'operationsCount' => 2//$userOperationsCount
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        if (Yii::$app->user->logout()) {
            return $this->goHome();
        }
    }

    public function actionGetOperations() {
        $result = [
            'error' => true,
            'message' => 'Не работает. Вообще.',
        ];
        $techCardUuid = Yii::$app->request->queryParams['uuid'] ?? null;
        $TechCard = new TechCard();

        if (Yii::$app->request->isGet && ($operations = $TechCard->getOperations($techCardUuid))) {
            $result = [
                'result' => $this->renderPartial('_operations', ['operations' => $operations]),
                'error' => false,
            ];
        }

        $this->SendJsonResponse($result);
    }

    /**
     * @var $userOperation UserOperations
     */
    public function actionAddOperation() {
        if (Yii::$app->user->isGuest) {
            $result = [
                'error' => true,
                'message' => 'Нужно выполнить вход в систему еще раз.'
            ];
            $this->SendJsonResponse($result);
        }

        $result = [
            'error' => true,
            'message' => 'Не работает. Вообще.'
        ];
        $total = intval(Yii::$app->request->queryParams['total']);
        $done = intval(Yii::$app->request->queryParams['done']);

        if ($done > $total) {
            $result = [
                'error' => true,
                'message' => 'Выполнено больше, чем надо.'
            ];
            $this->SendJsonResponse($result);
        }

        if ($done <= 0) {
            $result = [
                'error' => true,
                'message' => 'Выполнено меньше, чем надо.'
            ];
            $this->SendJsonResponse($result);
        }

        $userOperation = UserOperations::findOne([
            'techCardUuid' => Yii::$app->request->queryParams['techCardUuid'],
            'operationUuid' => Yii::$app->request->queryParams['operationUuid'],
        ]);

        if ($userOperation) {
            if ($userOperation->done + $done > $userOperation->total) {
                $result = [
                    'error' => true,
                    'message' => 'Выполнено больше, чем надо.'
                ];
                $this->SendJsonResponse($result);
            }
            $userOperation->done = $userOperation->done + $done;
        } else {
            $result = [
                'error' => true,
                'message' => 'Не найдена опреация '.Yii::$app->request->queryParams['description']
            ];
            $this->SendJsonResponse($result);
        }

        if ($userOperation->save()) {
            $log = new TaskLogger();
            $log->userId = \Yii::$app->user->id;
            $log->techCardUuid = $userOperation->techCardUuid;
            $log->operationUuid = $userOperation->operationUuid;
            $log->operationId = $userOperation->id;
            $log->total = $userOperation->total;
            $log->done = $done;
            $log->comment = Yii::$app->request->queryParams['comment'];;
            $log->totalDone = $userOperation->done;
            $log->techCardNumber = TechCard::getTechCardByUuid($userOperation->techCardUuid);
            $log->orderNumber = $userOperation->orderNumber;
            $log->save();
            $TechCard = new TechCard();
            $operations = $TechCard->getOperations($userOperation->techCardUuid);
            $result = [
                'result' => $this->renderPartial('_operations', [
                    'techCardUuid' => $userOperation->techCardUuid,
                    'operations' => $operations
                ]),
                'error' => false,
            ];
        } else {
            $result = [
                'error' => true,
                'message' => 'Не сохранилась опреация '.Yii::$app->request->queryParams['description']
            ];
            $this->SendJsonResponse($result);
        }

        $this->SendJsonResponse($result);
    }

    public function SendJsonResponse(array $response) {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $object = (object) $response;
        Yii::$app->response->data = $object;
        Yii::$app->response->send();

        Yii::$app->end(0);
    }

    public function actionJournal() {
        $searchModel = new TaskLogger();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('journal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
