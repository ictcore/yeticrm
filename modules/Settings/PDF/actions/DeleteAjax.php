<?php

/**
 * Delete Action Class for PDF Settings
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Maciej Stencel <m.stencel@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_PDF_DeleteAjax_Action extends Settings_Vtiger_Index_Action
{

	public function process(\App\Request $request)
	{
		$recordId = $request->get('record');

		$response = new Vtiger_Response();
		$recordModel = Vtiger_PDF_Model::getInstanceById($recordId);
		if (Settings_PDF_Record_Model::delete($recordModel)) {
			$response->setResult(array('success' => 'true'));
		} else {
			$response->setResult(array('success' => 'false'));
		}
		$response->emit();
	}
}
