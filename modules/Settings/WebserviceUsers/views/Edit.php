<?php

/**
 * Edit View Class
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_WebserviceUsers_Edit_View extends Settings_Vtiger_BasicModal_View
{

	/**
	 * Process
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		parent::preProcess($request);
		$qualifiedModuleName = $request->getModule(false);
		$recordId = $request->get('record');
		$type = $request->get('typeApi');
		if (!empty($recordId)) {
			$recordModel = Settings_WebserviceUsers_Record_Model::getInstanceById($recordId, $type);
		} else {
			$recordModel = Settings_WebserviceUsers_Record_Model::getCleanInstance($type);
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD_MODEL', $recordModel);
		$viewer->assign('TYPE_API', $type);
		$viewer->assign('MODULE_MODEL', $recordModel->getModule());
		$viewer->view('Edit.tpl', $qualifiedModuleName);
		parent::postProcess($request);
	}
}
