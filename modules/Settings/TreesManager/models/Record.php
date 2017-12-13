<?php

/**
 * Settings TreesManager record model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_TreesManager_Record_Model extends Settings_Vtiger_Record_Model
{

	/**
	 * Function to get the Id
	 * @return <Number> Role Id
	 */
	public function getId()
	{
		return $this->get('templateid');
	}

	/**
	 * Function to get the Role Name
	 * @return string
	 */
	public function getName()
	{
		return $this->get('rolename');
	}

	/**
	 * Function to get module of this record instance
	 * @return Settings_TreesManager_Record_Model $moduleModel
	 */
	public function getModule()
	{
		return $this->module;
	}

	/**
	 * Function to get the Edit View Url for the Role
	 * @return string
	 */
	public function getEditViewUrl()
	{
		return 'index.php?module=TreesManager&parent=Settings&view=Edit&record=' . $this->getId();
	}

	/**
	 * Function to get the Delete Action Url for the current role
	 * @return string
	 */
	public function getDeleteUrl()
	{
		return '?module=TreesManager&parent=Settings&action=Delete&record=' . $this->getId();
	}

	/**
	 * Function to get Detail view url
	 * @return string Url
	 */
	public function getDetailViewUrl()
	{
		return "index.php?module=TreesManager&parent=Settings&view=Edit&record=" . $this->getId();
	}

	/**
	 * Function to get List view url
	 * @return string Url
	 */
	public function getListViewUrl()
	{
		return "index.php?module=TreesManager&parent=Settings&view=List";
	}

	/**
	 * Function to get record links
	 * @return <Array> list of link models <Vtiger_Link_Model>
	 */
	public function getRecordLinks()
	{
		$links = [];
		$recordLinks = array(
			array(
				'linktype' => 'LISTVIEWRECORD',
				'linklabel' => 'LBL_EDIT',
				'linkurl' => $this->getEditViewUrl(),
				'linkicon' => 'glyphicon glyphicon-pencil'
			),
			array(
				'linktype' => 'LISTVIEWRECORD',
				'linklabel' => 'LBL_DELETE',
				'linkurl' => "javascript:Settings_Vtiger_List_Js.triggerDelete(event,'" . $this->getDeleteUrl() . "');",
				'linkicon' => 'glyphicon glyphicon-trash'
			)
		);
		foreach ($recordLinks as $recordLink) {
			$links[] = Vtiger_Link_Model::getInstanceFromValues($recordLink);
		}
		return $links;
	}

	/**
	 * Function to save the role
	 * @param array $tree
	 * @param int $depth
	 * @param string $parenttrre
	 */
	public function insertData($tree, $depth, $parenttrre)
	{
		$label = $tree['text'];
		$id = $tree['id'];
		$treeID = 'T' . $id;
		$icon = $tree['icon'] === 1 ? '' : $tree['icon'];
		if ($parenttrre != '')
			$parenttrre = $parenttrre . '::';
		$parenttrre = $parenttrre . $treeID;
		$params = [
			'templateid' => $this->getId(),
			'name' => $label,
			'tree' => $treeID,
			'parenttrre' => $parenttrre,
			'depth' => $depth,
			'label' => $label,
			'state' => $tree['state'] ? \App\Json::encode($tree['state']) : '',
			'icon' => $icon
		];
		App\Db::getInstance()->createCommand()->insert('vtiger_trees_templates_data', $params)->execute();
		if (!empty($tree['children'])) {
			foreach ($tree['children'] as $tree) {
				$this->insertData($tree, $depth + 1, $parenttrre);
				if ($tree['metadata']['replaceid'])
					$this->replaceValue($tree, $this->getId());
			}
		}
	}

	/**
	 * Get tree
	 * @param string $category
	 * @param string $treeValue
	 * @return boolean|array
	 */
	public function getTree($category = false, $treeValue = false)
	{
		$tree = [];
		$templateId = $this->getId();
		if (empty($templateId))
			return $tree;

		$lastId = 0;
		$dataReader = (new App\Db\Query())->from('vtiger_trees_templates_data')
				->where(['templateid' => $templateId])
				->createCommand()->query();
		$module = $this->get('module');
		if (is_numeric($module)) {
			$module = App\Module::getModuleName($module);
		}
		while ($row = $dataReader->read()) {
			$treeID = (int) str_replace('T', '', $row['tree']);
			$cut = strlen('::' . $row['tree']);
			$parenttrre = substr($row['parenttrre'], 0, - $cut);
			$pieces = explode('::', $parenttrre);
			$parent = (int) str_replace('T', '', end($pieces));
			$parameters = [
				'id' => $treeID,
				'parent' => $parent === 0 ? '#' : $parent,
				'text' => \App\Language::translate($row['name'], $module),
				'state' => ($row['state']) ? \App\Json::decode($row['state']) : '',
				'icon' => $row['icon']
			];
			if ($category) {
				$parameters['type'] = $category;
				if ($treeValue && strpos($treeValue, ",{$row['tree']},") !== false) {
					$parameters[$category] = ['checked' => true];
				}
			}
			$tree[] = $parameters;
			if ($treeID > $lastId)
				$lastId = $treeID;
		}
		$this->set('lastId', $lastId);
		return $tree;
	}

	/**
	 * Get
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		$val = parent::get($key);
		if ($key === 'share') {
			if ($val) {
				$val = !is_array($val) ? array_filter(explode(',', $val)) : $val;
			} else {
				$val = [];
			}
		}
		return $val;
	}

	/**
	 * Function to save the tree
	 */
	public function save()
	{
		$db = App\Db::getInstance();
		$templateId = $this->getId();
		$share = $this->get('share') ? ',' . implode(',', $this->get('share')) . ',' : '';
		if (empty($templateId)) {
			$db->createCommand()
				->insert('vtiger_trees_templates', ['name' => $this->get('name'), 'module' => $this->get('module'), 'share' => $share])
				->execute();
			$this->set('templateid', $db->getLastInsertID('vtiger_trees_templates_templateid_seq'));
			foreach ($this->get('tree') as $tree) {
				$this->insertData($tree, 0, '');
			}
		} else {
			$db->createCommand()
				->update('vtiger_trees_templates', ['name' => $this->get('name'), 'module' => $this->get('module'), 'share' => $share], ['templateid' => $templateId])
				->execute();
			$db->createCommand()->delete('vtiger_trees_templates_data', ['templateid' => $templateId])
				->execute();
			foreach ($this->get('tree') as $tree) {
				$this->insertData($tree, 0, '');
			}
		}
		if ($this->get('replace')) {
			$this->replaceValue($this->get('replace'), $templateId);
		}
		$this->clearCache();
	}

	/**
	 * Function to replaces value in module records
	 * @param array $tree
	 * @param int $templateId
	 */
	public function replaceValue($tree, $templateId)
	{
		$db = App\Db::getInstance();
		$modules = $this->get('share');
		$modules[] = $this->get('module');
		$dataReader = (new App\Db\Query())->select(['tablename', 'columnname', 'uitype'])
				->from('vtiger_field')
				->where(['tabid' => $modules, 'fieldparams' => (string) $templateId, 'presence' => [0, 2]])
				->createCommand()->query();
		while ($row = $dataReader->read()) {
			$tableName = $row['tablename'];
			$columnName = $row['columnname'];
			foreach ($tree as $treeRow) {
				$params = [];
				foreach ($treeRow['old'] as $new) {
					$params[] = $row['uitype'] === 309 ? ",T{$new}," : 'T' . $new;
				}
				$newVal = 'T' . current($treeRow['new']);
				if ($row['uitype'] === 309) {
					$newVal = ",{$newVal},";
				}
				$db->createCommand()
					->update($tableName, [$columnName => $newVal], [$columnName => $params])
					->execute();
			}
		}
	}

	/**
	 * Function to delete the role
	 */
	public function delete()
	{
		$db = App\Db::getInstance();
		$templateId = $this->getId();
		$db->createCommand()
			->delete('vtiger_trees_templates', ['templateid' => $templateId])
			->execute();
		$db->createCommand()
			->delete('vtiger_trees_templates_data', ['templateid' => $templateId])
			->execute();
		$this->clearCache();
	}

	public static function getChildren($fieldValue, $fieldName, $moduleModel)
	{

		$templateId = (new App\Db\Query())->select(['fieldparams'])
			->from('vtiger_field')
			->where(['tabid' => $moduleModel->getId(), 'columnname' => $fieldName, 'presence' => [0, 2]])
			->scalar();
		$values = explode(',', $fieldValue);
		$dataReader = (new App\Db\Query())->from('vtiger_trees_templates_data')
				->where(['templateid' => $templateId])
				->createCommand()->query();
		while ($row = $dataReader->read()) {
			$tree = $row['tree'];
			$parent = '';
			if ($row['depth'] > 0) {
				$parenttrre = $row['parenttrre'];
				$cut = strlen('::' . $tree);
				$parenttrre = substr($parenttrre, 0, - $cut);
				$pieces = explode('::', $parenttrre);
				$parent = end($pieces);
			}
			if ($parent && in_array($parent, $values) && !in_array($tree, $values)) {
				$values[] = $tree;
			}
		}
		return implode(',', $values);
	}

	/**
	 * Function to get the instance of Role model, given role id
	 * @param integer $record
	 * @return Settings_Roles_Record_Model instance, if exists. Null otherwise
	 */
	public static function getInstanceById($record)
	{
		$row = (new \App\Db\Query())->from('vtiger_trees_templates')->where(['templateid' => $record])
			->one();
		if ($row) {
			$instance = new self();
			$instance->setData($row);
			return $instance;
		}
		return null;
	}

	/**
	 * Function clears cache
	 */
	public function clearCache()
	{
		\App\Cache::delete('TreeValuesById', $this->getId());
	}
}
