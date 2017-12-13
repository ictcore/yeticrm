<?php

/**
 * PaymentsIn ListView model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class PaymentsIn_ListView_Model extends Vtiger_ListView_Model
{

	public function getAdvancedLinks()
	{
		$advancedLinks = parent::getAdvancedLinks();

		$advancedLinks[] = array(
			'linktype' => 'LISTVIEW',
			'linklabel' => 'LBL_PAYMENTS_IMPORT',
			'linkurl' => 'index.php?module=PaymentsIn&view=PaymentsImport',
			'linkicon' => ''
		);

		return $advancedLinks;
	}
}
