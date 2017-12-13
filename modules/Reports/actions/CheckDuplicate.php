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

class Reports_CheckDuplicate_Action extends Vtiger_Action_Controller
{

	public function checkPermission(\App\Request $request)
	{
		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if (!$currentUserPriviligesModel->hasModulePermission($request->getModule())) {
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}
	}

	public function process(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$reportName = $request->get('reportname');
		$record = $request->get('record');

		if ($record) {
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
		} else {
			$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
		}

		$recordModel->set('reportname', $reportName);
		$recordModel->set('reportid', $record);
		$recordModel->set('isDuplicate', $request->get('isDuplicate'));

		if (!$recordModel->checkDuplicate()) {
			$result = array('success' => false);
		} else {
			$result = array('success' => true, 'message' => \App\Language::translate('LBL_DUPLICATES_EXIST', $moduleName));
		}
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
}
