<?php

/**
 * Action to clipboard
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
class OpenStreetMap_ClipBoard_Action extends Vtiger_BasicAjax_Action
{

	public function __construct()
	{
		parent::__construct();
		$this->exposeMethod('save');
		$this->exposeMethod('delete');
		$this->exposeMethod('addAllRecords');
		$this->exposeMethod('addRecord');
	}

	public function process(\App\Request $request)
	{
		$mode = $request->getMode();
		if (!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	public function addAllRecords(\App\Request $request)
	{
		$coordinatesModel = OpenStreetMap_Coordinate_Model::getInstance();
		$coordinatesModel->set('moduleName', $request->get('srcModule'));
		$count = $coordinatesModel->saveAllRecordsToCache();
		$response = new Vtiger_Response();
		$response->setResult(['count' => $count]);
		$response->emit();
	}

	public function delete(\App\Request $request)
	{
		$coordinatesModel = OpenStreetMap_Coordinate_Model::getInstance();
		$coordinatesModel->set('moduleName', $request->get('srcModule'));
		$coordinatesModel->deleteCache();
		$response = new Vtiger_Response();
		$response->setResult(0);
		$response->emit();
	}

	public function save(\App\Request $request)
	{
		$records = $request->get('recordIds');
		$coordinatesModel = OpenStreetMap_Coordinate_Model::getInstance();
		$coordinatesModel->set('moduleName', $request->get('srcModule'));
		$coordinatesModel->deleteCache();
		$coordinatesModel->saveCache($records);
		$response = new Vtiger_Response();
		$response->setResult(count($records));
		$response->emit();
	}

	public function addRecord(\App\Request $request)
	{
		$record = $request->get('record');
		$srcModuleName = $request->get('srcModuleName');
		$coordinatesModel = OpenStreetMap_Coordinate_Model::getInstance();
		$coordinatesModel->set('moduleName', $srcModuleName);
		$coordinatesModel->addCache($record);
		$moduleModel = Vtiger_Module_Model::getInstance($srcModuleName);
		$coordinatesModel->set('srcModuleModel', $moduleModel);
		$coordinates = $coordinatesModel->readCoordinatesByRecords([$record]);
		if (empty($coordinates)) {
			$coordinates = \App\Language::translate('ERR_ADDRESS_NOT_FOUND', 'OpenStreetMap');
		}
		$response = new Vtiger_Response();
		$response->setResult($coordinates);
		$response->emit();
	}
}
