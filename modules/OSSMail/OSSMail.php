<?php

/**
 * OSSMail CRMEntity class
 * @package YetiForce.CRMEntity
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class OSSMail
{

	public function vtlib_handler($moduleName, $eventType)
	{
		$adb = PearDatabase::getInstance();
		if ($eventType == 'module.postinstall') {
			$displayLabel = 'OSSMail';
			$adb->pquery("UPDATE vtiger_tab SET customized=0 WHERE name=?", array($displayLabel), true);
			Settings_Vtiger_Module_Model::addSettingsField('LBL_MAIL', [
				'name' => 'Mail',
				'iconpath' => 'adminIcon-mail-download-history',
				'description' => 'LBL_OSSMAIL_DESCRIPTION',
				'linkto' => 'index.php?module=OSSMail&parent=Settings&view=index'
			]);
			$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_ossmails_logs` (
					  `id` int(19) NOT NULL AUTO_INCREMENT,
					  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `end_time` timestamp NULL DEFAULT NULL,
					  `action` varchar(100) DEFAULT NULL,
					  `status` tinyint(3) DEFAULT NULL,
					  `user` varchar(100) DEFAULT NULL,
					  `count` int(10) DEFAULT NULL,
					  `stop_user` varchar(100) DEFAULT NULL,
					  `info` varchar(100) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8");
			$Module = vtlib\Module::getInstance($moduleName);
			$user_id = Users_Record_Model::getCurrentUserModel()->get('user_name');
			$adb->pquery("INSERT INTO vtiger_ossmails_logs (`action`, `info`, `user`) VALUES (?, ?,?);", array('Action_InstallModule', $moduleName . ' ' . $Module->version, $user_id), false);
		} else if ($eventType == 'module.disabled') {
			$user_id = Users_Record_Model::getCurrentUserModel()->get('user_name');
			App\Db::getInstance()->createCommand()->insert('vtiger_ossmails_logs', ['action' => 'Action_DisabledModule', 'info' => $moduleName, 'user' => $user_id, 'start_time' => date('Y-m-d H:i:s')])->execute();
		} else if ($eventType == 'module.enabled') {
			if (Settings_ModuleManager_Library_Model::checkLibrary('roundcube')) {
				throw new \Exception\NotAllowedMethod(\App\Language::translate('ERR_NO_REQUIRED_LIBRARY', 'Settings:Vtiger', 'roundcube'));
			}
			$user_id = Users_Record_Model::getCurrentUserModel()->get('user_name');
			App\Db::getInstance()->createCommand()->insert('vtiger_ossmails_logs', ['action' => 'Action_EnabledModule', 'info' => $moduleName, 'user' => $user_id, 'start_time' => date('Y-m-d H:i:s')])->execute();
		} else if ($eventType == 'module.preuninstall') {
			
		} else if ($eventType == 'module.preupdate') {
			
		} else if ($eventType == 'module.postupdate') {
			$adb = PearDatabase::getInstance();
			$OSSMail = vtlib\Module::getInstance('OSSMail');
			if (version_compare($OSSMail->version, '1.39', '>')) {
				$user_id = Users_Record_Model::getCurrentUserModel()->get('user_name');
				App\Db::getInstance()->createCommand()->insert('vtiger_ossmails_logs', ['action' => 'Action_UpdateModule', 'info' => $moduleName . ' ' . $Module->version, 'user' => $user_id, 'start_time' => date('Y-m-d H:i:s')])->execute();
			}
		}
	}
}
