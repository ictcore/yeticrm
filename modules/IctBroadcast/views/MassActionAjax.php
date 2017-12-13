<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
//class Vtiger_MassActionAjax_View extends Vtiger_IndexAjax_View

class IctBroadcast_MassActionAjax_View extends Vtiger_IndexAjax_View {
	public function __construct()
	{
		parent::__construct();
	
		$this->exposeMethod('showBroadCasting');
		
	}

	public function process(\App\Request $request)
	{
		//echo "<pre>adeelsharif";print_r($request->get('mode'));
		$mode = $request->get('mode');
		if (!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}
	

	 /**
	 * Function shows form that will lets you ICTBroadcast
	 * @param \App\Request $request
	 */
	function showBroadCasting(\App\Request $request) {
		

		$sourceModule = 'Leads';
		$moduleName = 'IctBroadcast';
		$selectedIds = $request->get('selected_ids');
		$excludedIds = $request->get('excluded_ids');
		$cvId = $request->get('viewname');
		

		$moduleModel = Vtiger_Module_Model::getInstance($sourceModule);
		$phoneFields = $moduleModel->getFieldsByType('phone');
		$viewer = $this->getViewer($request);
		//$moduleSettingsName = $request->getModule(false);
	     echo "adeel sharif";
		//$record = Vtiger_Record_Model::getCleanInstance($moduleName);
		echo "adeel sharif";
		//$type = $request->get('type');
		//$bank = $request->get('bank');
			$arguments = array();
			$result  = $this->broadcast_api('User_Extension_List', $arguments);
			/*ini_set("log_errors32", 1);
			ini_set("error_log", "/tmp/php-errorwe.log");
			error_log( "Hello, errors!" );*/
			if($result[0] == true) {
			$data = $result[1];
			print_r($data);
			} else {
			$errmsg = $result[1];
			//print_r($errmsg);
			return $errmsg;
			}
//$json = json_encode($paymentsIn);
		$viewer->assign('VIEWNAME', $cvId);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('SOURCE_MODULE', $sourceModule);
		$viewer->assign('SELECTED_IDS', $selectedIds);
		$viewer->assign('EXCLUDED_IDS', $excludedIds);
		$viewer->assign('PHONE_FIELDS', $phoneFields);
		$viewer->assign('Campaign_type', $data);
		//$viewer->assign('JSON', $json);
//
//echo "<pre>adeelbhuttag222";print_r($request);
		$searchKey = $request->get('search_key');
		$searchValue = $request->get('search_value');
		$operator = $request->get('operator');

		if (!empty($operator)) {
			$viewer->assign('OPERATOR', $operator);
			$viewer->assign('ALPHABET_VALUE', $searchValue);
			$viewer->assign('SEARCH_KEY', $searchKey);
		}

		$searchParams = $request->get('search_params');
		if (!empty($searchParams)) {
			$viewer->assign('SEARCH_PARAMS', $searchParams);
		}
		//parent::process($request);
       
	echo $viewer->view('StartBroadcastForm1.tpl', $moduleName, true);
		//echo $viewer->view('SendSMSForm.tpl', $moduleName, true);
	}

	 public function broadcast_api($method, $arguments = array()) {
	  // update following with proper access info
	  $api_username = 'zuha';    // <=== Username at ICTBroadcast
	  $api_password = 'godisone';  // <=== Password at ICTBroadcast
	  $service_url  = 'http://202.142.186.26/rest'; // <=== URL for ICTBroadcast REST APIs

	  $post_data    = array(
	    'api_username' => $api_username,
	    'api_password' => $api_password
	  );
	  $api_url = "$service_url/$method";
	  $curl = curl_init($api_url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($curl, CURLOPT_POST, true);

	  foreach($arguments as $key => $value) {
	    if(is_array($value)){
	      $post_data[$key] = json_encode($value);
	    } else {
	      $post_data[$key] = $value;
	    }
	  }
	  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	  // enable following line in case, having trouble with certificate validation
	  // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  $curl_response = curl_exec($curl);
	  curl_close($curl);
	  return json_decode($curl_response);  

	}

}
