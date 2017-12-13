<?php
namespace App\Integrations;

/**
 * Pbx main class
 * @package YetiForce.App
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Pbx extends \App\Base
{

	/**
	 * Connector Instances
	 * @var \App\Integrations\className[] 
	 */
	private static $connectors = [];

	/**
	 * Get pbx connectors
	 * @return \App\Integrations\className
	 */
	public static function getConnectors()
	{
		$connectors = [];
		foreach ((new \DirectoryIterator(__DIR__ . DIRECTORY_SEPARATOR . 'Pbx')) as $fileInfo) {
			$fileName = $fileInfo->getBasename('.php');
			if ($fileInfo->getType() !== 'dir' && $fileName !== 'Base' && $fileInfo->getExtension() === 'php') {
				$className = '\App\Integrations\Pbx\\' . $fileName;
				if (!class_exists($className)) {
					\App\Log::warning('Not found Pbx class');
					continue;
				}
				$instance = new $className();
				$connectors[$fileName] = $instance;
			}
		}
		return $connectors;
	}

	/**
	 * Get connector instance
	 * @param string $name
	 * @return boolean|\App\Integrations\className
	 */
	public static function getConnectorInstance($name)
	{
		$className = '\App\Integrations\Pbx\\' . $name;
		if (isset(static::$connectors[$className])) {
			return static::$connectors[$className];
		}
		if (!class_exists($className)) {
			\App\Log::warning('Not found Pbx class');
		} else {
			return static::$connectors[$className] = new $className();
		}
		return false;
	}

	/**
	 * Whether a call is active with the PBX integration
	 * @return boolean
	 */
	public static function isActive()
	{
		$phone = \App\User::getCurrentUserModel()->getDetail('phone_crm_extension');
		if (empty($phone)) {
			return false;
		}
		return (new \App\Db\Query())->from('s_#__pbx')->where(['default' => 1])->exists();
	}

	/**
	 * Get default pbx instance
	 * @return \self
	 */
	public static function getDefaultInstance()
	{
		$data = (new \App\Db\Query())->from('s_#__pbx')->where(['default' => 1])->one();
		$instance = new self();
		$instance->setData($data);
		return $instance;
	}

	/**
	 * Load user phone
	 */
	public function loadUserPhone()
	{
		$this->set('sourcePhone', \App\User::getCurrentUserModel()->getDetail('phone_crm_extension'));
	}

	/**
	 * Perform phone call
	 * @param string $targetPhone
	 * @throws \Exception
	 */
	public function performCall($targetPhone)
	{
		if ($this->isEmpty('sourcePhone')) {
			throw new \Exception('No user phone number');
		}
		if (empty($targetPhone)) {
			throw new \Exception('No target phone number');
		}
		$this->set('targetPhone', $targetPhone);
		$connector = static::getConnectorInstance($this->get('type'));
		if (empty($connector)) {
			throw new \Exception('No PBX connector found');
		}
		$connector->performCall($this);
	}

	/**
	 * Function to get the confog param for a given key
	 * @param string $key
	 * @return mixed Value for the given key
	 */
	public function getConfig($key)
	{
		if ($this->isEmpty('paramArray')) {
			$this->set('paramArray', \App\Json::decode($this->get('param')));
		}
		$param = $this->get('paramArray');
		return isset($param[$key]) ? $param[$key] : null;
	}
}
