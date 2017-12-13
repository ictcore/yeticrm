<?php

/**
 * Companies edit view class
 * @package YetiForce.Settings.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_Companies_Edit_View extends Settings_Vtiger_Index_View
{

	/**
	 * Process function
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$record = $request->get('record');

		if ($record) {
			$recordModel = Settings_Companies_Record_Model::getInstance($record);
		} else {
			$recordModel = new Settings_Companies_Record_Model();
		}
		$viewer->assign('COMPANY_COLUMNS', Settings_Companies_Module_Model::getColumnNames());
		$viewer->assign('INDUSTRY_LIST', Settings_Companies_Module_Model::getIndustryList());
		$viewer->assign('RECORD_MODEL', $recordModel);
		$viewer->assign('RECORD_ID', $record);
		$viewer->assign('MODULE', $moduleName);
		$viewer->view('EditView.tpl', $qualifiedModuleName);
	}

	/**
	 * Get footer JS scripts
	 * @param \App\Request $request
	 * @return Vtiger_JsScript_Model[]
	 */
	public function getFooterScripts(\App\Request $request)
	{
		$headerScriptInstances = parent::getFooterScripts($request);
		$jsFileNames = [
			'modules.Vtiger.resources.AdvanceFilterEx',
			'modules.Settings.Companies.resources.Edit',
		];
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		return array_merge($headerScriptInstances, $jsScriptInstances);
	}
}
