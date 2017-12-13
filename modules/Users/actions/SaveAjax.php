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
Vtiger_Loader::includeOnce('~include/Webservices/Custom/ChangePassword.php');

class Users_SaveAjax_Action extends Vtiger_SaveAjax_Action
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('userExists');
		$this->exposeMethod('savePassword');
		$this->exposeMethod('restoreUser');
		$this->exposeMethod('editPasswords');
		$this->exposeMethod('updateUserColor');
		$this->exposeMethod('updateGroupColor');
		$this->exposeMethod('updateModuleColor');
		$this->exposeMethod('updateColorForProcesses');
		$this->exposeMethod('generateColor');
		$this->exposeMethod('activeColor');
		$this->exposeMethod('changeAccessKey');
	}

	public function checkPermission(\App\Request $request)
	{
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$userId = $request->getInteger('userid');
		if (!$currentUserModel->isAdminUser()) {
			$mode = $request->getMode();
			if ($mode === 'savePassword' && ($userId && (int) $currentUserModel->getId() !== $userId)) {
				throw new \Exception\NoPermittedToRecord('LBL_PERMISSION_DENIED');
			} else if ($mode !== 'savePassword' && ((int) $currentUserModel->getId() !== $request->getInteger('record'))) {
				throw new \Exception\NoPermittedToRecord('LBL_PERMISSION_DENIED');
			}
		}
	}

	/**
	 * Process
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$mode = $request->get('mode');
		if (!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}

		$recordModel = $this->saveRecord($request);
		$settingsModuleModel = Settings_Users_Module_Model::getInstance();
		$settingsModuleModel->refreshSwitchUsers();
		$fieldModelList = $recordModel->getModule()->getFields();
		$result = [];
		foreach ($fieldModelList as $fieldName => &$fieldModel) {
			if (!$fieldModel->isViewEnabled()) {
				continue;
			}
			$fieldValue = $displayValue = Vtiger_Util_Helper::toSafeHTML($recordModel->get($fieldName));
			if ($fieldModel->getFieldDataType() !== 'currency') {
				$displayValue = $fieldModel->getDisplayValue($fieldValue, $recordModel->getId());
			}
			if ($fieldName === 'language') {
				$displayValue = \App\Language::getLanguageLabel($fieldValue);
			}
			if (($fieldName === 'currency_decimal_separator' || $fieldName === 'currency_grouping_separator') && ($displayValue === '&nbsp;')) {
				$displayValue = \App\Language::translate('LBL_SPACE', 'Users');
			}
			$result[$fieldName] = ['value' => $fieldValue, 'display_value' => $displayValue];
		}

		$result['_recordLabel'] = $recordModel->getName();
		$result['_recordId'] = $recordModel->getId();

		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		$response->setResult($result);
		$response->emit();
	}

	/**
	 * Function to get the record model based on the request parameters
	 * @param \App\Request $request
	 * @return Vtiger_Record_Model or Module specific Record Model instance
	 */
	public function getRecordModelFromRequest(\App\Request $request)
	{
		$recordModel = parent::getRecordModelFromRequest($request);
		$fieldName = $request->get('field');
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		if ($fieldName === 'is_admin' && (!$currentUserModel->isAdminUser() || !$request->get('value'))) {
			$recordModel->set($fieldName, 'off');
			$recordModel->set('is_owner', 0);
		} else if ($fieldName === 'is_admin' && $currentUserModel->isAdminUser()) {
			$recordModel->set($fieldName, 'on');
			$recordModel->set('is_owner', 1);
		}
		return $recordModel;
	}

	public function userExists(\App\Request $request)
	{
		$module = $request->getModule();
		$userName = $request->get('user_name');
		$userModuleModel = Users_Module_Model::getCleanInstance($module);
		$status = $userModuleModel->checkDuplicateUser($userName);
		$response = new Vtiger_Response();
		$response->setResult($status);
		$response->emit();
	}

	public function savePassword(\App\Request $request)
	{
		$module = $request->getModule();
		$userModel = vglobal('current_user');
		$newPassword = $request->get('new_password');
		$oldPassword = $request->get('old_password');
		$checkPassword = Settings_Password_Record_Model::checkPassword($newPassword);
		if (!$checkPassword) {
			$wsUserId = vtws_getWebserviceEntityId($module, $request->get('userid'));
			$wsStatus = vtws_changePassword($wsUserId, $oldPassword, $newPassword, $newPassword, $userModel);
		}
		$response = new Vtiger_Response();
		if ($checkPassword) {
			$response->setError($checkPassword, $checkPassword);
		} elseif ($wsStatus['message']) {
			$response->setResult($wsStatus);
		} else {
			$response->setError('JS_PASSWORD_INCORRECT_OLD', 'JS_PASSWORD_INCORRECT_OLD');
		}
		$response->emit();
	}

	/**
	 * Mass edit users passwords
	 * @param \App\Request $request
	 * @throws WebServiceException
	 */
	public function editPasswords(\App\Request $request)
	{
		$module = $request->getModule();
		$userModel = vglobal('current_user');
		$newPassword = $request->get('new_password');
		$oldPassword = $request->get('old_password');
		$userIds = $request->get('userids');

		$checkPassword = Settings_Password_Record_Model::checkPassword($newPassword);

		if (!$checkPassword) {
			foreach ($userIds as $userId) {
				$wsUserId = vtws_getWebserviceEntityId($module, $userId);
				$wsStatus = vtws_changePassword($wsUserId, $oldPassword, $newPassword, $newPassword, $userModel);
			}
		}

		$response = new Vtiger_Response();
		if ($checkPassword) {
			$response->setError($checkPassword, $checkPassword);
		} else if ($wsStatus['message']) {
			$response->setResult($wsStatus);
		} else {
			$response->setError('JS_PASSWORD_INCORRECT_OLD', 'JS_PASSWORD_INCORRECT_OLD');
		}

		$response->emit();
	}
	/*
	 * To restore a user
	 * @param \App\Request Object
	 */

	public function restoreUser(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$record = $request->get('userid');

		$recordModel = Users_Record_Model::getInstanceById($record, $moduleName);
		$recordModel->set('status', 'Active');
		$recordModel->save();

		$db = PearDatabase::getInstance();
		$db->pquery("UPDATE vtiger_users SET deleted=? WHERE id=?", array(0, $record));

		$userModuleModel = Users_Module_Model::getInstance($moduleName);
		$listViewUrl = $userModuleModel->getListViewUrl();

		$response = new Vtiger_Response();
		$response->setResult(array('message' => \App\Language::translate('LBL_USER_RESTORED_SUCCESSFULLY', $moduleName), 'listViewUrl' => $listViewUrl));
		$response->emit();
	}

	public function updateUserColor(\App\Request $request)
	{
		$params = $request->get('params');
		Users_Colors_Model::updateUserColor($params);
		$response = new Vtiger_Response();
		$response->setResult(array(
			'success' => true,
			'message' => \App\Language::translate('LBL_SAVE_COLOR', $request->getModule(false))
		));
		$response->emit();
	}

	public function updateGroupColor(\App\Request $request)
	{
		$params = $request->get('params');
		Users_Colors_Model::updateGroupColor($params);
		$response = new Vtiger_Response();
		$response->setResult(array(
			'success' => true,
			'message' => \App\Language::translate('LBL_SAVE_COLOR', $request->getModule(false))
		));
		$response->emit();
	}

	public function updateModuleColor(\App\Request $request)
	{
		$params = $request->get('params');
		Users_Colors_Model::updateModuleColor($params);
		$response = new Vtiger_Response();
		$response->setResult(array(
			'success' => true,
			'message' => \App\Language::translate('LBL_SAVE_COLOR', $request->getModule(false))
		));
		$response->emit();
	}

	public function generateColor(\App\Request $request)
	{
		$params = $request->get('params');

		$response = new Vtiger_Response();
		$response->setResult([
			'success' => true,
			'color' => Users_Colors_Model::generateColor($params),
			'message' => App\Language::translate('LBL_GENERATED_COLOR', $request->getModule(false))
		]);
		$response->emit();
	}

	public function updateColorForProcesses(\App\Request $request)
	{
		$params = $request->get('params');
		Users_Colors_Model::updateColor($params);
		$response = new Vtiger_Response();
		$response->setResult(array(
			'success' => true,
			'message' => \App\Language::translate('LBL_SAVE_COLOR', $request->getModule(false))
		));
		$response->emit();
	}

	public function activeColor(\App\Request $request)
	{
		$params = $request->get('params');
		$color = Users_Colors_Model::activeColor($params);
		$response = new Vtiger_Response();
		$response->setResult(array(
			'success' => true,
			'color' => $color,
			'message' => \App\Language::translate('LBL_SAVE_COLOR', $request->getModule(false))
		));
		$response->emit();
	}

	public function changeAccessKey(\App\Request $request)
	{
		$recordId = $request->get('record');
		$moduleName = $request->getModule();

		$response = new Vtiger_Response();
		try {
			$recordModel = Users_Record_Model::getInstanceById($recordId, $moduleName);
			$oldAccessKey = $recordModel->get('accesskey');

			$entity = $recordModel->getEntity();
			$entity->createAccessKey();

			require_once('modules/Users/CreateUserPrivilegeFile.php');
			createUserPrivilegesfile($recordId);

			require("user_privileges/user_privileges_$recordId.php");
			$newAccessKey = $user_info['accesskey'];
			if ($newAccessKey != $oldAccessKey) {
				$response->setResult(array('message' => \App\Language::translate('LBL_ACCESS_KEY_UPDATED_SUCCESSFULLY', $moduleName), 'accessKey' => $newAccessKey));
			} else {
				$response->setError(\App\Language::translate('LBL_FAILED_TO_UPDATE_ACCESS_KEY', $moduleName));
			}
		} catch (Exception $ex) {
			$response->setError($ex->getMessage());
		}
		$response->emit();
	}
}
