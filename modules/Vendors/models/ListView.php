<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * *********************************************************************************** */

class Vendors_ListView_Model extends Vtiger_ListView_Model
{

	/**
	 * Function to get the list of Mass actions for the module
	 * @param <Array> $linkParams
	 * @return <Array> - Associative array of Link type to List of  Vtiger_Link_Model instances for Mass Actions
	 */
	public function getListViewMassActions($linkParams)
	{
		$links = parent::getListViewMassActions($linkParams);
		$moduleModel = $this->getModule();
		$currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$massActionLinks = [];
		if ($moduleModel->isPermitted('MassComposeEmail') && AppConfig::main('isActiveSendingMails') && App\Mail::getDefaultSmtp()) {
			$massActionLinks[] = [
				'linktype' => 'LISTVIEWMASSACTION',
				'linklabel' => 'LBL_MASS_SEND_EMAIL',
				'linkurl' => 'javascript:Vtiger_List_Js.triggerSendEmail()',
				'linkicon' => ''
			];
		}
		if ($currentUserModel->hasModulePermission('SMSNotifier') && $currentUserModel->hasModuleActionPermission($moduleModel->getId(), 'MassSendSMS')) {
			$massActionLinks[] = [
				'linktype' => 'LISTVIEWMASSACTION',
				'linklabel' => 'LBL_MASS_SEND_SMS',
				'linkurl' => 'javascript:Vtiger_List_Js.triggerSendSms("index.php?module=' . $moduleModel->getName() . '&view=MassActionAjax&mode=showSendSMSForm","SMSNotifier");',
				'linkicon' => ''
			];
		}
		foreach ($massActionLinks as $massActionLink) {
			$links['LISTVIEWMASSACTION'][] = Vtiger_Link_Model::getInstanceFromValues($massActionLink);
		}
		return $links;
	}
}
