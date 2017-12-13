<?php
namespace Api\Portal\Users;

/**
 * Users Login action class
 * @package YetiForce.WebserviceAction
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Login extends \Api\Core\BaseAction
{

	/** @var string[] Allowed request methods */
	public $allowedMethod = ['POST'];

	/**
	 * Check permission to method
	 * @return boolean
	 */
	public function checkPermission()
	{
		return true;
	}

	/**
	 * Check permission to module
	 * @throws \Api\Core\Exception
	 */
	public function checkPermissionToModule()
	{
		return true;
	}

	/**
	 * Post method
	 * @return array
	 */
	public function post()
	{
		$db = \App\Db::getInstance('webservice');
		$row = (new \App\Db\Query())
				->from('w_#__portal_user')
				->where(['user_name' => $this->controller->request->get('userName'), 'status' => 1])
				->limit(1)->one($db);
		if (!$row) {
			throw new \Api\Core\Exception('Invalid data access', 401);
		}
		if ($row['password_t'] !== $this->controller->request->get('password')) {
			throw new \Api\Core\Exception('Invalid user password', 401);
		}
		$db->createCommand()
			->update('w_#__portal_user', [
				'login_time' => date('Y-m-d H:i:s')
				], ['id' => $row['id']])
			->execute();
		$row = $this->updateSession($row);
		$userModel = \App\User::getUserModel($row['user_id']);
		return [
			'token' => $row['token'],
			'name' => \App\Record::getLabel($row['crmid']),
			'parentName' => \App\Record::getLabel(\App\Record::getParentRecord($row['crmid'])),
			'lastLoginTime' => $row['login_time'],
			'lastLogoutTime' => $row['logout_time'],
			'language' => $row['language'],
			'type' => $row['type'],
			'logged' => true,
			'preferences' => [
				'activity_view' => $userModel->getDetail('activity_view'),
				'hour_format' => $userModel->getDetail('hour_format'),
				'start_hour' => $userModel->getDetail('start_hour'),
				'date_format' => $userModel->getDetail('date_format'),
				'date_format_js' => \App\Fields\DateTime::currentUserJSDateFormat($userModel->getDetail('date_format')),
				'dayoftheweek' => $userModel->getDetail('dayoftheweek'),
				'time_zone' => $userModel->getDetail('time_zone'),
				'currency_id' => $userModel->getDetail('currency_id'),
				'currency_grouping_pattern' => $userModel->getDetail('currency_grouping_pattern'),
				'currency_decimal_separator' => $userModel->getDetail('currency_decimal_separator'),
				'currency_grouping_separator' => $userModel->getDetail('currency_grouping_separator'),
				'currency_symbol_placement' => $userModel->getDetail('currency_symbol_placement'),
				'no_of_currency_decimals' => $userModel->getDetail('no_of_currency_decimals'),
				'truncate_trailing_zeros' => $userModel->getDetail('truncate_trailing_zeros'),
				'end_hour' => $userModel->getDetail('end_hour'),
				'currency_name' => $userModel->getDetail('currency_name'),
				'currency_code' => $userModel->getDetail('currency_code'),
				'currency_symbol' => $userModel->getDetail('currency_symbol'),
				'conv_rate' => $userModel->getDetail('conv_rate')
			]
		];
	}

	/**
	 * Update session
	 * @param array $row
	 * @return array
	 */
	public function updateSession($row)
	{
		$db = \App\Db::getInstance('webservice');
		$token = md5(time() . rand());
		$params = $this->controller->request->getArray('params');
		$language = !empty($params['language']) ? $params['language'] : (empty($row['language']) ? $this->getLanguage() : $row['language']);
		$db->createCommand()->insert("w_#__portal_session", [
			'id' => $token,
			'user_id' => $row['id'],
			'created' => date('Y-m-d H:i:s'),
			'changed' => date('Y-m-d H:i:s'),
			'language' => $language,
			'params' => \App\Json::encode($params)
		])->execute();
		$row['token'] = $token;
		$row['language'] = $language;
		$db->createCommand()->delete("w_#__portal_session", ['<', 'changed', date('Y-m-d H:i:s', strtotime('-1 day'))])->execute();
		return $row;
	}
}
