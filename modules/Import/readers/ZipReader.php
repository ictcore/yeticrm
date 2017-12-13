<?php

/**
 * ZipReader class
 * @package YetiForce.Reader
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Import_ZipReader_Reader extends Import_FileReader_Reader
{

	protected $moduleName;
	protected $importFolderLocation;
	protected $filelist = [];

	/**
	 * Construct
	 * @param \App\Request $request
	 * @param Users_Record_Model $user
	 */
	public function __construct(\App\Request $request, $user)
	{
		$instance = Vtiger_Cache::get('ZipReader', $request->get('module') . $user->id);
		if (!empty($instance)) {
			$this->setInstanceProperties($instance);
			$this->request = $request;
			return;
		}
		$this->moduleName = $request->get('module');
		$this->extension = $request->get('extension');
		parent::__construct($request, $user);
		$this->initialize($request, $user);
		Vtiger_Cache::set('ZipReader', $this->moduleName . $user->id, $this);
	}

	public function setInstanceProperties($instance)
	{
		$objectProperties = get_object_vars($instance);
		foreach ($objectProperties as $properName => $propertyValue) {
			$this->$properName = $propertyValue;
		}
	}

	/**
	 * Initialize zip file
	 * @param \App\Request $request
	 * @param Users_Record_Model $user
	 */
	public function initialize(\App\Request $request, $user)
	{
		$zipfile = Import_Utils_Helper::getImportFilePath($user);
		$this->importFolderLocation = "{$zipfile}_{$this->extension}";
		// clean old data
		if ($request->getMode() === 'uploadAndParse') {
			$this->deleteFolder();
		}
		if ($this->extension && file_exists($zipfile) && !file_exists($this->importFolderLocation)) {
			mkdir($this->importFolderLocation);
			$zip = new \App\Zip($zipfile, ['onlyExtension' => $this->extension]);
			$this->filelist = $zip->unzip($this->importFolderLocation);
			unlink($zipfile);
		} elseif (is_dir($this->importFolderLocation)) {
			foreach (new DirectoryIterator($this->importFolderLocation) as $file) {
				if (!$file->isDot()) {
					if (strpos($file->getFilename(), '.' . $this->extension) !== false) {
						$this->filelist[] = $file->getFilename();
					}
				}
			}
		}
	}

	public function hasHeader()
	{
		return true;
	}

	public function checkExtension($filelist)
	{
		$return = true;
		foreach ($filelist as $name) {
			$nameArray = explode('.', $name);
			if (strtolower(array_pop($nameArray)) != strtolower($this->extension)) {
				$return = false;
				break;
			}
		}
		return $return;
	}

	public function getFirstRowData($hasHeader = true)
	{
		$data = $this->request->getAll();
		$newRequest = new \App\Request($data);
		$newRequest->set('type', $this->extension);
		$fileReader = Import_Module_Model::getFileReader($newRequest, $this->user);
		if (!$fileReader) {
			return false;
		}
		$filePath = $this->getNextFile(false);
		if (!$filePath) {
			$this->deleteFolder();
			return false;
		}
		$fileReader->filePath = $filePath;
		return $fileReader->getFirstRowData($hasHeader);
	}

	public function getNextFile($del = true)
	{
		$return = false;
		foreach ($this->filelist as $name) {
			$filePatch = $this->importFolderLocation . DIRECTORY_SEPARATOR . $name;
			if (file_exists($filePatch) && $this->checkExtension([$name])) {
				$return = $filePatch;
				if ($del) {
					unset($this->filelist[$name]);
				}
				break;
			}
			unset($this->filelist[$name]);
		}
		return $return;
	}

	public function read()
	{
		$data = $this->request->getAll();
		$newRequest = new \App\Request($data);
		$newRequest->set('type', $this->extension);
		$fileReader = Import_Module_Model::getFileReader($newRequest, $this->user);
		if (!$fileReader) {
			return false;
		}
		while ($filePath = $this->getNextFile()) {
			$fileReader->filePath = $filePath;
			$fileReader->read();
			$fileReader->deleteFile();
		}
		$this->deleteFolder();
	}

	public function deleteFolder()
	{
		if (!empty($this->importFolderLocation)) {
			\vtlib\Functions::recurseDelete($this->importFolderLocation);
		}
	}
}
