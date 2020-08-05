<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 04.08.2020
 * Time: 16:06
 */

namespace app\models\entities;

use Yii;
use yii\data\ActiveDataProvider;
use \yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "currencies_values".
 *
 * @property int $id
 * @property int $date_id
 * @property int $currency_id
 * @property string $value
 */

class CurrenciesValues extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currencies_values';
    }

    /**
     * Sets the values for the currencies
     *
     * @returns object
     */
    public static function getListByDate($dateID)
    {
        return CurrenciesValues::find()
            ->select(['currency_id', 'value', 'char', 'nominal', 'name'])
            ->innerJoin('currencies', 'currencies.id = currencies_values.currency_id')
            ->where(['date_id' => $dateID])
            ->all();
    }

    /**
     * Sets the values for the currencies
     *
     * @returns self method
     */
    public static function setValues($dateID, $content)
    {
        $currencies = Currencies::find()
            ->select(['id', 'code'])
            ->all();

        foreach ($currencies as $currency) {
            $model                  = new CurrenciesValues();
            $model->date_id         = $dateID;
            $model->currency_id     = $currency->id;
            $model->value           = $content[$currency->code]['value'];
            $model->save();
        }

        return self::getListByDate($dateID);
    }
}