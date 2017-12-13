<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Reports_DeleteAjax_Action extends Vtiger_DeleteAjax_Action
{

	public function checkPermission(\App\Request $request)
	{
		if (!Users_Privileges_Model::getCurrentUserPrivilegesModel()->hasModulePermission($request->getModule())) {
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}
	}
	
	public function process(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$response = new Vtiger_Response();
		$recordModel = Reports_Record_Model::getInstanceById($request->get('record'), $moduleName);
		if (!$recordModel->isDefault() && $recordModel->isEditable()) {
			$recordModel->delete();
			$response->setResult([App\Language::translate('LBL_REPORTS_DELETED_SUCCESSFULLY', $moduleName)]);
		} else {
			$response->setError(App\Language::translate('LBL_REPORT_DELETE_DENIED', $moduleName));
		}
		$response->emit();
	}
}
