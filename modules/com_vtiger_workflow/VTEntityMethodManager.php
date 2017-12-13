<?php
/* +*******************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * **************************************************************************** */

/**
 * Class VTEntityMethodManager
 */
class VTEntityMethodManager
{

	/**
	 * Add entity method
	 * @param string $moduleName
	 * @param string $methodName
	 * @param string $functionPath
	 * @param string $functionName
	 */
	public function addEntityMethod($moduleName, $methodName, $functionPath, $functionName)
	{
		$db = \App\Db::getInstance();
		$id = $db->getUniqueId("com_vtiger_workflowtasks_entitymethod");
		$db->createCommand()
			->insert('com_vtiger_workflowtasks_entitymethod', [
				'workflowtasks_entitymethod_id' => $id,
				'module_name' => $moduleName,
				'function_path' => $functionPath,
				'function_name' => $functionName,
				'method_name' => $methodName
			])->execute();
	}

	/**
	 * Execute method
	 * @param Vtiger_Record_Model $recordModel
	 * @param string $methodName
	 */
	public function executeMethod(Vtiger_Record_Model $recordModel, $methodName)
	{
		$moduleName = $recordModel->getModuleName();
		$data = (new \App\Db\Query())->select(['function_path', 'function_name'])->from('com_vtiger_workflowtasks_entitymethod')->where(['module_name' => $moduleName, 'method_name' => $methodName])->one();
		if ($data) {
			$functionPath = $data['function_path'];
			$functionName = $data['function_name'];
			require_once($functionPath);
			$functionName($recordModel);
		}
	}

	/**
	 * Get methods for module
	 * @param string $moduleName
	 * @return array
	 */
	public function methodsForModule($moduleName)
	{
		return (new \App\Db\Query())->select(['method_name'])->from('com_vtiger_workflowtasks_entitymethod')->where(['module_name' => $moduleName])->column();
	}
	/*
	  private function methodExists($object, $methodName){
	  $className = get_class($object);
	  $class = new ReflectionClass($className);
	  $methods = $class->getMethods();
	  foreach($methods as $method){
	  if($method->getName()==$methodName){
	  return true;
	  }
	  }
	  return false;
	  } */

	/**
	 * Function to remove workflowtasks entity method
	 * @param string $moduleName Module Name
	 * @param string $methodName Entity Method Name.
	 */
	public function removeEntityMethod($moduleName, $methodName)
	{
		\App\Db::getInstance()->createCommand()->delete('com_vtiger_workflowtasks_entitymethod', ['module_name' => $moduleName, 'method_name' => $methodName])->execute();
	}
}
