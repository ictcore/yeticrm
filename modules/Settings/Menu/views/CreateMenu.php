<?php

/**
 * Settings menu CreateMenu view class
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_Menu_CreateMenu_View extends Settings_Vtiger_IndexAjax_View
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('step1');
		$this->exposeMethod('step2');
	}

	public function step1(\App\Request $request)
	{
		$qualifiedModuleName = $request->getModule(false);
		$settingsModel = Settings_Menu_Module_Model::getInstance();
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE_MODEL', $settingsModel);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('ROLEID', $roleId);
		$viewer->view('CreateMenuStep1.tpl', $qualifiedModuleName);
	}

	public function step2(\App\Request $request)
	{
		$qualifiedModuleName = $request->getModule(false);
		$type = $request->get('mtype');
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE_MODEL', Settings_Menu_Module_Model::getInstance());
		$viewer->assign('RECORD', Settings_Menu_Record_Model::getCleanInstance());
		$viewer->assign('ICONS_LABEL', Settings_Menu_Record_Model::getIcons());
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('TYPE', $type);
		$viewer->view('CreateMenuStep2.tpl', $qualifiedModuleName);
	}
}


//CREATE TABLE vtiger_ictbroadcast ( ictbroadcastid int(10)  AUTO_INCREMENT PRIMARY KEY,gateway VARCHAR(30) NOT NULL) 