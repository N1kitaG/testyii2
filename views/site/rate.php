<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 04.08.2020
 * Time: 18:04
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Currency rate');
$this->params['breadcrumbs'][] = $this->title;
?>
<p><?= Yii::t('app', 'Date')?>: <strong><?= $date->date ?></strong></p>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'dateID')->dropDownList($dates, [
    'class' => 'form-control change-zone',
    'options' => [
        $dateID => [
            'Selected' => 'selected'
        ]
    ]]); ?>
<?php ActiveForm::end(); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'header'    => Yii::t('app', 'Name'),
            'value'     => 'name',

        ],
        [
            'header'    => Yii::t('app', 'Char'),
            'value'     => 'char'
        ],
        [
            'header'    => Yii::t('app', 'Nominal'),
            'value'     => 'nominal'
        ],
        [
            'header'    => Yii::t('app', 'Value'),
            'value'     => 'value'
        ],
    ]
]);?>