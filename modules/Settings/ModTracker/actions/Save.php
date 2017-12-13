<?php

/**
 * Settings ModTracker save action class
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_ModTracker_Save_Action extends Settings_Vtiger_Index_Action
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('changeActiveStatus');
	}

	public function changeActiveStatus(\App\Request $request)
	{
		$id = $request->get('id');
		$status = $request->get('status');
		$moduleModel = new Settings_ModTracker_Module_Model();
		$moduleModel->changeActiveStatus($id, $status == 'true' ? 1 : 0 );

		$response = new Vtiger_Response();
		if ($status == 'true') {
			$response->setResult(array('success' => true, 'message' => \App\Language::translate('LBL_TRACK_CHANGES_ENABLED', $request->getModule(false))));
		} else {
			$response->setResult(array('success' => true, 'message' => \App\Language::translate('LBL_TRACK_CHANGES_DISABLE', $request->getModule(false))));
		}
		$response->emit();
	}
}
