<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class HelpDesk_DetailView_Model extends Vtiger_DetailView_Model
{

	/**
	 * Function to get the detail view links (links and widgets)
	 * @param <array> $linkParams - parameters which will be used to calicaulate the params
	 * @return <array> - array of link models in the format as below
	 *                   array('linktype'=>list of link models);
	 */
	public function getDetailViewLinks($linkParams)
	{
		$linkModelList = parent::getDetailViewLinks($linkParams);
		$recordModel = $this->getRecord();

		$quotesModuleModel = Vtiger_Module_Model::getInstance('Faq');
		if ($quotesModuleModel->isPermitted('DetailView')) {
			$basicActionLink = array(
				'linktype' => 'DETAILVIEW',
				'linklabel' => 'LBL_CONVERT_FAQ',
				'linkurl' => $recordModel->getConvertFAQUrl(),
				'showLabel' => 1,
			);
			$linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
		}

		return $linkModelList;
	}

	public function getDetailViewRelatedLinks()
	{
		$recordModel = $this->getRecord();
		$moduleName = $recordModel->getModuleName();

		$relatedLinks = parent::getDetailViewRelatedLinks();
		$parentModel = Vtiger_Module_Model::getInstance('OSSTimeControl');
		if ($parentModel->isActive()) {
			$relatedLinks[] = [
				'linktype' => 'DETAILVIEWTAB',
				'linklabel' => 'LBL_CHARTS',
				'linkurl' => $recordModel->getDetailViewUrl() . '&mode=showCharts&requestMode=charts',
				'linkicon' => '',
				'linkKey' => 'LBL_RECORD_SUMMARY',
				'related' => 'Charts'
			];
		}
		$showPSTab = (!AppConfig::module($moduleName, 'HIDE_SUMMARY_PRODUCTS_SERVICES')) && (\App\Module::isModuleActive('Products') || \App\Module::isModuleActive('Services') || \App\Module::isModuleActive('Assets') || \App\Module::isModuleActive('OSSSoldServices'));
		if ($showPSTab) {
			$relatedLinks[] = [
				'linktype' => 'DETAILVIEWTAB',
				'linklabel' => 'LBL_RECORD_SUMMARY_PRODUCTS_SERVICES',
				'linkurl' => $recordModel->getDetailViewUrl() . '&mode=showRelatedProductsServices&requestMode=summary',
				'linkicon' => '',
				'linkKey' => 'LBL_RECORD_SUMMARY',
				'related' => 'ProductsAndServices',
				'countRelated' => AppConfig::relation('SHOW_RECORDS_COUNT')
			];
		}
		return $relatedLinks;
	}
}
