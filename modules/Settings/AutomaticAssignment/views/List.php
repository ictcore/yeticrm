<?php

/**
 * Automatic Assignment List View Class
 * @package YetiForce.Settings.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_AutomaticAssignment_List_View extends Settings_Vtiger_List_View
{

	/**
	 * Pre-process function
	 * @param \App\Request $request
	 * @param boolean $display
	 */
	public function preProcess(\App\Request $request, $display = true)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('SUPPORTED_MODULE_MODELS', Settings_AutomaticAssignment_Module_Model::getSupportedModules());
		parent::preProcess($request, $display);
	}
}
