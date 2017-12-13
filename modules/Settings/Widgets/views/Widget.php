<?php

/**
 * Settings OSSMailView index view class
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_Widgets_Widget_View extends Settings_Vtiger_Index_View
{

	public function process(\App\Request $request)
	{
		$mode = $request->getMode();
		if ($mode) {
			$this->$mode($request);
		} else {
			$this->createStep1($request);
		}
	}

	public function createStep1(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$sourceModule = $request->get('mod');
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$moduleModel = Settings_Widgets_Module_Model::getInstance($qualifiedModuleName);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('SOUNRCE_MODULE', $sourceModule);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->view('WidgetList.tpl', $qualifiedModuleName);
	}

	public function createStep2(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$type = $request->get('type');
		$tabId = $request->get('tabId');
		$moduleModel = Settings_Widgets_Module_Model::getInstance($qualifiedModuleName);
		$RelatedModule = $moduleModel->getRelatedModule($tabId);
		$widgetName = 'Vtiger_' . $type . '_Widget';
		$viewer->assign('TYPE', $type);
		$viewer->assign('SOURCE', $tabId);
		$viewer->assign('WID', '');
		$viewer->assign('WIDGETINFO', ['data' => [
				'limit' => 5, 'relatedmodule' => '', 'columns' => '', 'action' => '', 'switchHeader' => '', 'filter' => '', 'checkbox' => ''
			], 'nomargin' => '', 'label' => ''
		]);
		$viewer->assign('SOURCEMODULE', vtlib\Functions::getModuleName($tabId));
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('RELATEDMODULES', $RelatedModule);
		$viewer->assign('PRIVILEGESMODEL', Users_Privileges_Model::getCurrentUserPrivilegesModel());
		if (class_exists($widgetName)) {
			$widgetInstance = new $widgetName();
			$tplName = $widgetInstance->getConfigTplName();
			$viewer->view("widgets/$tplName.tpl", 'Vtiger');
		}
	}

	public function edit(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$wid = $request->get('id');
		$moduleModel = Settings_Widgets_Module_Model::getInstance($qualifiedModuleName);
		$WidgetInfo = $moduleModel->getWidgetInfo($wid);
		$RelatedModule = $moduleModel->getRelatedModule($WidgetInfo['tabid']);
		$type = $WidgetInfo['type'];
		$viewer = $this->getViewer($request);
		$viewer->assign('SOURCE', $WidgetInfo['tabid']);
		$viewer->assign('SOURCEMODULE', vtlib\Functions::getModuleName($WidgetInfo['tabid']));
		$viewer->assign('WID', $wid);
		$viewer->assign('WIDGETINFO', $WidgetInfo);
		$viewer->assign('TYPE', $type);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('RELATEDMODULES', $RelatedModule);
		$widgetName = 'Vtiger_' . $type . '_Widget';
		if (class_exists($widgetName)) {
			$widgetInstance = new $widgetName();
			$tplName = $widgetInstance->getConfigTplName();
			$viewer->view("widgets/$tplName.tpl", 'Vtiger');
		}
	}
}
