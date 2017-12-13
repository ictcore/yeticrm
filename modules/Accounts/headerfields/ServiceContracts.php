<?php

/**
 * ServiceContracts Header Field Class
 * @package YetiForce.HeaderField
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Accounts_ServiceContracts_HeaderField
{

	public function process(Vtiger_DetailView_Model $viewModel)
	{
		$row = (new \App\Db\Query())->select('MAX(due_date) AS date,count(*) AS total')->from('vtiger_servicecontracts')
			->innerJoin('vtiger_crmentity', 'vtiger_servicecontracts.servicecontractsid = vtiger_crmentity.crmid')
			->where(['deleted' => 0, 'sc_related_to' => $viewModel->getRecord()->getId(), 'contract_status' => 'In Progress'])
			->one();
		if (!empty($row['date']) || !empty($row['total'])) {
			return [
				'class' => 'btn-success',
				'title' => \App\Language::translate('LBL_NUMBER_OF_ACTIVE_CONTRACTS', 'Accounts') . ': ' . $row['total'],
				'badge' => DateTimeField::convertToUserFormat($row['date']),
				'action' => 'Vtiger_Detail_Js.getInstance().getTabContainer().find(\'[data-reference="ServiceContracts"]:not(.hide)\').trigger("click");'
			];
		}
		return false;
	}
}
