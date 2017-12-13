<?php

/**
 * Vtiger menu model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Vtiger_Menu_Model
{

	/**
	 * Static Function to get all the accessible menu models with/without ordering them by sequence
	 * @param boolean $sequenced - true/false
	 * @return <Array> - List of Vtiger_Menu_Model instances
	 */
	public static function getAll($sequenced = false, $restrictedModulesList = [])
	{
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$userPrivModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();

		$roleMenu = 'user_privileges/menu_' . filter_var($userPrivModel->get('roleid'), FILTER_SANITIZE_NUMBER_INT) . '.php';
		if (file_exists($roleMenu)) {
			require($roleMenu);
		} else {
			require('user_privileges/menu_0.php');
		}
		if (count($menus) == 0) {
			require('user_privileges/menu_0.php');
		}
		return $menus;
	}

	public static function vtranslateMenu($key, $module)
	{
		$language = \App\Language::getLanguage();
		$moduleStrings = Vtiger_Language_Handler::getModuleStringsFromFile($language, 'Menu');
		if (isset($moduleStrings['languageStrings'][$key])) {
			return stripslashes($moduleStrings['languageStrings'][$key]);
		}
		return Vtiger_Language_Handler::getTranslatedString($key, $module);
	}

	public static function getBreadcrumbs($pageTitle = false)
	{
		$breadcrumbs = false;
		$request = App\Request::init();
		$userPrivModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$roleMenu = 'user_privileges/menu_' . filter_var($userPrivModel->get('roleid'), FILTER_SANITIZE_NUMBER_INT) . '.php';
		if (file_exists($roleMenu)) {
			require($roleMenu);
		} else {
			require('user_privileges/menu_0.php');
		}
		if (count($menus) == 0) {
			require('user_privileges/menu_0.php');
		}
		$moduleName = $request->getModule();
		$view = $request->get('view');
		$parent = $request->get('parent');
		if ($parent !== 'Settings') {
			if (empty($parent)) {
				foreach ($parentList as &$parentItem) {
					if ($moduleName === $parentItem['mod']) {
						$parent = $parentItem['parent'];
						break;
					}
				}
			}
			$parentMenu = self::getParentMenu($parentList, $parent, $moduleName);
			if (count($parentMenu) > 0) {
				$breadcrumbs = array_reverse($parentMenu);
			}
			$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
			if ($moduleModel && $moduleModel->getDefaultUrl()) {
				$breadcrumbs[] = [
					'name' => \App\Language::translate($moduleName, $moduleName),
					'url' => $moduleModel->getDefaultUrl()
				];
			} else {
				$breadcrumbs[] = [
					'name' => \App\Language::translate($moduleName, $moduleName)
				];
			}

			if ($pageTitle) {
				$breadcrumbs[] = ['name' => App\Language::translate($pageTitle, $moduleName)];
			} elseif ($view == 'Edit' && $request->get('record') === '') {
				$breadcrumbs[] = ['name' => App\Language::translate('LBL_VIEW_CREATE', $moduleName)];
			} elseif ($view != '' && $view != 'index' && $view != 'Index') {
				$breadcrumbs[] = ['name' => App\Language::translate('LBL_VIEW_' . strtoupper($view), $moduleName)];
			} elseif ($view == '') {
				$breadcrumbs[] = ['name' => App\Language::translate('LBL_HOME', $moduleName)];
			}
			if ($request->get('record') != '') {
				$recordLabel = vtlib\Functions::getCRMRecordLabel($request->get('record'));
				if ($recordLabel != '') {
					$breadcrumbs[] = ['name' => $recordLabel];
				}
			}
		} elseif ($parent === 'Settings') {
			$qualifiedModuleName = $request->getModule(false);
			$breadcrumbs[] = [
				'name' => \App\Language::translate('LBL_VIEW_SETTINGS', $qualifiedModuleName),
				'url' => 'index.php?module=Vtiger&parent=Settings&view=Index',
			];
			if ($moduleName !== 'Vtiger' || $view !== 'Index') {
				$fieldId = $request->get('fieldid');
				$menu = Settings_Vtiger_MenuItem_Model::getAll();
				foreach ($menu as &$menuModel) {
					if (empty($fieldId)) {
						if ($menuModel->getModule() === $moduleName) {
							$parent = $menuModel->getMenu();
							$breadcrumbs[] = ['name' => App\Language::translate($parent->get('label'), $qualifiedModuleName)];
							$breadcrumbs[] = ['name' => App\Language::translate($menuModel->get('name'), $qualifiedModuleName),
								'url' => $menuModel->getUrl()
							];
							break;
						}
					} else {
						if ($fieldId == $menuModel->getId()) {
							$parent = $menuModel->getMenu();
							$breadcrumbs[] = ['name' => App\Language::translate($parent->get('label'), $qualifiedModuleName)];
							$breadcrumbs[] = ['name' => App\Language::translate($menuModel->get('name'), $qualifiedModuleName),
								'url' => $menuModel->getUrl()
							];
							break;
						}
					}
				}
				if (is_array($pageTitle)) {
					foreach ($pageTitle as $title) {
						$breadcrumbs[] = $title;
					}
				} else {
					if ($pageTitle) {
						$breadcrumbs[] = ['name' => App\Language::translate($pageTitle, $qualifiedModuleName)];
					} elseif ($view == 'Edit' && $request->get('record') == '' && $request->get('parent_roleid') == '') {
						$breadcrumbs[] = ['name' => App\Language::translate('LBL_VIEW_CREATE', $qualifiedModuleName)];
					} elseif ($view != '' && $view != 'List') {
						$breadcrumbs[] = ['name' => App\Language::translate('LBL_VIEW_' . strtoupper($view), $qualifiedModuleName)];
					}
					if ($request->get('record') != '' && $moduleName === 'Users') {
						$recordLabel = \App\Fields\Owner::getUserLabel($request->get('record'));
						if ($recordLabel != '') {
							$breadcrumbs[] = ['name' => $recordLabel];
						}
					}
				}
			}
		}
		return $breadcrumbs;
	}

	public static function getParentMenu($parentList, $parent, $module, $return = [])
	{
		if ($parent != 0 && key_exists($parent, $parentList)) {
			$return [] = [
				'name' => self::vtranslateMenu($parentList[$parent]['name'], $module),
				'url' => $parentList[$parent]['url'],
			];
			if ($parentList[$parent]['parent'] != 0 && key_exists($parentList[$parent]['parent'], $parentList)) {
				$return = self::getParentMenu($parentList, $parentList[$parent]['parent'], $module, $return);
			}
		}
		return $return;
	}

	/**
	 * 
	 * @param type $url
	 * @return type modulename 
	 */
	public static function getModuleNameFromUrl($url)
	{
		$params = vtlib\Functions::getQueryParams($url);
		if ($params['parent']) {
			return ($params['parent'] . ':' . $params['module']);
		}
		return $params['module'];
	}

	/**
	 * Function to get icon of element in menu
	 * @param string|array $menu
	 * @param string $title
	 * @return string|boolean
	 */
	public static function getMenuIcon($menu, $title = '')
	{
		if ($title == '') {
			$title = Vtiger_Menu_Model::vtranslateMenu($menu['label']);
		}
		if (is_string($menu)) {
			$iconName = \Vtiger_Theme::getImagePath($menu);
			if (file_exists($iconName)) {
				return '<img src="' . $iconName . '" alt="' . $title . '" title="' . $title . '" class="menuIcon" />';
			}
		}
		if (!empty($menu['icon'])) {
			if (strpos($menu['icon'], 'glyphicon-') !== false) {
				return '<span class="glyphicon ' . $menu['icon'] . '" aria-hidden="true"></span>';
			} elseif (strpos($menu['icon'], 'fa-') !== false) {
				return '<span class="' . $menu['icon'] . '" aria-hidden="true"></span>';
			} elseif (strpos($menu['icon'], 'adminIcon-') !== false || strpos($menu['icon'], 'userIcon-') !== false || strpos($menu['icon'], 'AdditionalIcon-') !== false) {
				return '<span class="menuIcon ' . $menu['icon'] . '" aria-hidden="true"></span>';
			}
			$icon = \Vtiger_Theme::getImagePath($menu['icon']);
			if ($icon) {
				return '<img src="' . $icon . '" alt="' . $title . '" title="' . $title . '" class="menuIcon" />';
			}
		}
		if (isset($menu['type']) && $menu['type'] == 'Module') {
			return '<span class="menuIcon userIcon-' . $menu['mod'] . '" aria-hidden="true"></span>';
		}
		return '';
	}
}
