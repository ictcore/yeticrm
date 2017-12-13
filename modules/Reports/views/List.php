<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * ********************************************************************************** */

class Reports_List_View extends Vtiger_Index_View
{

	protected $listViewHeaders = false;
	protected $listViewEntries = false;
	protected $listViewCount = false;

	public function checkPermission(\App\Request $request)
	{
		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if (!$currentUserPriviligesModel->hasModulePermission($request->getModule())) {
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}
	}

	public function preProcess(\App\Request $request, $display = true)
	{
		parent::preProcess($request, false);

		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$folders = $moduleModel->getFolders();
		$listViewModel = new Reports_ListView_Model();
		$listViewModel->set('module', $moduleModel);

		$folderId = $request->get('viewname');
		if (empty($folderId) || $folderId == 'undefined') {
			$folderId = 'All';
		}
		$sortBy = $request->get('sortorder');
		$orderBy = $request->get('orderby');

		$listViewModel->set('folderid', $folderId);
		$listViewModel->set('orderby', $orderBy);
		$listViewModel->set('sortorder', $sortBy);

		$linkModels = $listViewModel->getListViewLinks(false);
		$pageNumber = $request->get('page');
		$listViewMassActionModels = $listViewModel->getListViewMassActions(false);

		if (empty($pageNumber)) {
			$pageNumber = '1';
		}
		$pagingModel = new Vtiger_Paging_Model();
		$pagingModel->set('page', $pageNumber);
		$viewer->assign('PAGING_MODEL', $pagingModel);

		if (!$this->listViewHeaders) {
			$this->listViewHeaders = $listViewModel->getListViewHeaders();
		}
		if (!$this->listViewEntries) {
			$this->listViewEntries = $listViewModel->getListViewEntries($pagingModel);
		}

		$noOfEntries = count($this->listViewEntries);

		$viewer->assign('LISTVIEW_LINKS', $linkModels);
		$viewer->assign('FOLDERS', $folders);
		$viewer->assign('VIEWNAME', $folderId);
		$viewer->assign('PAGE_NUMBER', $pageNumber);
		$viewer->assign('LISTVIEW_MASSACTIONS', $listViewMassActionModels);
		$viewer->assign('LISTVIEW_ENTRIES_COUNT', $noOfEntries);


		if (!$this->listViewCount) {
			$this->listViewCount = $listViewModel->getListViewCount();
		}
		$totalCount = $this->listViewCount;
		$pagingModel->set('totalCount', (int) $totalCount);
		$pageCount = $pagingModel->getPageCount();
		$startPaginFrom = $pagingModel->getStartPagingFrom();

		$viewer->assign('PAGE_COUNT', $pageCount);
		$viewer->assign('LISTVIEW_COUNT', $totalCount);
		$viewer->assign('START_PAGIN_FROM', $startPaginFrom);

		if ($display) {
			$this->preProcessDisplay($request);
		}
	}

	public function preProcessTplName(\App\Request $request)
	{
		return 'ListViewPreProcess.tpl';
	}

	public function process(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$folderId = $request->get('viewname');
		if (empty($folderId) || $folderId == 'undefined') {
			$folderId = 'All';
		}
		$pageNumber = $request->get('page');
		$orderBy = $request->get('orderby');

		$sortOrder = $request->get('sortorder');
		if ($sortOrder == "ASC") {
			$nextSortOrder = "DESC";
			$sortImage = "glyphicon glyphicon-chevron-down";
		} else {
			$nextSortOrder = "ASC";
			$sortImage = "glyphicon glyphicon-chevron-up";
		}

		$listViewModel = new Reports_ListView_Model();
		$listViewModel->set('module', $moduleModel);
		$listViewModel->set('folderid', $folderId);

		if (!empty($orderBy)) {
			$listViewModel->set('orderby', $orderBy);
			$listViewModel->set('sortorder', $sortOrder);
		}
		$listViewMassActionModels = $listViewModel->getListViewMassActions(false);
		if (empty($pageNumber)) {
			$pageNumber = '1';
		}
		$viewer->assign('MODULE', $moduleName);
		$pagingModel = new Vtiger_Paging_Model();
		$pagingModel->set('page', $pageNumber);
		$viewer->assign('PAGING_MODEL', $pagingModel);

		$viewer->assign('LISTVIEW_MASSACTIONS', $listViewMassActionModels);

		if (!$this->listViewHeaders) {
			$this->listViewHeaders = $listViewModel->getListViewHeaders();
		}
		if ($folderId == 'All') {
			$this->listViewHeaders['foldername'] = 'LBL_FOLDER_NAME';
		}

		if (!$this->listViewEntries) {
			$this->listViewEntries = $listViewModel->getListViewEntries($pagingModel);
		}
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$noOfEntries = count($this->listViewEntries);

		$viewer->assign('PAGE_NUMBER', $pageNumber);
		$viewer->assign('LISTVIEW_ENTRIES_COUNT', $noOfEntries);
		$viewer->assign('LISTVIEW_HEADERS', $this->listViewHeaders);
		$viewer->assign('LISTVIEW_ENTRIES', $this->listViewEntries);
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('VIEWNAME', $folderId);

		$viewer->assign('ORDER_BY', $orderBy);
		$viewer->assign('SORT_ORDER', $sortOrder);
		$viewer->assign('NEXT_SORT_ORDER', $nextSortOrder);
		$viewer->assign('SORT_IMAGE', $sortImage);
		$viewer->assign('COLUMN_NAME', $orderBy);
		if (AppConfig::performance('LISTVIEW_COMPUTE_PAGE_COUNT')) {
			if (!$this->listViewCount) {
				$this->listViewCount = $listViewModel->getListViewCount();
			}
			$totalCount = $this->listViewCount;
			$pageLimit = $pagingModel->getPageLimit();
			$pageCount = ceil((int) $totalCount / (int) $pageLimit);

			if ($pageCount == 0) {
				$pageCount = 1;
			}
			$viewer->assign('PAGE_COUNT', $pageCount);
			$viewer->assign('LISTVIEW_COUNT', $totalCount);
		}

		$viewer->view('ListViewContents.tpl', $moduleName);
	}

	public function postProcess(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();

		$viewer->view('ListViewPostProcess.tpl', $moduleName);
		parent::postProcess($request);
	}

	/**
	 * Function to get the list of Script models to be included
	 * @param \App\Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	public function getFooterScripts(\App\Request $request)
	{
		$headerScriptInstances = parent::getFooterScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			'modules.Vtiger.resources.List',
			"modules.$moduleName.resources.List",
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	/**
	 * Function returns the number of records for the current filter
	 * @param \App\Request $request
	 */
	public function getRecordsCount(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$cvId = $request->get('viewname');
		$count = $this->getListViewCount($request);

		$result = [];
		$result['module'] = $moduleName;
		$result['viewname'] = $cvId;
		$result['count'] = $count;

		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		$response->setResult($result);
		$response->emit();
	}

	/**
	 * Function to get listView count
	 * @param \App\Request $request
	 */
	public function getListViewCount(\App\Request $request)
	{
		$folderId = $request->get('viewname');
		if (empty($folderId)) {
			$folderId = 'All';
		}
		$listViewModel = new Reports_ListView_Model();
		$listViewModel->set('folderid', $folderId);
		$count = $listViewModel->getListViewCount();

		return $count;
	}

	/**
	 * Function to get the page count for list
	 * @return total number of pages
	 */
	public function getPageCount(\App\Request $request)
	{
		$listViewCount = $this->getListViewCount($request);
		$pagingModel = new Vtiger_Paging_Model();
		$pageLimit = $pagingModel->getPageLimit();
		$pageCount = ceil((int) $listViewCount / (int) $pageLimit);

		if ($pageCount == 0) {
			$pageCount = 1;
		}
		$result = [];
		$result['page'] = $pageCount;
		$result['numberOfRecords'] = $listViewCount;
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
}
