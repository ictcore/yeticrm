<?php

/**
 * Record Model
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
class Settings_WebserviceApps_Record_Model extends Settings_Vtiger_Record_Model
{

	public function getId()
	{
		return $this->get('id');
	}

	public function getName()
	{
		return $this->get('name');
	}

	public static function getInstanceById($recordId)
	{
		if (empty($recordId)) {
			return false;
		}
		$model = new self();
		$db = PearDatabase::getInstance();
		$result = $db->pquery('SELECT * FROM w_yf_servers WHERE id = ? LIMIT 1', [$recordId]);
		$data = $db->getRow($result);
		$model->setData($data);
		return $model;
	}
}
