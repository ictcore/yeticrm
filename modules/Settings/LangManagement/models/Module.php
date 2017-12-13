<?php

/**
 * LangManagement Module Class
 * @package YetiForce.Settings.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author YetiForce.com
 */
class Settings_LangManagement_Module_Model extends Settings_Vtiger_Module_Model
{

	const url_separator = '^';

	/**
	 * Remove translation
	 * @param array $params
	 * @return (string|bool)[]
	 */
	public static function deleteTranslation($params)
	{
		$change = false;
		$langkey = $params['langkey'];
		foreach ($params['lang'] as $lang) {
			$edit = false;
			$mod = str_replace(self::url_separator, '.', $params['mod']);
			if (\AppConfig::performance('LOAD_CUSTOM_FILES')) {
				$qualifiedName = "custom.languages.$lang.$mod";
			} else {
				$qualifiedName = "languages.$lang.$mod";
			}
			$fileName = Vtiger_Loader::resolveNameToPath($qualifiedName);
			if (file_exists($fileName)) {
				$fileContent = file($fileName);
				foreach ($fileContent as $key => $file_row) {
					if (self::parse_data("'$langkey'", $file_row)) {
						unset($fileContent[$key]);
						$edit = $change = true;
					}
				}
				if ($edit) {
					$fileContent = implode("", $fileContent);
					$filePointer = fopen($fileName, 'w+');
					fwrite($filePointer, $fileContent);
					fclose($filePointer);
				}
			}
		}
		return $change ? ['success' => true, 'data' => 'LBL_DeleteTranslationOK'] : ['success' => false, 'data' => 'LBL_DELETE_TRANSLATION_FAILED'];
	}

	/**
	 * Save
	 * @param array $params
	 * @return array
	 */
	public static function saveTranslation($params)
	{
		if ($params['is_new'] == 'true') {
			$result = self::addTranslation($params);
		} else {
			$result = self::updateTranslation($params);
		}
		return $result;
	}

	/**
	 * Add translation
	 * @param array $params
	 * @return (string|bool)[]
	 */
	public static function addTranslation($params)
	{
		$lang = $params['lang'];
		$mod = $params['mod'];
		$langkey = addslashes($params['langkey']);
		$val = addslashes($params['val']);
		$mod = str_replace(self::url_separator, '.', $mod);

		if (\AppConfig::performance('LOAD_CUSTOM_FILES')) {
			$qualifiedName = "custom.languages.$lang.$mod";
		} else {
			$qualifiedName = "languages.$lang.$mod";
		}
		$fileName = Vtiger_Loader::resolveNameToPath($qualifiedName);
		$fileExists = file_exists($fileName);
		if ($fileExists) {
			require $fileName;
			if ($params['type'] === 'php') {
				$langTab = $languageStrings;
			} else {
				$langTab = $jsLanguageStrings;
			}
			if (is_array($langTab) && array_key_exists($langkey, $langTab)) {
				return ['success' => false, 'data' => 'LBL_KeyExists'];
			}
			$fileContent = file_get_contents($fileName);
			if ($params['type'] == 'php') {
				$to_replase = '$languageStrings = [';
			} else {
				$to_replase = '$jsLanguageStrings = [';
			}
			$new_translation = "'$langkey' => '$val',";
			if (self::parse_data($to_replase, $fileContent)) {
				$fileContent = str_ireplace($to_replase, $to_replase . PHP_EOL . '	' . $new_translation, $fileContent);
			} else {
				if (self::parse_data('?>', $fileContent)) {
					$fileContent = str_replace('?>', '', $fileContent);
				}
				$fileContent = $fileContent . PHP_EOL . $to_replase . PHP_EOL . '	' . $new_translation . PHP_EOL . '];';
			}
		} else {
			if (\AppConfig::performance('LOAD_CUSTOM_FILES')) {
				self::createCustomLangDirectory($params);
			}
			$fileContent = '<?php' . PHP_EOL;
		}
		$filePointer = fopen($fileName, 'w');
		fwrite($filePointer, $fileContent);
		fclose($filePointer);
		if (!$fileExists) {
			return self::addTranslation($params);
		}
		return ['success' => true, 'data' => 'LBL_AddTranslationOK'];
	}

	/**
	 * Function to update translation
	 * @param array $params
	 * @return (string|bool)[]
	 */
	public static function updateTranslation($params)
	{
		$lang = $params['lang'];
		$mod = $params['mod'];
		$langkey = $params['langkey'];
		$val = addslashes($params['val']);
		$mod = str_replace(self::url_separator, '.', $mod);
		$languageStrings = $jsLanguageStrings = [];
		$customType = \AppConfig::performance('LOAD_CUSTOM_FILES');
		if ($customType) {
			$qualifiedName = "custom.languages.$lang.$mod";
		} else {
			$qualifiedName = "languages.$lang.$mod";
		}
		$fileName = Vtiger_Loader::resolveNameToPath($qualifiedName);
		$fileExists = file_exists($fileName);
		if ($fileExists) {
			require($fileName);
			if ($params['type'] === 'php') {
				$langTab = $languageStrings;
			} else {
				$langTab = $jsLanguageStrings;
			}
			if (!is_array($langTab) || !array_key_exists($langkey, $langTab)) {
				if ($customType) {
					return self::addTranslation($params);
				}
				return array('success' => false, 'data' => 'LBL_DO_NOT_POSSIBLE_TO_MAKE_CHANGES');
			}
			$countLangEl = count(explode("\n", $langTab[$langkey]));
			$i = 1;
			$start = false;
			$fileContentEdit = file($fileName);
			foreach ($fileContentEdit as $k => $row) {
				if ($start && $i < $countLangEl) {
					unset($fileContentEdit[$k]);
					$i++;
				}
				if (strstr($row, "'$langkey'") !== false || strstr($row, '"' . $langkey . '"') !== false) {
					$fileContentEdit[$k] = "	'$langkey' => '$val'," . PHP_EOL;
					$start = true;
				}
			}
			$fileContent = implode("", $fileContentEdit);
		} else {
			if ($customType) {
				self::createCustomLangDirectory($params);
			}
			$fileContent = '<?php' . PHP_EOL;
		}
		$filePointer = fopen($fileName, 'w+');
		fwrite($filePointer, $fileContent);
		fclose($filePointer);
		if (!$fileExists) {
			self::updateTranslation($params);
		}
		return array('success' => true, 'data' => 'LBL_UpdateTranslationOK');
	}

	/**
	 * Function creates directory structure
	 * @param array $params
	 * @throws \Exception\AppException
	 */
	public static function createCustomLangDirectory($params)
	{
		$mod = explode(self::url_separator, $params['mod']);
		$folders = ['custom', 'languages', $params['lang']];
		if (count($mod) > 1) {
			$folders[] = 'Settings';
		}
		foreach ($folders as $key => $name) {
			$loc .= DIRECTORY_SEPARATOR . $name;
			if (!file_exists(ROOT_DIRECTORY . $loc)) {
				if (!mkdir(ROOT_DIRECTORY . $loc)) {
					\App\Log::warning("No permissions to create directories: $loc");
					throw new \Exception\AppException('No permissions to create directories');
				}
			}
		}
	}

	/**
	 * Function gets translations
	 * @param string[] $lang
	 * @param string $mod
	 * @param type $ShowDifferences
	 * @return type
	 */
	public function loadLangTranslation($lang, $mod, $ShowDifferences = 0)
	{
		$keysPhp = $keysJs = $langs = $langTab = $respPhp = $respJs = [];
		$mod = str_replace(self::url_separator, '/', $mod);
		if (self::parse_data(',', $lang)) {
			$langs = explode(',', $lang);
		} else {
			$langs[] = $lang;
		}
		foreach ($langs as $lang) {
			$langData = Vtiger_Language_Handler::getModuleStringsFromFile($lang, $mod);
			if ($langData) {
				$langTab[$lang]['php'] = $langData['languageStrings'];
				$langTab[$lang]['js'] = $langData['jsLanguageStrings'];
				$keysPhp = array_merge($keysPhp, array_keys($langData['languageStrings']));
				$keysJs = array_merge($keysJs, array_keys($langData['jsLanguageStrings']));
			}
		}
		$keysPhp = array_unique($keysPhp);
		$keysJs = array_unique($keysJs);
		foreach ($keysPhp as $key) {
			foreach ($langs as $language) {
				$respPhp[$key][$language] = htmlentities($langTab[$language]['php'][$key], ENT_QUOTES, 'UTF-8');
			}
		}
		foreach ($keysJs as $key) {
			foreach ($langs as $language) {
				$respJs[$key][$language] = htmlentities($langTab[$language]['js'][$key], ENT_QUOTES, 'UTF-8');
			}
		}
		return ['php' => $respPhp, 'js' => $respJs, 'langs' => $langs, 'keys' => $keys];
	}

	public function loadAllFieldsFromModule($lang, $mod, $showDifferences = 0)
	{
		$variablesFromFile = $this->loadLangTranslation($lang, 'HelpInfo', $showDifferences);
		$output = [];
		if (self::parse_data(',', $lang)) {
			$langs = explode(",", $lang);
		} else {
			$langs[] = $lang;
		}
		$output['langs'] = $langs;
		$dataReader = (new \App\Db\Query())
				->from('vtiger_field')
				->where(['tabid' => \App\Module::getModuleId($mod), 'presence' => [0, 2]])
				->createCommand()->query();
		while ($row = $dataReader->read()) {
			$output['php'][$mod . '|' . $row['fieldlabel']]['label'] = \App\Language::translate($row['fieldlabel'], $mod);
			$output['php'][$mod . '|' . $row['fieldlabel']]['info'] = array('view' => explode(',', $row['helpinfo']), 'fieldid' => $row['fieldid']);
			foreach ($langs AS $lang) {
				$output['php'][$mod . '|' . $row['fieldlabel']][$lang] = stripslashes($variablesFromFile['php'][$mod . '|' . $row['fieldlabel']][$lang]);
			}
		}
		return $output;
	}

	public function getModFromLang($lang)
	{
		if ($lang == '' || $lang === null) {
			$lang = 'en_us';
		} else {
			if (self::parse_data(',', $lang)) {
				$langA = explode(",", $lang);
				$lang = $langA[0];
			}
		}
		$dir = "languages/$lang";
		if (!file_exists($dir)) {
			return false;
		}
		$files = [];
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);
		foreach ($objects as $name => $object) {
			if (strpos($object->getFilename(), '.php') !== false) {
				$name = str_replace('.php', "", $name);
				$val = str_replace($dir . DIRECTORY_SEPARATOR, "", $name);
				$key = str_replace($dir . DIRECTORY_SEPARATOR, "", $name);
				$key = str_replace("/", self::url_separator, $key);
				$key = str_replace("\\", self::url_separator, $key);
				$val = str_replace(DIRECTORY_SEPARATOR, "|", $val);
				$files[$key] = $val;
			}
		}
		return self::SettingsTranslate($files);
	}

	public function SettingsTranslate($langs)
	{
		$settings = [];
		foreach ($langs as $key => $lang) {
			if (self::parse_data('|', $lang)) {
				$langArray = explode("|", $lang);
				unset($langs[$key]);
				$settings[$key] = \App\Language::translate($langArray[1], 'Settings:' . $langArray[1]);
			} else {
				$langs[$key] = \App\Language::translate($key, $key);
			}
		}
		return array('mods' => $langs, 'settings' => $settings);
	}

	/**
	 * Function added new language
	 * @param array $params
	 * @return array
	 */
	public static function add($params)
	{
		if (App\Language::getAll(['prefix' => $params['prefix']])) {
			return ['success' => false, 'data' => 'LBL_LangExist'];
		}
		$destiny = 'languages/' . $params['prefix'] . '/';
		mkdir($destiny);
		vtlib\Functions::recurseCopy('languages/en_us/', $destiny);
		$db = \App\Db::getInstance();
		$db->createCommand()->insert('vtiger_language', [
			'id' => $db->getUniqueId('vtiger_language'),
			'name' => $params['name'],
			'prefix' => $params['prefix'],
			'label' => $params['label'],
		])->execute();
		return ['success' => true, 'data' => 'LBL_AddDataOK'];
	}

	public function save($params)
	{
		if ($params['type'] == 'Checkbox') {
			$val = $params['val'] == 'true' ? 1 : 0;
			\App\Db::getInstance()->createCommand()
				->update('vtiger_language', [$params['name'] => $val], ['prefix' => $params['prefix']])
				->execute();
			return true;
		}
		return false;
	}

	public function saveView($params)
	{
		if (!is_array($params['value'])) {
			$params['value'] = [$params['value']];
		}
		$value = implode(',', $params['value']);
		\App\Db::getInstance()->createCommand()
			->update('vtiger_field', ['helpinfo' => $value], ['fieldid' => $params['fieldid']])
			->execute();
		return array('success' => true, 'data' => 'LBL_SUCCESSFULLY_UPDATED');
	}

	public static function delete($params)
	{
		$dir = 'languages/' . $params['prefix'];
		if (file_exists($dir)) {
			self::DeleteDir($dir);
		}
		\App\Db::getInstance()->createCommand()
			->delete('vtiger_language', ['prefix' => $params['prefix']])
			->execute();
		return true;
	}

	/**
	 * Parse data
	 * @param string $a
	 * @param string $b
	 * @return boolean
	 */
	public static function parse_data($a, $b)
	{
		$resp = false;
		if ($b != '' && stristr($b, $a) !== false) {
			$resp = true;
		}
		return $resp;
	}

	public function DeleteDir($dir)
	{
		$fd = opendir($dir);
		if (!$fd)
			return false;
		while (($file = readdir($fd)) !== false) {
			if ($file == "." || $file == "..")
				continue;
			if (is_dir($dir . "/" . $file)) {
				self::DeleteDir($dir . "/" . $file);
			} else {
				unlink("$dir/$file");
			}
		}
		closedir($fd);
		rmdir($dir);
	}

	public function setAsDefault($lang)
	{

		\App\Log::trace("Entering Settings_LangManagement_Module_Model::setAsDefault(" . $lang . ") method ...");
		$db = \App\Db::getInstance();
		$prefix = $lang['prefix'];
		$fileName = 'config/config.inc.php';
		$completeData = file_get_contents($fileName);
		$updatedFields = "default_language";
		$patternString = "\$%s = '%s';";
		$pattern = '/\$' . $updatedFields . '[\s]+=([^;]+);/';
		$replacement = sprintf($patternString, $updatedFields, ltrim($prefix, '0'));
		$fileContent = preg_replace($pattern, $replacement, $completeData);
		$filePointer = fopen($fileName, 'w');
		fwrite($filePointer, $fileContent);
		fclose($filePointer);
		$dataReader = (new \App\Db\Query)->select('prefix')
				->from('vtiger_language')
				->where(['isdefault' => 1])
				->createCommand()->query();
		if ($dataReader->count() == 1) {
			$prefixOld = $dataReader->readColumn(0);
			$db->createCommand()->update('vtiger_language', ['isdefault' => 0], ['isdefault' => 1])->execute();
		}
		$status = $db->createCommand()->update('vtiger_language', ['isdefault' => 1], ['prefix' => $prefix])->execute();
		if ($status)
			$status = true;
		else
			$status = false;
		\App\Log::trace("Exiting Settings_LangManagement_Module_Model::setAsDefault() method ...");
		return array('success' => $status, 'prefixOld' => $prefixOld);
	}

	public function getStatsData($langBase, $langs, $byModule = false)
	{
		$filesName = $this->getModFromLang($langBase);
		if (strpos($langs, $langBase) === false) {
			$langs .= ',' . $langBase;
		}
		$data = [];
		foreach ($filesName as $gropu) {
			foreach ($gropu as $mode => $name) {
				if ($byModule === false || $byModule === $mode) {
					$data[$mode] = $this->getStats($this->loadLangTranslation($langs, $mode), $langBase, $byModule);
				}
			}
		}
		return $data;
	}

	public function getStats($data, $langBase, $byModule)
	{
		$differences = [];
		$i = 0;
		foreach ($data as $id => $dataLang) {
			if (!in_array($id, ['php', 'js']))
				continue;
			foreach ($dataLang as $key => $langs) {
				foreach ($langs as $lang => $value) {
					if ($lang == $langBase) {
						++$i;
						continue;
					}
					if (!empty($langs[$langBase]) && ($value == $langs[$langBase] || empty($value))) {
						if ($byModule !== false) {
							$differences[$id][$key][$langBase] = $langs[$langBase];
							$differences[$id][$key][$lang] = $value;
						} else {
							$differences[$lang][] = $key;
						}
					}
				}
			}
		}
		if ($byModule === false) {
			array_unshift($differences, $i);
		}
		return $differences;
	}
}
