<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * ********************************************************************************** */

class Settings_Currency_Record_Model extends Settings_Vtiger_Record_Model
{

	/**
	 * Return currency id
	 * @return int|null
	 */
	public function getId()
	{
		return $this->get('id');
	}

	/**
	 * Return currency name
	 * @return string
	 */
	public function getName()
	{
		return $this->get('currency_name');
	}

	/**
	 * Check if currency is base
	 * @return bool
	 */
	public function isBaseCurrency()
	{
		return ($this->get('defaultid') != '-11') ? false : true;
	}

	/**
	 * Return record actions links
	 * @return array
	 */
	public function getRecordLinks()
	{
		if ($this->isBaseCurrency()) {
			//NO Edit and delete link for base currency
			return [];
		}
		$editLink = [
			'linkurl' => "javascript:Settings_Currency_Js.triggerEdit(event, '" . $this->getId() . "')",
			'linklabel' => 'LBL_EDIT',
			'linkicon' => 'glyphicon glyphicon-pencil'
		];
		$editLinkInstance = Vtiger_Link_Model::getInstanceFromValues($editLink);

		$deleteLink = [
			'linkurl' => "javascript:Settings_Currency_Js.triggerDelete(event,'" . $this->getId() . "')",
			'linklabel' => 'LBL_DELETE',
			'linkicon' => 'glyphicon glyphicon-trash'
		];
		$deleteLinkInstance = Vtiger_Link_Model::getInstanceFromValues($deleteLink);
		return array($editLinkInstance, $deleteLinkInstance);
	}

	/**
	 * return delete state of record
	 * @return int
	 */
	public function getDeleteStatus()
	{
		if ($this->has('deleted')) {
			return $this->get('deleted');
		}
		//by default non deleted
		return 0;
	}

	/**
	 * Populate changes to database
	 * @return int
	 */
	public function save()
	{
		$db = \App\Db::getInstance();
		$id = $this->getId();
		$tableName = Settings_Currency_Module_Model::tableName;
		if (!empty($id)) {
			$db->createCommand()->update($tableName, [
				'currency_name' => $this->get('currency_name'),
				'currency_code' => $this->get('currency_code'),
				'currency_status' => $this->get('currency_status'),
				'currency_symbol' => $this->get('currency_symbol'),
				'conversion_rate' => $this->get('conversion_rate'),
				'deleted' => $this->getDeleteStatus()
				], ['id' => $id])->execute();
		} else {
			$id = $db->getUniqueID($tableName);
			$db->createCommand()
				->insert($tableName, [
					'id' => $id,
					'currency_name' => $this->get('currency_name'),
					'currency_code' => $this->get('currency_code'),
					'currency_status' => $this->get('currency_status'),
					'currency_symbol' => $this->get('currency_symbol'),
					'conversion_rate' => $this->get('conversion_rate'),
					'defaultid' => 0,
					'deleted' => 0
				])->execute();
		}
		self::clearCache();
		return $id;
	}

	/**
	 * Function clears cache
	 */
	public static function clearCache()
	{
		\App\Cache::delete('Currency', 'List');
	}

	/**
	 * Returns instance of self
	 * @param int $id
	 * @return \self
	 */
	public static function getInstance($id)
	{
		$db = (new App\Db\Query())->from(Settings_Currency_Module_Model::tableName);
		if (vtlib\Utils::isNumber($id)) {
			$query = $db->where(['id' => $id]);
		} else {
			$query = $db->where(['currency_name' => $id]);
		}
		$row = $query->createCommand()->queryOne();
		if ($row) {
			$instance = new self();
			$instance->setData($row);
		}
		return $instance;
	}

	/**
	 * Return all non mapped currences
	 * @param array $includedIds
	 * @return  \Settings_Currency_Record_Model[]
	 */
	public static function getAllNonMapped($includedIds = [])
	{
		if (!is_array($includedIds)) {
			if (!empty($includedIds)) {
				$includedIds = array($includedIds);
			} else {
				$includedIds = [];
			}
		}
		$query = (new \App\Db\Query())->select(['vtiger_currencies.*'])->from('vtiger_currencies')->leftJoin('vtiger_currency_info', 'vtiger_currency_info.currency_name = vtiger_currencies.currency_name')->where(['or', ['vtiger_currency_info.currency_name' => null], ['vtiger_currency_info.deleted' => 1]]);
		if (!empty($includedIds)) {
			$params = $includedIds;
			$query->orWhere(['vtiger_currency_info.id' => $includedIds]);
		}
		$currencyModelList = [];
		$dataReader = $query->createCommand()->query();
		while ($row = $dataReader->read()) {
			$modelInstance = new self();
			$modelInstance->setData($row);
			$currencyModelList[$row['currencyid']] = $modelInstance;
		}
		return $currencyModelList;
	}

	/**
	 * Return currences
	 * @param array $excludedIds
	 * @return  \Settings_Currency_Record_Model[]
	 */
	public static function getAll($excludedIds = [])
	{
		$query = (new App\Db\Query())->from(Settings_Currency_Module_Model::tableName)
			->where(['deleted' => 0, 'currency_status' => 'Active']);
		if (!empty($excludedIds)) {
			$query->andWhere(['<>', 'id', $excludedIds]);
		}
		$dataReader = $query->createCommand()->query();
		$instanceList = [];
		while ($row = $dataReader->read()) {
			$instanceList[$row['id']] = new Settings_Currency_Record_Model($row);
		}
		return $instanceList;
	}
}
