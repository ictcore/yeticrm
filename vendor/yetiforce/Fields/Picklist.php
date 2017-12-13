<?php
namespace App\Fields;

/**
 * Picklist class
 * @package YetiForce.App
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Picklist
{

	/**
	 * Function to get role based picklist values
	 * @param string $fieldName
	 * @param string $roleId
	 * @return array list of role based picklist values
	 */
	public static function getRoleBasedPicklistValues($fieldName, $roleId)
	{
		$cacheKey = $fieldName . $roleId;
		if (\App\Cache::has('getRoleBasedPicklistValues', $cacheKey)) {
			return \App\Cache::get('getRoleBasedPicklistValues', $cacheKey);
		}
		$dataReader = (new \App\Db\Query())->select($fieldName)
				->from("vtiger_$fieldName")
				->innerJoin('vtiger_role2picklist', "vtiger_role2picklist.picklistvalueid = vtiger_$fieldName.picklist_valueid")
				->innerJoin('vtiger_picklist', 'vtiger_picklist.picklistid = vtiger_role2picklist.picklistid')
				->where(['vtiger_role2picklist.roleid' => $roleId])
				->orderBy("vtiger_{$fieldName}.sortorderid")
				->createCommand()->query();
		$fldVal = [];
		while (($val = $dataReader->readColumn(0)) !== false) {
			$fldVal[] = decode_html($val);
		}
		\App\Cache::save('getRoleBasedPicklistValues', $cacheKey, $fldVal);
		return $fldVal;
	}

	/**
	 * Function which will give the picklist values for a field
	 * @param string $fieldName -- string
	 * @return array -- array of values
	 */
	public static function getPickListValues($fieldName)
	{
		if (\App\Cache::has('getPickListValues', $fieldName)) {
			return \App\Cache::get('getPickListValues', $fieldName);
		}
		$primaryKey = static::getPickListId($fieldName);
		$dataReader = (new \App\Db\Query())->select([$primaryKey, $fieldName])
				->from("vtiger_$fieldName")
				->orderBy('sortorderid')
				->createCommand()->query();
		$values = [];
		while ($row = $dataReader->read()) {
			$values[$row[$primaryKey]] = decode_html(decode_html($row[$fieldName]));
		}
		\App\Cache::save('getPickListValues', $fieldName, $values);
		return $values;
	}

	/**
	 * Function which will give the editable picklist values for a field
	 * @param string $fieldName -- string
	 * @return array -- array of values
	 */
	public static function getEditablePicklistValues($fieldName)
	{
		$values = static::getPickListValues($fieldName);
		$nonEditableValues = static::getNonEditablePicklistValues($fieldName);
		foreach ($values as $key => &$value) {
			if ($value === '--None--' || isset($nonEditableValues[$key])) {
				unset($values[$key]);
			}
		}
		return $values;
	}

	/**
	 * Function which will give the non editable picklist values for a field
	 * @param string $fieldName -- string
	 * @return array -- array of values
	 */
	public static function getNonEditablePicklistValues($fieldName)
	{
		if (\App\Cache::has('getNonEditablePicklistValues', $fieldName)) {
			return \App\Cache::get('getNonEditablePicklistValues', $fieldName);
		}
		$primaryKey = static::getPickListId($fieldName);
		$dataReader = (new \App\Db\Query())->select([$primaryKey, $fieldName])
				->from("vtiger_$fieldName")
				->where(['presence' => 0])
				->createCommand()->query();
		$values = [];
		while ($row = $dataReader->read()) {
			$values[$row[$primaryKey]] = decode_html(decode_html($row[$fieldName]));
		}
		\App\Cache::save('getNonEditablePicklistValues', $fieldName, $values);
		return $values;
	}

	/**
	 * Function to get picklist key for a picklist
	 */
	public static function getPickListId($fieldName)
	{
		$pickListIds = [
			'opportunity_type' => 'opptypeid',
			'sales_stage' => 'sales_stage_id',
			'rating' => 'rating_id',
			'ticketpriorities' => 'ticketpriorities_id',
			'ticketseverities' => 'ticketseverities_id',
			'ticketstatus' => 'ticketstatus_id',
			'salutationtype' => 'salutationid',
			'faqstatus' => 'faqstatus_id',
			'faqcategories' => 'faqcategories_id',
			'recurring_frequency' => 'recurring_frequency_id',
			'payment_duration' => 'payment_duration_id',
			'language' => 'id',
			'duration_minutes' => 'minutesid'
		];
		if (isset($pickListIds[$fieldName])) {
			return $pickListIds[$fieldName];
		}
		return $fieldName . 'id';
	}

	/**
	 * Function to get modules which has picklist values
	 * It gets the picklist modules and return in an array in the following format
	 * $modules = Array($tabid=>$tablabel,$tabid1=>$tablabel1,$tabid2=>$tablabel2,-------------,$tabidn=>$tablabeln)
	 */
	public static function getPickListModules()
	{
		return (new App\Db\Query())->select(['vtiger_tab.tablabel', 'vtiger_tab.name as tabname'])->from('vtiger_field')
				->innerJoin('vtiger_tab', 'vtiger_field.tabid = vtiger_tab.tabid')->where(['uitype' => [15, 33], 'vtiger_field.presence' => [0, 2]])
				->andWhere((['<>', 'vtiger_field.tabid', 29]))
				->andWhere((['<>', 'vtiger_tab.presence', 1]))->distinct('vtiger_field.fieldname')->orderBy(['vtiger_field.tabid' => SORT_ASC])->createCommand()->queryAllByGroup(0);
	}

	/**
	 * this function returns all the assigned picklist values for the given tablename for the given roleid
	 * @param string $tableName - the picklist tablename
	 * @param integer $roleid - the roleid of the role for which you want data
	 * @return array $val - the assigned picklist values in array format
	 */
	public static function getAssignedPicklistValues($tableName, $roleid)
	{
		if (\App\Cache::has('getAssignedPicklistValues', $tableName . $roleid)) {
			return \App\Cache::get('getAssignedPicklistValues', $tableName . $roleid);
		}
		$values = [];
		$exists = (new \App\Db\Query())->select(['picklistid'])->from('vtiger_picklist')->where(['name' => $tableName])->exists();
		if ($exists) {
			$sub = getSubordinateRoleAndUsers($roleid);
			$subRoles = [$roleid];
			$subRoles = array_merge($subRoles, array_keys($sub));

			$roleids = [];
			foreach ($subRoles as $role) {
				$roleids[] = $role;
			}
			$dataReader = (new \App\Db\Query())->select([$tableName, 'sortid'])->from("vtiger_$tableName")
					->innerJoin('vtiger_role2picklist', "$tableName.picklist_valueid = vtiger_role2picklist.picklistvalueid")
					->where(['roleid' => $roleids])->orderBy('sortid')->distinct($tableName)->createCommand()->query();
			while ($row = $dataReader->read()) {
				/** Earlier we used to save picklist values by encoding it. Now, we are directly saving those(getRaw()).
				 *  If value in DB is like "test1 &amp; test2" then $abd->fetch_[] is giving it as
				 *  "test1 &amp;$amp; test2" which we should decode two time to get result
				 */
				$pickVal = \App\Purifier::decodeHtml(\App\Purifier::decodeHtml($row[$tableName]));
				$values[$pickVal] = $pickVal;
			}
			// END
			\App\Cache::save('getAssignedPicklistValues', $tableName . $roleid, $values);
			return $values;
		}
	}

	/**
	 * Function to get picklist dependency data source
	 * @param string $module
	 * @return array
	 */
	public static function getPicklistDependencyDatasource($module)
	{
		if (\App\Cache::has('getPicklistDependencyDatasource', $module)) {
			return \App\Cache::get('getPicklistDependencyDatasource', $module);
		}
		$query = (new \App\Db\Query())->from('vtiger_picklist_dependency')->where(['tabid' => \App\Module::getModuleId($module)]);
		$dataReader = $query->createCommand()->query();
		$picklistDependencyDatasource = [];
		while ($row = $dataReader->read()) {
			$pickArray = [];
			$sourceField = $row['sourcefield'];
			$targetField = $row['targetfield'];
			$sourceValue = \App\Purifier::decodeHtml($row['sourcevalue']);
			$targetValues = \App\Purifier::decodeHtml($row['targetvalues']);
			$unserializedTargetValues = \App\Json::decode(html_entity_decode($targetValues));
			$criteria = \App\Purifier::decodeHtml($row['criteria']);
			$unserializedCriteria = \App\Json::decode(html_entity_decode($criteria));

			if (!empty($unserializedCriteria) && $unserializedCriteria['fieldname'] !== null) {
				$conditionValue = [
					'condition' => [$unserializedCriteria['fieldname'] => $unserializedCriteria['fieldvalues']],
					'values' => $unserializedTargetValues
				];
				$picklistDependencyDatasource[$sourceField][$sourceValue][$targetField][] = $conditionValue;
			} else {
				$picklistDependencyDatasource[$sourceField][$sourceValue][$targetField] = $unserializedTargetValues;
			}
			if (empty($picklistDependencyDatasource[$sourceField]['__DEFAULT__'][$targetField])) {
				foreach (self::getPickListValues($targetField) as $picklistValue) {
					$pickArray[] = \App\Purifier::decodeHtml($picklistValue);
				}
				$picklistDependencyDatasource[$sourceField]['__DEFAULT__'][$targetField] = $pickArray;
			}
		}
		\App\Cache::save('getPicklistDependencyDatasource', $module, $picklistDependencyDatasource);
		return $picklistDependencyDatasource;
	}
}
