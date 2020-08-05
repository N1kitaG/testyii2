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
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property int $num
 * @property int $nominal
 * @property string $code
 * @property string $char
 * @property string $name
 */
class Currencies extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currencies';
    }
}