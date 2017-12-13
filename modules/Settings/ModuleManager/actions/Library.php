<?php

/**
 * Library action class
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_ModuleManager_Library_Action extends Settings_Vtiger_IndexAjax_View
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('download');
		$this->exposeMethod('update');
	}

	public function process(\App\Request $request)
	{
		$mode = $request->getMode();
		if (!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	/**
	 * Function to update library
	 * @param \App\Request $request
	 */
	public function update(\App\Request $request)
	{
		Settings_ModuleManager_Library_Model::update($request->get('name'));
		header("Location: index.php?module=ModuleManager&parent=Settings&view=List");
	}

	/**
	 * Function to download library
	 * @param \App\Request $request
	 */
	public function download(\App\Request $request)
	{
		Settings_ModuleManager_Library_Model::download($request->get('name'));
		header("Location: index.php?module=ModuleManager&parent=Settings&view=List");
	}
}
