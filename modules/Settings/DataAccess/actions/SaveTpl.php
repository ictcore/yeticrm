<?php

/**
 * Settings DataAccess SaveTpl action class
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_DataAccess_SaveTpl_Action extends Settings_Vtiger_Index_Action
{

	public function checkPermission(\App\Request $request)
	{
		return;
	}

	public function process(\App\Request $request)
	{
		$baseModule = $request->get('base_module');
		$summary = $request->get('summary');
		$conditionAll = $request->getRaw('condition_all_json');
		$conditionOption = $request->getRaw('condition_option_json');
		$db = \App\Db::getInstance();
		$db->createCommand()->insert('vtiger_dataaccess', [
			'module_name' => $baseModule,
			'summary' => $summary
		])->execute();
		$recordId = $db->getLastInsertID('vtiger_dataaccess_dataaccessid_seq');
		Settings_DataAccess_Module_Model::addConditions($conditionAll, $recordId);
		Settings_DataAccess_Module_Model::addConditions($conditionOption, $recordId, false);
		header("Location: index.php?module=DataAccess&parent=Settings&view=Index");
	}
}
