<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currencies}}`.
 */
class m200804_161851_create_currencies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currencies}}', [
            'id'        => $this->primaryKey(),
            'code'      => $this->string(255),
            'num'       => $this->integer(3),
            'char'      => $this->string(3),
            'nominal'   => $this->integer(11),
            'name'      => $this->string(11),
        ]);

        $this->createTable('{{%dates}}', [
            'id'        => $this->primaryKey(),
            'date'      => $this->string(11),
        ]);

        $this->createTable('{{%currencies_values}}', [
            'id'            => $this->primaryKey(),
            'date_id'       => $this->integer(11),
            'currency_id'   => $this->integer(11),
            'value'         => $this->string(11),
        ]);

        $this->createIndex('currencies_values_date_id_foreign', 'currencies_values', 'date_id');
        $this->addForeignKey('currencies_values_date_id_foreign', 'currencies_values', 'date_id', 'dates', 'id');

        $this->createIndex('currencies_values_currency_id_foreign', 'currencies_values', 'currency_id');
        $this->addForeignKey('currencies_values_currency_id_foreign', 'currencies_values', 'currency_id', 'currencies', 'id');

        $xml = simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp');

        foreach ($xml->Valute as $key => $valute) {
            $this->insert('currencies', [
                'code' => (string) $valute["ID"][0],
                'num'       => (string) $valute->NumCode[0],
                'char'      => (string) $valute->CharCode[0],
                'nominal'   => (integer) $valute->Nominal[0],
                'name'      => (string) $valute->Name[0],
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $errors = [];

        $tables = [
            '{{%currencies}}',
            '{{%dates}}',
            '{{%currencies_values}}'
        ];

        $this->dropForeignKey('currencies_values_date_id_foreign', 'currencies_values');
        $this->dropIndex('currencies_values_date_id_foreign', 'currencies_values');

        $this->dropForeignKey('currencies_values_currency_id_foreign', 'currencies_values');
        $this->dropIndex('currencies_values_currency_id_foreign', 'currencies_values');

        foreach ($tables as $key => $table) {
            if (!$this->dropTable($table)) {
                $errors[] = "Drop table '{$table}' failed.\n";
            }
        }

        return true;
    }
}
