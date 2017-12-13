<?php
namespace App;

/**
 * Privilege Util basic class
 * @package YetiForce.App
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class PrivilegeUtil
{

	/** Function to get parent record owner
	 * @param $tabid -- tabid :: Type integer
	 * @param $parModId -- parent module id :: Type integer
	 * @param $recordId -- record id :: Type integer
	 * @returns $parentRecOwner -- parentRecOwner:: Type integer
	 */
	public static function getParentRecordOwner($tabid, $parModId, $recordId)
	{
		\App\Log::trace("Entering getParentRecordOwner($tabid,$parModId,$recordId) method ...");
		$parentRecOwner = [];
		$parentTabName = \vtlib\Functions::getModuleName($parModId);
		$relTabName = \vtlib\Functions::getModuleName($tabid);
		$fn_name = 'get' . $relTabName . 'Related' . $parentTabName;
		$entId = static::$fn_name($recordId);
		if ($entId != '') {
			$recordMetaData = \vtlib\Functions::getCRMRecordMetadata($entId);
			if ($recordMetaData) {
				$ownerId = $recordMetaData['smownerid'];
				$type = \App\Fields\Owner::getType($ownerId);
				$parentRecOwner[$type] = $ownerId;
			}
		}
		\App\Log::trace('Exiting getParentRecordOwner method ...');
		return $parentRecOwner;
	}

	/**
	 * Function return related account with ticket
	 * @param int $recordId
	 * @return int
	 */
	private static function getHelpDeskRelatedAccounts($recordId)
	{
		return (new Db\Query)->select(['parent_id'])->from('vtiger_troubletickets')->innerJoin('vtiger_crmentity', 'vtiger_troubletickets.parent_id = vtiger_crmentity.crmid')->where(['ticketid' => $recordId, 'vtiger_crmentity.setype' => 'Accounts'])->scalar();
	}

	protected static $datashareRelatedCache = false;

	/**
	 * Function to get data share related modules
	 * @return array
	 */
	public static function getDatashareRelatedModules()
	{
		if (static::$datashareRelatedCache === false) {
			$relModSharArr = [];
			$dataReader = (new \App\Db\Query())->from('vtiger_datashare_relatedmodules')->createCommand()->query();
			while ($row = $dataReader->read()) {
				$relTabId = $row['relatedto_tabid'];
				if (isset($relModSharArr[$relTabId]) && is_array($relModSharArr[$relTabId])) {
					$temArr = $relModSharArr[$relTabId];
					$temArr[] = $row['tabid'];
				} else {
					$temArr = [];
					$temArr[] = $row['tabid'];
				}
				$relModSharArr[$relTabId] = $temArr;
			}
			static::$datashareRelatedCache = $relModSharArr;
		}
		return static::$datashareRelatedCache;
	}

	protected static $defaultSharingActionCache = false;

	/**
	 * This Function returns the Default Organisation Sharing Action Array for all modules
	 * @return array
	 */
	public static function getAllDefaultSharingAction()
	{
		if (static::$defaultSharingActionCache === false) {
			\App\Log::trace('getAllDefaultSharingAction');
			static::$defaultSharingActionCache = (new \App\Db\Query())->select(['tabid', 'permission'])->from('vtiger_def_org_share')->createCommand()->queryAllByGroup(0);
		}
		return static::$defaultSharingActionCache;
	}

	protected static $usersByRoleCache = [];

	/**
	 * Function to get the vtiger_role related user ids
	 * @param int $roleId RoleId :: Type varchar
	 * @return array $users -- Role Related User Array in the following format:
	 */
	public static function getUsersByRole($roleId)
	{
		if (isset(static::$usersByRoleCache[$roleId])) {
			return static::$usersByRoleCache[$roleId];
		}
		$users = (new \App\Db\Query())->select(['userid'])->from('vtiger_user2role')->where(['roleid' => $roleId])->column();
		static::$usersByRoleCache[$roleId] = $users;
		return $users;
	}

	/**
	 * Function to get the users names by role
	 * @param int $roleId
	 * @return array $users
	 */
	public static function getUsersNameByRole($roleId)
	{
		if (\App\Cache::has('getUsersNameByRole', $roleId)) {
			return \App\Cache::get('getUsersNameByRole', $roleId);
		}
		$users = static::getUsersByRole($roleId);
		$roleRelatedUsers = [];
		if ($users) {
			foreach ($users as $userId) {
				$roleRelatedUsers[$userId] = Fields\Owner::getUserLabel($userId);
			}
		}
		\App\Cache::save('getUsersNameByRole', $roleId, $roleRelatedUsers);
		return $users;
	}

	protected static $roleByUsersCache = [];

	/**
	 * Function to get the role related user ids
	 * @param int $userId RoleId :: Type varchar
	 */
	public static function getRoleByUsers($userId)
	{
		if (isset(static::$roleByUsersCache[$userId])) {
			return static::$roleByUsersCache[$userId];
		}
		$roleId = (new \App\Db\Query())->select('roleid')
			->from('vtiger_user2role')->where(['userid' => $userId])
			->scalar();
		static::$roleByUsersCache[$userId] = $roleId;
		return $roleId;
	}

	/**
	 * Function to get user groups
	 * @param int $userId
	 * @return array - groupId's
	 */
	public static function getUserGroups($userId)
	{
		if (Cache::has('UserGroups', $userId)) {
			return Cache::get('UserGroups', $userId);
		}
		$groupIds = (new \App\Db\Query())->select('groupid')->from('vtiger_users2group')->where(['userid' => $userId])->column();
		Cache::save('UserGroups', $userId, $groupIds);
		return $groupIds;
	}

	/**
	 * Function to get role groups
	 * @param string $roleId
	 * @return array
	 */
	public static function getRoleGroups($roleId)
	{
		if (Cache::has('RoleGroups', $roleId)) {
			return Cache::get('RoleGroups', $roleId);
		}
		$groupIds = (new \App\Db\Query())->select('groupid')->from('vtiger_group2role')->where(['roleid' => $roleId])->column();
		Cache::save('RoleGroups', $roleId, $groupIds);
		return $groupIds;
	}

	/**
	 * Function to get role subordinates groups
	 * @param string $roleId
	 * @return array
	 */
	public static function getRoleSubordinatesGroups($roleId)
	{
		if (Cache::has('RoleSubordinatesGroups', $roleId)) {
			return Cache::get('RoleSubordinatesGroups', $roleId);
		}

		$roles = self::getParentRole($roleId);
		$roles [] = $roleId;
		$groupIds = (new \App\Db\Query())->select(['groupid'])->from('vtiger_group2rs')->where(['roleandsubid' => $roles])->column();
		Cache::save('RoleSubordinatesGroups', $roleId, $groupIds);
		return $groupIds;
	}

	/**
	 * This function is to retreive the vtiger_profiles associated with the  the specified role
	 * @param string $roleId
	 * @return array
	 */
	public static function getProfilesByRole($roleId)
	{
		$profiles = Cache::staticGet('getProfilesByRole', $roleId);
		if ($profiles) {
			return $profiles;
		}
		$profiles = (new \App\Db\Query())
			->select('profileid')
			->from('vtiger_role2profile')
			->where(['roleid' => $roleId])
			->column();
		Cache::staticSave('getProfilesByRole', $roleId, $profiles);
		return $profiles;
	}

	/**
	 *  This function is to retreive the vtiger_profiles associated with the  the specified user
	 * @param int $userId
	 * @return array
	 */
	public static function getProfilesByUser($userId)
	{
		$roleId = \App\PrivilegeUtil::getRoleByUsers($userId);
		return static::getProfilesByRole($roleId);
	}

	const MEMBER_TYPE_USERS = 'Users';
	const MEMBER_TYPE_GROUPS = 'Groups';
	const MEMBER_TYPE_ROLES = 'Roles';
	const MEMBER_TYPE_ROLE_AND_SUBORDINATES = 'RoleAndSubordinates';

	protected static $membersCache = false;

	/**
	 * Function to get all members
	 * @return array
	 */
	public static function getMembers()
	{
		if (static::$membersCache === false) {
			$members = [];
			$owner = new \App\Fields\Owner();
			foreach ($owner->initUsers() as $id => $user) {
				$members[static::MEMBER_TYPE_USERS][static::MEMBER_TYPE_USERS . ':' . $id] = ['name' => $user['fullName'], 'id' => $id, 'type' => static::MEMBER_TYPE_USERS];
			}
			foreach ($owner->getGroups(false) as $id => $groupName) {
				$members[static::MEMBER_TYPE_GROUPS][static::MEMBER_TYPE_GROUPS . ':' . $id] = ['name' => $groupName, 'id' => $id, 'type' => static::MEMBER_TYPE_GROUPS];
			}
			foreach (\Settings_Roles_Record_Model::getAll() as $id => $roleModel) {
				$members[static::MEMBER_TYPE_ROLES][static::MEMBER_TYPE_ROLES . ':' . $id] = ['name' => $roleModel->getName(), 'id' => $id, 'type' => static::MEMBER_TYPE_ROLES];
				$members[static::MEMBER_TYPE_ROLE_AND_SUBORDINATES][static::MEMBER_TYPE_ROLE_AND_SUBORDINATES . ':' . $id] = ['name' => $roleModel->getName(), 'id' => $id, 'type' => static::MEMBER_TYPE_ROLE_AND_SUBORDINATES];
			}
			static::$membersCache = $members;
		}
		return static::$membersCache;
	}

	protected static $usersByMemberCache = [];

	/**
	 * Get list of users based on members, eg. Users:2, Roles:H2
	 * @param string $member
	 * @return array
	 */
	public static function getUserByMember($member)
	{
		if (isset(static::$usersByMemberCache[$member])) {
			return static::$usersByMemberCache[$member];
		}
		list($type, $id) = explode(':', $member);
		$users = [];
		switch ($type) {
			case 'Users' :
				$users[] = (int) $id;
				break;
			case 'Groups' :
				$users = array_merge($users, static::getUsersByGroup($id));
				break;
			case 'Roles' :
				$users = array_merge($users, static::getUsersByRole($id));
				break;
			case 'RoleAndSubordinates' :
				$users = array_merge($users, static::getUsersByRoleAndSubordinate($id));
				break;
		}
		return static::$usersByMemberCache[$member] = array_unique($users);
	}

	protected static $usersByGroupCache = [];

	/**
	 * Get list of users based on group id
	 * @param int $groupId
	 * @param int $i
	 * @return array
	 */
	public static function getUsersByGroup($groupId, $i = 0)
	{
		if (isset(static::$usersByGroupCache[$roleId])) {
			return static::$usersByGroupCache[$roleId];
		}
		$users = [];
		$adb = \PearDatabase::getInstance();
		//Retreiving from the user2grouptable
		$users = (new \App\Db\Query())->select(['userid'])->from('vtiger_users2group')->where(['groupid' => $groupId])->column();
		//Retreiving from the vtiger_group2role
		$dataReader = (new \App\Db\Query())->select(['roleid'])->from('vtiger_group2role')->where(['groupid' => $groupId])->createCommand()->query();
		while ($roleId = $dataReader->readColumn(0)) {
			$roleUsers = static::getUsersByRole($roleId);
			$users = array_merge($users, $roleUsers);
		}
		//Retreiving from the vtiger_group2rs
		$dataReader = (new \App\Db\Query())->select(['roleandsubid'])->from('vtiger_group2rs')->where(['groupid' => $groupId])->createCommand()->query();
		while ($roleId = $dataReader->readColumn(0)) {
			$roleUsers = static::getUsersByRoleAndSubordinate($roleId);
			$users = array_merge($users, $roleUsers);
		}
		if ($i < 5) {
			//Retreving from group2group
			$dataReader = (new \App\Db\Query())->select(['containsgroupid'])->from('vtiger_group2grouprel')->where(['groupid' => $groupId])->createCommand()->query();
			while ($roleId = $dataReader->readColumn(0)) {
				$roleUsers = static::getUsersByGroup($containsGroupId, $i++);
				$users = array_merge($users, $roleUsers);
			}
		} else {
			\App\Log::warning('Exceeded the recursive limit, a loop might have been created. Group ID:' . $groupId);
		}
		return static::$usersByGroupCache[$groupId] = array_unique($users);
	}

	protected static $usersBySubordinateCache = [];

	/**
	 * Function to get the roles and subordinate users
	 * @param int $roleId
	 * @return array
	 */
	public static function getUsersByRoleAndSubordinate($roleId)
	{
		if (isset(static::$usersBySubordinateCache[$roleId])) {
			return static::$usersBySubordinateCache[$roleId];
		}
		$roleInfo = static::getRoleDetail($roleId);
		$parentRole = $roleInfo['parentrole'];
		$users = (new \App\Db\Query())->select(['vtiger_user2role.userid'])->from('vtiger_user2role')->innerJoin('vtiger_role', 'vtiger_user2role.roleid = vtiger_role.roleid')
				->where(['like', 'vtiger_role.parentrole', "$parentRole%", false])->column();
		static::$usersBySubordinateCache[$roleId] = $users;
		return $users;
	}

	protected static $roleInfoCache = [];

	/**
	 * Function to get the vtiger_role information of the specified vtiger_role
	 * @param $roleid -- RoleId :: Type varchar
	 * @returns $roleInfoArray-- RoleInfoArray in the following format:
	 */
	public static function getRoleDetail($roleId)
	{
		if (Cache::has('RoleDetail', $roleId)) {
			return Cache::get('RoleDetail', $roleId);
		}
		$row = (new Db\Query())->from('vtiger_role')->where(['roleid' => $roleId])->one();
		if ($row) {
			$parentRoleArr = explode('::', $row['parentrole']);
			array_pop($parentRoleArr);
			$row['parentRoles'] = $parentRoleArr;
			$immediateParent = array_pop($parentRoleArr);
			$row['immediateParent'] = $immediateParent;
		}
		Cache::save('RoleDetail', $roleId, $row);
		return $row;
	}

	/**
	 * Function to get the role name
	 * @param int $roleId
	 * @return string
	 */
	public static function getRoleName($roleId)
	{
		$roleInfo = static::getRoleDetail($roleId);
		return $roleInfo['rolename'];
	}

	/**
	 * To retreive the parent vtiger_role of the specified vtiger_role
	 * @param $roleid -- The Role Id:: Type varchar
	 * @return  parent vtiger_role array in the following format:
	 */
	public static function getParentRole($roleId)
	{
		$roleInfo = static::getRoleDetail($roleId);
		return $roleInfo['parentRoles'];
	}

	/**
	 * To retreive the subordinate vtiger_roles of the specified parent vtiger_role
	 * @param int $roleId
	 * @return array
	 */
	public static function getRoleSubordinates($roleId)
	{
		if (\App\Cache::has('getRoleSubordinates', $roleId)) {
			return \App\Cache::get('getRoleSubordinates', $roleId);
		}
		$roleDetails = static::getRoleDetail($roleId);
		$roleSubordinates = (new \App\Db\Query())
			->select(['roleid'])
			->from('vtiger_role')
			->where(['like', 'parentrole', $roleDetails['parentrole'] . '::%', false])
			->column();

		\App\Cache::save('getRoleSubordinates', $roleId, $roleSubordinates, \App\Cache::LONG);
		return $roleSubordinates;
	}

	/**
	 * Function to get the Profile Tab Permissions for the specified vtiger_profileid
	 * @param int $profileid
	 * @return int[]
	 */
	public static function getProfileTabsPermission($profileid)
	{
		Log::trace("Entering getProfileTabsPermission(" . $profileid . ") method ...");
		if (Cache::has('getProfileTabsPermission', $profileid)) {
			return Cache::get('getProfileTabsPermission', $profileid);
		}
		$profileData = (new Db\Query())->select(['tabid', 'permissions'])->from('vtiger_profile2tab')->where(['profileid' => $profileid])->createCommand()->queryAllByGroup(0);
		$profileData = array_map('intval', $profileData);
		Cache::save('getProfileTabsPermission', $profileid, $profileData);
		Log::trace("Exiting getProfileTabsPermission method ...");
		return $profileData;
	}

	/**
	 * Function to get the Profile Global Information for the specified vtiger_profileid
	 * @param int $profileid
	 * @return int[]
	 */
	public static function getProfileGlobalPermission($profileid)
	{
		if (Cache::has('getProfileGlobalPermission', $profileid)) {
			return Cache::get('getProfileGlobalPermission', $profileid);
		}
		$profileData = (new Db\Query())->select(['globalactionid', 'globalactionpermission'])->from('vtiger_profile2globalpermissions')->where(['profileid' => $profileid])->createCommand()->queryAllByGroup(0);
		$profileData = array_map('intval', $profileData);
		Cache::save('getProfileGlobalPermission', $profileid, $profileData);
		return $profileData;
	}

	/**
	 * To retreive the global permission of the specifed user from the various vtiger_profiles associated with the user
	 * @param int $userId
	 * @return int[]
	 */
	public static function getCombinedUserGlobalPermissions($userId)
	{
		if (Cache::staticHas('getCombinedUserGlobalPermissions', $userId)) {
			return Cache::staticGet('getCombinedUserGlobalPermissions', $userId);
		}
		$userGlobalPerrArr = [];
		$profArr = static::getProfilesByUser($userId);
		$profileId = array_shift($profArr);
		if ($profileId) {
			$userGlobalPerrArr = static::getProfileGlobalPermission($profileId);
			foreach ($profArr as $profileId) {
				$tempUserGlobalPerrArr = static::getProfileGlobalPermission($profileId);
				foreach ($userGlobalPerrArr as $globalActionId => $globalActionPermission) {
					if ($globalActionPermission === 1) {
						$permission = $tempUserGlobalPerrArr[$globalActionId];
						if ($permission === 0) {
							$userGlobalPerrArr[$globalActionId] = $permission;
						}
					}
				}
			}
		}
		Cache::staticSave('getCombinedUserGlobalPermissions', $userId, $userGlobalPerrArr);
		return $userGlobalPerrArr;
	}

	/**
	 * To retreive the vtiger_tab permissions of the specifed user from the various vtiger_profiles associated with the user
	 * @param int $userId
	 * @return array
	 */
	public static function getCombinedUserTabsPermissions($userId)
	{
		if (Cache::staticHas('getCombinedUserTabsPermissions', $userId)) {
			return Cache::staticGet('getCombinedUserTabsPermissions', $userId);
		}
		$profArr = static::getProfilesByUser($userId);
		$profileId = array_shift($profArr);
		if ($profileId) {
			$userTabPerrArr = static::getProfileTabsPermission($profileId);
			foreach ($profArr as $profileId) {
				$tempUserTabPerrArr = static::getProfileTabsPermission($profileId);
				foreach ($userTabPerrArr as $tabId => $tabPermission) {
					if ($tabPermission === 1) {
						$permission = $tempUserTabPerrArr[$tabId];
						if ($permission === 0) {
							$userTabPerrArr[$tabId] = $permission;
						}
					}
				}
			}
		}
		$homeTabid = \App\Module::getModuleId('Home');
		if (!isset($userTabPerrArr[$homeTabid])) {
			$userTabPerrArr[$homeTabid] = 0;
		}
		Cache::staticSave('getCombinedUserTabsPermissions', $userId, $userTabPerrArr);
		return $userTabPerrArr;
	}

	protected static $dataShareStructure = [
		'role2role' => ['vtiger_datashare_role2role', 'to_roleid'],
		'role2rs' => ['vtiger_datashare_role2rs', 'to_roleandsubid'],
		'role2group' => ['vtiger_datashare_role2group', 'to_groupid'],
		'role2user' => ['vtiger_datashare_role2us', 'to_userid'],
		'rs2role' => ['vtiger_datashare_rs2role', 'to_roleid'],
		'rs2rs' => ['vtiger_datashare_rs2rs', 'to_roleandsubid'],
		'rs2group' => ['vtiger_datashare_rs2grp', 'to_groupid'],
		'rs2user' => ['vtiger_datashare_rs2us', 'to_userid'],
		'group2role' => ['vtiger_datashare_grp2role', 'to_roleid'],
		'group2rs' => ['vtiger_datashare_grp2rs', 'to_roleandsubid'],
		'group2user' => ['vtiger_datashare_grp2us', 'to_userid'],
		'group2group' => ['vtiger_datashare_grp2grp', 'to_groupid'],
		'user2user' => ['vtiger_datashare_us2us', 'to_userid'],
		'user2group' => ['vtiger_datashare_us2grp', 'to_groupid'],
		'user2role' => ['vtiger_datashare_us2role', 'to_roleid'],
		'user2rs' => ['vtiger_datashare_us2rs', 'to_roleandsubid'],
	];

	/**
	 * Get data share
	 * @param int $tabId
	 * @param int $roleId
	 * @return array
	 */
	public static function getDatashare($type, $tabId, $data)
	{
		$cacheKey = "$type|$tabId|" . (is_array($data) ? implode(',', $data) : $data);
		if (\App\Cache::staticHas('getDatashare', $cacheKey)) {
			return \App\Cache::staticGet('getDatashare', $cacheKey);
		}
		$structure = self::$dataShareStructure[$type];
		$query = (new \App\Db\Query())->select([$structure[0] . '.*'])->from($structure[0])
			->innerJoin('vtiger_datashare_module_rel', "$structure[0].shareid = vtiger_datashare_module_rel.shareid")
			->where(['vtiger_datashare_module_rel.tabid' => $tabId]);
		if ($data) {
			$query->andWhere([$structure[1] => $data]);
		}
		$rows = $query->all();
		\App\Cache::staticSave('getDatashare', $cacheKey, $rows);
		return $rows;
	}

	/**
	 * Gives an array which contains the information for what all roles, groups and user data is to be shared with the spcified user for the specified module
	 * @param string $module module name
	 * @param int $userid user id
	 * @param array $defOrgShare default organization sharing permission array
	 * @param string $currentUserRoles roleid
	 * @param string $parentRoles parent roles
	 * @param int $currentUserGroups user id
	 * @return array array which contains the id of roles,group and users data shared with specifed user for the specified module
	 */
	public static function getUserModuleSharingObjects($module, $userid, $defOrgShare, $currentUserRoles, $parentRoles, $currentUserGroups)
	{
		$modTabId = \App\Module::getModuleId($module);
		$modShareWritePermission = $modShareReadPermission = ['ROLE' => [], 'GROUP' => []];
		$modDefOrgShare = null;
		if (isset($defOrgShare[$modTabId])) {
			$modDefOrgShare = $defOrgShare[$modTabId];
		}
		$shareIdMembers = [];
		//If Sharing of leads is Private
		if ($modDefOrgShare === 3 || $modDefOrgShare === 0) {
			$roleWritePer = $roleWritePer = $rsWritePer = $grpReadPer = $grpWritePer = $roleReadPer = [];
			//Retreiving from vtiger_role to vtiger_role
			$rows = static::getDatashare('role2role', $modTabId, $currentUserRoles);
			foreach ($rows as &$row) {
				$shareRoleId = $row['share_roleid'];
				$shareIdRoleMembers = [];
				$shareIdRoles = [];
				$shareIdRoles[] = $shareRoleId;
				$shareIdRoleMembers['ROLE'] = $shareIdRoles;
				$shareIdMembers[$row['shareid']] = $shareIdRoleMembers;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($roleReadPer[$shareRoleId])) {
							$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					}
					if (!isset($role_write_per[$shareRoleId])) {
						$roleWritePer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($roleReadPer[$shareRoleId])) {
						$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
					}
				}
			}
			//Retreiving from role to rs
			$parRoleList = [];
			if (is_array($parentRoles)) {
				foreach ($parentRoles as $par_role_id) {
					array_push($parRoleList, $par_role_id);
				}
			}
			array_push($parRoleList, $currentUserRoles);
			$rows = static::getDatashare('role2rs', $modTabId, $parRoleList);
			foreach ($rows as &$row) {
				$shareRoleId = $row['share_roleid'];
				$shareIdRoleMembers = [];
				$shareIdRoles = [];
				$shareIdRoles[] = $shareRoleId;
				$shareIdRoleMembers['ROLE'] = $shareIdRoles;
				$shareIdMembers[$row['shareid']] = $shareIdRoleMembers;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($roleReadPer[$shareRoleId])) {
							$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					}
					if (!isset($role_write_per[$shareRoleId])) {
						$roleWritePer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($roleReadPer[$shareRoleId])) {
						$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
					}
				}
			}
			//Get roles from Role2Grp
			$groupList = $currentUserGroups;
			if (empty($groupList)) {
				$groupList = [0];
			}
			if ($groupList) {
				$rows = static::getDatashare('role2group', $modTabId, $groupList);
				foreach ($rows as $row) {
					$shareRoleId = $row['share_roleid'];
					$shareIdRoleMembers = [];
					$shareIdRoles = [];
					$shareIdRoles[] = $shareRoleId;
					$shareIdRoleMembers['ROLE'] = $shareIdRoles;
					$shareIdMembers[$row['shareid']] = $shareIdRoleMembers;
					if ($row['permission'] === 1) {
						if ($modDefOrgShare === 3) {
							if (!isset($roleReadPer[$shareRoleId])) {
								$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
							}
						}
						if (!isset($role_write_per[$shareRoleId])) {
							$roleWritePer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
						if (!isset($roleReadPer[$shareRoleId])) {
							$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					}
				}
			}
			//Get roles from Role2Us
			if (!empty($userid)) {
				$rows = static::getDatashare('role2user', $modTabId, $userid);
				foreach ($rows as &$row) {
					$shareRoleId = $row['share_roleid'];
					$shareIdRoleMembers = [];
					$shareIdRoles = [];
					$shareIdRoles[] = $shareRoleId;
					$shareIdRoleMembers['ROLE'] = $shareIdRoles;
					$shareIdMembers[$row['shareid']] = $shareIdRoleMembers;
					if ($row['permission'] === 1) {
						if ($modDefOrgShare === 3) {
							if (!isset($roleReadPer[$shareRoleId])) {
								$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
							}
						}
						if (!isset($role_write_per[$shareRoleId])) {
							$roleWritePer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
						if (!isset($roleReadPer[$shareRoleId])) {
							$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					}
				}
			}
			//Retreiving from rs to vtiger_role
			$rows = static::getDatashare('rs2role', $modTabId, $currentUserRoles);
			foreach ($rows as &$row) {
				$shareRoleId = $row['share_roleid'];
				$shareRoleIds = getRoleAndSubordinatesRoleIds($row['share_roleandsubid']);
				$shareIdRoleMembers = [];
				$shareIdRoles = [];
				foreach ($shareRoleIds as &$shareRoleId) {
					$shareIdRoles[] = $shareRoleId;
					if ($row['permission'] === 1) {
						if ($modDefOrgShare === 3) {
							if (!isset($roleReadPer[$shareRoleId])) {
								$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
							}
						}
						if (!isset($role_write_per[$shareRoleId])) {
							$roleWritePer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
						if (!isset($roleReadPer[$shareRoleId])) {
							$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					}
				}
				$shareIdRoleMembers['ROLE'] = $shareIdRoles;
				$shareIdMembers[$row['shareid']] = $shareIdRoleMembers;
			}
			//Retreiving from rs to rs
			$rows = static::getDatashare('rs2rs', $modTabId, $parRoleList);
			foreach ($rows as &$row) {
				$share_rsid = $row['share_roleandsubid'];
				$shareRoleIds = getRoleAndSubordinatesRoleIds($share_rsid);
				$shareIdRoleMembers = [];
				$shareIdRoles = [];
				foreach ($shareRoleIds as &$shareRoleId) {
					$shareIdRoles[] = $shareRoleId;
					if ($row['permission'] === 1) {
						if ($modDefOrgShare === 3) {
							if (!isset($roleReadPer[$shareRoleId])) {
								$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
							}
						}
						if (!isset($role_write_per[$shareRoleId])) {
							$roleWritePer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
						if (!isset($roleReadPer[$shareRoleId])) {
							$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					}
				}
				$shareIdRoleMembers['ROLE'] = $shareIdRoles;
				$shareIdMembers[$row['shareid']] = $shareIdRoleMembers;
			}
			//Get roles from Rs2Grp 
			$rows = static::getDatashare('rs2group', $modTabId, $groupList);
			foreach ($rows as &$row) {
				$shareRoleIds = getRoleAndSubordinatesRoleIds($share_rsid);
				$shareIdRoleMembers = [];
				$shareIdRoles = [];
				foreach ($shareRoleIds as &$shareRoleId) {
					$shareIdRoles[] = $shareRoleId;
					if ($row['permission'] === 1) {
						if ($modDefOrgShare === 3) {
							if (!isset($roleReadPer[$shareRoleId])) {
								$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
							}
						}
						if (!isset($role_write_per[$shareRoleId])) {
							$roleWritePer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
						if (!isset($roleReadPer[$shareRoleId])) {
							$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					}
				}
				$shareIdRoleMembers['ROLE'] = $shareIdRoles;
				$shareIdMembers[$row['shareid']] = $shareIdRoleMembers;
			}
			//Get roles from Rs2Us 
			$rows = static::getDatashare('rs2user', $modTabId, $userid);
			foreach ($rows as &$row) {
				$share_rsid = $row['share_roleandsubid'];
				$shareRoleIds = getRoleAndSubordinatesRoleIds($share_rsid);
				$shareIdRoleMembers = [];
				$shareIdRoles = [];
				foreach ($shareRoleIds as &$shareRoleId) {
					$shareIdRoles[] = $shareRoleId;
					if ($row['permission'] === 1) {
						if ($modDefOrgShare === 3) {
							if (!isset($roleReadPer[$shareRoleId])) {
								$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
							}
						}
						if (!isset($role_write_per[$shareRoleId])) {
							$roleWritePer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
						if (!isset($roleReadPer[$shareRoleId])) {
							$roleReadPer[$shareRoleId] = \App\PrivilegeUtil::getUsersByRole($shareRoleId);
						}
					}
				}
				$shareIdRoleMembers['ROLE'] = $shareIdRoles;
				$shareIdMembers[$row['shareid']] = $shareIdRoleMembers;
			}
			$modShareReadPermission['ROLE'] = $roleReadPer;
			$modShareWritePermission['ROLE'] = $roleWritePer;

			//Retreiving from the grp2role sharing 
			$rows = static::getDatashare('group2role', $modTabId, $currentUserRoles);
			foreach ($rows as $row) {
				$shareGrpId = $row['share_groupid'];
				$shareIdGrpMembers = [];
				$shareIdGrps = [];
				$shareIdGrps[] = $shareGrpId;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($grpReadPer[$shareGrpId])) {
							$focusGrpUsers = new \GetGroupUsers();
							$focusGrpUsers->getAllUsersInGroup($shareGrpId);
							$grpReadPer[$shareGrpId] = $focusGrpUsers->group_users;
							foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
								if (!isset($grpReadPer[$subgrpid])) {
									$grpReadPer[$subgrpid] = $subgrpusers;
								}
								if (!in_array($subgrpid, $shareIdGrps)) {
									$shareIdGrps[] = $subgrpid;
								}
							}
						}
					}
					if (!isset($grpWritePer[$shareGrpId])) {
						$focusGrpUsers = new \GetGroupUsers();
						$focusGrpUsers->getAllUsersInGroup($shareGrpId);
						$grpWritePer[$shareGrpId] = $focusGrpUsers->group_users;
						foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
							if (!isset($grpWritePer[$subgrpid])) {
								$grpWritePer[$subgrpid] = $subgrpusers;
							}
							if (!in_array($subgrpid, $shareIdGrps)) {
								$shareIdGrps[] = $subgrpid;
							}
						}
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($grpReadPer[$shareGrpId])) {
						$focusGrpUsers = new \GetGroupUsers();
						$focusGrpUsers->getAllUsersInGroup($shareGrpId);
						$grpReadPer[$shareGrpId] = $focusGrpUsers->group_users;
						foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
							if (!isset($grpReadPer[$subgrpid])) {
								$grpReadPer[$subgrpid] = $subgrpusers;
							}
							if (!in_array($subgrpid, $shareIdGrps)) {
								$shareIdGrps[] = $subgrpid;
							}
						}
					}
				}
				$shareIdGrpMembers['GROUP'] = $shareIdGrps;
				$shareIdMembers[$row['shareid']] = $shareIdGrpMembers;
			}

			//Retreiving from the grp2rs sharing 
			$rows = static::getDatashare('group2rs', $modTabId, $parRoleList);
			foreach ($rows as $row) {
				$shareGrpId = $row['share_groupid'];
				$shareIdGrpMembers = [];
				$shareIdGrps = [];
				$shareIdGrps[] = $shareGrpId;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($grpReadPer[$shareGrpId])) {
							$focusGrpUsers = new \GetGroupUsers();
							$focusGrpUsers->getAllUsersInGroup($shareGrpId);
							$grpReadPer[$shareGrpId] = $focusGrpUsers->group_users;
							foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
								if (!isset($grpReadPer[$subgrpid])) {
									$grpReadPer[$subgrpid] = $subgrpusers;
								}
								if (!in_array($subgrpid, $shareIdGrps)) {
									$shareIdGrps[] = $subgrpid;
								}
							}
						}
					}
					if (!isset($grpWritePer[$shareGrpId])) {
						$focusGrpUsers = new \GetGroupUsers();
						$focusGrpUsers->getAllUsersInGroup($shareGrpId);
						$grpWritePer[$shareGrpId] = $focusGrpUsers->group_users;
						foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
							if (!isset($grpWritePer[$subgrpid])) {
								$grpWritePer[$subgrpid] = $subgrpusers;
							}
							if (!in_array($subgrpid, $shareIdGrps)) {
								$shareIdGrps[] = $subgrpid;
							}
						}
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($grpReadPer[$shareGrpId])) {
						$focusGrpUsers = new \GetGroupUsers();
						$focusGrpUsers->getAllUsersInGroup($shareGrpId);
						$grpReadPer[$shareGrpId] = $focusGrpUsers->group_users;
						foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
							if (!isset($grpReadPer[$subgrpid])) {
								$grpReadPer[$subgrpid] = $subgrpusers;
							}
							if (!in_array($subgrpid, $shareIdGrps)) {
								$shareIdGrps[] = $subgrpid;
							}
						}
					}
				}
				$shareIdGrpMembers['GROUP'] = $shareIdGrps;
				$shareIdMembers[$row['shareid']] = $shareIdGrpMembers;
			}

			//Retreiving from the grp2us sharing 
			$rows = static::getDatashare('group2user', $modTabId, $userid);
			foreach ($rows as $row) {
				$shareGrpId = $row['share_groupid'];
				$shareIdGrpMembers = [];
				$shareIdGrps = [];
				$shareIdGrps[] = $shareGrpId;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($grpReadPer[$shareGrpId])) {
							$focusGrpUsers = new \GetGroupUsers();
							$focusGrpUsers->getAllUsersInGroup($shareGrpId);
							$grpReadPer[$shareGrpId] = $focusGrpUsers->group_users;
							foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
								if (!isset($grpReadPer[$subgrpid])) {
									$grpReadPer[$subgrpid] = $subgrpusers;
								}
								if (!in_array($subgrpid, $shareIdGrps)) {
									$shareIdGrps[] = $subgrpid;
								}
							}
						}
					}
					if (!isset($grpWritePer[$shareGrpId])) {
						$focusGrpUsers = new \GetGroupUsers();
						$focusGrpUsers->getAllUsersInGroup($shareGrpId);
						$grpWritePer[$shareGrpId] = $focusGrpUsers->group_users;
						foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
							if (!isset($grpWritePer[$subgrpid])) {
								$grpWritePer[$subgrpid] = $subgrpusers;
							}
							if (!in_array($subgrpid, $shareIdGrps)) {
								$shareIdGrps[] = $subgrpid;
							}
						}
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($grpReadPer[$shareGrpId])) {
						$focusGrpUsers = new \GetGroupUsers();
						$focusGrpUsers->getAllUsersInGroup($shareGrpId);
						$grpReadPer[$shareGrpId] = $focusGrpUsers->group_users;
						foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
							if (!isset($grpReadPer[$subgrpid])) {
								$grpReadPer[$subgrpid] = $subgrpusers;
							}
							if (!in_array($subgrpid, $shareIdGrps)) {
								$shareIdGrps[] = $subgrpid;
							}
						}
					}
				}
				$shareIdGrpMembers['GROUP'] = $shareIdGrps;
				$shareIdMembers[$row['shareid']] = $shareIdGrpMembers;
			}

			//Retreiving from the grp2grp sharing 
			$rows = static::getDatashare('group2group', $modTabId, $groupList);
			foreach ($rows as $row) {
				$shareGrpId = $row['share_groupid'];
				$shareIdGrpMembers = [];
				$shareIdGrps = [];
				$shareIdGrps[] = $shareGrpId;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($grpReadPer[$shareGrpId])) {
							$focusGrpUsers = new \GetGroupUsers();
							$focusGrpUsers->getAllUsersInGroup($shareGrpId);
							$grpReadPer[$shareGrpId] = $focusGrpUsers->group_users;
							foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
								if (!isset($grpReadPer[$subgrpid])) {
									$grpReadPer[$subgrpid] = $subgrpusers;
								}
								if (!in_array($subgrpid, $shareIdGrps)) {
									$shareIdGrps[] = $subgrpid;
								}
							}
						}
					}
					if (!isset($grpWritePer[$shareGrpId])) {
						$focusGrpUsers = new \GetGroupUsers();
						$focusGrpUsers->getAllUsersInGroup($shareGrpId);
						$grpWritePer[$shareGrpId] = $focusGrpUsers->group_users;
						foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
							if (!isset($grpWritePer[$subgrpid])) {
								$grpWritePer[$subgrpid] = $subgrpusers;
							}
							if (!in_array($subgrpid, $shareIdGrps)) {
								$shareIdGrps[] = $subgrpid;
							}
						}
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($grpReadPer[$shareGrpId])) {
						$focusGrpUsers = new \GetGroupUsers();
						$focusGrpUsers->getAllUsersInGroup($shareGrpId);
						$grpReadPer[$shareGrpId] = $focusGrpUsers->group_users;
						foreach ($focusGrpUsers->group_subgroups as $subgrpid => $subgrpusers) {
							if (!isset($grpReadPer[$subgrpid])) {
								$grpReadPer[$subgrpid] = $subgrpusers;
							}
							if (!in_array($subgrpid, $shareIdGrps)) {
								$shareIdGrps[] = $subgrpid;
							}
						}
					}
				}
				$shareIdGrpMembers['GROUP'] = $shareIdGrps;
				$shareIdMembers[$row['shareid']] = $shareIdGrpMembers;
			}

			//Get roles from Us2Us 
			$rows = static::getDatashare('user2user', $modTabId, $userid);
			foreach ($rows as $row) {
				$shareUserId = $row['share_userid'];
				$shareIdGrpMembers = [];
				$shareIdUsers = [];
				$shareIdUsers[] = $shareUserId;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($grpReadPer[$shareUserId])) {
							$grpReadPer[$shareUserId] = [$shareUserId];
						}
					}
					if (!isset($grpWritePer[$shareUserId])) {
						$grpWritePer[$shareUserId] = [$shareUserId];
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($grpReadPer[$shareUserId])) {
						$grpReadPer[$shareUserId] = [$shareUserId];
					}
				}
				$shareIdGrpMembers['GROUP'] = $shareIdUsers;
				$shareIdMembers[$row['shareid']] = $shareIdGrpMembers;
			}
			//Get roles from Us2Grp 
			$rows = static::getDatashare('user2group', $modTabId, $groupList);
			foreach ($rows as $row) {
				$shareUserId = $row['share_userid'];
				$shareIdGrpMembers = [];
				$shareIdUsers = [];
				$shareIdUsers[] = $shareUserId;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($grpReadPer[$shareUserId])) {
							$grpReadPer[$shareUserId] = [$shareUserId];
						}
					}
					if (!isset($grpWritePer[$shareUserId])) {
						$grpWritePer[$shareUserId] = [$shareUserId];
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($grpReadPer[$shareUserId])) {
						$grpReadPer[$shareUserId] = [$shareUserId];
					}
				}
				$shareIdGrpMembers['GROUP'] = $shareIdUsers;
				$shareIdMembers[$row['shareid']] = $shareIdGrpMembers;
			}
			//Get roles from Us2role 
			$rows = static::getDatashare('user2role', $modTabId, $currentUserRoles);
			foreach ($rows as $row) {
				$shareUserId = $row['share_userid'];
				$shareIdGrpMembers = [];
				$shareIdUsers = [];
				$shareIdUsers[] = $shareUserId;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($grpReadPer[$shareUserId])) {
							$grpReadPer[$shareUserId] = [$shareUserId];
						}
					}
					if (!isset($grpWritePer[$shareUserId])) {
						$grpWritePer[$shareUserId] = [$shareUserId];
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($grpReadPer[$shareUserId])) {
						$grpReadPer[$shareUserId] = [$shareUserId];
					}
				}
				$shareIdGrpMembers['GROUP'] = $shareIdUsers;
				$shareIdMembers[$row['shareid']] = $shareIdGrpMembers;
			}

			//Get roles from Us2rs 
			$rows = static::getDatashare('user2rs', $modTabId, $parRoleList);
			foreach ($rows as $row) {
				$shareUserId = $row['share_userid'];
				$shareIdGrpMembers = [];
				$shareIdUsers = [];
				$shareIdUsers[] = $shareUserId;
				if ($row['permission'] === 1) {
					if ($modDefOrgShare === 3) {
						if (!isset($grpReadPer[$shareUserId])) {
							$grpReadPer[$shareUserId] = [$shareUserId];
						}
					}
					if (!isset($grpWritePer[$shareUserId])) {
						$grpWritePer[$shareUserId] = [$shareUserId];
					}
				} elseif ($row['permission'] === 0 && $modDefOrgShare === 3) {
					if (!isset($grpReadPer[$shareUserId])) {
						$grpReadPer[$shareUserId] = [$shareUserId];
					}
				}
				$shareIdGrpMembers['GROUP'] = $shareIdUsers;
				$shareIdMembers[$row['shareid']] = $shareIdGrpMembers;
			}
			$modShareReadPermission['GROUP'] = $grpReadPer;
			$modShareWritePermission['GROUP'] = $grpWritePer;
		}
		return [
			'read' => $modShareReadPermission,
			'write' => $modShareWritePermission,
			'sharingrules' => $shareIdMembers,
		];
	}
}
