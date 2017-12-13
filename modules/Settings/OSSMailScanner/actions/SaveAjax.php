<?php

/**
 * Mail scanner action creating mail
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_OSSMailScanner_SaveAjax_Action extends Settings_Vtiger_IndexAjax_View
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('updateFolders');
	}

	public function updateFolders(\App\Request $request)
	{
		$user = $request->get('user');
		$folders = $request->get('folders');
		$mailScannerRecordModel = Vtiger_Record_Model::getCleanInstance('OSSMailScanner');
		$mailScannerRecordModel->setFolderList($user, $folders);
		$response = new Vtiger_Response();
		$response->setResult([
			'success' => true,
			'message' => \App\Language::translate('LBL_SAVE_FOLDER_INFO', $request->getModule())
		]);
		$response->emit();
	}
}
