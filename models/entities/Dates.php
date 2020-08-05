<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 04.08.2020
 * Time: 16:06
 */

namespace app\models\entities;

use Yii;
use \yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "dates".
 *
 * @property int $id
 * @property string $date
 */

class Dates extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dates';
    }

    /**
     * Get date via filter.
     *
     * @returns object Dates
     */
    public static function getBy($filter)
    {
        return Dates::find()
            ->where($filter)
            ->one();
    }

    /**
     * Inserts id DB new value.
     *
     * @returns integer
     */
    public static function insertDate($date)
    {
        $dates = new Dates();
        $dates->date = $date;
        $dates->save();

        return $dates->id;
    }
}