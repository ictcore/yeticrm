<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Settings_PBXManager_Index_View extends Settings_Vtiger_Index_View
{

	public function __construct()
	{
		$this->exposeMethod('gatewayInfo');
	}

	public function process(\App\Request $request)
	{
		$this->gatewayInfo($request);
	}

	public function gatewayInfo(\App\Request $request)
	{
		$recordModel = Settings_PBXManager_Record_Model::getInstance();
		$moduleModel = Settings_PBXManager_Module_Model::getCleanInstance();
		$viewer = $this->getViewer($request);

		
		print_r($moduleModel);
		echo "==========";
		print_r($recordModel);
		 //echo $moduleModel."==========".$recordModel;exit;
		
		
		$viewer->assign('RECORD_ID', $recordModel->get('id'));
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('MODULE', $request->getModule(false));
		$viewer->assign('QUALIFIED_MODULE', $request->getModule(false));
		$viewer->assign('RECORD_MODEL', $recordModel);
		$viewer->view('index.tpl', $request->getModule(false));
	}
}
