<?php

namespace app\models\cases;

use Yii;
use yii\base\Model;
use app\models\entities\Users;

/**
 * FindCurrenciesByDate model to find currencies by date.
 *
 * @property Users|null $user This property is read-only.
 *
 */
class FindCurrenciesByDate extends Model
{
    public $dateID;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['dateID', 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dateID'       => Yii::t('app', Yii::t('app', 'Choose date')),
        ];
    }
}
