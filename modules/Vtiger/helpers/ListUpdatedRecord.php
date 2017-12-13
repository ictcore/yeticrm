<?php

/**
 * ListUpdatedRecord class
 * @package YetiForce.Helper
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class ListUpdatedRecord
{

	public static function getListRecord($module = NULL, array $columnList, $limit)
	{
		$moduleList = [];
		$recordList = [];
		if (!$module) {
			$moduleList = (new \App\Db\Query())->select('name')
					->from('vtiger_tab')
					->where(['isentitytype' => 1])
					->andWhere(['<>', 'presence', 1])
					->createCommand()->queryColumn();
		} else {
			$moduleList[] = $module;
		}
		if (!in_array('smownerid', $columnList)) {
			$columnList[] = 'smownerid';
		}
		if ($limit == 'all') {
			$limit = 200;
		}
		$select = array_values($columnList);
		$select['smownerid'] = \App\Module::getSqlForNameInDisplayFormat('Users');
		$dataReader = (new \App\Db\Query())->select($select)->from('vtiger_crmentity')
				->leftJoin('u_#__crmentity_label', 'u_#__crmentity_label.crmid = vtiger_crmentity.crmid')
				->innerJoin('vtiger_users', 'vtiger_users.id = vtiger_crmentity.smownerid')
				->where(['was_read' => 0, 'vtiger_crmentity.deleted' => 0, 'setype' => $moduleList])
				->limit($limit)
				->createCommand()->query();
		while ($row = $dataReader->read()) {
			$row['setype'] = \App\Language::translate($row['setype'], $row['setype']);
			$recordList [] = $row;
		}
		if (empty($recordList)) {
			return false;
		}
		return $recordList;
	}
}
