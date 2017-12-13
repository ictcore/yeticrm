<?php

/**
 * OSSEmployees record model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class OSSEmployees_Record_Model extends Vtiger_Record_Model
{

	/**
	 * Function returns the details of Employees Hierarchy
	 * @return <Array>
	 */
	public function getEmployeeHierarchy()
	{
		$focus = CRMEntity::getInstance($this->getModuleName());
		$hierarchy = $focus->getEmployeeHierarchy($this->getId());
		foreach ($hierarchy['entries'] as $employeeId => $employeeInfo) {
			preg_match('/<a href="+/', $employeeInfo[0], $matches);
			if ($matches !== null) {
				preg_match('/[.\s]+/', $employeeInfo[0], $dashes);
				preg_match("/<a(.*)>(.*)<\/a>/i", $employeeInfo[0], $name);

				$recordModel = Vtiger_Record_Model::getCleanInstance('OSSEmployees');
				$recordModel->setId($employeeId);
				$hierarchy['entries'][$employeeId][0] = $dashes[0] . "<a href=" . $recordModel->getDetailViewUrl() . ">" . $name[2] . "</a>";
			}
		}
		return $hierarchy;
	}
}
