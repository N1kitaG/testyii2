<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 04.08.2020
 * Time: 17:13
 */

use yii\helpers\Html;

$this->title = Yii::t('app','User was successfully created');
?>
<h1><?= $this->title ?></h1>
<p><?= Html::a(Yii::t('app', 'login'), ['/login'])?></p>