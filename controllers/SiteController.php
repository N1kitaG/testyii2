<?php

namespace app\controllers;


use app\models\cases\RegisterForm;
use app\models\CurrenciesCrawler;
use app\models\entities\CurrenciesValues;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\cases\LoginForm;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/rate']);
        }

        return $this->render('index');
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

            return $this->redirect(['/rate']);
        }

        $model->password = '';
        return $this->render('login', compact('model'));
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Rate action.
     *
     * @return string
     */
    public function actionRate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/login']);
        }

        $crawler = new CurrenciesCrawler();

        $date    = $crawler->date;
        $dateID  = $crawler->dateID;
        $dataProvider = new ActiveDataProvider([
            'query' => CurrenciesValues::find()
                ->select(['currency_id', 'value', 'char', 'nominal', 'name'])
                ->innerJoin('currencies', 'currencies.id = currencies_values.currency_id')
                ->where(['date_id' => $dateID])->asArray(),
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $this->render('rate', compact('dataProvider', 'date'));
    }

    /**
     * Displays register page.
     *
     * @return string
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->createUser()) {
            return $this->redirect(['/login']);
        }

        return $this->render('register', compact('model'));
    }
}
