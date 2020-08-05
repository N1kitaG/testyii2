<?php

namespace app\models;

use app\models\entities\CurrenciesValues;
use Yii;
use app\models\entities\Dates;
use app\models\entities\Users;

/**
 * Crawler that gets the content from:
 * http://www.cbr.ru/scripts/XML_daily.asp *
 *
 * @property Users|null $user This property is read-only.
 *
 */
class CurrenciesCrawler
{
    private $link       = "http://www.cbr.ru/scripts/XML_daily.asp";
    private $xml        = null;
    private $content    = null;
    public  $values     = null;
    public  $date       = null;
    public  $dateID     = null;

    public function __construct()
    {
        $this->xml     = simplexml_load_file($this->link);
        $this->date    = (string) $this->xml['Date'];
        $this->xmlToArray();

        $this->dateID  = (Dates::getBy(['date' => $this->date])->id)
            ? Dates::getBy(['date' => $this->date])->id
            : Dates::insertDate($this->date)
        ;

        $this->values  = (CurrenciesValues::getListByDate($this->dateID))
            ? CurrenciesValues::getListByDate($this->dateID)
            : CurrenciesValues::setValues($this->dateID, $this->content)
        ;
    }

    /**
     * Parce XML content to PHP Array.
     *
     */
    public function xmlToArray()
    {
        $arResult = [];

        foreach ($this->xml->Valute as $key => $valute) {
            $arResult[(string) $valute["ID"][0]] = [
                'num'       => (string) $valute->NumCode[0],
                'char'      => (string) $valute->CharCode[0],
                'nominal'   => (integer) $valute->Nominal[0],
                'name'      => (string) $valute->Name[0],
                'value'     => (string) $valute->Value[0],
            ];
        }

        $this->content = $arResult;
    }
}
