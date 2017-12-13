<?php
/**
 * Class to delete
 * @package YetiForce.Settings.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

/**
 * Class to delete
 */
class Settings_SMSNotifier_DeleteAjax_Action extends Settings_Vtiger_Delete_Action
{

	/**
	 * Function  proccess
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$recordId = $request->get('record');
		$qualifiedModuleName = $request->getModule(false);
		$recordModel = Settings_SMSNotifier_Record_Model::getInstanceById($recordId, $qualifiedModuleName);
		$result = $recordModel->delete();

		$responceToEmit = new Vtiger_Response();
		$responceToEmit->setResult($result);
		$responceToEmit->emit();
	}

	/**
	 * Validating incoming request.
	 * @param \App\Request $request
	 */
	public function validateRequest(\App\Request $request)
	{
		$request->validateReadAccess();
	}
}
