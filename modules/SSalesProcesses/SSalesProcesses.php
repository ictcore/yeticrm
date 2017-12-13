<?php
/**
 * @package YetiForce.CRMEntity
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
include_once 'modules/Vtiger/CRMEntity.php';

class SSalesProcesses extends Vtiger_CRMEntity
{

	public $table_name = 'u_yf_ssalesprocesses';
	public $table_index = 'ssalesprocessesid';
	protected $lockFields = ['ssalesprocesses_status' => ['PLL_SALE_COMPLETED', 'PLL_SALE_FAILED', 'PLL_SALE_CANCELLED']];

	/**
	 * Mandatory table for supporting custom fields.
	 */
	public $customFieldTable = Array('u_yf_ssalesprocessescf', 'ssalesprocessesid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	public $tab_name = Array('vtiger_crmentity', 'u_yf_ssalesprocesses', 'u_yf_ssalesprocessescf', 'vtiger_entity_stats');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	public $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'u_yf_ssalesprocesses' => 'ssalesprocessesid',
		'u_yf_ssalesprocessescf' => 'ssalesprocessesid',
		'vtiger_entity_stats' => 'crmid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	public $list_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'LBL_SUBJECT' => Array('ssalesprocesses', 'subject'),
		'Assigned To' => Array('crmentity', 'smownerid')
	);
	public $list_fields_name = Array(
		/* Format: Field Label => fieldname */
		'LBL_SUBJECT' => 'subject',
		'Assigned To' => 'assigned_user_id',
	);

	/**
	 * @var string[] List of fields in the RelationListView
	 */
	public $relationFields = ['subject', 'assigned_user_id'];
	// Make the field link to detail view
	public $list_link_field = 'subject';
	// For Popup listview and UI type support
	public $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'LBL_SUBJECT' => Array('ssalesprocesses', 'subject'),
		'Assigned To' => Array('vtiger_crmentity', 'assigned_user_id'),
	);
	public $search_fields_name = Array(
		/* Format: Field Label => fieldname */
		'LBL_SUBJECT' => 'subject',
		'Assigned To' => 'assigned_user_id',
	);
	// For Popup window record selection
	public $popup_fields = Array('subject');
	// For Alphabetical search
	public $def_basicsearch_col = 'subject';
	// Column value to use on detail view record text display
	public $def_detailview_recname = 'subject';
	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	public $mandatory_fields = Array('subject', 'assigned_user_id');
	public $default_order_by = '';
	public $default_sort_order = 'ASC';

	/**
	 * Invoked when special actions are performed on the module.
	 * @param String Module name
	 * @param String Event Type
	 */
	public function vtlib_handler($moduleName, $eventType)
	{
		$adb = PearDatabase::getInstance();
		if ($eventType == 'module.postinstall') {
			\App\Fields\RecordNumber::setNumber($moduleName, 'S-SP', '1');
			$adb->pquery('UPDATE vtiger_tab SET customized=0 WHERE name=?', ['SSalesProcesses']);

			$modcommentsModuleInstance = vtlib\Module::getInstance('ModComments');
			if ($modcommentsModuleInstance && file_exists('modules/ModComments/ModComments.php')) {
				include_once 'modules/ModComments/ModComments.php';
				if (class_exists('ModComments'))
					ModComments::addWidgetTo(array('SSalesProcesses'));
			}
			CRMEntity::getInstance('ModTracker')->enableTrackingForModule(vtlib\Functions::getModuleId($moduleName));
		} else if ($eventType == 'module.disabled') {
			
		} else if ($eventType == 'module.preuninstall') {
			
		} else if ($eventType == 'module.preupdate') {
			
		} else if ($eventType == 'module.postupdate') {
			
		}
	}

	/**
	 * Function to get sales hierarchy of the given Sale
	 * @param integer $id - ssalesprocessesid
	 * returns Sales hierarchy in array format
	 */
	public function getHierarchy($id, $getRawData = false, $getLinks = true)
	{
		\App\Log::trace("Entering getHierarchy(" . $id . ") method ...");
		$listviewHeader = [];
		$listviewEntries = [];
		$listColumns = AppConfig::module('SSalesProcesses', 'COLUMNS_IN_HIERARCHY');
		if (empty($listColumns)) {
			$listColumns = $this->list_fields_name;
		}
		foreach ($listColumns as $fieldname => $colname) {
			if (\App\Field::getFieldPermission('SSalesProcesses', $colname)) {
				$listviewHeader[] = App\Language::translate($fieldname);
			}
		}
		$salesProcessesList = [];
		$encounteredSalesProcesses = [$id];
		$salesProcessesList = $this->getParentSales($id, $salesProcessesList, $encounteredSalesProcesses);
		$baseId = current(array_keys($salesProcessesList));
		$salesProcessesList = [$baseId => $salesProcessesList[$baseId]];
		$salesProcessesList[$baseId] = $this->getChildSales($baseId, $salesProcessesList[$baseId], $salesProcessesList[$baseId]['depth']);
		$salesProcessesHierarchy = $this->getHierarchyData($id, $salesProcessesList[$baseId], $baseId, $listviewEntries, $getRawData, $getLinks);
		$salesProcessesHierarchy = ['header' => $listviewHeader, 'entries' => $listviewEntries];
		\App\Log::trace('Exiting getHierarchy method ...');
		return $salesProcessesHierarchy;
	}

	/**
	 * Function to create array of all the sales in the hierarchy
	 * @param integer $id - Id of the record highest in hierarchy
	 * @param array $salesProcessesInfoBase 
	 * @param integer $salesProcessesId - ssalesprocessesid
	 * @param array $listviewEntries 
	 * returns All the parent sales of the given Sale in array format
	 */
	public function getHierarchyData($id, $salesProcessesInfoBase, $salesProcessesId, &$listviewEntries, $getRawData = false, $getLinks = true)
	{

		\App\Log::trace('Entering getHierarchyData(' . $id . ',' . $salesProcessesId . ') method ...');

		$currentUser = Users_Privileges_Model::getCurrentUserModel();
		$hasRecordViewAccess = $currentUser->isAdminUser() || \App\Privilege::isPermitted('SSalesProcesses', 'DetailView', $salesProcessesId);
		$listColumns = AppConfig::module('SSalesProcesses', 'COLUMNS_IN_HIERARCHY');

		if (empty($listColumns)) {
			$listColumns = $this->list_fields_name;
		}

		foreach ($listColumns as $colname) {
			// Permission to view sales is restricted, avoid showing field values (except sales name)
			if (\App\Field::getFieldPermission('SSalesProcesses', $colname)) {
				$data = $salesProcessesInfoBase[$colname];
				if ($getRawData === false) {
					if ($colname == 'subject') {
						if ($salesProcessesId != $id) {
							if ($getLinks) {
								if ($hasRecordViewAccess) {
									$data = '<a href="index.php?module=SSalesProcesses&action=DetailView&record=' . $salesProcessesId . '">' . $data . '</a>';
								} else {
									$data = '<span>' . $data . '&nbsp;<span class="glyphicon glyphicon-warning-sign"></span></span>';
								}
							}
						} else {
							$data = '<strong>' . $data . '</strong>';
						}
						// - to show the hierarchy of the Sales
						$salesProcessesDepth = str_repeat(" .. ", $salesProcessesInfoBase['depth']);
						$data = $salesProcessesDepth . $data;
					}
				}
				$salesProcessesInfoData[] = $data;
			}
		}

		$listviewEntries[$salesProcessesId] = $salesProcessesInfoData;

		foreach ($salesProcessesInfoBase as $accId => $salesProcessesInfo) {
			if (is_array($salesProcessesInfo) && intval($accId)) {
				$listviewEntries = $this->getHierarchyData($id, $salesProcessesInfo, $accId, $listviewEntries, $getRawData, $getLinks);
			}
		}

		\App\Log::trace('Exiting getHierarchyData method ...');
		return $listviewEntries;
	}

	/**
	 * Function to Recursively get all the upper sales of a given Sales
	 * @param integer $id - ssalesprocessesid
	 * @param array $parentSSalesProcesses - Array of all the parent sales
	 * returns All the parent Sales of the given ssalesprocessesid in array format
	 */
	public function getParentSales($id, &$parentSSalesProcesses, &$encounteredSalesProcesses, $depthBase = 0)
	{
		\App\Log::trace('Entering getParentSales(' . $id . ') method ...');

		if ($depthBase == AppConfig::module('SSalesProcesses', 'MAX_HIERARCHY_DEPTH')) {
			\App\Log::error('Exiting getParentSales method ... - exceeded maximum depth of hierarchy');
			return $parentSSalesProcesses;
		}

		$userNameSql = App\Module::getSqlForNameInDisplayFormat('Users');
		$row = (new App\Db\Query())->select([
				'u_#__ssalesprocesses.*',
				new \yii\db\Expression("CASE when (vtiger_users.user_name not like '') THEN $userNameSql ELSE vtiger_groups.groupname END as user_name")
			])->from('u_#__ssalesprocesses')
			->innerJoin('vtiger_crmentity', 'vtiger_crmentity.crmid = u_#__ssalesprocesses.ssalesprocessesid')
			->leftJoin('vtiger_groups', 'vtiger_groups.groupid = vtiger_crmentity.smownerid')
			->leftJoin('vtiger_users', 'vtiger_users.id = vtiger_crmentity.smownerid')
			->where(['vtiger_crmentity.deleted' => 0, 'u_#__ssalesprocesses.ssalesprocessesid' => $id])
			->one();
		if ($row) {
			$parentid = $row['parentid'];

			if ($parentid != '' && $parentid != 0 && !in_array($parentid, $encounteredSalesProcesses)) {
				$encounteredSalesProcesses[] = $parentid;
				$this->getParentSales($parentid, $parentSSalesProcesses, $encounteredSalesProcesses, $depthBase + 1);
			}

			$parentSSalesProcessesInfo = [];
			$depth = 0;

			if (isset($parentSSalesProcesses[$parentid])) {
				$depth = $parentSSalesProcesses[$parentid]['depth'] + 1;
			}

			$parentSSalesProcessesInfo['depth'] = $depth;
			$listColumns = AppConfig::module('SSalesProcesses', 'COLUMNS_IN_HIERARCHY');

			if (empty($listColumns)) {
				$listColumns = $this->list_fields_name;
			}

			foreach ($listColumns as $columnname) {
				if ($columnname == 'assigned_user_id') {
					$parentSSalesProcessesInfo[$columnname] = $row['user_name'];
				} else {
					$parentSSalesProcessesInfo[$columnname] = $row[$columnname];
				}
			}

			$parentSSalesProcesses[$id] = $parentSSalesProcessesInfo;
		}
		\App\Log::trace('Exiting getParentSales method ...');
		return $parentSSalesProcesses;
	}

	/**
	 * Function to Recursively get all the child sales of a given Sale
	 * @param integer $id - ssalesprocessesid
	 * @param array $childSalesProcesses - Array of all the child sales
	 * @param integer $depthBase - Depth at which the particular sales has to be placed in the hierarchy
	 * returns All the child sales of the given ssalesprocessesid in array format
	 */
	public function getChildSales($id, &$childSalesProcesses, $depthBase)
	{
		\App\Log::trace('Entering getChildSales(' . $id . ',' . $depthBase . ') method ...');
		if ($depthBase == AppConfig::module('SSalesProcesses', 'MAX_HIERARCHY_DEPTH')) {
			\App\Log::error('Exiting getChildSales method ... - exceeded maximum depth of hierarchy');
			return $childSalesProcesses;
		}
		$userNameSql = App\Module::getSqlForNameInDisplayFormat('Users');
		$dataReader = (new App\Db\Query())->select([
					'u_#__ssalesprocesses.*',
					new \yii\db\Expression("CASE when (vtiger_users.user_name NOT LIKE '') THEN $userNameSql ELSE vtiger_groups.groupname END as user_name")
				])->from('u_#__ssalesprocesses')
				->innerJoin('vtiger_crmentity', 'vtiger_crmentity.crmid = u_#__ssalesprocesses.ssalesprocessesid')
				->leftJoin('vtiger_groups', 'vtiger_groups.groupid = vtiger_crmentity.smownerid')
				->leftJoin('vtiger_users', 'vtiger_users.id = vtiger_crmentity.smownerid')
				->where(['vtiger_crmentity.deleted' => 0, 'u_#__ssalesprocesses.parentid' => $id])
				->createCommand()->query();
		$listColumns = AppConfig::module('SSalesProcesses', 'COLUMNS_IN_HIERARCHY');
		if (empty($listColumns)) {
			$listColumns = $this->list_fields_name;
		}
		if ($dataReader->count() > 0) {
			$depth = $depthBase + 1;
			while ($row = $dataReader->read()) {
				$childAccId = $row['ssalesprocessesid'];
				$childSalesProcessesInfo = [];
				$childSalesProcessesInfo['depth'] = $depth;

				foreach ($listColumns as $columnname) {
					if ($columnname == 'assigned_user_id') {
						$childSalesProcessesInfo[$columnname] = $row['user_name'];
					} else {
						$childSalesProcessesInfo[$columnname] = $row[$columnname];
					}
				}

				$childSalesProcesses[$childAccId] = $childSalesProcessesInfo;
				$this->getChildSales($childAccId, $childSalesProcesses[$childAccId], $depth);
			}
		}

		\App\Log::trace('Exiting getChildSales method ...');
		return $childSalesProcesses;
	}
}
