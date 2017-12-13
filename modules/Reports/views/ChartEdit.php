<?php
/* * ***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * *********************************************************************************** */

Class Reports_ChartEdit_View extends Vtiger_Edit_View
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('step1');
		$this->exposeMethod('step2');
		$this->exposeMethod('step3');
	}

	public function checkPermission(\App\Request $request)
	{
		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if (!$currentUserPriviligesModel->hasModulePermission($request->getModule())) {
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}

		$record = $request->get('record');
		if ($record) {
			$reportModel = Reports_Record_Model::getCleanInstance($record);
			if (!$reportModel->isEditable()) {
				throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
			}
		}
	}

	public function preProcess(\App\Request $request, $display = true)
	{
		parent::preProcess($request);
		$viewer = $this->getViewer($request);
		$record = $request->get('record');
		$moduleName = $request->getModule();

		$reportModel = Reports_Record_Model::getCleanInstance($record);
		$primaryModule = $reportModel->getPrimaryModule();
		$primaryModuleModel = Vtiger_Module_Model::getInstance($primaryModule);
		if ($primaryModuleModel) {
			$currentUser = Users_Record_Model::getCurrentUserModel();
			$userPrivilegesModel = Users_Privileges_Model::getInstanceById($currentUser->getId());
			$permission = $userPrivilegesModel->hasModulePermission($primaryModuleModel->getId());

			if (!$permission) {
				$viewer->assign('MODULE', $primaryModule);
				$viewer->assign('MESSAGE', 'LBL_PERMISSION_DENIED');
				$viewer->view('OperationNotPermitted.tpl', $primaryModule);
				throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
			}
		}

		$viewer->assign('REPORT_MODEL', $reportModel);
		$viewer->assign('RECORD_ID', $record);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('VIEW', 'ChartEdit');
		$viewer->assign('RECORD_MODE', $request->getMode());
		$viewer->view('EditChartHeader.tpl', $request->getModule());
	}

	public function process(\App\Request $request)
	{
		$mode = $request->getMode();
		if (!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
		} else {
			$this->step1($request);
		}
	}

	public function step1(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$record = $request->get('record');

		$reportModel = Reports_Record_Model::getCleanInstance($record);
		if (!$reportModel->has('folderid')) {
			$reportModel->set('folderid', $request->get('folder'));
		}
		$data = $request->getAll();
		foreach ($data as $name => $value) {
			$reportModel->set($name, $value);
		}

		$modulesList = $reportModel->getModulesList();

		if (!empty($record)) {
			$viewer->assign('MODE', 'edit');
		} else {
			$firstModuleName = reset($modulesList);
			if ($firstModuleName)
				$reportModel->setPrimaryModule($firstModuleName);
			$viewer->assign('MODE', '');
		}

		$reportModuleModel = $reportModel->getModule();
		$reportFolderModels = $reportModuleModel->getFolders();

		$relatedModules = $reportModel->getReportRelatedModules();

		foreach ($relatedModules as $primaryModule => $relatedModuleList) {
			$translatedRelatedModules = [];

			foreach ($relatedModuleList as $relatedModuleName) {
				$translatedRelatedModules[$relatedModuleName] = \App\Language::translate($relatedModuleName, $relatedModuleName);
			}
			$relatedModules[$primaryModule] = $translatedRelatedModules;
		}

		$viewer->assign('MODULELIST', $modulesList);
		$viewer->assign('RELATED_MODULES', $relatedModules);
		$viewer->assign('REPORT_MODEL', $reportModel);
		$viewer->assign('REPORT_FOLDERS', $reportFolderModels);
		$viewer->assign('RECORD_ID', $record);

		if ($request->get('isDuplicate')) {
			$viewer->assign('IS_DUPLICATE', true);
		}

		$viewer->view('ChartEditStep1.tpl', $moduleName);
	}

	public function step2(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$record = $request->get('record');

		$reportModel = Reports_Record_Model::getCleanInstance($record);
		if (!empty($record) && !$request->get('isDuplicate')) {
			$viewer->assign('SELECTED_STANDARD_FILTER_FIELDS', $reportModel->getSelectedStandardFilter());
			$viewer->assign('SELECTED_ADVANCED_FILTER_FIELDS', $reportModel->transformToNewAdvancedFilter());
		}
		$data = $request->getAll();
		foreach ($data as $name => $value) {
			$reportModel->set($name, $value);
		}
		$primaryModule = $request->get('primary_module');
		$secondaryModules = $request->get('secondary_modules');
		$reportModel->setPrimaryModule($primaryModule);
		if (!empty($secondaryModules)) {
			$secondaryModules = implode(':', $secondaryModules);
			$reportModel->setSecondaryModule($secondaryModules);

			$secondaryModules = explode(':', $secondaryModules);
		} else {
			$secondaryModules = [];
		}
		$viewer->assign('RECORD_ID', $record);
		$viewer->assign('REPORT_MODEL', $reportModel);
		$viewer->assign('PRIMARY_MODULE', $primaryModule);

		$recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($reportModel);
		$primaryModuleRecordStructure = $recordStructureInstance->getPrimaryModuleRecordStructure();
		$secondaryModuleRecordStructures = $recordStructureInstance->getSecondaryModuleRecordStructure();

		$viewer->assign('SECONDARY_MODULES', $secondaryModules);
		$viewer->assign('PRIMARY_MODULE_RECORD_STRUCTURE', $primaryModuleRecordStructure);
		$viewer->assign('SECONDARY_MODULE_RECORD_STRUCTURES', $secondaryModuleRecordStructures);
		$viewer->assign('DATE_FILTERS', Vtiger_AdvancedFilter_Helper::getDateFilter($moduleName));
		if (($primaryModule === 'Calendar') || (in_array('Calendar', $secondaryModules))) {
			$advanceFilterOpsByFieldType = Calendar_Field_Model::getAdvancedFilterOpsByFieldType();
		} else {
			$advanceFilterOpsByFieldType = Vtiger_Field_Model::getAdvancedFilterOpsByFieldType();
		}
		$viewer->assign('ADVANCED_FILTER_OPTIONS', \App\CustomView::ADVANCED_FILTER_OPTIONS);
		$viewer->assign('ADVANCED_FILTER_OPTIONS_BY_TYPE', $advanceFilterOpsByFieldType);
		$viewer->assign('MODULE', $moduleName);

		$calculationFields = $reportModel->get('calculation_fields');
		if ($calculationFields) {
			$calculationFields = \App\Json::decode($calculationFields);
			$viewer->assign('LINEITEM_FIELD_IN_CALCULATION', $reportModel->showLineItemFieldsInFilter($calculationFields));
		}
		if ($request->get('isDuplicate')) {
			$viewer->assign('IS_DUPLICATE', true);
		}
		$viewer->view('ChartEditStep2.tpl', $moduleName);
	}

	public function step3(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$record = $request->get('record');

		$reportModel = Reports_Record_Model::getCleanInstance($record);
		if (!empty($record)) {
			$viewer->assign('SELECTED_STANDARD_FILTER_FIELDS', $reportModel->getSelectedStandardFilter());
			$viewer->assign('SELECTED_ADVANCED_FILTER_FIELDS', $reportModel->transformToNewAdvancedFilter());
		}
		$data = $request->getAll();
		foreach ($data as $name => $value) {
			$reportModel->set($name, $value);
		}
		$primaryModule = $request->get('primary_module');
		$secondaryModules = $request->get('secondary_modules');
		$reportModel->setPrimaryModule($primaryModule);
		if (!empty($secondaryModules)) {
			$secondaryModules = implode(':', $secondaryModules);
			$reportModel->setSecondaryModule($secondaryModules);
			$secondaryModules = explode(':', $secondaryModules);
		} else {
			$secondaryModules = [];
		}

		$chartModel = Reports_Chart_Model::getInstanceById($reportModel);
		$viewer->assign('CHART_MODEL', $chartModel);

		$viewer->assign('ADVANCED_FILTERS', $request->get('advanced_filter'));
		$viewer->assign('PRIMARY_MODULE_FIELDS', $reportModel->getPrimaryModuleFieldsForAdvancedReporting());
		$viewer->assign('SECONDARY_MODULE_FIELDS', $reportModel->getSecondaryModuleFieldsForAdvancedReporting());
		$viewer->assign('CALCULATION_FIELDS', $reportModel->getModuleCalculationFieldsForReport());

		if ($request->get('isDuplicate')) {
			$viewer->assign('IS_DUPLICATE', true);
		}

		$viewer->assign('RECORD_ID', $record);
		$viewer->assign('REPORT_MODEL', $reportModel);
		$viewer->assign('PRIMARY_MODULE', $primaryModule);
		$viewer->assign('SECONDARY_MODULES', $secondaryModules);
		$viewer->assign('MODULE', $moduleName);

		$viewer->view('ChartEditStep3.tpl', $moduleName);
	}

	/**
	 * Function to get the list of Script models to be included
	 * @param \App\Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	public function getFooterScripts(\App\Request $request)
	{
		$headerScriptInstances = parent::getFooterScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			"modules.Reports.resources.Edit",
			"modules.Reports.resources.Edit1",
			"modules.Reports.resources.Edit2",
			"modules.Reports.resources.Edit3",
			"modules.$moduleName.resources.ChartEdit",
			"modules.$moduleName.resources.ChartEdit1",
			"modules.$moduleName.resources.ChartEdit2",
			"modules.$moduleName.resources.ChartEdit3"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
