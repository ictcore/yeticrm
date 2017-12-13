<?php

/**
 * Modal view
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
class Settings_AdvancedPermission_RecalculatePermission_View extends Settings_Vtiger_BasicModal_View
{

	public function process(\App\Request $request)
	{
		parent::preProcess($request);
		$qualifiedModuleName = $request->getModule(false);
		$modules = vtlib\Functions::getAllModules();
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE_NAME', $request->getModule(true));
		$viewer->assign('MODULE', $qualifiedModuleName);
		$viewer->assign('LIST_MODULES' , $modules);
		$viewer->view('RecalculatePermission.tpl', $qualifiedModuleName);
		parent::postProcess($request);
	}
}
