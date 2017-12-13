<?php

/**
 * Products SummaryWidget model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Products_SummaryWidget_Model
{

	const MODULES = ['Products', 'OutsourcedProducts', 'Assets', 'Services', 'OSSOutsourcedServices', 'OSSSoldServices'];
	const CATEGORY_MODULES = ['Products', 'OutsourcedProducts', 'Services', 'OSSOutsourcedServices'];

	public static function getCleanInstance()
	{
		$instance = new self();
		return $instance;
	}

	public function getProductsServices(\App\Request $request, Vtiger_Viewer $viewer)
	{
		$fromModule = $request->get('fromModule');
		$record = $request->get('record');
		$mod = $request->get('mod');
		if (!in_array($mod, self::MODULES)) {
			throw new \Exception\AppException('Not supported Module');
		}
		$limit = 10;
		if (!empty($request->get('limit'))) {
			$limit = $request->get('limit');
		}
		$pagingModel = new Vtiger_Paging_Model();
		$pagingModel->set('page', 0);
		$pagingModel->set('limit', $limit);

		$parentRecordModel = Vtiger_Record_Model::getInstanceById($record, $fromModule);
		$relationListView = Vtiger_RelationListView_Model::getInstance($parentRecordModel, $mod);
		$recordsModels = $relationListView->getEntries($pagingModel);
		$recordsHeader = $relationListView->getHeaders();
		array_splice($recordsHeader, 3);
		$viewer->assign('RELATED_RECORDS', $recordsModels);
		$viewer->assign('RELATED_HEADERS', $recordsHeader);
		if (in_array($mod, self::CATEGORY_MODULES)) {
			$viewer->assign('RELATED_HEADERS_TREE', $relationListView->getTreeHeaders());
			$viewer->assign('RELATED_RECORDS_TREE', $relationListView->getTreeEntries());
		}
		$viewer->assign('RECORD_PAGING_MODEL', $pagingModel);
	}

	/**
	 * Get related modules record counts
	 * @param Vtiger_Record_Model $parentRecordModel
	 * @return type
	 */
	public static function getModulesAndCount(Vtiger_Record_Model $parentRecordModel)
	{
		$modules = [];
		foreach (self::MODULES as &$moduleName) {
			$count = 0;
			if (!\App\Privilege::isPermitted($moduleName)) {
				continue;
			}
			$relationListView = Vtiger_RelationListView_Model::getInstance($parentRecordModel, $moduleName);
			if (!$relationListView->getRelationModel()) {
				continue;
			}
			if (in_array($moduleName, self::CATEGORY_MODULES)) {
				$count += (int) $relationListView->getRelatedTreeEntriesCount();
			}
			$count += (int) $relationListView->getRelatedEntriesCount();
			$modules[$moduleName] = $count;
		}
		return $modules;
	}
}
