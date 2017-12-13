<?php

/**
 * Switch Users Action Class
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Users_SwitchUsers_Action extends Vtiger_Action_Controller
{

	/**
	 * Function checks permissions
	 * @param \App\Request $request
	 * @throws \Exception\NoPermitted
	 */
	public function checkPermission(\App\Request $request)
	{
		$userId = $request->get('id');
		require('user_privileges/switchUsers.php');
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$baseUserId = $currentUserModel->getRealId();
		if (!key_exists($baseUserId, $switchUsers) || !key_exists($userId, $switchUsers[$baseUserId])) {
			$db = \App\Db::getInstance('log');
			$db->createCommand()->insert('l_#__switch_users', [
				'baseid' => $baseUserId,
				'destid' => $userId,
				'busername' => $currentUserModel->getName(),
				'dusername' => '',
				'date' => date('Y-m-d H:i:s'),
				'ip' => \App\RequestUtil::getRemoteIP(),
				'agent' => $_SERVER['HTTP_USER_AGENT'],
				'status' => 'Failed login - No permission',
			])->execute();
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}
	}

	/**
	 * Function proccess
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$baseUserId = $currentUserModel->getId();
		$userId = $request->get('id');
		$user = new Users();
		$currentUser = $user->retrieveCurrentUserInfoFromFile($userId);
		$name = $currentUserModel->getName();
		$userName = $currentUser->column_fields['user_name'];
		App\Session::set('authenticated_user_id', $userId);
		App\Session::set('user_name', $userName);
		App\Session::set('full_user_name', $name);

		$status = 'Switched';
		if (empty(App\Session::get('baseUserId'))) {
			App\Session::set('baseUserId', $baseUserId);
			$status = 'Signed in';
		} elseif ($userId === App\Session::get('baseUserId')) {
			$baseUserId = $userId;
			App\Session::set('baseUserId', '');
			$status = 'Signed out';
		} else {
			$baseUserId = App\Session::get('baseUserId');
		}

		$db = \App\Db::getInstance('log');
		$db->createCommand()->insert('l_#__switch_users', [
			'baseid' => $baseUserId,
			'destid' => $userId,
			'busername' => $currentUserModel->getName(),
			'dusername' => $name,
			'date' => date('Y-m-d H:i:s'),
			'ip' => \App\RequestUtil::getRemoteIP(),
			'agent' => $_SERVER['HTTP_USER_AGENT'],
			'status' => $status,
		])->execute();

		header('Location: index.php');
	}
}
