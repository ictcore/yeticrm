<?php

/**
 * Settings RealizationProcesses SaveGeneral action class
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_RealizationProcesses_SaveGeneral_Action extends Settings_Vtiger_Index_Action
{

	public function __construct()
	{
		$this->exposeMethod('save');
	}

	/**
	 * Save date
	 * @param <array> request
	 * @return true if saved, false otherwise
	 */
	public function save(\App\Request $request)
	{
		$response = new Vtiger_Response();
		$status = $request->get('status');
		$moduleId = $request->get('moduleId');
		$moduleName = $request->getModule(false);
		try {
			if (Settings_RealizationProcesses_Module_Model::updateStatusNotModify($moduleId, $status)) {
				$response->setResult(array('success' => true, 'message' => \App\Language::translate('LBL_SAVE_CONFIG_OK', $moduleName)));
			} else {
				$response->setResult(array('success' => false, 'message' => \App\Language::translate('LBL_SAVE_CONFIG_ERROR', $moduleName)));
			}
		} catch (Exception $e) {
			$response->setError($e->getCode(), $e->getMessage());
		}
		$response->emit();
	}
}
