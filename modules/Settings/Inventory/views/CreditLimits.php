<?php

/**
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_Inventory_CreditLimits_View extends Settings_Vtiger_Index_View
{

	public function getView()
	{
		return 'CreditLimits';
	}

	public function process(\App\Request $request)
	{
		$mode = $request->getMode();
		if (!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}
		$view = $this->getView();
		$recordModel = new Settings_Inventory_Record_Model();
		$recordModel->setType($view);
		$allData = Settings_Inventory_Record_Model::getDataAll($view);

		$qualifiedModuleName = $request->getModule(false);
		$viewer = $this->getViewer($request);
		$viewer->assign('PAGE_LABELS', $this->getPageLabels($request));
		$viewer->assign('RECORD_MODEL', $recordModel);
		$viewer->assign('INVENTORY_DATA', $allData);
		$viewer->assign('VIEW', $view);
		$viewer->assign('CURRENCY', Vtiger_Util_Helper::getBaseCurrency());
		$viewer->view('Index.tpl', $qualifiedModuleName);
	}

	public function getPageLabels(\App\Request $request)
	{
		if ($request->get('type')) {
			$view = $request->get('type');
		} else {
			$view = $request->get('view');
		}
		$translations = [];
		$translations['title'] = 'LBL_' . strtoupper($view);
		$translations['title_single'] = 'LBL_' . strtoupper($view) . '_SINGLE';
		$translations['description'] = 'LBL_' . strtoupper($view) . '_DESCRIPTION';
		return $translations;
	}
}
