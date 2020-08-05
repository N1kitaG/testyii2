<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'The Crawler';
?>
<div class="site-index">
    <p> <?= Yii::t('app', 'Please make') ?>
        <?= Html::a(Yii::t('app', 'login'), ['/login']) ?>
        <?= Yii::t('app', 'or')?>
        <?= Html::a(Yii::t('app', 'to register'), ['/register']) ?></p>
</div>
