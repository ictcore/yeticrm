<?php

/**
 * 
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mriusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_LoginHistory_List_View extends Settings_Vtiger_List_View
{

	public function preProcess(\App\Request $request, $display = true)
	{
		$viewer = $this->getViewer($request);
		$loginHistoryRecordModel = new Settings_LoginHistory_Record_Model();
		$usersList = $loginHistoryRecordModel->getAccessibleUsers();
		$viewer->assign('USERSLIST', $usersList);
		$viewer->assign('SELECTED_USER', $request->get('user_name'));
		parent::preProcess($request, false);
	}
}
