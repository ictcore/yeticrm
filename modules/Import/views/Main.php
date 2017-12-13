<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * *********************************************************************************** */

class Import_Main_View extends Vtiger_View_Controller
{

	public $request;
	public $user;
	public $numberOfRecords;

	public function checkPermission(\App\Request $request)
	{
		$currentUserPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if (!$currentUserPrivilegesModel->hasModulePermission($request->get('module'))) {
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}
	}

	public function process(\App\Request $request)
	{
		return;
	}

	public function __construct($request, $user)
	{
		$this->request = $request;
		$this->user = $user;
	}

	public static function import($request, $user)
	{
		$importController = new Import_Main_View($request, $user);

		$importController->saveMap();
		$fileReadStatus = $importController->copyFromFileToDB();
		if ($fileReadStatus) {
			$importController->queueDataImport();
		}

		$isImportScheduled = $importController->request->get('is_scheduled');

		if ($isImportScheduled) {
			$importInfo = Import_Queue_Action::getUserCurrentImportInfo($importController->user);
			self::showScheduledStatus($importInfo);
		} else {
			$importController->triggerImport();
		}
	}

	public function triggerImport($batchImport = false)
	{
		$importInfo = Import_Queue_Action::getImportInfo($this->request->get('module'), $this->user);
		$importDataController = new Import_Data_Action($importInfo, $this->user);

		if (!$batchImport) {
			if (!$importDataController->initializeImport()) {
				Import_Utils_Helper::showErrorPage(\App\Language::translate('ERR_FAILED_TO_LOCK_MODULE', 'Import'));
				throw new \Exception\AppException(\App\Language::translate('ERR_FAILED_TO_LOCK_MODULE', 'Import'));
			}
		}

		$importDataController->importData();
		Import_Queue_Action::updateStatus($importInfo['id'], Import_Queue_Action::$IMPORT_STATUS_HALTED);
		$importInfo = Import_Queue_Action::getImportInfo($this->request->get('module'), $this->user);

		self::showImportStatus($importInfo, $this->user);
	}

	/**
	 * Show import status
	 * @param array $importInfo
	 * @param Users_Record_Model $user
	 * @throws \Exception\AppException
	 */
	public static function showImportStatus($importInfo, $user)
	{
		if (empty($importInfo)) {
			Import_Utils_Helper::showErrorPage(\App\Language::translate('ERR_IMPORT_INTERRUPTED', 'Import'));
			throw new \Exception\AppException(\App\Language::translate('ERR_IMPORT_INTERRUPTED', 'Import'));
		}
		$importDataController = new Import_Data_Action($importInfo, $user);
		if ($importInfo['temp_status'] === Import_Queue_Action::$IMPORT_STATUS_HALTED ||
			$importInfo['temp_status'] === Import_Queue_Action::$IMPORT_STATUS_NONE) {
			$continueImport = true;
		} else {
			$continueImport = false;
		}

		$importStatusCount = $importDataController->getImportStatusCount();
		$totalRecords = $importStatusCount['TOTAL'];
		if ($totalRecords > ($importStatusCount['IMPORTED'] + $importStatusCount['FAILED'])) {
			self::showCurrentStatus($importInfo, $importStatusCount, $continueImport);
		} else {
			$importDataController->finishImport();
			self::showResult($importInfo, $importStatusCount);
		}
	}

	public static function showCurrentStatus($importInfo, $importStatusCount, $continueImport)
	{
		$moduleName = $importInfo['module'];
		$importId = $importInfo['id'];

		$viewer = new Vtiger_Viewer();

		$viewer->assign('FOR_MODULE', $moduleName);
		$viewer->assign('MODULE', 'Import');
		$viewer->assign('IMPORT_ID', $importId);
		$viewer->assign('IMPORT_RESULT', $importStatusCount);
		$viewer->assign('INVENTORY_MODULES', getInventoryModules());
		$viewer->assign('CONTINUE_IMPORT', $continueImport);

		$viewer->view('ImportStatus.tpl', 'Import');
	}

	public static function showResult($importInfo, $importStatusCount)
	{
		$moduleName = $importInfo['module'];
		$ownerId = $importInfo['user_id'];

		$viewer = new Vtiger_Viewer();
		$viewer->assign('FOR_MODULE', $moduleName);
		$viewer->assign('MODULE', 'Import');
		$viewer->assign('OWNER_ID', $ownerId);
		$viewer->assign('IMPORT_RESULT', $importStatusCount);
		$viewer->assign('INVENTORY_MODULES', getInventoryModules());
		$viewer->assign('TYPE', $importInfo['type']);
		$viewer->assign('MERGE_ENABLED', $importInfo['merge_type']);

		$viewer->view('ImportResult.tpl', 'Import');
	}

	public static function showScheduledStatus($importInfo)
	{
		$moduleName = $importInfo['module'];
		$importId = $importInfo['id'];

		$viewer = new Vtiger_Viewer();

		$viewer->assign('FOR_MODULE', $moduleName);
		$viewer->assign('MODULE', 'Import');
		$viewer->assign('IMPORT_ID', $importId);

		$viewer->view('ImportSchedule.tpl', 'Import');
	}

	public function saveMap()
	{
		$saveMap = $this->request->get('save_map');
		$mapName = $this->request->get('save_map_as');
		if ($saveMap && !empty($mapName)) {
			$fieldMapping = $this->request->get('field_mapping');
			$fileReader = Import_Module_Model::getFileReader($this->request, $this->user);
			if ($fileReader === null) {
				return false;
			}
			$hasHeader = $fileReader->hasHeader();
			if ($hasHeader) {
				$firstRowData = $fileReader->getFirstRowData($hasHeader);
				$headers = array_keys($firstRowData['LBL_STANDARD_FIELDS']);
				if (isset($firstRowData['LBL_INVENTORY_FIELDS'])) {
					$headers = array_merge($headers, array_keys($firstRowData['LBL_INVENTORY_FIELDS']));
				}
				foreach ($fieldMapping as $fieldName => $index) {
					$saveMapping["$headers[$index]"] = $fieldName;
				}
			} else {
				$saveMapping = array_flip($fieldMapping);
			}
			$map = [];
			$map['name'] = $mapName;
			$map['content'] = $saveMapping;
			$map['module'] = $this->request->get('module');
			$map['has_header'] = ($hasHeader) ? 1 : 0;
			$map['assigned_user_id'] = $this->user->id;
			(new Import_Map_Model($map, $this->user))->save();
		}
	}

	public function copyFromFileToDB()
	{
		$fileReader = Import_Module_Model::getFileReader($this->request, $this->user);
		$fileReader->read();
		$fileReader->deleteFile();
		if ($fileReader->getStatus() === 'success') {
			$this->numberOfRecords = $fileReader->getNumberOfRecordsRead();
			return true;
		} else {
			Import_Utils_Helper::showErrorPage(\App\Language::translate('ERR_FILE_READ_FAILED', 'Import') . ' - ' .
				\App\Language::translate($fileReader->getErrorMessage(), 'Import'));
			return false;
		}
	}

	public function queueDataImport()
	{
		$immediateImportRecordLimit = \AppConfig::module('Import', 'IMMEDIATE_IMPORT_LIMIT');

		$numberOfRecordsToImport = $this->numberOfRecords;
		if ($numberOfRecordsToImport > $immediateImportRecordLimit) {
			$this->request->set('is_scheduled', true);
		}
		Import_Queue_Action::add($this->request, $this->user);
	}

	public static function deleteMap($request)
	{
		$moduleName = $request->getModule();
		$mapId = $request->get('mapid');
		if (!empty($mapId)) {
			Import_Map_Model::markAsDeleted($mapId);
		}

		$viewer = new Vtiger_Viewer();
		$viewer->assign('FOR_MODULE', $moduleName);
		$viewer->assign('MODULE', 'Import');
		$viewer->assign('SAVED_MAPS', Import_Map_Model::getAllByModule($moduleName));
		$viewer->view('Import_Saved_Maps.tpl', 'Import');
	}
}

?>
