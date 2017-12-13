<?php

/**
 * Reservations RightPanel view class
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Reservations_RightPanel_View extends Vtiger_IndexAjax_View
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('getUsersList');
		$this->exposeMethod('getTypesList');
	}

	public function getUsersList(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('ALL_ACTIVEUSER_LIST', \App\Fields\Owner::getInstance(false, $currentUser)->getAccessibleUsers());
		$viewer->assign('ALL_ACTIVEGROUP_LIST', \App\Fields\Owner::getInstance(false, $currentUser)->getAccessibleGroups());
		$viewer->assign('USER_MODEL', $currentUser);
		$viewer->view('RightPanel.tpl', $moduleName);
	}

	public function getTypesList(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer->assign('ALL_ACTIVETYPES_LIST', Reservations_Calendar_Model::getCalendarTypes());
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('USER_MODEL', $currentUser);
		$viewer->view('RightPanel.tpl', $moduleName);
	}
}
