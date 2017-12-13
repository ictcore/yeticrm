<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * ********************************************************************************** */
require_once('include/Webservices/Utils.php');
require_once("include/Webservices/WebServiceError.php");
require_once 'include/Webservices/ModuleTypes.php';
require_once('include/Webservices/Create.php');
require_once 'include/Webservices/DescribeObject.php';
require_once 'include/Webservices/WebserviceField.php';
require_once 'include/Webservices/EntityMeta.php';
require_once 'include/Webservices/VtigerWebserviceObject.php';

require_once("modules/Users/Users.php");

class VTCreateTodoTask extends VTTask
{

	public $executeImmediately = true;

	public function getFieldNames()
	{
		return ['todo', 'description', 'time', 'days_start', 'days_end', 'status', 'priority', 'days', 'direction_start', 'datefield_start', 'direction_end', 'datefield_end', 'sendNotification', 'assigned_user_id', 'days', 'doNotDuplicate', 'duplicateStatus', 'updateDates'];
	}

	function getAdmin()
	{
		$user = Users::getActiveAdminUser();
		$currentUser = vglobal('current_user');
		$this->originalUser = $currentUser;
		$currentUser = $user;
		return $user;
	}

	/**
	 * Execute task
	 * @param Vtiger_Record_Model $recordModel
	 */
	public function doTask($recordModel)
	{
		if (!\App\Module::isModuleActive('Calendar')) {
			return;
		}
		\App\Log::trace('Start ' . __CLASS__ . ':' . __FUNCTION__);
		$adminUser = $this->getAdmin();
		$userId = $recordModel->get('assigned_user_id');
		if ($userId === null) {
			$userId = $adminUser;
		}
		$moduleName = $recordModel->getModuleName();

		if ($this->doNotDuplicate == 'true') {

			$entityId = $recordModel->getId();
			$query = (new App\Db\Query())->from('vtiger_activity')
				->innerJoin('vtiger_crmentity', 'vtiger_crmentity.crmid = vtiger_activity.activityid')
				->where([
				'and',
				['vtiger_crmentity.deleted' => 0],
				['or', ['vtiger_activity.link' => $entityId], ['vtiger_activity.process' => $entityId]],
				['vtiger_activity.activitytype' => 'Task'],
				['vtiger_activity.subject' => $this->todo]
			]);
			$status = vtlib\Functions::getArrayFromValue($this->duplicateStatus);
			if (count($status) > 0) {
				$query->andWhere(['not in', 'vtiger_activity.status', $status]);
			}
			if ($query->count() > 0) {
				\App\Log::warning(__CLASS__ . '::' . __METHOD__ . ': To Do was ignored because a duplicate was found.' . $this->todo);
				return;
			}
		}

		if ($this->assigned_user_id === 'currentUser') {
			$userId = \App\User::getCurrentUserId();
		} else if ($this->assigned_user_id === 'triggerUser') {
			$userId = $recordModel->executeUser;
		} else if ($this->assigned_user_id === 'copyParentOwner') {
			$userId = $recordModel->get('assigned_user_id');
		} else if (!empty($this->assigned_user_id)) { // Added to check if the user/group is active
			$userExists = (new App\Db\Query())->from('vtiger_users')
				->where(['id' => $this->assigned_user_id, 'status' => 'Active'])
				->exists();
			if ($userExists) {
				$userId = $this->assigned_user_id;
			} else {
				$groupExist = (new App\Db\Query())->from('vtiger_groups')
					->where(['groupid' => $this->assigned_user_id])
					->exists();
				if ($groupExist) {
					$userId = $this->assigned_user_id;
				}
			}
		}

		if ($this->datefield_start == 'wfRunTime') {
			$baseDateStart = date('Y-m-d H:i:s');
		} else {
			$baseDateStart = $recordModel->get($this->datefield_start);
			if ($baseDateStart == '') {
				$baseDateStart = date('Y-m-d');
			}
		}

		$time = explode(' ', $baseDateStart);
		if (count($time) < 2) {
			$timeWithSec = Vtiger_Time_UIType::getTimeValueWithSeconds($this->time);
			$dbInsertDateTime = DateTimeField::convertToDBTimeZone($baseDateStart . ' ' . $timeWithSec);
			$time = $dbInsertDateTime->format('H:i:s');
		} else {
			$time = $time[1];
		}
		preg_match('/\d\d\d\d-\d\d-\d\d/', $baseDateStart, $match);
		$baseDateStart = strtotime($match[0]);

		if ($this->datefield_end == 'wfRunTime') {
			$baseDateEnd = date('Y-m-d H:i:s');
		} else {
			$baseDateEnd = $recordModel->get($this->datefield_end);
			if ($baseDateEnd == '') {
				$baseDateEnd = date('Y-m-d');
			}
		}

		$timeEnd = explode(' ', $baseDateEnd);
		if (count($timeEnd) < 2) {
			$row = (new App\Db\Query())->select(['end_hour'])->from('vtiger_users')->where(['id' => $userId])->one();
			if ($row) {
				$timeEnd = $row['end_hour'];
				$timeWithSec = Vtiger_Time_UIType::getTimeValueWithSeconds($timeEnd);
				$dbInsertDateTime = DateTimeField::convertToDBTimeZone($baseDateEnd . ' ' . $timeWithSec);
				$timeEnd = $dbInsertDateTime->format('H:i:s');
			} else {
				$timeEnd = $adminUser->column_fields['end_hour'];
				$timeWithSec = Vtiger_Time_UIType::getTimeValueWithSeconds($timeEnd);
				$dbInsertDateTime = DateTimeField::convertToDBTimeZone($baseDateEnd . ' ' . $timeWithSec);
				$timeEnd = $dbInsertDateTime->format('H:i:s');
			}
		} else {
			$timeEnd = $timeEnd[1];
		}
		preg_match('/\d\d\d\d-\d\d-\d\d/', $baseDateEnd, $match);
		$baseDateEnd = strtotime($match[0]);
		$date_start = strftime('%Y-%m-%d', $baseDateStart + (int) $this->days_start * 24 * 60 * 60 * (strtolower($this->direction_start) == 'before' ? -1 : 1));
		$due_date = strftime('%Y-%m-%d', $baseDateEnd + (int) $this->days_end * 24 * 60 * 60 * (strtolower($this->direction_end) == 'before' ? -1 : 1));
		$textParser = \App\TextParser::getInstanceByModel($recordModel);
		$fields = [
			'activitytype' => 'Task',
			'description' => $textParser->setContent($this->description)->parse()->getContent(),
			'subject' => $textParser->setContent($this->todo)->parse()->getContent(),
			'taskpriority' => $this->priority,
			'activitystatus' => $this->status,
			'assigned_user_id' => $userId,
			'time_start' => $time,
			'time_end' => $timeEnd,
			'sendnotification' => ($this->sendNotification != '' && $this->sendNotification != 'N') ?
			true : false,
			'date_start' => $date_start,
			'due_date' => $due_date,
			'visibility' => 'Private',
		];
		$field = \App\ModuleHierarchy::getMappingRelatedField($moduleName);
		if ($field) {
			$fields[$field] = $recordModel->getId();
		}
		$newRecordModel = Vtiger_Record_Model::getCleanInstance('Calendar');
		$newRecordModel->setData($fields);
		$newRecordModel->setHandlerExceptions(['disableWorkflow' => true]);
		$newRecordModel->save();

		relateEntities($recordModel->getEntity(), $moduleName, $recordModel->getId(), 'Calendar', $newRecordModel->getId());

		if ($this->updateDates == 'true') {
			App\Db::getInstance()->createCommand()->insert('vtiger_activity_update_dates', [
				'activityid' => $newRecordModel->getId(),
				'parent' => $recordModel->getId(),
				'task_id' => $this->id,
			])->execute();
		}
		\App\Log::trace('End ' . __CLASS__ . ':' . __FUNCTION__);
	}

	static function conv12to24hour($timeStr)
	{
		$arr = [];
		preg_match('/(\d{1,2}):(\d{1,2})(am|pm)/', $timeStr, $arr);
		if ($arr[3] == 'am') {
			$hours = ((int) $arr[1]) % 12;
		} else {
			$hours = ((int) $arr[1]) % 12 + 12;
		}
		return str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($arr[2], 2, '0', STR_PAD_LEFT);
	}

	public function getTimeFieldList()
	{
		return array('time');
	}
}
