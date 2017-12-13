<?php

/**
 * Settings users module model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_Users_Module_Model extends Settings_Vtiger_Module_Model
{

	public static function getInstance($name = 'Settings:Vtiger')
	{
		$instance = new self();
		return $instance;
	}

	public static function getConfig($type)
	{
		$db = PearDatabase::getInstance();

		$result = $db->pquery('SELECT * FROM yetiforce_auth WHERE type = ?;', [$type]);
		if ($db->num_rows($result) == 0) {
			return [];
		}
		$config = [];
		$numRowsCount = $db->num_rows($result);
		for ($i = 0; $i < $numRowsCount; ++$i) {
			$param = $db->query_result_raw($result, $i, 'param');
			$value = $db->query_result_raw($result, $i, 'value');
			if ($param == 'users') {
				$config[$param] = $value == '' ? [] : explode(',', $value);
			} else {
				$config[$param] = $value;
			}
		}
		return $config;
	}

	public static function setConfig($param)
	{
		$value = $param['val'];
		if (is_array($value)) {
			$value = implode(',', $value);
		}
		App\Db::getInstance()->createCommand()
			->update('yetiforce_auth', ['value' => $value], ['type' => $param['type'], 'param' => $param['param']])
			->execute();
		return true;
	}

	/**
	 * Save configuration about switching between users
	 * @param array $data
	 */
	public function saveSwitchUsers($data)
	{
		$map = $switchUsers = $switchUsersRaw = [];
		if (!empty($data) && count($data)) {
			foreach ($data as $row) {
				$switchUsersRaw [$row['user']] = $row['access'];
				$accessList = [];
				if (count($row['access'])) {
					foreach ($row['access'] as $access) {
						$accessList = array_merge($accessList, $this->getUserID($access));
					}
				}
				foreach ($this->getUserID($row['user']) as $user) {
					$map[$user] = array_merge(isset($map[$user]) ? $map[$user] : [], $accessList);
				}
			}
		}
		foreach ($map as $user => $accessList) {
			$usersForSort = [];
			$usersForSort[$user] = $this->getUserName($user);
			foreach ($accessList as $ID) {
				$usersForSort[$ID] = $this->getUserName($ID);
			}
			asort($usersForSort);
			$switchUsers[$user] = $usersForSort;
		}
		$content = '<?php' . PHP_EOL .
				'$switchUsersRaw = ' . \vtlib\Functions::varExportMin($switchUsersRaw) . ';' . PHP_EOL .
				'$switchUsers = ' . \vtlib\Functions::varExportMin($switchUsers) . ';' . PHP_EOL;
		file_put_contents('user_privileges/switchUsers.php', $content);
	}

	/**
	 * Returns the list of users to switch
	 * @return array
	 */
	public function getSwitchUsers()
	{
		require('user_privileges/switchUsers.php');
		return $switchUsersRaw;
	}

	public static $usersID = [];

	public function getUserID($data)
	{
		if (key_exists($data, self::$usersID)) {
			return self::$usersID[$data];
		}
		if (substr($data, 0, 1) === 'H') {
			$return = (new \App\Db\Query())->select(['userid'])
					->from('vtiger_user2role')
					->innerJoin('vtiger_users', 'vtiger_users.id = vtiger_user2role.userid')
					->where(['and', ['roleid' => $data], ['<>', 'status', 'Inactive']])
					->column();
		} else {
			$return = [(int) $data];
		}
		self::$usersID[$data] = $return;
		return $return;
	}

	public static $users = [];

	public function getUserName($id)
	{
		if (key_exists($id, self::$users)) {
			return self::$users[$id];
		}
		$entityData = \App\Module::getEntityInfo('Users');
		$user = new Users();
		$currentUser = $user->retrieveCurrentUserInfoFromFile($id);
		$colums = [];
		foreach ($entityData['fieldnameArr'] as &$fieldname) {
			$colums[] = $currentUser->column_fields[$fieldname];
		}
		$name = implode(' ', $colums);
		self::$users[$id] = $name;
		return $name;
	}

	/**
	 * Refresh list users to switch
	 */
	public function refreshSwitchUsers()
	{
		$switchUsersRaw = $this->getSwitchUsers();
		$map = $switchUsers = [];
		if (count($switchUsersRaw)) {
			foreach ($switchUsersRaw as $key => $row) {
				$accessList = [];
				if (count($row)) {
					foreach ($row as $access) {
						$accessList = array_merge($accessList, $this->getUserID($access));
					}
				}
				foreach ($this->getUserID($key) as $user) {
					$map[$user] = array_merge(isset($map[$user]) ? $map[$user] : [], $accessList);
				}
			}
		}
		foreach ($map as $user => $accessList) {
			$usersForSort = [];
			$usersForSort [$user] = $this->getUserName($user);
			foreach ($accessList as $ID) {
				$usersForSort[$ID] = $this->getUserName($ID);
			}
			asort($usersForSort);
			$switchUsers [$user] = $usersForSort;
		}
		$content = '<?php' . PHP_EOL .
				'$switchUsersRaw = ' . \vtlib\Functions::varExportMin($switchUsersRaw) . ';' . PHP_EOL .
				'$switchUsers = ' . \vtlib\Functions::varExportMin($switchUsers) . ';' . PHP_EOL;
		file_put_contents('user_privileges/switchUsers.php', $content);
	}

	/**
	 * Function to get locks
	 * @return array
	 */
	public function getLocks()
	{
		include('user_privileges/locks.php');
		return $locksRaw;
	}

	/**
	 * Return type of locks
	 * @return string[]
	 */
	public function getLocksTypes()
	{
		return [
			'copy' => 'LBL_LOCK_COPY',
			'cut' => 'LBL_LOCK_CUT',
			'paste' => 'LBL_LOCK_PASTE',
			'contextmenu' => 'LBL_LOCK_RIGHT_MENU',
			'selectstart' => 'LBL_LOCK_SELECT_TEXT',
			'drag' => 'LBL_LOCK_DRAG'
		];
	}

	/**
	 * Function to save locks for users
	 * @param array $data
	 */
	public function saveLocks($data)
	{
		$oldValues = $this->getLocks();
		$map = $toSave = [];
		if (!empty($data)) {
			foreach ($data as $row) {
				if (empty($row['locks'])) {
					continue;
				}
				if (key_exists($row['user'], $toSave)) {
					$toSave[$row['user']] = array_merge($toSave[$row['user']], $row['locks']);
				} else {
					$toSave[$row['user']] = $row['locks'];
				}
			}
			foreach ($toSave as $user => &$locks) {
				$locks = array_unique($locks);
				foreach ($this->getUserID($user) as $userID) {
					$map[$userID] = array_merge(isset($map[$userID]) ? $map[$userID] : [], $locks);
				}
			}
		}
		$content = '<?php' . PHP_EOL .
				'$locksRaw = ' . \vtlib\Functions::varExportMin($toSave) . ';' . PHP_EOL .
				'$locks = ' . \vtlib\Functions::varExportMin($map) . ';';
		file_put_contents('user_privileges/locks.php', $content);
		$newValues = $this->getLocks();
		$difference = vtlib\Functions::arrayDiffAssocRecursive($newValues, $oldValues);
		if (!empty($difference)) {
			foreach ($difference as $id => $locks) {
				if (strpos($id, 'H') === false) {
					$name = Users_Record_Model::getInstanceById($id, 'Users');
				} else {
					$name = Settings_Roles_Record_Model::getInstanceById($id);
				}
				$name = $name->getName();
				if ($oldValues[$id]) {
					$prev[$name] = implode(',', $oldValues[$id]);
				} else {
					$prev[$name] = '';
				}
				$post[$name] = implode(',', $newValues[$id]);
				Settings_Vtiger_Tracker_Model::addDetail($prev, $post);
			}
		}

		$difference = vtlib\Functions::arrayDiffAssocRecursive($oldValues, $newValues);
		if (!empty($difference)) {
			Settings_Vtiger_Tracker_Model::changeType('delete');
			foreach ($difference as $id => $locks) {
				if (strpos($id, 'H') === false) {
					$name = Users_Record_Model::getInstanceById($id, 'Users');
				} else {
					$name = Settings_Roles_Record_Model::getInstanceById($id);
				}
				$name = $name->getName();
				$prev[$name] = implode(',', $oldValues[$id]);
				if ($newValues[$id]) {
					$post[$name] = implode(',', $newValues[$id]);
				} else {
					$post[$name] = '';
				}
				Settings_Vtiger_Tracker_Model::addDetail($prev, $post);
			}
		}
	}
}
