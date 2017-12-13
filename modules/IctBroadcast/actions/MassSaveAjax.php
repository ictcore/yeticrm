<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class IctBroadcast_MassSaveAjax_Action extends Vtiger_Mass_Action {

	/**
	 * Check Permission
	 * @param \App\Request $request
	 * @throws \Exception\NoPermitted
	 */
public function checkPermission(\App\Request $request)
	{
		$sourceModule = $request->get('source_module');
		
		/*if (!\App\Privilege::isPermitted($sourceModule, 'CreateView') || !\App\Privilege::isPermitted($sourceModule, 'MassSendSMS') || !SMSNotifier_Module_Model::checkServer()) {
			throw new \Exception\NoPermitted('adeel bhuttag');
		}*/
	}

		/**
	 * Function that save valu in ictbroadcast
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request) {
        $sourceModule = $request->get('source_module');
		$type = $request->get('type');
		$bank = $request->get('bank');
		$fileInstance = \App\Fields\File::loadFromRequest($_FILES['file']);
		$result = Vtiger_Util_Helper::transformUploadedFiles($_FILES, true);
       $group = $request->get('group');
		$campaing_type = $request->get('campaing_type');
		//echo "<pre>dddd";print_r($request);
        $recordIds = $this->getRecordsListFromRequest($request);
        $moduleModel = Vtiger_Module_Model::getInstance('Leads');
        $json_data = array();
       $nameFields = $moduleModel->getFieldsByLabel();
		foreach($nameFields as $key=>$test)
        {
           $fieldInfo[$key]  = $test->get('name');
        }
		   unset($fieldInfo['Lead No'],$fieldInfo['Designation'],$fieldInfo['Lead Source'],$fieldInfo['Po Box'],$fieldInfo['Website'],$fieldInfo['AddressLevel3'],$fieldInfo['Lead Status'],$fieldInfo['AddressLevel1'],$fieldInfo['AddressLevel4'],$fieldInfo['AddressLevel2'],$fieldInfo['AddressLevel6'],$fieldInfo['AddressLevel7'],$fieldInfo['Local number'],$fieldInfo['AddressLevel5'],$fieldInfo['Building number'],$fieldInfo['AddressLevel8'],$fieldInfo['LBL_CRMACTIVITY'],$fieldInfo['FL_TOTAL_TIME_H'],$fieldInfo['Closed Time'],$fieldInfo['Created Time'],$fieldInfo['Created By'],$fieldInfo['Modified Time'],$fieldInfo['Verification data'],$fieldInfo['Lead Source'],$fieldInfo['LBL_LEGAL_FORM'],$fieldInfo['Registration number 1'],$fieldInfo['Registration number 2'],$fieldInfo['Approval for email']

		   	,$fieldInfo['Approval for phone calls'],$fieldInfo['Assigned To'],$fieldInfo['Share with users'],$fieldInfo['Vat ID']	,$fieldInfo['Industry'],$fieldInfo['Sub industry'],$fieldInfo['No Of Employees'],$fieldInfo['LBL_RELATION'],

		   	$fieldInfo['Was read'],$fieldInfo['Last Modified By'],$fieldInfo['FL_ACTIVE'],$fieldInfo['FL_IS_PRIVATE']
		   	,$fieldInfo['Description'],$fieldInfo['Attention'],$fieldInfo['Annual Revenue'],$fieldInfo['Fax'],$fieldInfo['Secondary Email']
		);
		//echo "<pre>";print_r($fieldInfo);
        foreach($recordIds as $recordId) {
			$recordModel = Vtiger_Record_Model::getInstanceById($recordId);
			$numberSelected = false;
			foreach($fieldInfo as $key=>$fieldname) {
				$fieldValue = $recordModel->get($fieldname);
				if(!empty($fieldValue)) {
					$toNumbers[$recordId][$key] = $fieldValue;

					//echo $toNumbers['First Name'.'_'.$recordId];
					$numberSelected = true;
				}
			}
			if($numberSelected) {
				$recordIds[] = $recordId;
			}
		}
		//exit;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 if(($campaing_type == 'voice' AND $_FILES['fle']['type']=='audio/x-wav') OR ($campaing_type == 'fax' AND ($_FILES['fle']['type']=='application/pdf' OR $_FILES['fle']['type']=='image/tiff' )) OR ($campaing_type =='voice_interactive' AND $_FILES['fle']['type']=='audio/x-wav')){

		    	 	
	$arguments = array('contact_group'=> array('name' => $group));

	$result  = $this->broadcast_api('Contact_Group_Create', $arguments);

	//   echo "<pre>adeeeeelbhutta123456789809";print_r($request->get('group'));

	if($result[0] == true) {
		$contact_group_id = $result[1];
		// print_r($contact_id);
		$json_data['group_id'] = $contact_group_id;
		$json_data['campaign_type'] = $campaing_type;
	} else {
		$errmsg = $result[1];
	return $errmsg;
	}
	foreach($toNumbers as  $c_data){
		$contact = array(
		'phone' => $c_data['Phone'], 
		'first_name'=>$c_data['Company'], 
		'last_name'=>'', 
		'email'=> $c_data['Email']
		);
		$arguments = array('contact'=>$contact, 'contact_group_id'=> $json_data['group_id']);
		$result  = $this->broadcast_api('Contact_Create', $arguments);
		if($result[0] == true) {
		 $contact_id = $result[1];
		} else {
		 $errmsg = $result[1];
		 return $errmsg;
		}
	}
	
	} else{
	throw new \Exception\NoPermitted('Please Choose Correct File According to Campaign Type ');
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
	if($campaing_type == 'voice' || $campaing_type=='fax' || $campaing_type =='voice_interactive' ){

		if($campaing_type=='voice'){

			$method = 'Recording_Create';
			$method_campaign =  'Campaign_Create';

		}elseif($campaing_type=='fax'){
			$method = 'Document_Create';
			$method_campaign =  'Campaign_Fax_Create';
		}elseif($campaing_type == 'voice_interactive'){
			$method = 'Recording_Create';

			$method_campaign =  'Campaign_Interactive_Create';
		}
		$mimetyper = $_FILES['fle']['type'];
		$m_file = curl_file_create($_FILES['fle']['tmp_name'], $mimetyper, basename($_FILES['fle']['tmp_name']));
		$arguments = array('title'=> $group, 'media'=>$m_file);
		$result = $this->broadcast_api($method, $arguments);
		if($result[0] == true) {
			$recording_id = $result[1];
			//print_r($recording_id);
		} else {
			$errmsg = $result[1];
			print_r($errmsg);
		}
		if($campaing_type == 'voice' || $campaing_type=='fax'){

				$campaign = array(
				'contact_group_id'  => $contact_group_id,     //  contact_group_id
				'message'           => $recording_id,     //  recording_id
				);
		}
		if($campaing_type =='voice_interactive'){

		 $campaign = array(
			'contact_group_id'  => $contact_group_id,     //  contact_group_id
			'message'           => $recording_id,     //  recording_id
			'extension_key'     => '1',     // any value from 0 to 7 
		    'extension_id'      => $request->get('extension'),     // extension_id 
			);

		}

		$arguments = array('campaign'=>$campaign);
		$result = $this->broadcast_api($method_campaign , $arguments);
		if($result[0] == true) {
			$campaign_id = $result[1];
		//print_r($campaign_id);
		} else {
			echo "campaignerror";
			$errmsg = $result[1];
			print_r($errmsg);
		} 
	}
?>
<script>
alert("Campaign Created Successfully");
</script>
<?php
          sleep(5);
			header('Location: http://localhost/YetiForceCRM/index.php?module=Leads&view=List&mid=48&parent=47');
	       /*$response = new Vtiger_Response();

			if(!empty($toNumbers)) {
			
				$response->setResult($json_data);
			} else {
				$response->setResult(false);
			}
			return $response;*/
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
