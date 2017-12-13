<?php
/* +***********************************************************************************************************************************
  /**
 * Settings HideBlocks edit view class
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */

Class Settings_HideBlocks_Edit_View extends Settings_Vtiger_Index_View
{

	public function process(\App\Request $request)
	{
		$recordId = $request->get('record');
		$qualifiedModuleName = $request->getModule(false);
		$mode = '';
		$enabled = 0;
		$views = [];
		$viewer = $this->getViewer($request);
		$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
		if ($recordId) {
			$mode = 'edit';
			$recordModel = Settings_HideBlocks_Record_Model::getInstanceById($recordId, $qualifiedModuleName);
			$enabled = $recordModel->get('enabled');
			if ($recordModel->get('view') != '')
				$views = explode(',', $recordModel->get('view'));
			$viewer->assign('BLOCK_ID', $recordModel->get('blockid'));
		}

		$viewer->assign('MODE', $mode);
		$viewer->assign('RECORD_ID', $recordId);
		$viewer->assign('ENABLED', $enabled);
		$viewer->assign('SELECTED_VIEWS', $views);
		$viewer->assign('MODULE', 'HideBlocks');
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('BLOCKS', $moduleModel->getAllBlock());
		$viewer->assign('VIEWS', $moduleModel->getViews());
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->view('EditView.tpl', $qualifiedModuleName);
	}
}
