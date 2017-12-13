<?php

/**
 * WebserviceUsers ListView Model Class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_WebserviceUsers_ListView_Model extends Settings_Vtiger_ListView_Model
{

	/**
	 * Function sets module instance
	 * @param string $name
	 * @return $this
	 */
	public function setModule($name)
	{
		$modelClassName = Vtiger_Loader::getComponentClassName('Model', 'Module', $name);
		$this->module = new $modelClassName();
		$this->module->typeApi = \App\Request::_get('typeApi');
		return $this;
	}

	/**
	 * Function to get Basic links
	 * @return array of Basic links
	 */
	public function getBasicLinks()
	{
		$basicLinks = [];
		$moduleModel = $this->getModule();
		if ($moduleModel->hasCreatePermissions())
			$basicLinks[] = [
				'linktype' => 'LISTVIEWBASIC',
				'linklabel' => 'LBL_ADD_RECORD',
				'linkdata' => ['url' => $moduleModel->getEditViewUrl()],
				'linkicon' => 'glyphicon glyphicon-plus',
				'linkclass' => 'btn-success addRecord',
				'showLabel' => 1,
				'modalView' => true
			];

		return $basicLinks;
	}
}
