<?php

/**
 * Companies delete action model class
 * @package YetiForce.Settings.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Adrian Koń <a.kon@yetiforce.com>
 */
class Settings_Companies_DeleteAjax_Action extends Settings_Vtiger_Delete_Action
{

	/**
	 * Process
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$record = $request->get('record');
		$qualifiedModuleName = $request->getModule(false);
		$recordModel = Settings_Companies_Record_Model::getInstance($record);
		$recordModel->delete();

		$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
		header("Location: {$moduleModel->getDefaultUrl()}");
	}
	
	/**
	 * Validate Request
	 * @param \App\Request $request
	 */
	public function validateRequest(\App\Request $request)
	{
		$request->validateReadAccess();
	}
}
