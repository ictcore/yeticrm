<?php

/**
 * action class
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class PaymentsIn_GenerateRecords_Action extends Vtiger_Action_Controller
{

	public function checkPermission(\App\Request $request)
	{
		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if (!$currentUserPriviligesModel->hasModuleActionPermission($moduleName, 'Save')) {
			throw new \Exception\AppException(\App\Language::translate($moduleName) . ' ' . \App\Language::translate('LBL_NOT_ACCESSIBLE'));
		}
	}

	public function process(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$bag = false;
		$paymentsIn = $request->get('paymentsIn');
		foreach ($paymentsIn as $fields) {
			$ossPaymentsIn = CRMEntity::getInstance($moduleName);
			$ossPaymentsIn->column_fields['paymentsname'] = 'Name';
			$ossPaymentsIn->column_fields['paymentsvalue'] = $fields['amount'];
			$ossPaymentsIn->column_fields['paymentscurrency'] = $fields['third_letter_currency_code'];
			$ossPaymentsIn->column_fields['paymentstitle'] = $fields['details']['title'];
			$ossPaymentsIn->column_fields['bank_account'] = $fields['details']['contAccount'];
			$saved = $ossPaymentsIn->save('PaymentsIn');
			if ($saved === false) {
				$bag = true;
			}
		}

		if ($bag) {
			$result = ['success' => true, 'return' => \App\Language::translate('MSG_SAVE_OK', $moduleName)];
		} else {
			$result = ['success' => false, 'return' => \App\Language::translate('MSG_SAVE_ERROR', $moduleName)];
		}

		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
}
