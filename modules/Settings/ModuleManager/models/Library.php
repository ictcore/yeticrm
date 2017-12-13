<?php

/**
 * Module Manager Library class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_ModuleManager_Library_Model
{

	/**
	 * List of all installation libraries
	 * @var array
	 */
	public static $libraries = [
		'mPDF' => ['dir' => 'libraries/mPDF/', 'url' => 'https://github.com/YetiForceCompany/lib_mPDF', 'name' => 'lib_mPDF'],
		'roundcube' => ['dir' => 'public_html/modules/OSSMail/roundcube/', 'url' => 'https://github.com/YetiForceCompany/lib_roundcube', 'name' => 'lib_roundcube'],
		'PHPExcel' => ['dir' => 'libraries/PHPExcel/', 'url' => 'https://github.com/YetiForceCompany/lib_PHPExcel', 'name' => 'lib_PHPExcel'],
		'Gantt' => ['dir' => 'public_html/libraries/gantt/', 'url' => 'https://github.com/YetiForceCompany/lib_gantt', 'name' => 'lib_gantt'],
	];

	/**
	 * Path to save temporary files
	 * @var string
	 */
	const TEMP_DIR = 'cache' . DIRECTORY_SEPARATOR . 'upload';

	/**
	 * Function to check library status
	 * @param string $name
	 * @return boolean
	 */
	public static function checkLibrary($name)
	{
		if (App\Cache::has('LIBRARY', $name)) {
			return App\Cache::get('LIBRARY', $name);
		}
		$status = true;
		if (static::$libraries[$name]) {
			$lib = static::$libraries[$name];
			if (file_exists($lib['dir'] . 'version.php')) {
				$libVersion = require $lib['dir'] . 'version.php';
				if (App\Version::check($libVersion['version'], $lib['name'])) {
					$status = false;
				}
			}
		}
		App\Cache::save('LIBRARY', $name, $status, App\Cache::LONG);
		return $status;
	}

	/**
	 * Get a list of all libraries and their statuses
	 * @return array
	 */
	public static function &getAll()
	{
		$libs = [];
		foreach (static::$libraries as $name => $lib) {
			$status = 0;
			if (is_dir($lib['dir'])) {
				$status = 2;
				if (file_exists($lib['dir'] . 'version.php')) {
					$libVersion = require $lib['dir'] . 'version.php';
					if (App\Version::check($libVersion['version'], $lib['name'])) {
						$status = 1;
					}
				}
			}
			$lib['status'] = $status;
			$libs[$name] = $lib;
		}
		return $libs;
	}

	/**
	 * Download all missing libraries
	 * @throws \Exception\NoPermitted
	 */
	public static function downloadAll()
	{
		foreach (static::$libraries as $name => &$lib) {
			static::download($name);
		}
	}

	/**
	 * Function to download library
	 * @param string $name
	 * @return boolean
	 * @throws \Exception\NoPermitted
	 */
	public static function download($name)
	{
		if (!static::$libraries[$name]) {
			App\Log::warning('Library does not exist: ' . $name);
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}

		$lib = static::$libraries[$name];
		if (file_exists($lib['dir'] . 'version.php')) {
			App\Log::info('Library has already been downloaded: ' . $name);
			return false;
		}
		$path = static::TEMP_DIR . DIRECTORY_SEPARATOR . $lib['name'] . '.zip';
		$mode = AppConfig::developer('MISSING_LIBRARY_DEV_MODE') ? 'developer' : App\Version::get($lib['name']);
		$compressedName = $lib['name'] . '-' . $mode;
		if (!file_exists($path)) {
			stream_context_set_default([
				'ssl' => [
					'verify_peer' => true,
					'verify_peer_name' => true,
				],
			]);
			$url = $lib['url'] . "/archive/$mode.zip";
			$headers = get_headers($url, 1);
			if (isset($headers['Status']) && strpos($headers['Status'], '302') !== false) {
				App\Log::trace('Started downloading library: ' . $name);
				if ($file = file_get_contents($url, false, stream_context_create(['ssl' => ['verify_peer' => true, 'verify_peer_name' => true]]))) {
					file_put_contents($path, $file);
					App\Log::trace('Completed downloads library: ' . $name);
				}
			} else {
				App\Log::warning('Can not connect to the server' . $url);
			}
		}
		if (file_exists($path) && filesize($path) > 0) {
			$zip = new \App\Zip($path, ['checkFiles' => false]);
			$zip->unzip([$compressedName => $lib['dir']]);
			unlink($path);
		} else {
			App\Log::warning('No import file: ' . $name);
		}
	}

	/**
	 * Function to update library
	 * @param string $name
	 * @throws \Exception\NoPermitted
	 */
	public static function update($name)
	{
		$lib = static::$libraries[$name];
		\vtlib\Functions::recurseDelete($lib['dir']);
		static::download($name);
	}
}
