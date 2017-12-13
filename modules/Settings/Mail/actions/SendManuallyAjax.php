<?php

/**
 * Sen mail manually action model class
 * @package YetiForce.Settings.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Adrian Koń <a.kon@yetiforce.com>
 */
class Settings_Mail_SendManuallyAjax_Action extends Settings_Vtiger_IndexAjax_View
{

	/**
	 * Checking permission 
	 * @param \App\Request $request
	 * @throws \Exception\NoPermittedForAdmin
	 */
	public function checkPermission(\App\Request $request)
	{
		$currentUserModel = \App\User::getCurrentUserModel();
		if (!$currentUserModel->isAdmin()) {
			throw new \Exception\NoPermittedForAdmin('LBL_PERMISSION_DENIED');
		}
	}

	/**
	 * Process
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$record = $request->get('id');
		$db = \App\Db::getInstance('admin');
		$row = (new \App\Db\Query())->from('s_#__mail_queue')
				->where(['id' => $record])->one($db);
		$status = \App\Mailer::sendByRowQueue($row);
		if ($status) {
			$db->createCommand()->delete('s_#__mail_queue', ['id' => $row['id']])->execute();
		} else {
			$db->createCommand()->update('s_#__mail_queue', ['status' => 2], ['id' => $row['id']])->execute();
		}
		$response = new Vtiger_Response();
		$response->setResult(['success' => true, 'message' => \App\Language::translate('LBL_SEND_EMAIL_MANUALLY', $request->getModule(false))]);
		$response->emit();
	}

	/**
	 * Validate Request
	 * @param \App\Request $request
	 */
	public function validateRequest(\App\Request $request)
	{
		$request->validateReadAccess();
	}
}
