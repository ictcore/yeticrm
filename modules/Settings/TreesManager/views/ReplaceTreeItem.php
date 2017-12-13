<?php

/**
 * Settings TreesManager ReplaceTreeItem view class
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_TreesManager_ReplaceTreeItem_View extends Settings_Vtiger_Index_View
{

	public function process(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule(false);
		$viewer->assign('QUALIFIED_MODULE', $moduleName);
		$viewer->view('ReplaceTreeItem.tpl', $moduleName);
	}
}
