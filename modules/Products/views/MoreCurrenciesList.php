<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ********************************************************************************** */

class Products_MoreCurrenciesList_View extends Vtiger_IndexAjax_View
{

	public function checkPermission(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$record = $request->get('record');
		$lockEdit = false;
		if (empty($record) || $request->get('isDuplicate') == 'true') {
			$recordPermission = Users_Privileges_Model::isPermitted($moduleName, 'CreateView');
		} else {
			$recordPermission = Users_Privileges_Model::isPermitted($moduleName, 'EditView', $record);
			$lockEdit = Users_Privileges_Model::checkLockEdit($moduleName, Vtiger_Record_Model::getInstanceById($record, $moduleName));
		}
		if (!$recordPermission || ($lockEdit && $request->get('isDuplicate') != 'true')) {
			throw new \Exception\NoPermittedToRecord('LBL_NO_PERMISSIONS_FOR_THE_RECORD');
		}
	}

	public function process(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		$currencyName = $request->get('currency');

		if (!empty($recordId)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
			$priceDetails = $recordModel->getPriceDetails();
		} else {
			$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
			$priceDetails = $recordModel->getPriceDetails();

			foreach ($priceDetails as $key => $currencyDetails) {
				if ($currencyDetails['curname'] === $currencyName) {
					$baseCurrencyConversionRate = $currencyDetails['conversionrate'];
					break;
				}
			}

			foreach ($priceDetails as $key => $currencyDetails) {
				if ($currencyDetails['curname'] === $currencyName) {
					$currencyDetails['conversionrate'] = 1;
					$currencyDetails['is_basecurrency'] = 1;
				} else {
					$currencyDetails['conversionrate'] = $currencyDetails['conversionrate'] / $baseCurrencyConversionRate;
					$currencyDetails['is_basecurrency'] = 0;
				}
				$priceDetails[$key] = $currencyDetails;
			}
		}

		$viewer = $this->getViewer($request);

		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('PRICE_DETAILS', $priceDetails);
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());

		$viewer->view('MoreCurrenciesList.tpl', 'Products');
	}
}
