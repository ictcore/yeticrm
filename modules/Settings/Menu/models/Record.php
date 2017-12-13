<?php

/**
 * Settings menu record model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Settings_Menu_Record_Model extends Settings_Vtiger_Record_Model
{

	/**
	 * Function to get Id of this record instance
	 * @return <Integer> Id
	 */
	public function getId()
	{
		return $this->get('id');
	}

	/**
	 * Function to get Name of this record instance
	 * @return string Name
	 */
	public function getName()
	{
		return $this->get('name');
	}

	public function getAll($roleId)
	{

		$settingsModel = Settings_Menu_Module_Model::getInstance();
		$query = (new \App\Db\Query())->select('yetiforce_menu.*, vtiger_tab.name')->from('yetiforce_menu')
				->leftJoin('vtiger_tab', 'vtiger_tab.tabid = yetiforce_menu.module')->where(['role' => $roleId])->orderBy('yetiforce_menu.sequence, yetiforce_menu.parentid');
		$dataReader = $query->createCommand()->query();
		$menu = [];
		while ($row = $dataReader->read()) {
			$menu[] = [
				'id' => $row['id'],
				'parent' => $row['parentid'] == 0 ? '#' : $row['parentid'],
				'text' => Vtiger_Menu_Model::vtranslateMenu($settingsModel->getMenuName($row, true), $row['name']),
				'icon' => 'menu-icon-' . $settingsModel->getMenuTypes($row['type'])
			];
		}
		return $menu;
	}

	public static function getCleanInstance()
	{
		$instance = new self();
		return $instance;
	}

	public static function getInstanceById($id)
	{
		$query = (new \App\Db\Query())->from('yetiforce_menu')->where(['id' => $id]);
		$row = $query->one();
		if ($row === false)
			return false;
		$instance = new self();
		$instance->setData($row);
		return $instance;
	}

	public function initialize($data)
	{
		$this->setData($data);
	}

	public function save()
	{
		$db = \App\Db::getInstance();
		$settingsModel = Settings_Menu_Module_Model::getInstance();
		$edit = $this->get('edit');
		$params = [];
		$sqlCol = '';
		$role = 0;
		if ($edit) {
			$data = $this->getData();
			foreach ($data as $key => $item) {
				if (is_array($item)) {
					$item = implode(',', $item);
				}
				if ($key != 'id' && $key != 'edit') {
					$params[$key] = $item;
				}
			}
			if (!isset($data['newwindow'])) {
				$params['newwindow'] = 0;
			}
			if (!isset($data['filters'])) {
				$params['filters'] = '';
			}
			$db->createCommand()->update('yetiforce_menu', $params, ['id' => $this->getId()])->execute();
		} else {
			foreach ($this->getData() as $key => $item) {
				if (is_array($item)) {
					$item = implode(',', $item);
				}
				$sqlCol .= $key . ',';
				switch ($key) {
					case 'role': $role = $item = filter_var($item, FILTER_SANITIZE_NUMBER_INT);
						break;
					case 'type': $item = $settingsModel->getMenuTypeKey($item);
						break;
				}
				$params[] = $item;
			}
			$maxSequence = (new \App\Db\Query())->from('yetiforce_menu')->where(['role' => $role, 'parentid' => 0])->max('sequence');
			$max = (int) $maxSequence;
			$sqlCol .= 'sequence';
			$params[] = $max + 1;
			$sqlCol = explode(',', $sqlCol);
			foreach ($sqlCol as $key => $value) {
				$insertParams[$value] = $params[$key];
			}
			$db->createCommand()->insert('yetiforce_menu', $insertParams)->execute();
		}
		$this->generateFileMenu($this->get('role'));
	}

	public function saveSequence($data, $generate = false)
	{
		$db = \App\Db::getInstance();
		$role = 0;
		foreach ($data as $item) {
			$db->createCommand()->update('yetiforce_menu', ['sequence' => $item['s'], 'parentid' => $item['p']], ['id' => $item['i']])->execute();
			if (isset($item['c'])) {
				$this->saveSequence($item['c'], false);
			}
			$role = $item['r'];
		}
		if ($generate)
			$this->generateFileMenu($role);
	}

	/**
	 * Function removes menu items
	 * @param int[] $ids
	 */
	public function removeMenu($ids)
	{
		$db = \App\Db::getInstance();
		if (!is_array($ids)) {
			$ids = [$ids];
		}
		foreach ($ids as $id) {
			if (empty($id)) {
				continue;
			}
			$recordModel = Settings_Menu_Record_Model::getInstanceById($id);
			$query = (new \App\Db\Query())->select('id')->from('yetiforce_menu')->where(['parentid' => $id]);
			$dataReader = $query->createCommand()->query();
			while ($childId = $dataReader->readColumn(0)) {
				$this->removeMenu($childId);
			}
			$db->createCommand()->delete('yetiforce_menu', ['id' => $id])->execute();
			$this->generateFileMenu($recordModel->get('role'));
		}
	}

	public function getChildMenu($roleId, $parent)
	{
		$settingsModel = Settings_Menu_Module_Model::getInstance();
		$menu = [];
		$query = (new \App\Db\Query())->select(('yetiforce_menu.*, vtiger_tab.name'))
			->from('yetiforce_menu')
			->leftJoin('vtiger_tab', 'vtiger_tab.tabid = yetiforce_menu.module')
			->where(['role' => $roleId, 'parentid' => $parent])
			->orderBy(' yetiforce_menu.sequence', 'yetiforce_menu.parentid');
		$dataReader = $query->createCommand()->query();

		while ($row = $dataReader->read()) {
			$menu[] = [
				'id' => $row['id'],
				'tabid' => $row['module'],
				'mod' => $row['name'],
				'name' => $settingsModel->getMenuName($row),
				'type' => $settingsModel->getMenuTypes($row['type']),
				'sequence' => $row['sequence'],
				'newwindow' => $row['newwindow'],
				'dataurl' => $settingsModel->getMenuUrl($row),
				//'showicon' => $row['showicon'],
				'icon' => $row['icon'],
				//'sizeicon' => $row['sizeicon'],
				'parent' => $row['parentid'],
				'hotkey' => $row['hotkey'],
				'filters' => $row['filters'],
				'childs' => $this->getChildMenu($roleId, $row['id'])
			];
		}
		return $menu;
	}

	public function generateFileMenu($roleId)
	{
		$roleId = filter_var($roleId, FILTER_SANITIZE_NUMBER_INT);
		$menu = $this->getChildMenu($roleId, 0);
		$content = '<?php' . PHP_EOL . '$menus = [';
		foreach ($menu as $item) {
			$content .= $this->createContentMenu($item);
		}
		$content .= '];' . PHP_EOL . '$parentList = [';
		foreach ($menu as $item) {
			$content .= $this->createParentList($item);
		}
		$content .= '];' . PHP_EOL . '$filterList = [';
		foreach ($menu as $item) {
			$content .= $this->createFilterList($item);
		}
		$content .= '];';
		$file = ROOT_DIRECTORY . '/user_privileges/menu_' . $roleId . '.php';
		file_put_contents($file, $content);
	}

	public function createContentMenu($menu)
	{
		unset($menu['filters']);
		$content = $menu['id'] . '=>[';
		foreach ($menu as $key => $item) {
			if ($key == 'childs') {
				if (count($item) > 0) {
					$childs = var_export($key, true) . '=>[';
					foreach ($item as $child) {
						$childs .= $this->createContentMenu($child);
					}
					$childs .= '],';
					$content .= trim($childs, ',');
				}
			} else {
				$content .= var_export($key, true) . '=>' . var_export($item, true) . ',';
			}
		}
		$content = trim($content, ',') . '],';
		return $content;
	}

	public function createParentList($menu)
	{
		$content = $menu['id'] . '=>[';
		$content .= "'name'=>" . var_export($menu['name'], true) . ',';
		$content .= "'url'=>" . var_export($menu['dataurl'], true) . ',';
		$content .= "'parent'=>" . var_export($menu['parent'], true) . ',';
		$content .= "'mod'=>" . var_export($menu['mod'], true);
		$content .= '],';
		if (count($menu['childs']) > 0) {
			foreach ($menu['childs'] as $child) {
				$content .= $this->createParentList($child);
			}
		}
		return $content;
	}

	public function createFilterList($menu)
	{
		$content = '';
		if (!empty($menu['filters'])) {
			$content = $menu['id'] . '=>[';
			$content .= "'module'=>" . var_export($menu['mod'], true) . ",";
			$content .= "'filters'=>" . var_export($menu['filters'], true);
			$content .= '],';
		}
		if (count($menu['childs']) > 0) {
			foreach ($menu['childs'] as $child) {
				$content .= $this->createFilterList($child);
			}
		}
		return $content;
	}

	/**
	 * A function used to refresh menu files
	 */
	public function refreshMenuFiles()
	{
		$allRoles = Settings_Roles_Record_Model::getAll();
		$this->generateFileMenu(0);
		foreach ($allRoles as $role) {
			$roleId = str_replace('H', '', $role->getId());
			if (file_exists('user_privileges/menu_' . $roleId . '.php'))
				$this->generateFileMenu($roleId);
		}
	}

	public static function getIcons()
	{
		return ['userIcon-VirtualDesk', 'userIcon-Home', 'userIcon-CompaniesAndContact', 'userIcon-Campaigns', 'userIcon-Support', 'userIcon-Project', 'userIcon-Bookkeeping', 'userIcon-HumanResources', 'userIcon-Secretary', 'userIcon-Database', 'userIcon-Sales', 'userIcon-VendorsAccounts'];
	}

	public function getRolesContainMenu()
	{
		$allRoles = Settings_Roles_Record_Model::getAll();
		$menu = [];
		$counter = 0;
		foreach ($allRoles as $roleId => $value) {
			$hasMenu = $this->getAll(filter_var($roleId, FILTER_SANITIZE_NUMBER_INT));
			if ($hasMenu) {
				$menu[$counter]['roleName'] = $allRoles[$roleId]->get('rolename');
				$menu[$counter]['roleId'] = $roleId;
				$counter++;
			}
		}
		return $menu;
	}

	/**
	 * Function adds records to task queue that updates reviewing changes in records
	 * @param int $fromRole - Copy from role
	 * @param int $toRole - Copy to role
	 */
	public function copyMenu($fromRole, $toRole)
	{
		$db = \App\Db::getInstance();
		$nextId = $db->getUniqueID('yetiforce_menu', 'id', false);

		$query = (new \App\Db\Query())->from('yetiforce_menu')->where(['role' => $fromRole]);
		$dataReader = $query->createCommand()->query();
		$rows = $dataReader->readAll();

		if ($rows) {
			foreach ($rows as &$row) {
				$oldAndNewIds[$row['id']] = $nextId;
				$nextId += 1;
			}
			foreach ($rows as &$row) {
				if (array_key_exists($row['parentid'], $oldAndNewIds)) {
					$parentId = $oldAndNewIds[$row['parentid']];
				} else {
					$parentId = 0;
				}

				$params = [
					'role' => $toRole,
					'parentid' => $parentId,
					'type' => $row['type'],
					'sequence' => $row['sequence'],
					'module' => $row['module'],
					'label' => $row['label'],
					'newwindow' => $row['newwindow'],
					'dataurl' => $row['dataurl'],
					'showicon' => $row['showicon'],
					'icon' => $row['icon'],
					'sizeicon' => $row['sizeicon'],
					'hotkey' => $row['hotkey'],
					'filters' => $row['filters'],
				];
				$db->createCommand()->insert('yetiforce_menu', $params)->execute();
			}
			$this->generateFileMenu($toRole);
		}
	}
}
