<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * *********************************************************************************** */

class SMSNotifier_Module_Model extends Vtiger_Module_Model
{

	/**
	 * Function to check whether the module is an entity type module or not
	 * @return boolean true/false
	 */
	public function isQuickCreateSupported()
	{
		//SMSNotifier module is not enabled for quick create
		return false;
	}

	/**
	 * Function to check whether the module is summary view supported
	 * @return boolean - true/false
	 */
	public function isSummaryViewSupported()
	{
		return false;
	}

	/**
	 * Function to get the module is permitted to specific action
	 * @param string $actionName
	 * @return <boolean>
	 */
	public function isPermitted($actionName)
	{
		if ($actionName === 'EditView') {
			return false;
		}
		return Users_Privileges_Model::isPermitted($this->getName(), $actionName);
	}

	/**
	 * Function to get Settings links
	 * @return <Array>
	 */
	public function getSettingLinks()
	{
		Vtiger_Loader::includeOnce('~~modules/com_vtiger_workflow/VTWorkflowUtils.php');

		$editWorkflowsImagePath = Vtiger_Theme::getImagePath('EditWorkflows.png');
		$settingsLinks = [];


		if (VTWorkflowUtils::checkModuleWorkflow($this->getName())) {
			$settingsLinks[] = array(
				'linktype' => 'LISTVIEWSETTING',
				'linklabel' => 'LBL_EDIT_WORKFLOWS',
				'linkurl' => 'index.php?parent=Settings&module=Workflows&view=List&sourceModule=' . $this->getName(),
				'linkicon' => $editWorkflowsImagePath
			);
		}

		$settingsLinks[] = array(
			'linktype' => 'LISTVIEWSETTING',
			'linklabel' => \App\Language::translate('LBL_SERVER_CONFIG', $this->getName()),
			'linkurl' => 'index.php?module=SMSNotifier&parent=Settings&view=List',
			'linkicon' => ''
		);
		return $settingsLinks;
	}

	/**
	 * Function to get instance of provider model
	 * @param string $providerName
	 * @return boolean|\SMSNotifier_Basic_Provider
	 */
	public static function getProviderInstance($providerName)
	{
		if (!empty($providerName)) {
			$providerName = trim($providerName);
			$className = Vtiger_Loader::getComponentClassName('Provider', $providerName, 'SMSNotifier');
			if ($className && class_exists($className)) {
				return new $className();
			}
		}
		return false;
	}

	/**
	 * Function to get All providers
	 * @return \SMSNotifier_Basic_Provider[]
	 */
	public static function getProviders()
	{
		$iterator = new \DirectoryIterator(dirname(__FILE__) . '/../providers');
		foreach ($iterator as $item) {
			if ($item->isFile() && $item->getFilename() !== 'Basic.php' && $item->getExtension() === 'php') {
				$providers[] = self::getProviderInstance($item->getBasename('.php'));
			}
		}
		return $providers;
	}

	/**
	 * Function to get active provider
	 * @return \SMSNotifier_Basic_Provider[]
	 */
	public static function getActiveProviderInstance()
	{
		$cacheName = 'activeProviderInstance';
		if (\App\Cache::has('SMSNotifierConfig', $cacheName)) {
			return clone \App\Cache::get('SMSNotifierConfig', $cacheName);
		}
		$provider = false;
		$data = (new App\Db\Query())
			->from('a_#__smsnotifier_servers')
			->where(['isactive' => 1])
			->one();
		if ($data) {
			$provider = self::getProviderInstance($data['providertype']);
			if (!empty($data['parameters'])) {
				$parameters = \App\Json::decode(decode_html($data['parameters']));
				foreach ($parameters as $k => $v) {
					$provider->set($k, $v);
				}
			}
			$provider->set('api_key', $data['api_key']);
		}
		\App\Cache::save('SMSNotifierConfig', $cacheName, $provider, \App\Cache::LONG);
		return $provider;
	}

	/**
	 * Check server
	 * @return bool
	 */
	public static function checkServer()
	{
		$provider = self::getActiveProviderInstance();
		return ($provider !== false);
	}

	/**
	 * Adds sms notifications to cron
	 * @param string $message
	 * @param string[] $toNumbers
	 * @param int[] $recordIds
	 * @param string $ralModuleName
	 * @return int
	 */
	public static function addSmsToCron($message, $toNumbers, $recordIds, $ralModuleName)
	{
		return \App\Db::getInstance('admin')->createCommand()->insert('s_#__smsnotifier_queue', [
				'message' => $message,
				'tonumbers' => is_array($toNumbers) ? implode(',', $toNumbers) : $toNumbers,
				'records' => is_array($recordIds) ? implode(',', $recordIds) : $recordIds,
				'module' => $ralModuleName])->execute();
	}
}
