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

class RecycleBin_RecycleBinAjax_Action extends Vtiger_Mass_Action
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('restoreRecords');
		$this->exposeMethod('emptyRecycleBin');
		$this->exposeMethod('deleteRecords');
	}

	public function checkPermission(\App\Request $request)
	{
		if ($request->get('mode') == 'emptyRecycleBin') {
			//we dont check for permissions since recylebin axis will not be there for non admin users
			return true;
		}
		$targetModuleName = $request->get('sourceModule', $request->get('module'));
		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if (!$currentUserPriviligesModel->hasModuleActionPermission($targetModuleName, 'Delete')) {
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}
	}

	public function preProcess(\App\Request $request)
	{
		return true;
	}

	public function postProcess(\App\Request $request)
	{
		return true;
	}

	public function process(\App\Request $request)
	{
		$mode = $request->get('mode');

		if (!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	/**
	 * Function to restore the deleted records.
	 * @param type $sourceModule
	 * @param type $recordIds
	 */
	public function restoreRecords(\App\Request $request)
	{
		$sourceModule = $request->get('sourceModule');
		$recordIds = $this->getRecordsListFromRequest($request);
		$recycleBinModule = new RecycleBin_Module_Model();

		$response = new Vtiger_Response();
		if ($recordIds) {
			$recycleBinModule->restore($sourceModule, $recordIds);
			$response->setResult(array(true));
		}

		$response->emit();
	}

	/**
	 * Function to delete the records permanently in vitger CRM database
	 */
	public function emptyRecycleBin(\App\Request $request)
	{
		$recycleBinModule = new RecycleBin_Module_Model();

		$status = $recycleBinModule->emptyRecycleBin();

		if ($status) {
			$response = new Vtiger_Response();
			$response->setResult(array($status));
			$response->emit();
		}
	}

	/**
	 * Function to deleted the records permanently in CRM
	 * @param type $reocrdIds
	 */
	public function deleteRecords(\App\Request $request)
	{
		$recordIds = $this->getRecordsListFromRequest($request);
		$recycleBinModule = new RecycleBin_Module_Model();

		$response = new Vtiger_Response();
		if ($recordIds) {
			$recycleBinModule->deleteRecords($recordIds);
			$response->setResult(array(true));
			$response->emit();
		}
	}
}
