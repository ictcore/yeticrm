<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ********************************************************************************** */
namespace vtlib;

/**
 * Provides API to import language into vtiger CRM
 * @package vtlib
 */
class ThemeImport extends ThemeExport
{

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_export_tmpdir;
	}

	/**
	 * Initialize Import
	 * @access private
	 */
	public function initImport($zipfile, $overwrite)
	{
		$this->__initSchema();
		$name = $this->getModuleNameFromZip($zipfile);
		return $name;
	}

	/**
	 * Import Module from zip file
	 * @param String Zip file name
	 * @param Boolean True for overwriting existing module
	 */
	public function import($zipfile, $overwrite = false)
	{
		$this->initImport($zipfile, $overwrite);

		// Call module import function
		$this->import_Theme($zipfile);
	}

	/**
	 * Update Module from zip file
	 * @param Object Instance of Language (to keep Module update API consistent)
	 * @param String Zip file name
	 * @param Boolean True for overwriting existing module
	 */
	public function update($instance, $zipfile, $overwrite = true)
	{
		$this->import($zipfile, $overwrite);
	}

	/**
	 * Import Module
	 * @access private
	 */
	public function import_Theme($zipfile)
	{
		$name = $this->_modulexml->name;
		$label = $this->_modulexml->label;
		$parent = $this->_modulexml->parent;

		self::log("Importing $label ... STARTED");
		$vtiger6format = false;

		$zip = new \App\Zip($zipfile);
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$fileName = $zip->getNameIndex($i);
			if (!$zip->isdir($fileName)) {
				if (strpos($fileName, '/') === false) {
					continue;
				}
				$targetdir = substr($fileName, 0, strripos($fileName, '/'));
				$targetfile = basename($fileName);
				$dounzip = false;
				// Case handling for jscalendar
				if (stripos($targetdir, "layouts/$parent/skins/$label") === 0) {
					$dounzip = true;
					$vtiger6format = true;
				}
				if ($dounzip) {
					// vtiger6 format
					if ($vtiger6format) {
						$targetdir = "layouts/$parent/skins/" . str_replace("layouts/$parent/skins", '', $targetdir);
						@mkdir($targetdir, 0777, true);
					}
					if ($zip->unzipFile($fileName, "$targetdir/$targetfile") !== false) {
						self::log("Copying file $fileName ... DONE");
					} else {
						self::log("Copying file $fileName ... FAILED");
					}
				} else {
					self::log("Copying file $fileName ... SKIPPED");
				}
			}
		}
		if ($zip) {
			$zip->close();
		}
		self::register($label, $name, $parent);
		self::log("Importing $label [$prefix] ... DONE");
		return;
	}
}
