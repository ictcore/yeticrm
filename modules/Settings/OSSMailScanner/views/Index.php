<?php

/**
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_OSSMailScanner_Index_View extends Settings_Vtiger_Index_View
{

	private $prefixesForModules = ['Project', 'HelpDesk', 'SSalesProcesses', 'Campaigns'];

	public function process(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$mailModuleActive = vtlib\Functions::getModuleId('OSSMail');
		$mailScannerRecordModel = Vtiger_Record_Model::getCleanInstance('OSSMailScanner');
		$identityList = [];
		if ($mailModuleActive) {
			$accountsList = OSSMail_Record_Model::getAccountsList();
			foreach ($accountsList as $key => $account) {
				$identityList[$account['user_id']] = OSSMailScanner_Record_Model::getIdentities($account['user_id']);
			}
		}

		$actionsList = OSSMailScanner_Record_Model::getActionsList();
		$ConfigFolderList = OSSMailScanner_Record_Model::getConfigFolderList();
		$emailSearch = OSSMailScanner_Record_Model::getEmailSearch();
		$emailSearchList = OSSMailScanner_Record_Model::getEmailSearchList();
		$widgetCfg = OSSMailScanner_Record_Model::getConfig(false);
		$supportedModules = Settings_Vtiger_CustomRecordNumberingModule_Model::getSupportedModules();
		foreach ($supportedModules as $supportedModule) {
			if (in_array($supportedModule->name, $this->prefixesForModules)) {
				$numbering[$supportedModule->name] = \App\Fields\RecordNumber::getNumber($supportedModule->name);
			}
		}

		$checkCron = OSSMailScanner_Record_Model::getCron();
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD_MODEL', $mailScannerRecordModel);
		$viewer->assign('ACCOUNTS_LIST', $accountsList);
		$viewer->assign('ACTIONS_LIST', $actionsList);
		$viewer->assign('CONFIGFOLDERLIST', $ConfigFolderList);
		$viewer->assign('WIDGET_CFG', $widgetCfg);
		$viewer->assign('EMAILSEARCH', $emailSearch);
		$viewer->assign('EMAILSEARCHLIST', $emailSearchList);
		$viewer->assign('RECORDNUMBERING', $numbering);
		$viewer->assign('ERRORNOMODULE', !$mailModuleActive);
		$viewer->assign('MODULENAME', $moduleName);
		$viewer->assign('IDENTITYLIST', $identityList);
		$viewer->assign('CHECKCRON', $checkCron);
		echo $viewer->view('Index.tpl', $request->getModule(false), true);
	}
}
