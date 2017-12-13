<?php
namespace App\Db\Importers;

use yii\db\Schema;

/**
 * Base class for database import
 * @package YetiForce.App
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Base
{

	/**
	 * Database section
	 * @var string 
	 */
	public $dbType = 'base';

	/**
	 * Table structure
	 * @var array 
	 */
	public $tables;

	/**
	 * Foreign keys
	 * @var array 
	 */
	public $foreignKey;

	/**
	 * Data to import
	 * @var array 
	 */
	public $data;

	/**
	 * Db
	 * @var \App\Db 
	 */
	public $db;

	/**
	 * Db schema
	 * @var \yii\db\Schema 
	 */
	protected $schema;

	/**
	 * Construct
	 */
	public function __construct()
	{
		$this->db = \App\Db::getInstance($this->dbType);
		$this->schema = $this->db->getSchema();
	}

	/**
	 * Creates a primary key column.
	 * @param integer $length column size or precision definition.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function primaryKey($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_PK, $length)->notNull();
	}

	/**
	 * Creates a primary unsigned key column.
	 * @param integer $length column size or precision definition.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function primaryKeyUnsigned($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_UPK, $length)->notNull();
	}

	/**
	 * Creates a big primary key column.
	 * @param integer $length column size or precision definition.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function bigPrimaryKey($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_BIGPK, $length)->notNull();
	}

	/**
	 * Creates a big primary unsigned key column.
	 * @param integer $length column size or precision definition.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function bigPrimaryKeyUnsigned($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_UBIGPK, $length)->notNull();
	}

	/**
	 * Creates a char column.
	 * @param integer $length column size definition i.e. the maximum string length.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function char($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_CHAR, $length);
	}

	/**
	 * Creates a string column.
	 * @param integer $length column size definition i.e. the maximum string length.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function stringType($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_STRING, $length);
	}

	/**
	 * Creates a text column.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function text()
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_TEXT);
	}

	/**
	 * Creates a tinyint column. Available only in MySql.
	 * @param integer $length column size or precision definition.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function tinyInteger($length = 5)
	{
		return $this->schema->createColumnSchemaBuilder('tinyint', $length);
	}

	/**
	 * Creates a smallint column.
	 * @param integer $length column size or precision definition.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function smallInteger($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_SMALLINT, $length);
	}

	/**
	 * Creates an integer column.
	 * @param integer $length column size or precision definition.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function integer($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_INTEGER, $length);
	}

	/**
	 * Creates a bigint column.
	 * @param integer $length column size or precision definition.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function bigInteger($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_BIGINT, $length);
	}

	/**
	 * Creates a float column.
	 * @param integer $precision column value precision. First parameter passed to the column type, e.g. FLOAT(precision).
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function floatType($precision = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_FLOAT, $precision);
	}

	/**
	 * Creates a double column.
	 * @param integer $precision column value precision. First parameter passed to the column type, e.g. DOUBLE(precision).
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function double($precision = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_DOUBLE, $precision);
	}

	/**
	 * Creates a decimal column.
	 * @param integer $precision column value precision, which is usually the total number of digits.
	 * First parameter passed to the column type, e.g. DECIMAL(precision, scale).
	 * This parameter will be ignored if not supported by the DBMS.
	 * @param integer $scale column value scale, which is usually the number of digits after the decimal point.
	 * Second parameter passed to the column type, e.g. DECIMAL(precision, scale).
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function decimal($precision = null, $scale = null)
	{
		$length = [];
		if ($precision !== null) {
			$length[] = $precision;
		}
		if ($scale !== null) {
			$length[] = $scale;
		}
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_DECIMAL, $length);
	}

	/**
	 * Creates a datetime column.
	 * @param integer $precision column value precision. First parameter passed to the column type, e.g. DATETIME(precision).
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function dateTime($precision = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_DATETIME, $precision);
	}

	/**
	 * Creates a timestamp column.
	 * @param integer $precision column value precision. First parameter passed to the column type, e.g. TIMESTAMP(precision).
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function timestamp($precision = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_TIMESTAMP, $precision);
	}

	/**
	 * Creates a time column.
	 * @param integer $precision column value precision. First parameter passed to the column type, e.g. TIME(precision).
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function time($precision = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_TIME, $precision);
	}

	/**
	 * Creates a date column.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function date()
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_DATE);
	}

	/**
	 * Creates a binary column.
	 * @param integer $length column size or precision definition.
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function binary($length = null)
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_BINARY, $length);
	}

	/**
	 * Creates a varbinary column. Available only in MySql.
	 * @param integer $length column size or precision definition.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function varbinary($length = 255)
	{
		return $this->schema->createColumnSchemaBuilder('varbinary', $length);
	}

	/**
	 * Creates a boolean column.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function boolean()
	{
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_BOOLEAN);
	}

	/**
	 * Creates a money column.
	 * @param integer $precision column value precision, which is usually the total number of digits.
	 * First parameter passed to the column type, e.g. DECIMAL(precision, scale).
	 * This parameter will be ignored if not supported by the DBMS.
	 * @param integer $scale column value scale, which is usually the number of digits after the decimal point.
	 * Second parameter passed to the column type, e.g. DECIMAL(precision, scale).
	 * This parameter will be ignored if not supported by the DBMS.
	 * @return \yii\db\ColumnSchemaBuilder the column instance which can be further customized.
	 */
	public function money($precision = null, $scale = null)
	{
		$length = [];
		if ($precision !== null) {
			$length[] = $precision;
		}
		if ($scale !== null) {
			$length[] = $scale;
		}
		return $this->schema->createColumnSchemaBuilder(Schema::TYPE_MONEY, $length);
	}
}
