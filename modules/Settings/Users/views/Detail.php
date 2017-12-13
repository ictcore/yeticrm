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

class Settings_Users_Detail_View extends Users_PreferenceDetail_View
{

	public function checkPermission(\App\Request $request)
	{
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$record = $request->get('record');
		if ($currentUserModel->isAdminUser() === true || ($currentUserModel->get('id') == $record && AppConfig::security('SHOW_MY_PREFERENCES'))) {
			return true;
		} else {
			throw new \Exception\AppException('LBL_PERMISSION_DENIED');
		}
	}

	public function preProcess(\App\Request $request, $display = true)
	{
		parent::preProcess($request, false);
		$this->preProcessSettings($request);
	}

	/**
	 * Pre process settings
	 * @param \App\Request $request
	 */
	public function preProcessSettings(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$selectedMenuId = $request->get('block');
		$fieldId = $request->get('fieldid');
		$settingsModel = Settings_Vtiger_Module_Model::getInstance();
		$menuModels = $settingsModel->getMenus();
		$menu = $settingsModel->prepareMenuToDisplay($menuModels, $moduleName, $selectedMenuId, $fieldId);
		$viewer->assign('MENUS', $menu);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->view('SettingsMenuStart.tpl', $qualifiedModuleName);
	}

	public function postProcessSettings(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$qualifiedModuleName = $request->getModule(false);
		$viewer->view('SettingsMenuEnd.tpl', $qualifiedModuleName);
	}

	public function postProcess(\App\Request $request)
	{
		$this->postProcessSettings($request);
		parent::postProcess($request);
	}

	public function process(\App\Request $request)
	{
		$viewer = $this->getViewer($request);

		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->view('UserViewHeader.tpl', $request->getModule());
		parent::process($request);
	}

	public function getFooterScripts(\App\Request $request)
	{
		$headerScriptInstances = parent::getFooterScripts($request);

		$jsFileNames = array(
			'modules.Settings.Vtiger.resources.Index'
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	/**
	 * Function to get Ajax is enabled or not
	 * @param Vtiger_Record_Model record model
	 * @return <boolean> true/false
	 */
	public function isAjaxEnabled($recordModel)
	{
		if ($recordModel->get('status') != 'Active') {
			return false;
		}
		return $recordModel->isEditable();
	}
}
