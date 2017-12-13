<?php

/**
 * ApiAddress model class
 * @package YetiForce.CRMEntity
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class ApiAddress
{

	/**
	 * Invoked when special actions are performed on the module.
	 * @param String Module name
	 * @param String Event Type
	 */
	public function vtlib_handler($moduleName, $eventType)
	{
		require_once('include/utils/utils.php');
		$adb = PearDatabase::getInstance();
		$registerLink = false;
		if ($eventType == 'module.postinstall') {
			//Add Assets Module to Customer Portal
			$adb = PearDatabase::getInstance();
			$registerLink = true;

			$adb->query("UPDATE vtiger_tab SET customized=0 WHERE name='$moduleName'");
			$sql = "INSERT INTO `vtiger_apiaddress` ( `nominatim`, `key`, `source`, `min_length` ) VALUES ( ?, ?, ?, ?);";
			$adb->pquery($sql, array(0, 0, 'https://api.opencagedata.com/geocode/v1/', 3), true);
		} else if ($eventType == 'module.disabled') {
			
		} else if ($eventType == 'module.enabled') {
			
		} else if ($eventType == 'module.preuninstall') {
			
		} else if ($eventType == 'module.preupdate') {
			
		} else if ($eventType == 'module.postupdate') {
			
		}
		$displayLabel = 'LBL_API_ADDRESS';
		if ($registerLink) {
			Settings_Vtiger_Module_Model::addSettingsField('LBL_INTEGRATION', [
				'name' => $displayLabel,
				'iconpath' => '',
				'description' => 'LBL_API_ADDRESS_DESCRIPTION',
				'linkto' => 'index.php?module=ApiAddress&parent=Settings&view=Configuration'
			]);
		} else {
			Settings_Vtiger_Module_Model::deleteSettingsField('LBL_INTEGRATION', $displayLabel);
		}
	}
}
