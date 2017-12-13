<?php

/**
 * Edit view class for MailSmtp
 * @package YetiForce.Settings.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Adrian Koń <a.kon@yetiforce.com>
 */
class Settings_MailSmtp_Edit_View extends Settings_Vtiger_Index_View
{

	/**
	 * Function proccess
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$moduleName = $request->getModule(false);
		$viewer = $this->getViewer($request);
		$record = $request->get('record');
		if (!empty($record)) {
			$recordModel = Settings_MailSmtp_Record_Model::getInstanceById($record);
		} else {
			$recordModel = Settings_MailSmtp_Record_Model::getCleanInstance();
		}
		$viewer->assign('RECORD_MODEL', $recordModel);
		$viewer->assign('RECORD_ID', $record);
		$viewer->assign('QUALIFIED_MODULE', $moduleName);
		$viewer->view('Edit.tpl', $moduleName);
	}

	/**
	 * Function to get the list of Script models to be included
	 * @param \App\Request $request
	 * @return array - List of Vtiger_JsScript_Model instances
	 */
	public function getFooterScripts(\App\Request $request)
	{
		$headerScriptInstances = parent::getFooterScripts($request);
		$moduleName = $request->getModule();
		$jsFileNames = [
			"modules.Settings.$moduleName.resources.Edit",
		];
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
