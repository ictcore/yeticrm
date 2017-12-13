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

class Settings_ModuleManager_Basic_Action extends Settings_Vtiger_IndexAjax_View
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('updateModuleStatus');
		$this->exposeMethod('importUserModuleStep3');
		$this->exposeMethod('updateUserModuleStep3');
		$this->exposeMethod('checkModuleName');
		$this->exposeMethod('createModule');
		$this->exposeMethod('deleteModule');
	}

	public function process(\App\Request $request)
	{
		$mode = $request->getMode();
		if (!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	public function updateModuleStatus(\App\Request $request)
	{
		$moduleName = $request->get('forModule');
		$moduleManagerModel = new Settings_ModuleManager_Module_Model();
		$response = new Vtiger_Response();
		try {
			if ($request->getBoolean('updateStatus')) {
				$moduleManagerModel->enableModule($moduleName);
			} else {
				$moduleManagerModel->disableModule($moduleName);
			}
		} catch (\Exception\NotAllowedMethod $e) {
			$response->setError($e->getMessage());
		}
		$response->emit();
	}

	public function importUserModuleStep3(\App\Request $request)
	{
		$importModuleName = $request->get('module_import_name');
		$uploadFile = $request->get('module_import_file');
		$uploadDir = Settings_ModuleManager_Module_Model::getUploadDirectory();
		$uploadFileName = "$uploadDir/$uploadFile";
		vtlib\Deprecated::checkFileAccess($uploadFileName);

		$importType = $request->get('module_import_type');
		if (strtolower($importType) == 'language') {
			$package = new vtlib\Language();
		} else if (strtolower($importType) == 'layout') {
			$package = new vtlib\Layout();
		} else {
			$package = new vtlib\Package();
		}

		$package->import($uploadFileName);

		\vtlib\Deprecated::checkFileAccessForDeletion($uploadFileName);
		unlink($uploadFileName);

		$result = array('success' => true, 'importModuleName' => $importModuleName);
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}

	public function updateUserModuleStep3(\App\Request $request)
	{
		$importModuleName = $request->get('module_import_name');
		$uploadFile = $request->get('module_import_file');
		$uploadDir = Settings_ModuleManager_Module_Model::getUploadDirectory();
		$uploadFileName = "$uploadDir/$uploadFile";
		vtlib\Deprecated::checkFileAccess($uploadFileName);

		$importType = strtolower($request->get('module_import_type'));
		if ($importType == 'language') {
			$package = new vtlib\Language();
		} else if ($importType == 'layout') {
			$package = new vtlib\Layout();
		} else {
			$package = new vtlib\Package();
		}

		if ($importType == 'language' || $importType == 'layout') {
			$package->import($uploadFileName);
		} else {
			$package->update(vtlib\Module::getInstance($importModuleName), $uploadFileName);
		}

		\vtlib\Deprecated::checkFileAccessForDeletion($uploadFileName);
		unlink($uploadFileName);

		$result = array('success' => true, 'importModuleName' => $importModuleName);
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}

	public function validateRequest(\App\Request $request)
	{
		$request->validateWriteAccess();
	}

	public function checkModuleName(\App\Request $request)
	{
		$qualifiedModuleName = $request->getModule(false);
		$moduleName = $request->get('moduleName');
		$module = vtlib\Module::getInstance($moduleName);
		if ($module) {
			$result = array('success' => false, 'text' => \App\Language::translate('LBL_MODULE_ALREADY_EXISTS_TRY_ANOTHER', $qualifiedModuleName));
		} elseif (preg_match('/[^A-Za-z]/i', $moduleName)) {
			$result = array('success' => false, 'text' => \App\Language::translate('LBL_INVALID_MODULE_NAME', $qualifiedModuleName));
		} else {
			$result = array('success' => true);
		}
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}

	public function createModule(\App\Request $request)
	{
		$formData = $request->get('formData');
		$moduleManagerModel = new Settings_ModuleManager_Module_Model();
		$result = array('success' => true, 'text' => ucfirst($formData['module_name']));
		try {
			$moduleManagerModel->createModule($formData);
		} catch (Exception $e) {
			$result = array('success' => false, 'text' => $e->getMessage());
		}
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}

	public function deleteModule(\App\Request $request)
	{
		$moduleName = $request->get('forModule');
		$moduleInstance = vtlib\Module::getInstance($moduleName);
		if ($moduleInstance) {
			$moduleInstance->delete();
			$result = array('success' => true);
		} else
			$result = array('success' => false);
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
}
