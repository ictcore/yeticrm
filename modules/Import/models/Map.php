<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Import_Map_Model extends \App\Base
{

	public static $tableName = 'vtiger_import_maps';
	public $map;
	public $user;

	public function __construct($map, $user)
	{
		$this->map = $map;
		$this->user = $user;
	}

	public static function getInstanceFromDb($row, $user)
	{
		$map = [];
		foreach ($row as $key => $value) {
			if ($key == 'content') {
				$content = [];
				$pairs = explode("&", $value);
				foreach ($pairs as $pair) {
					list($mappedName, $sequence) = explode("=", $pair);
					$mappedName = str_replace('/eq/', '=', $mappedName);
					$mappedName = str_replace('/amp/', '&', $mappedName);
					$content["$mappedName"] = $sequence;
				}
				$map[$key] = $content;
			} else {
				$map[$key] = $value;
			}
		}
		return new Import_Map_Model($map, $user);
	}

	public static function markAsDeleted($mapId)
	{
		\App\Db::getInstance()
			->createCommand()
			->update('vtiger_import_maps', ['date_modified' => date('Y-m-d H:i:s'), 'deleted' => 1], ['id' => $mapId])
			->execute();
	}

	public function getId()
	{
		$map = $this->map;
		return $map['id'];
	}

	public function getAllValues()
	{
		return $this->map;
	}

	public function getValue($key)
	{
		$map = $this->map;
		return $map[$key];
	}

	public function getStringifiedContent()
	{
		if (empty($this->map['content']))
			return;
		$content = $this->map['content'];
		$keyValueStrings = [];
		foreach ($content as $key => $value) {
			$key = str_replace('=', '/eq/', $key);
			$key = str_replace('&', '/amp/', $key);
			$keyValueStrings[] = $key . '=' . $value;
		}
		$stringifiedContent = implode('&', $keyValueStrings);
		return $stringifiedContent;
	}

	public function save()
	{
		$db = PearDatabase::getInstance();

		$map = $this->getAllValues();
		$map['content'] = "" . $db->getEmptyBlob() . "";
		$map['date_entered'] = date('Y-m-d H:i:s');
		$columnNames = array_keys($map);
		$columnValues = array_values($map);
		if (count($map) > 0) {
			$sql = 'INSERT INTO ' . self::$tableName . ' (' . implode(',', $columnNames) . ') VALUES (' . generateQuestionMarks($columnValues) . ')';
			$db->pquery($sql, [$columnValues]);

			$table = self::$tableName;
			$column = 'content';
			$val = $this->getStringifiedContent();
			$where = 'name=' . $db->sql_escape_string($this->getValue('name')) . ' && module=' . $db->sql_escape_string($this->getValue('module'));
			$db->updateBlob($table, $column, $val, $where);
		}
	}

	public static function getAllByModule($moduleName)
	{
		$current_user = vglobal('current_user');
		$dataReader = (new App\Db\Query())->from(self::$tableName)
				->where(['deleted' => 0, 'module' => $moduleName])
				->createCommand()->query();
		$savedMaps = [];
		while ($row = $dataReader->read()) {
			$importMap = Import_Map_Model::getInstanceFromDb($row, $current_user);
			$savedMaps[$importMap->getId()] = $importMap;
		}
		return $savedMaps;
	}
}
