<?php

/**
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_Inventory_ModalAjax_View extends Settings_Inventory_CreditLimits_View
{

	public function process(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$qualifiedModuleName = $request->getModule(false);
		$id = $request->get('id');
		$type = $request->get('type');

		if (empty($id)) {
			$recordModel = new Settings_Inventory_Record_Model();
		} else {
			$recordModel = Settings_Inventory_Record_Model::getInstanceById($id, $type);
		}

		$viewer->assign('PAGE_LABELS', $this->getPageLabels($request));
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('RECORD_MODEL', $recordModel);
		$viewer->assign('TYPE', $type);
		$viewer->assign('CURRENCY', Vtiger_Util_Helper::getBaseCurrency());
		echo $viewer->view('Modal.tpl', $qualifiedModuleName, true);
	}
}
