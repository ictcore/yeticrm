<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Settings_IctBroadcast_Index_View extends Settings_Vtiger_Index_View
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
	 
/*ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
error_log( "Hello, errors123!" );*/
		$recordModel = Settings_IctBroadcast_Record_Model::getInstance();

		$moduleModel = Settings_IctBroadcast_Module_Model::getCleanInstance();
		print_r($moduleModel);
		echo "==========";
		print_r($recordModel);
		 //echo $moduleModel."==========".$recordModel;exit;
		  
		$viewer = $this->getViewer($request);
                
		$viewer->assign('RECORD_ID', $recordModel->get('id'));
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('MODULE', $request->getModule(false));
		$viewer->assign('QUALIFIED_MODULE', $request->getModule(false));
		$viewer->assign('RECORD_MODEL', $recordModel);
		echo "==========";
		$viewer->view('index.tpl', $request->getModule(false));
	}
}
