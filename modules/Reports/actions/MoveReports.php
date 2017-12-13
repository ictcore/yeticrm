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

class Reports_MoveReports_Action extends Vtiger_Mass_Action
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
		$parentModule = 'Reports';
		$reportIdsList = Reports_Record_Model::getRecordsListFromRequest($request);
		$folderId = $request->get('folderid');

		if (!empty($reportIdsList)) {
			foreach ($reportIdsList as $reportId) {
				$reportModel = Reports_Record_Model::getInstanceById($reportId);
				if (!$reportModel->isDefault() && $reportModel->isEditable()) {
					$reportModel->move($folderId);
				} else {
					$reportsMoveDenied[] = \App\Language::translate($reportModel->getName(), $parentModule);
				}
			}
		}
		$response = new Vtiger_Response();
		if (empty($reportsMoveDenied)) {
			$response->setResult(array(\App\Language::translate('LBL_REPORTS_MOVED_SUCCESSFULLY', $parentModule)));
		} else {
			$response->setError($reportsMoveDenied, \App\Language::translate('LBL_DENIED_REPORTS', $parentModule));
		}

		$response->emit();
	}
}
