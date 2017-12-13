<?php

/**
 * Configuration notifications
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_Notifications_Configuration_View extends Settings_Vtiger_Index_View
{

	/**
	 * Function gets module settings
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$srcModule = $request->get('srcModule');
		$modules = Vtiger_Watchdog_Model::getSupportedModules();
		if ($request->isEmpty('srcModule')) {
			reset($modules);
			$srcModule = key($modules);
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('WATCHDOG_MODULE', Vtiger_Watchdog_Model::getInstance($srcModule));
		$viewer->assign('SELECTED_MODULE', $srcModule);
		$viewer->assign('SUPPORTED_MODULES', $modules);
		$viewer->view('Configuration.tpl', $request->getModule(false));
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
			"modules.Settings.$moduleName.resources.Configuration",
			'~libraries/jquery/datatables/media/js/jquery.dataTables.min.js',
			'~libraries/jquery/datatables/plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'
		];
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
