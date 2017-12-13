<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ********************************************************************************** */

/**
 * Functionality to save and retrieve Tasks from the database.
 */
class VTTaskManager
{

	/**
	 * Save the task into the database.
	 *
	 * When a new task is saved for the first time a field is added to it called
	 * id that stores the task id used in the database.
	 *
	 * @param VTTask $task The task instance to save.
	 * @return The id of the task
	 */
	public function saveTask($task)
	{
		$db = App\Db::getInstance();
		if (is_numeric($task->id)) {//How do I check whether a member exists in php?
			$taskId = $task->id;
			$db->createCommand()->update('com_vtiger_workflowtasks', ['summary' => $task->summary, 'task' => serialize($task)], ['task_id' => $taskId])->execute();
			return $taskId;
		} else {
			$taskId = $db->getUniqueID("com_vtiger_workflowtasks");
			$task->id = $taskId;
			$db->createCommand()->insert('com_vtiger_workflowtasks', [
				'task_id' => $taskId,
				'workflow_id' => $task->workflowId,
				'summary' => $task->summary,
				'task' => serialize($task)
			])->execute();
			return $taskId;
		}
	}

	/**
	 * Delete task by id
	 * @param int $taskId
	 */
	public function deleteTask($taskId)
	{
		App\Db::getInstance()->createCommand()->delete('com_vtiger_workflowtasks', ['task_id' => $taskId])->execute();
	}

	/**
	 * Create a new class instance
	 * @param string $taskType
	 * @param int $workflowId
	 * @return VTTask
	 */
	public function createTask($taskType, $workflowId)
	{
		$taskTypeInstance = VTTaskType::getInstanceFromTaskType($taskType);
		$taskClass = $taskTypeInstance->get('classname');
		$this->requireTask($taskClass, $taskTypeInstance);
		$task = new $taskClass();
		$task->workflowId = $workflowId;
		$task->summary = "";
		$task->active = true;
		return $task;
	}

	/**
	 * Retrieve a task from the database
	 *
	 * @param $taskId The id of the task to retrieve.
	 * @return VTTask The retrieved task.
	 */
	public function retrieveTask($taskId)
	{
		$task = (new \App\Db\Query())->select(['task'])->from('com_vtiger_workflowtasks')->where(['task_id' => $taskId])->scalar();
		$task = $this->unserializeTask($task);
		return $task;
	}

	/**
	 * Return tasks for workflow
	 * @param int $workflowId
	 */
	public function getTasksForWorkflow($workflowId)
	{
		if (\App\Cache::staticHas('getTasksForWorkflow', $workflowId)) {
			return \App\Cache::staticGet('getTasksForWorkflow', $workflowId);
		}
		$rows = (new \App\Db\Query())->select(['task'])->from('com_vtiger_workflowtasks')->where(['workflow_id' => $workflowId])->column();
		$tasks = [];
		foreach ($rows as &$task) {
			$this->requireTask(self::taskName($task));
			$tasks[] = unserialize($task);
		}
		\App\Cache::staticGet('getTasksForWorkflow', $workflowId, $tasks);
		return $tasks;
	}

	/**
	 * Userialize task string
	 * @param string $str
	 * @return array|bool
	 */
	public function unserializeTask($str)
	{
		$this->requireTask(self::taskName($str));
		return unserialize($str);
	}

	/**
	 * Return all tasks
	 * @return array
	 */
	function getTasks()
	{
		$result = (new \App\Db\Query())->select(['task'])->from('com_vtiger_workflowtasks')->all();
		return $this->getTasksForResult($result);
	}

	/**
	 * Create tasks from query result array
	 * @param array $result
	 * @return VTTask[]
	 */
	private function getTasksForResult($result)
	{
		$tasks = [];
		foreach ($result as $row) {
			$this->requireTask(self::taskName($row['task']));
			$tasks[] = unserialize($row['task']);
		}
		return $tasks;
	}

	/**
	 * Return task name
	 * @param string $serializedTask
	 * @return string
	 */
	private function taskName($serializedTask)
	{
		$matches = [];
		preg_match('/"([^"]+)"/', $serializedTask, $matches);
		return $matches[1];
	}

	/**
	 * Require task
	 * @param string $taskType
	 * @param VTTaskType $taskTypeInstance
	 */
	private function requireTask($taskType, $taskTypeInstance = '')
	{
		if (!empty($taskTypeInstance)) {
			$taskClassPath = $taskTypeInstance->get('classpath');
			require_once($taskClassPath);
		} else {
			if (!empty($taskType)) {
				require_once("tasks/$taskType.php");
			}
		}
	}

	/**
	 * Return template path
	 * @param string $moduleName
	 * @param VTTaskType $taskTypeInstance
	 * @return string
	 */
	public function retrieveTemplatePath($moduleName, VTTaskType $taskTypeInstance)
	{
		$taskTemplatePath = $taskTypeInstance->get('templatepath');
		if (!empty($taskTemplatePath)) {
			return $taskTemplatePath;
		} else {
			$taskType = $taskTypeInstance->get('classname');
			return "$moduleName/taskforms/$taskType.tpl";
		}
	}
}

/**
 * VTiger workflow VTTask class
 */
abstract class VTTask
{

	/**
	 * Task contents
	 * @var Vtiger_Record_Model
	 */
	var $contents;

	/**
	 * Do task
	 * @param Vtiger_Record_Model
	 */
	public abstract function doTask($recordModel);

	/**
	 * Return field names
	 */
	public abstract function getFieldNames();

	/**
	 * Return time field list
	 * @return array
	 */
	public function getTimeFieldList()
	{
		return [];
	}

	/**
	 * Return content
	 * @param Vtiger_Record_Model $recordModel
	 * @return Vtiger_Record_Model
	 */
	public function getContents($recordModel)
	{
		return $this->contents;
	}

	/**
	 * Set contents
	 * @param Vtiger_Record_Model $recordModel
	 */
	public function setContents($recordModel)
	{
		$this->contents = $recordModel;
	}

	/**
	 * Check if has contents
	 * @param Vtiger_Record_Model $recordModel
	 * @return boolean
	 */
	public function hasContents($recordModel)
	{
		if ($this->getContents($recordModel)) {
			return true;
		}
		return false;
	}

	/**
	 * Return formatted time for timepicker
	 * @param string $time
	 * @return string
	 */
	public function formatTimeForTimePicker($time)
	{
		list($h, $m, $s) = explode(':', $time);
		$mn = str_pad($m - $m % 15, 2, 0, STR_PAD_LEFT);
		$AM_PM = array('am', 'pm');
		return str_pad(($h % 12), 2, 0, STR_PAD_LEFT) . ':' . $mn . $AM_PM[($h / 12) % 2];
	}
}

/**
 * VTTaskType class
 */
class VTTaskType
{

	/**
	 * Data array
	 * @var array
	 */
	var $data;

	/**
	 * Return value for $data key
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		return $this->data[$key];
	}

	/**
	 * Set value for $data key
	 * @param string $key
	 * @param mixed $value
	 * @return $this
	 */
	public function set($key, $value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	/**
	 * Replace $data array
	 * @param array $valueMap
	 * @return $this
	 */
	public function setData($valueMap)
	{
		$this->data = $valueMap;
		return $this;
	}

	/**
	 * Return instance of self with new $data array
	 * @param array $values
	 * @return VTTaskType
	 */
	public static function getInstance($values)
	{
		$instance = new self();
		return $instance->setData($values);
	}

	/**
	 * Registers new task type in database
	 * @param array $taskType
	 */
	public static function registerTaskType($taskType)
	{
		$db = \App\Db::getInstance();
		$modules = \App\Json::encode($taskType['modules']);
		$taskType['id'] = $db->getUniqueID('com_vtiger_workflow_tasktypes');
		$db->createCommand()->insert('com_vtiger_workflow_tasktypes', [
			'id' => $taskType['id'],
			'tasktypename' => $taskType['name'],
			'label' => $taskType['label'],
			'classname' => $taskType['classname'],
			'classpath' => $taskType['classpath'],
			'templatepath' => $taskType['templatepath'],
			'modules' => $modules,
			'sourcemodule' => $taskType['sourcemodule']
		])->execute();
	}

	/**
	 * return all task types
	 * @param string $moduleName
	 * @return VTTaskType[]
	 */
	public static function getAll($moduleName = '')
	{
		$query = (new App\Db\Query())->from('com_vtiger_workflow_tasktypes');
		$dataReader = $query->createCommand()->query();
		while ($rawData = $dataReader->read()) {
			$taskName = $rawData['tasktypename'];
			$moduleslist = $rawData['modules'];
			$sourceModule = $rawData['sourcemodule'];
			$modules = \App\Json::decode($moduleslist);
			$includeModules = $modules['include'];
			$excludeModules = $modules['exclude'];

			if (!empty($sourceModule)) {
				if (\App\Module::getModuleId($sourceModule) === null || !\App\Module::isModuleActive($sourceModule)) {
					continue;
				}
			}

			if (empty($includeModules) && empty($excludeModules)) {
				$taskTypeInstances[$taskName] = self::getInstance($rawData);
				continue;
			} elseif (!empty($includeModules)) {
				if (in_array($moduleName, $includeModules)) {
					$taskTypeInstances[$taskName] = self::getInstance($rawData);
				}
				continue;
			} elseif (!empty($excludeModules)) {
				if (!(in_array($moduleName, $excludeModules))) {
					$taskTypeInstances[$taskName] = self::getInstance($rawData);
				}
				continue;
			}
		}
		return $taskTypeInstances;
	}

	/**
	 * Return instance from task type name
	 * @param string $taskType
	 * @return VTTaskType
	 */
	public static function getInstanceFromTaskType($taskType)
	{
		$row = (new App\Db\Query())->from('com_vtiger_workflow_tasktypes')->where(['tasktypename' => $taskType])->one();

		$taskTypes['name'] = $row['tasktypename'];
		$taskTypes['label'] = $row['label'];
		$taskTypes['classname'] = $row['classname'];
		$taskTypes['classpath'] = $row['classpath'];
		$taskTypes['templatepath'] = $row['templatepath'];
		$taskTypes['sourcemodule'] = $row['sourcemodule'];

		$taskDetails = self::getInstance($taskTypes);
		return $taskDetails;
	}
}
