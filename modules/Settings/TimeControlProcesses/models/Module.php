<?php

/**
 * Settings TimeControlProcesses module model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_TimeControlProcesses_Module_Model extends \App\Base
{

	public static function getCleanInstance()
	{
		$instance = new self();
		return $instance;
	}

	public function getConfigInstance($type = false)
	{

		\App\Log::trace('Start ' . __METHOD__ . " | Type: " . print_r($type, true));
		$query = (new App\Db\Query())->from('yetiforce_proc_tc');
		if ($type) {
			$query->where(['type' => $type]);
		}
		$dataReader = $query->createCommand()->query();
		$output = [];
		while ($row = $dataReader->read()) {
			$output[$row['type']][$row['param']] = $row['value'];
		}
		$this->setData($output);
		\App\Log::trace('End ' . __METHOD__);
		return $this;
	}

	public function setConfig($param)
	{
		\App\Log::trace('Start ' . __METHOD__);
		\App\Db::getInstance()->createCommand()
			->update('yetiforce_proc_tc', ['value' => $param['value']], ['type' => $param['type'], 'param' => $param['param']])->execute();
		\App\Log::trace('End ' . __METHOD__);
		return true;
	}
}
