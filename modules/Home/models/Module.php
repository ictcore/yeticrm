<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com.
 * *********************************************************************************** */

class Home_Module_Model extends Vtiger_Module_Model
{

	/**
	 * Function returns the default view for the Home module
	 * @return string
	 */
	public function getDefaultViewName()
	{
		return 'DashBoard';
	}

	/**
	 * Function returns latest comments across CRM
	 * @param \Vtiger_Paging_Model $pagingModel
	 * @return \Vtiger_Record_Model[]
	 */
	public function getComments($pagingModel)
	{
		$query = new \App\Db\Query();
		$query->select(['*', 'createdtime' => 'vtiger_crmentity.createdtime', 'assigned_user_id' => 'vtiger_crmentity.smownerid',
				'parentId' => 'crmentity2.crmid', 'parentModule' => 'crmentity2.setype'])
			->from('vtiger_modcomments')
			->innerJoin('vtiger_crmentity', 'vtiger_modcomments.modcommentsid = vtiger_crmentity.crmid')
			->innerJoin('vtiger_crmentity crmentity2', 'vtiger_modcomments.related_to = crmentity2.crmid')
			->where(['vtiger_crmentity.deleted' => 0, 'crmentity2.deleted' => 0]);
		\App\PrivilegeQuery::getConditions($query, 'ModComments');
		$query->orderBy(['vtiger_modcomments.modcommentsid' => SORT_DESC])
			->limit($pagingModel->getPageLimit())
			->offset($pagingModel->getStartIndex());
		$dataReader = $query->createCommand()->query();
		$comments = [];
		while ($row = $dataReader->read()) {
			if (Users_Privileges_Model::isPermitted($row['setype'], 'DetailView', $row['related_to'])) {
				$commentModel = Vtiger_Record_Model::getCleanInstance('ModComments');
				$commentModel->setData($row);
				$time = $commentModel->get('createdtime');
				$comments[$time] = $commentModel;
			}
		}
		return $comments;
	}

	/**
	 * Function returns part of the query to  fetch only  activity
	 * @param \App\Db\Query $query
	 * @param string $type
	 */
	public function getActivityQuery(\App\Db\Query $query, $type)
	{
		if ($type == 'updates') {
			$query->andWhere(['<>', 'module', 'ModComments']);
		}
	}

	/**
	 * Function returns the Calendar Events for the module
	 * @param string $mode - upcoming/overdue mode
	 * @param Vtiger_Paging_Model $pagingModel - $pagingModel
	 * @param string $user - all/userid
	 * @param string $recordId - record id
	 * @return array
	 */
	public function getCalendarActivities($mode, Vtiger_Paging_Model $pagingModel, $user, $recordId = false, $paramsMore = [])
	{
		$activities = [];
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$query = new \App\Db\Query();
		if (!$user) {
			$user = $currentUser->getId();
		}

		$orderBy = $pagingModel->getForSql('orderby');
		$sortOrder = $pagingModel->getForSql('sortorder');

		if (empty($sortOrder) || !in_array(strtolower($sortOrder), ['asc', 'desc'])) {
			$sortOrder = 'ASC';
		}
		if (empty($orderBy)) {
			$orderBy = "due_date $sortOrder, time_end $sortOrder";
		} else {
			$orderBy .= ' ' . $sortOrder;
		}
		$query->select('vtiger_crmentity.crmid, vtiger_crmentity.smownerid, vtiger_crmentity.setype, vtiger_activity.*')
			->from('vtiger_activity')
			->innerJoin('vtiger_crmentity', 'vtiger_crmentity.crmid = vtiger_activity.activityid')
			->where(['vtiger_crmentity.deleted' => 0]);
		\App\PrivilegeQuery::getConditions($query, 'Calendar');
		if ($mode === 'upcoming') {
			$query->andWhere(['or', ['vtiger_activity.status' => null], ['vtiger_activity.status' => $paramsMore['status']]]);
		} elseif ($mode === 'overdue') {
			$query->andWhere(['or', ['vtiger_activity.status' => null], ['vtiger_activity.status' => $paramsMore['status']]]);
		} elseif ($mode === 'assigned_upcoming') {
			$query->andWhere(['or', ['vtiger_activity.status' => null], ['vtiger_activity.status' => $paramsMore['status']]]);
			$query->andWhere(['vtiger_crmentity.smcreatorid' => $paramsMore['user']]);
		} elseif ($mode === 'assigned_over') {
			$query->andWhere(['or', ['vtiger_activity.status' => null], ['vtiger_activity.status' => $paramsMore['status']]]);
			$query->andWhere(['vtiger_crmentity.smcreatorid' => $paramsMore['user']]);
		} elseif ($mode === 'createdByMeButNotMine') {
			$query->andWhere(['or', ['vtiger_activity.status' => null], ['vtiger_activity.status' => $paramsMore['status']]]);
			$query->andWhere(['and', ['vtiger_crmentity.smcreatorid' => $paramsMore['user']], ['NOT IN', 'vtiger_crmentity.smownerid', $paramsMore['user']]]);
		}

		if ($user !== 'all' && !empty($user)) {
			settype($user, 'int');
			$subQuery = (new \App\Db\Query())->select('crmid')->from('u_yf_crmentity_showners')->innerJoin('vtiger_activity', 'u_yf_crmentity_showners.crmid=vtiger_activity.activityid')->where(['userid' => $user])->distinct('crmid');
			$query->andWhere(['or', ['vtiger_crmentity.smownerid' => $user], ['vtiger_crmentity.crmid' => $subQuery]]);
		}

		$query->orderBy($orderBy)
			->limit($pagingModel->getPageLimit() + 1)
			->offset($pagingModel->getStartIndex());

		$dataReader = $query->createCommand()->query();
		while ($row = $dataReader->read()) {
			$model = Vtiger_Record_Model::getCleanInstance('Calendar');
			$model->setData($row);
			$model->setId($row['crmid']);
			if ($row['parent_id']) {
				if (isRecordExists($row['parent_id'])) {
					$record = Vtiger_Record_Model::getInstanceById($row['parent_id']);
					if ($record->getModuleName() == 'Accounts') {
						$model->set('contractor', $record);
					} else if ($record->getModuleName() == 'Project') {
						if (isRecordExists($record->get('linktoaccountscontacts'))) {
							$recordContractor = Vtiger_Record_Model::getInstanceById($record->get('linktoaccountscontacts'));
							$model->set('contractor', $recordContractor);
						}
					} else if ($record->getModuleName() == 'ServiceContracts') {
						if (isRecordExists($record->get('sc_realted_to'))) {
							$recordContractor = Vtiger_Record_Model::getInstanceById($record->get('sc_realted_to'));
							$model->set('contractor', $recordContractor);
						}
					} else if ($record->getModuleName() == 'HelpDesk') {
						if (isRecordExists($record->get('parent_id'))) {
							$recordContractor = Vtiger_Record_Model::getInstanceById($record->get('parent_id'));
							;
							$model->set('contractor', $recordContractor);
						}
					}
				}
			}

			$contactsA = getActivityRelatedContacts($row['activityid']);
			if (count($contactsA)) {
				foreach ($contactsA as $j => $rcA2) {
					$contactsA[$j] = '<a href="index.php?module=Contacts&view=Detail&record=' . $j . '">' . $rcA2 . '</a>';
					$model->set('contact_id', $contactsA);
				}
			}
			$activities[] = $model;
		}

		$pagingModel->calculatePageRange($dataReader->count());
		if ($dataReader->count() > $pagingModel->getPageLimit()) {
			array_pop($activities);
			$pagingModel->set('nextPageExists', true);
		} else {
			$pagingModel->set('nextPageExists', false);
		}

		return $activities;
	}

	/**
	 * Function returns the Calendar Events for the module
	 * @param string $mode - upcoming/overdue mode
	 * @param <Vtiger_Paging_Model> $pagingModel - $pagingModel
	 * @param string $user - all/userid
	 * @param string $recordId - record id
	 * @return <Array>
	 */
	public function getAssignedProjectsTasks($mode, $pagingModel, $user, $recordId = false)
	{
		$currentUser = Users_Record_Model::getCurrentUserModel();
		if (!$user) {
			$user = $currentUser->getId();
		}
		$nowInUserFormat = Vtiger_Datetime_UIType::getDisplayDateTimeValue(date('Y-m-d H:i:s'));
		$nowInDBFormat = Vtiger_Datetime_UIType::getDBDateTimeValue($nowInUserFormat);
		list($currentDate, $currentTime) = explode(' ', $nowInDBFormat);
		$query = (new App\Db\Query())
			->select(['vtiger_crmentity.crmid', 'vtiger_crmentity.smownerid', 'vtiger_crmentity.setype', 'vtiger_projecttask.*'])
			->from('vtiger_projecttask')
			->innerJoin('vtiger_crmentity', 'vtiger_crmentity.crmid = vtiger_projecttask.projecttaskid')
			->where(['vtiger_crmentity.deleted' => 0, 'vtiger_crmentity.smcreatorid' => $currentUser->getId()]);
		\App\PrivilegeQuery::getConditions($query, 'ProjectTask');
		if ($mode === 'upcoming') {
			$query->andWhere(['>=', 'targetenddate', $currentDate]);
		} elseif ($mode === 'overdue') {
			$query->andWhere(['<', 'targetenddate', $currentDate]);
		}
		$accessibleUsers = \App\Fields\Owner::getInstance(false, $currentUser)->getAccessibleUsers();
		$accessibleGroups = \App\Fields\Owner::getInstance(false, $currentUser)->getAccessibleGroups();
		if ($user != 'all' && $user != '' && (array_key_exists($user, $accessibleUsers) || array_key_exists($user, $accessibleGroups))) {
			$query->andWhere(['vtiger_crmentity.smownerid' => $user]);
		}
		$query->orderBy('targetenddate')
			->limit($pagingModel->getPageLimit() + 1)
			->offset($pagingModel->getStartIndex());
		$dataReader = $query->createCommand()->query();
		$projecttasks = [];
		while ($row = $dataReader->read()) {
			$model = Vtiger_Record_Model::getCleanInstance('ProjectTask');
			$model->setData($row);
			$model->setId($row['crmid']);
			if ($row['projectid']) {
				if (isRecordExists($row['projectid'])) {
					$record = Vtiger_Record_Model::getInstanceById($row['projectid'], 'Project');
					if (isRecordExists($record->get('linktoaccountscontacts'))) {
						$model->set('account', '<a href="index.php?module=' . vtlib\Functions::getCRMRecordType($record->get('linktoaccountscontacts')) . '&view=Detail&record=' . $record->get('linktoaccountscontacts') . '">' . vtlib\Functions::getCRMRecordLabel($record->get('linktoaccountscontacts')) . '</a>');
					}
				}
			}
			$projecttasks[] = $model;
		}
		$pagingModel->calculatePageRange($dataReader->count());
		if ($dataReader->count() > $pagingModel->getPageLimit()) {
			array_pop($projecttasks);
			$pagingModel->set('nextPageExists', true);
		} else {
			$pagingModel->set('nextPageExists', false);
		}

		return $projecttasks;
	}

	/**
	 * Function returns comments and recent activities across module
	 * @param <Vtiger_Paging_Model> $pagingModel
	 * @param string $type - comments, updates or all
	 * @return <Array>
	 */
	public function getHistory($pagingModel, $type = false)
	{
		if (empty($type)) {
			$type = 'all';
		}
		$comments = [];
		if ($type == 'all' || $type == 'comments') {
			$modCommentsModel = Vtiger_Module_Model::getInstance('ModComments');
			if ($modCommentsModel->isPermitted('DetailView')) {
				$comments = $this->getComments($pagingModel);
			}
			if ($type == 'comments') {
				return $comments;
			}
		}
		//As getComments api is used to get comment infomation,no need of getting
		//comment information again,so avoiding from modtracker
		//updateActivityQuery api is used to update a query to fetch a only activity
		if ($type == 'updates' || $type == 'all') {
			$query = new \App\Db\Query();
			$query->select('vtiger_modtracker_basic.*')
				->from('vtiger_modtracker_basic')
				->innerJoin('vtiger_crmentity', 'vtiger_modtracker_basic.crmid = vtiger_crmentity.crmid')
				->where(['vtiger_crmentity.deleted' => 0]);

			$this->getActivityQuery($query, $type);
			$query->orderBy(['vtiger_modtracker_basic.id' => SORT_DESC])
				->limit($pagingModel->getPageLimit())
				->offset($pagingModel->getStartIndex());
			$dataReader = $query->createCommand()->query();
			$activites = [];
			while ($row = $dataReader->read()) {
				$moduleName = $row['module'];
				$recordId = $row['crmid'];
				if (Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $recordId)) {
					$modTrackerRecorModel = new ModTracker_Record_Model();
					$modTrackerRecorModel->setData($row)->setParent($recordId, $moduleName);
					$time = $modTrackerRecorModel->get('changedon');
					$activites[$time] = $modTrackerRecorModel;
				}
			}
		}
		$history = array_merge($activites, $comments);

		$dateTime = [];
		foreach ($history as $time => $model) {
			$dateTime[] = $time;
		}

		if (!empty($history)) {
			array_multisort($dateTime, SORT_DESC, SORT_STRING, $history);
			return $history;
		}
		return false;
	}
}
