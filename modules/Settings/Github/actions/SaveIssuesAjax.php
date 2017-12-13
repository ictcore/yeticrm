<?php

/**
 * Save issue to github
 * @package YetiForce.Github
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
class Settings_Github_SaveIssuesAjax_Action extends Settings_Vtiger_Basic_Action
{

	public function process(\App\Request $request)
	{
		$title = $request->get('title');
		$body = $request->get('body');
		$clientModel = Settings_Github_Client_Model::getInstance();
		$success = $clientModel->createIssue($body, $title);
		$success = $success ? true : false;
		$responce = new Vtiger_Response();
		$responce->setResult(array('success' => $success));
		$responce->emit();
	}

	public function validateRequest(\App\Request $request)
	{
		$request->validateWriteAccess();
	}
}
