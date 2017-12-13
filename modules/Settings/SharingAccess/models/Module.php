<?php
/**
 * Settings SharingAccess module model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */

/**
 * Sharng Access Vtiger Module Model Class
 */
class Settings_SharingAccess_Module_Model extends Vtiger_Module_Model
{

	/**
	 * Constants for mapping module's Sharing Access permissions editable
	 */
	const EDITABLE = 0;
	const READONLY = 1;
	const HIDDEN = 2;

	/**
	 * Constants used for mapping module's Sharing Access Permission
	 */
	const SHARING_ACCESS_READ_ONLY = 0;
	const SHARING_ACCESS_READ_CREATE = 1;
	const SHARING_ACCESS_PUBLIC = 2;
	const SHARING_ACCESS_PRIVATE = 3;

	public function getPermissionValue()
	{
		return $this->get('permission');
	}

	/**
	 * Function checks if the sharing access for the module is enabled or not
	 * @return boolean
	 */
	public function isSharingEditable()
	{
		return ($this->get('editstatus') == self::EDITABLE);
	}

	/**
	 * Function checks if the module is Private
	 * @return Boolean
	 */
	public function isPrivate()
	{
		return ((int) $this->get('permission') == self::SHARING_ACCESS_PRIVATE);
	}

	/**
	 * Function checks if the module is Public
	 * @return Boolean
	 */
	public function isPublic()
	{
		return ($this->get('editstatus') == self::SHARING_ACCESS_PUBLIC);
	}

	public function getRulesListUrl()
	{
		return '?module=SharingAccess&parent=Settings&view=IndexAjax&mode=showRules&for_module=' . $this->getId();
	}

	public function getCreateRuleUrl()
	{
		return '?module=SharingAccess&parent=Settings&view=IndexAjax&mode=editRule&for_module=' . $this->getId();
	}

	public function getSharingRules()
	{
		return Settings_SharingAccess_Rule_Model::getAllByModule($this);
	}

	public function getRules()
	{
		return Settings_SharingAccess_Rule_Model::getAllByModule($this);
	}

	/**
	 * Save permission
	 */
	public function save()
	{
		App\Db::getInstance()->createCommand()
			->update('vtiger_def_org_share', ['permission' => $this->get('permission')], ['tabid' => $this->getId()])
			->execute();
	}

	/**
	 * Static Function to get the instance of Vtiger Module Model for the given id or name
	 * @param mixed id or name of the module
	 */
	public static function getInstance($value)
	{
		$instance = false;
		$query = (new App\Db\Query())->from('vtiger_def_org_share')
			->innerJoin('vtiger_tab', 'vtiger_tab.tabid = vtiger_def_org_share.tabid');
		if (vtlib\Utils::isNumber($value)) {
			$query->where(['vtiger_tab.tabid' => $value]);
		} else {
			$query->where(['name' => $value]);
		}
		$row = $query->one();
		if ($row) {
			$instance = new self();
			$instance->initialize($row);
			$instance->set('permission', $row['permission']);
			$instance->set('editstatus', $row['editstatus']);
		}
		return $instance;
	}

	/**
	 * Static Function to get the instance of Vtiger Module Model for all the modules
	 * @return <Array> - List of Vtiger Module Model or sub class instances
	 */
	public static function getAll($editable = false, $restrictedModulesList = [], $isEntityType = false)
	{
		$moduleModels = [];
		$query = (new \App\Db\Query())->from('vtiger_def_org_share')
			->innerJoin('vtiger_tab', 'vtiger_tab.tabid = vtiger_def_org_share.tabid')
			->where(['vtiger_tab.presence' => [0, 2]]);
		if ($editable) {
			$query->andWhere(['editstatus' => self::EDITABLE]);
		}
		$query->orderBy(['vtiger_def_org_share.tabid' => SORT_ASC]);
		$dataReader = $query->createCommand()->query();
		while ($row = $dataReader->read()) {
			$instance = new Settings_SharingAccess_Module_Model();
			$instance->initialize($row);
			$instance->set('permission', $row['permission']);
			$instance->set('editstatus', $row['editstatus']);
			$moduleModels[$row['tabid']] = $instance;
		}
		return $moduleModels;
	}

	/**
	 * Static Function to get the instance of Vtiger Module Model for all the modules
	 * @return <Array> - List of Vtiger Module Model or sub class instances
	 */
	public static function getDependentModules()
	{
		$dependentModulesList = [];
		$dependentModulesList['Accounts'] = ['HelpDesk'];

		return $dependentModulesList;
	}

	/**
	 * Function recalculate the sharing rules
	 */
	public static function recalculateSharingRules()
	{
		$phpMaxExecutionTime = AppConfig::main('php_max_execution_time');
		set_time_limit($phpMaxExecutionTime);
		require_once('modules/Users/CreateUserPrivilegeFile.php');
		$userIds = (new App\Db\Query())->select(['id'])
			->from('vtiger_users')
			->where(['deleted' => 0])
			->column();
		foreach ($userIds as $id) {
			createUserSharingPrivilegesfile($id);
		}
	}
}
