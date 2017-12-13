<?php

/**
 * Save keys
 * @package YetiForce.Github
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
class Settings_Github_SaveKeysAjax_Action extends Settings_Vtiger_Basic_Action
{

	public function process(\App\Request $request)
	{
		$clientId = $request->get('client_id');
		$token = $request->get('token');
		$username = $request->get('username');
		$clientModel = Settings_Github_Client_Model::getInstance();
		$clientModel->setToken($token);
		$clientModel->setClientId($clientId);
		$clientModel->setUsername($username);
		if ($clientModel->checkToken()) {
			$success = $clientModel->saveKeys();
			$success = $success ? true : false;
		} else {
			$success = false;
		}
		$responce = new Vtiger_Response();
		$responce->setResult(array('success' => $success));
		$responce->emit();
	}

	public function validateRequest(\App\Request $request)
	{
		$request->validateWriteAccess();
	}
}
