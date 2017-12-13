<?php
/**
 * Time Control Handler Class
 * @package YetiForce.Handler
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
Vtiger_Loader::includeOnce('~~modules/com_vtiger_workflow/include.php');
Vtiger_Loader::includeOnce('~~include/Webservices/Utils.php');
Vtiger_Loader::includeOnce('~~include/Webservices/Retrieve.php');

class OSSTimeControl_TimeControl_Handler
{

	/**
	 * EntityAfterUnLink handler function
	 * @param App\EventHandler $eventHandler
	 */
	public function entityAfterUnLink(App\EventHandler $eventHandler)
	{
		$params = $eventHandler->getParams();
		$wfs = new VTWorkflowManager();
		$workflows = $wfs->getWorkflowsForModule($params['destinationModule'], VTWorkflowManager::$MANUAL);
		$recordModel = Vtiger_Record_Model::getInstanceById($params['destinationRecordId'], $params['destinationModule']);
		foreach ($workflows as &$workflow) {
			if ($workflow->evaluate($recordModel)) {
				$workflow->performTasks($recordModel);
			}
		}
	}

	/**
	 * EntityAfterDelete handler function
	 * @param App\EventHandler $eventHandler
	 */
	public function entityAfterDelete(App\EventHandler $eventHandler)
	{
		$recordModel = $eventHandler->getRecordModel();
		$wfs = new VTWorkflowManager();
		$workflows = $wfs->getWorkflowsForModule($eventHandler->getModuleName(), VTWorkflowManager::$MANUAL);
		foreach ($workflows as &$workflow) {
			if ($workflow->evaluate($recordModel)) {
				$workflow->performTasks($recordModel);
			}
		}
	}

	/**
	 * EntityAfterSave handler function
	 * @param App\EventHandler $eventHandler
	 */
	public function entityAfterSave(App\EventHandler $eventHandler)
	{
		$recordModel = $eventHandler->getRecordModel();
		OSSTimeControl_Record_Model::setSumTime($recordModel);
		$wfs = new VTWorkflowManager();
		$workflows = $wfs->getWorkflowsForModule($eventHandler->getModuleName(), VTWorkflowManager::$MANUAL);
		foreach ($workflows as &$workflow) {
			if ($workflow->evaluate($recordModel)) {
				$workflow->performTasks($recordModel);
			}
		}
	}

	/**
	 * EntityAfterRestore handler function
	 * @param App\EventHandler $eventHandler
	 */
	public function entityAfterRestore(App\EventHandler $eventHandler)
	{
		$recordModel = $eventHandler->getRecordModel();
		$wfs = new VTWorkflowManager();
		$workflows = $wfs->getWorkflowsForModule($eventHandler->getModuleName(), VTWorkflowManager::$MANUAL);
		foreach ($workflows as &$workflow) {
			if ($workflow->evaluate($recordModel)) {
				$workflow->performTasks($recordModel);
			}
		}
	}
}
