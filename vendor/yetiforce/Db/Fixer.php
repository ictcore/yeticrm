<?php
namespace App\Db;

/**
 * Class that repaire structure and data in database
 * @package YetiForce.App
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Fixer
{

	/**
	 * Add missing entries in vtiger_def_org_field
	 */
	public static function defOrgField()
	{
		\App\Log::trace('Entering ' . __METHOD__);
		$dbCommand = \App\Db::getInstance()->createCommand();
		$subQuery = (new \App\Db\Query())->select(['fieldid'])->from('vtiger_def_org_field');
		$query = (new \App\Db\Query())->select(['tabid', 'fieldid'])->from('vtiger_field')->where(['not in', 'vtiger_field.fieldid', $subQuery]);
		$data = $query->createCommand()->queryAllByGroup(2);
		foreach ($data as $tabId => $fieldIds) {
			foreach ($fieldIds as $fieldId) {
				$isExists = (new \App\Db\Query())->from('vtiger_def_org_field')->where(['tabid' => $tabId, 'fieldid' => $fieldId])->exists();
				if (!$isExists) {
					$dbCommand->insert('vtiger_def_org_field', [
						'tabid' => $tabId,
						'fieldid' => $fieldId,
						'visible' => 0,
						'readonly' => 0,
					])->execute();
				}
			}
		}
		\App\Log::trace('Exiting ' . __METHOD__);
	}

	/**
	 * Add missing entries in vtiger_profile2field
	 */
	public static function profileField()
	{
		\App\Log::trace('Entering ' . __METHOD__);
		$profileIds = \vtlib\Profile::getAllIds();
		$dbCommand = \App\Db::getInstance()->createCommand();
		$subQuery = (new \App\Db\Query())->select(['fieldid'])->from('vtiger_profile2field');
		$query = (new \App\Db\Query())->select(['tabid', 'fieldid'])->from('vtiger_field')->where(['not in', 'vtiger_field.fieldid', $subQuery]);
		$data = $query->createCommand()->queryAllByGroup(2);
		foreach ($data as $tabId => $fieldIds) {
			foreach ($fieldIds as $fieldId) {
				foreach ($profileIds as $profileId) {
					$isExists = (new \App\Db\Query())->from('vtiger_profile2field')->where(['profileid' => $profileId, 'fieldid' => $fieldId])->exists();
					if (!$isExists) {
						$dbCommand->insert('vtiger_profile2field', ['profileid' => $profileId, 'tabid' => $tabId, 'fieldid' => $fieldId, 'visible' => 0, 'readonly' => 0])->execute();
					}
				}
			}
		}
		\App\Log::trace('Exiting ' . __METHOD__);
	}

	/**
	 * Add missing entries in vtiger_profile2utility
	 */
	public static function baseModuleTools()
	{
		$missing = $curentProfile2utility = [];
		foreach ((new \App\Db\Query())->from('vtiger_profile2utility')->all() as $row) {
			$curentProfile2utility[$row['profileid']][$row['tabid']][$row['activityid']] = $row['permission'];
		}
		$profileIds = \vtlib\Profile::getAllIds();
		$moduleIds = array_keys(\vtlib\Functions::getAllModules());
		$baseActionIds = array_map('App\Module::getActionId', \Settings_ModuleManager_Module_Model::$baseModuleTools);
		$exceptions = \Settings_ModuleManager_Module_Model::getBaseModuleToolsExceptions();
		foreach ($profileIds as $profileId) {
			foreach ($moduleIds as $moduleId) {
				foreach ($baseActionIds as $actionId) {
					if (!isset($curentProfile2utility[$profileId][$moduleId][$actionId])) {
						$missing[] = ['profileid' => $profileId, 'tabid' => $moduleId, 'activityid' => $actionId];
					}
				}
			}
		}
		$dbCommand = \App\Db::getInstance()->createCommand();
		foreach ($missing as $row) {
			if (isset($exceptions[$row['tabid']]['allowed'])) {
				if (!isset($exceptions[$row['tabid']]['allowed'][$row['activityid']])) {
					continue;
				}
			} elseif (isset($exceptions[$row['tabid']]['notAllowed']) && ($exceptions[$row['tabid']]['notAllowed'] === false || isset($exceptions[$row['tabid']]['notAllowed'][$row['activityid']]))) {
				continue;
			}
			$dbCommand->insert('vtiger_profile2utility', ['profileid' => $row['profileid'], 'tabid' => $row['tabid'], 'activityid' => $row['activityid'], 'permission' => 1,])->execute();
		}
		RecalculateSharingRules();
	}
}
