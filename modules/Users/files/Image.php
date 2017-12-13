<?php
/*
 * Basic class to handle files
 * @package YetiForce.Files
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

/**
 * Basic class to handle files
 */
class Users_Image_File
{

	public function getCheckPermission(\App\Request $request)
	{
		return true;
	}

	public function get(\App\Request $request)
	{
		$record = $request->get('record');
		if (empty($record)) {
			throw new \Exception\NoPermitted('Not Acceptable', 406);
		}
		$recordModel = Vtiger_Record_Model::getInstanceById($record, $request->getModule());
		$path = ROOT_DIRECTORY . DIRECTORY_SEPARATOR . $recordModel->getImagePath();
		$file = App\Fields\File::loadFromPath($path);
		header('Content-Type: ' . $file->getMimeType());
		header("Content-Transfer-Encoding: binary");
		readfile($path);
	}

	public function postCheckPermission(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$record = $request->get('record');
		$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		// Check for operation access.
		$allowed = Users_Privileges_Model::isPermitted($moduleName, 'Save', $record);
		if ($allowed) {
			// Deny access if not administrator or account-owner or self
			if (!$currentUserModel->isAdminUser()) {
				if (empty($record)) {
					$allowed = false;
				} else if ($currentUserModel->get('id') !== $recordModel->getId()) {
					$allowed = false;
				}
			}
		}
		if (!$allowed) {
			throw new \Exception\AppException('LBL_PERMISSION_DENIED');
		}
	}

	public function post(\App\Request $request)
	{
		
	}
}
