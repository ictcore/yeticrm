<?php

/**
 * Settings RealizationProcesses module model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_RealizationProcesses_Module_Model extends Settings_Vtiger_Module_Model
{

	/**
	 * Gets Project status 
	 * @return - array of Project status
	 */
	public static function getProjectStatus()
	{
		\App\Log::trace('Entering Settings_RealizationProcesses_Module_Model::getProjectStatus() method ...');
		$return = \App\Fields\Picklist::getPickListValues('projectstatus');
		\App\Log::trace('Exiting Settings_RealizationProcesses_Module_Model::getProjectStatus() method ...');
		return $return;
	}

	/**
	 * Gets status
	 * @return - array of status
	 */
	public static function getStatusNotModify()
	{
		\App\Log::trace('Entering Settings_RealizationProcesses_Module_Model::getStatusNotModify() method ...');
		$dataReader = (new App\Db\Query())->from('vtiger_realization_process')
				->createCommand()->query();
		while ($row = $dataReader->read()) {
			$moduleId = $row['module_id'];
			$moduleName = App\Module::getModuleName($moduleId);
			$return[$moduleName]['id'] = $moduleId;
			$status = \App\Json::decode(html_entity_decode($row['status_indicate_closing']));
			if (!is_array($status)) {
				$status = [$status];
			}
			$return[$moduleName]['status'] = $status;
		}

		\App\Log::trace('Exiting Settings_RealizationProcesses_Module_Model::getStatusNotModify() method ...');
		return $return;
	}

	/**
	 * Update status
	 * @return - array of status
	 */
	public static function updateStatusNotModify($moduleId, $status)
	{
		\App\Log::trace('Entering Settings_RealizationProcesses_Module_Model::updateStatusNotModify() method ...');
		\App\Db::getInstance()->createCommand()->update('vtiger_realization_process', [
			'status_indicate_closing' => \App\Json::encode($status)
			], ['module_id' => $moduleId])->execute();
		\App\Log::trace('Exiting Settings_RealizationProcesses_Module_Model::updateStatusNotModify() method ...');
		return true;
	}
}
