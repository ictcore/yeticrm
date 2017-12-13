<?php

/**
 * Settings menu module model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_Menu_Module_Model
{

	protected $types = [
		0 => 'Module',
		1 => 'Shortcut',
		2 => 'Label',
		3 => 'Separator',
		4 => 'Script',
		5 => 'QuickCreate',
		6 => 'HomeIcon',
		7 => 'CustomFilter',
		8 => 'Profile',
	];

	/**
	 * Function to get instance
	 * @param boolean true/false
	 * @return <Settings_Menu_Module_Model>
	 */
	public static function getInstance()
	{
		$instance = new self();
		return $instance;
	}

	public function getMenuTypes($key = false)
	{
		if ($key === false)
			return $this->types;
		return $this->types[$key];
	}

	public function getMenuTypeKey($val)
	{
		return array_search($val, $this->types);
	}

	public function getMenuName($row, $settings = false)
	{
		switch ($row['type']) {
			case 0: $name = empty($row['label']) ? $row['name'] : $row['label'];
				break;
			case 3: $name = 'LBL_SEPARATOR';
				break;
			case 5:
				if ($row['label'] != '') {
					$name = $row['label'];
				} elseif ($settings) {
					$name = \App\Language::translate('LBL_QUICK_CREATE_MODULE', 'Menu') . ': ' . Vtiger_Menu_Model::vtranslateMenu('SINGLE_' . $row['name'], $row['name']);
				}
				break;
			case 6: $name = 'LBL_HOME';
				break;
			case 7:
				$query = (new \App\Db\Query())->select('viewname, entitytype')->from('vtiger_customview')->where(['cvid' => $row['dataurl']]);
				$data = $query->one();
				if ($settings) {
					$name = Vtiger_Menu_Model::vtranslateMenu($data['entitytype'], $data['entitytype']) . ': ' . \App\Language::translate($data['viewname'], $data['entitytype']);
				} else {
					$name = Vtiger_Menu_Model::vtranslateMenu($data['viewname'], $data['entitytype']);
				}
				break;
			default: $name = $row['label'];
				break;
		}
		return $name;
	}

	public function getMenuUrl($row)
	{
		switch ($row['type']) {
			case 0:
				$moduleModel = Vtiger_Module_Model::getInstance($row['module']);
				$url = $moduleModel->getDefaultUrl() . '&mid=' . $row['id'] . '&parent=' . $row['parentid'];
				break;
			case 1: $url = $row['dataurl'];
				break;
			case 4: $url = addslashes($row['dataurl']);
				break;
			case 7: $url = 'index.php?module=' . $row['name'] . '&view=List&viewname=' . $row['dataurl'] . '&mid=' . $row['id'] . '&parent=' . $row['parentid'];
				break;
			default: $url = null;
				break;
		}
		return $url;
	}

	public function getModulesList()
	{
		$notInParam = "('Home','Reports','RecycleBin','OSSMail','Portal','Rss')";
		$query = (new \App\Db\Query())->select('tabid, name')->from('vtiger_tab')
			->where(['not in', 'name', ['Users', 'ModComments']])
			->andWhere(['or', 'isentitytype = 1', "name IN $notInParam"])
			->orderBy('name');
		$dataReader = $query->createCommand()->query();
		$modules = $dataReader->readAll();
		return $modules;
	}

	public static function getLastId()
	{
		$maxSequence = (new \App\Db\Query())
			->from('yetiforce_menu')
			->max('id');
		return (int) $maxSequence;
	}

	/**
	 * Function to get all filters
	 * @return array
	 */
	public function getCustomViewList()
	{
		$filters = (new \App\Db\Query())->select('cvid, viewname, entitytype, vtiger_tab.tabid')
				->from('vtiger_customview')
				->leftJoin('vtiger_tab', 'vtiger_tab.name = vtiger_customview.entitytype')->all();
		foreach (Vtiger_Module_Model::getAll() as $module) {
			$filterDir = 'modules' . DIRECTORY_SEPARATOR . $module->get('name') . DIRECTORY_SEPARATOR . 'filters';
			if (file_exists($filterDir)) {
				$fileFilters = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($filterDir, FilesystemIterator::SKIP_DOTS));
				foreach ($fileFilters as $filter) {
					$name = str_replace('.php', '', $filter->getFilename());
					$handlerClass = Vtiger_Loader::getComponentClassName('Filter', $name, $module->get('name'));
					if (class_exists($handlerClass)) {
						$filters[] = [
							'viewname' => (new $handlerClass())->getViewName(),
							'cvid' => $name,
							'entitytype' => $module->get('name'),
							'tabid' => $module->getId(),
						];
					}
				}
			}
		}
		return $filters;
	}
}
