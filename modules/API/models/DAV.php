<?php

/**
 * DAV model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class API_DAV_Model
{

	public $davUsers = [];

	public static function runCronCardDav()
	{
		$dav = new self();
		\App\Log::trace(__METHOD__ . ' | Start CardDAV Sync ');
		$crmUsers = Users_Record_Model::getAll();
		$davUsers = self::getAllUser(1);
		foreach ($crmUsers as $key => $user) {
			if (array_key_exists($key, $davUsers)) {
				$user->set('david', $davUsers[$key]['david']);
				$user->set('addressbooksid', $davUsers[$key]['addressbooksid']);
				$dav->davUsers[$key] = $user;
				\App\Log::trace(__METHOD__ . ' | User is active ' . $user->getName());
			} else { // User is inactive
				\App\Log::info(__METHOD__ . ' | User is inactive ' . $user->getName());
			}
		}
		$cardDav = new API_CardDAV_Model();
		$cardDav->davUsers = $dav->davUsers;
		$cardDav->cardDavCrm2Dav();
		$cardDav->cardDav2Crm();
		\App\Log::trace(__METHOD__ . ' | End CardDAV Sync ');
	}

	public static function runCronCalDav()
	{
		$dav = new self();
		\App\Log::trace(__METHOD__ . ' | Start CalDAV Sync ');
		$crmUsers = Users_Record_Model::getAll();
		$davUsers = self::getAllUser(2);
		foreach ($crmUsers as $key => $user) {
			if (array_key_exists($key, $davUsers)) {
				$user->set('david', $davUsers[$key]['david']);
				$user->set('calendarsid', $davUsers[$key]['calendarsid']);
				$dav->davUsers[$key] = $user;
				\App\Log::trace(__METHOD__ . ' | User is active ' . $user->getName());
			} else { // User is inactive
				\App\Log::info(__METHOD__ . ' | User is inactive ' . $user->getName());
			}
		}
		$cardDav = new API_CalDAV_Model();
		$cardDav->davUsers = $dav->davUsers;
		$cardDav->calDavCrm2Dav();
		$cardDav->calDav2Crm();
		\App\Log::trace(__METHOD__ . ' | End CalDAV Sync ');
	}

	public static function getAllUser($type = 0)
	{
		$db = new App\Db\Query();
		if ($type == 0) {
			$db->select([
					'dav_users.*',
					'addressbooksid' => 'dav_addressbooks.id',
					'calendarsid' => 'dav_calendars.id',
					'dav_principals.email',
					'dav_principals.displayname',
					'vtiger_users.status',
					'userid' => 'vtiger_users.id',
					'vtiger_users.user_name'
				])->from('dav_users')
				->innerJoin('vtiger_users', 'vtiger_users.id = dav_users.userid')
				->innerJoin('dav_principals', 'dav_principals.userid = dav_users.userid')
				->leftJoin('dav_addressbooks', 'dav_addressbooks.principaluri = dav_principals.uri')
				->leftJoin('dav_calendars', 'dav_calendars.principaluri = dav_principals.uri');
		} elseif ($type == 1) {
			$db->select([
					'david' => 'dav_users.id',
					'userid' => 'dav_users.userid',
					'addressbooksid' => 'dav_addressbooks.id'
				])->from('dav_users')
				->innerJoin('vtiger_users', 'vtiger_users.id = dav_users.userid')
				->innerJoin('dav_principals', 'dav_principals.userid = dav_users.userid')
				->innerJoin('dav_addressbooks', 'dav_addressbooks.principaluri = dav_principals.uri')
				->where(['vtiger_users.status' => 'Active']);
		} elseif ($type == 2) {
			$db->select([
					'david' => 'dav_users.id',
					'userid' => 'dav_users.userid',
					'calendarsid' => 'dav_calendars.id'
				])->from('dav_users')
				->innerJoin('vtiger_users', 'vtiger_users.id = dav_users.userid')
				->innerJoin('dav_principals', 'dav_principals.userid = dav_users.userid')
				->innerJoin('dav_calendars', 'dav_calendars.principaluri = dav_principals.uri')
				->where(['vtiger_users.status' => 'Active']);
		}
		$dataReader = $db->createCommand()->query();
		$users = [];
		while ($row = $dataReader->read()) {
			$users[$row['userid']] = $row;
		}
		return $users;
	}
}
