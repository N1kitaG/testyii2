<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 05.08.2020
 * Time: 9:49
 */

namespace app\controllers;

use app\models\CurrenciesCrawler;
use yii\web\Controller;

class DaemonController extends Controller
{
    public function actionDaily()
    {
        $crawler = new CurrenciesCrawler();
        unset($crawler);
    }
}