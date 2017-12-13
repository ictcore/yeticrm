<?php
namespace App;

/**
 * Text parser class
 * @package YetiForce.App
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class TextParser
{

	/** @var array Examples of supported variables */
	public static $variableExamples = [
		'LBL_ORGANIZATION_NAME' => '$(organization : name)$',
		'LBL_ORGANIZATION_LOGO' => '$(organization : mailLogo)$',
		'LBL_EMPLOYEE_NAME' => '$(employee : last_name)$',
		'LBL_CRM_DETAIL_VIEW_URL' => '$(record : CrmDetailViewURL)$',
		'LBL_PORTAL_DETAIL_VIEW_URL' => '$(record : PortalDetailViewURL)$',
		'LBL_RECORD_ID' => '$(record : RecordId)$',
		'LBL_RECORD_LABEL' => '$(record : RecordLabel)$',
		'LBL_LIST_OF_CHANGES_IN_RECORD' => '$(record : ChangesListChanges)$',
		'LBL_LIST_OF_NEW_VALUES_IN_RECORD' => '$(record : ChangesListValues)$',
		'LBL_RECORD_COMMENT' => '$(record : Comments 5)$, $(record : Comments)$',
		'LBL_RELATED_RECORD_LABEL' => '$(relatedRecord : parent_id|email1|Accounts)$, $(relatedRecord : parent_id|email1)$',
		'LBL_OWNER_EMAIL' => '$(relatedRecord : assigned_user_id|email1|Users)$',
		'LBL_SOURCE_RECORD_LABEL' => '$(sourceRecord : RecordLabel)$',
		'LBL_CUSTOM_FUNCTION' => '$(custom : ContactsPortalPass)$',
		'LBL_RELATED_RECORDS_LIST' => '$(relatedRecordsList : Contacts|firstname,lastname,email|[[["firstname","a","Tom"]]]||5)$',
		'LBL_RECORDS_LIST' => '$(recordsList : Contacts|firstname,lastname,email|[[["firstname","a","Tom"]]]||5)$',
	];

	/** @var array Variables for entity modules */
	public static $variableGeneral = [
		'LBL_CURRENT_DATE' => '$(general : CurrentDate)$',
		'LBL_CURRENT_TIME' => '$(general : CurrentTime)$',
		'LBL_BASE_TIMEZONE' => '$(general : BaseTimeZone)$',
		'LBL_USER_TIMEZONE' => '$(general : UserTimeZone)$',
		'LBL_SITE_URL' => '$(general : SiteUrl)$',
		'LBL_PORTAL_URL' => '$(general : PortalUrl)$',
		'LBL_TRANSLATE' => '$(translate : Accounts|LBL_COPY_BILLING_ADDRESS)$, $(translate : LBL_SECONDS)$',
	];

	/** @var array Variables for entity modules */
	public static $variableEntity = [
		'CrmDetailViewURL' => 'LBL_CRM_DETAIL_VIEW_URL',
		'PortalDetailViewURL' => 'LBL_PORTAL_DETAIL_VIEW_URL',
		'RecordId' => 'LBL_RECORD_ID',
		'RecordLabel' => 'LBL_RECORD_LABEL',
		'ChangesListChanges' => 'LBL_LIST_OF_CHANGES_IN_RECORD',
		'ChangesListValues' => 'LBL_LIST_OF_NEW_VALUES_IN_RECORD',
		'Comments' => 'LBL_RECORD_COMMENT'
	];

	/** @var string[] List of available functions */
	protected static $baseFunctions = ['general', 'translate', 'record', 'relatedRecord', 'sourceRecord', 'organization', 'employee', 'params', 'custom', 'relatedRecordsList', 'recordsList'];

	/** @var string[] List of source modules */
	public static $sourceModules = [
		'Campaigns' => ['Leads', 'Accounts', 'Contacts', 'Vendors', 'Partners', 'Competition']
	];
	private static $recordVariable;
	private static $relatedVariable;

	/** @var int Record id */
	public $record;

	/** @var string Module name */
	public $moduleName;

	/** @var \Vtiger_Record_Model Record model */
	public $recordModel;

	/** @var string|null Parser type */
	public $type;

	/** @var \Vtiger_Record_Model Source record model */
	protected $sourceRecordModel;

	/** @var string Content */
	protected $content;

	/** @var string Rwa content */
	protected $rawContent;

	/** @var bool without translations */
	protected $withoutTranslations = false;

	/** @var string Language content */
	protected $language;

	/** @var array Additional params */
	protected $params;

	/**
	 * Get instanace by record id
	 * @param int $record Record id
	 * @param string $moduleName Module name
	 * @return \self
	 */
	public static function getInstanceById($record, $moduleName)
	{
		$class = get_called_class();
		$instance = new $class();
		$instance->record = $record;
		$instance->moduleName = $moduleName;
		$instance->recordModel = \Vtiger_Record_Model::getInstanceById($record, $moduleName);
		return $instance;
	}

	/**
	 * Get instanace by record model
	 * @param \Vtiger_Record_Model $recordModel
	 * @return \self
	 */
	public static function getInstanceByModel(\Vtiger_Record_Model $recordModel)
	{
		$class = get_called_class();
		$instance = new $class();
		$instance->record = $recordModel->getId();
		$instance->moduleName = $recordModel->getModuleName();
		$instance->recordModel = $recordModel;
		return $instance;
	}

	/**
	 * Get clean instanace
	 * @param string $moduleName Module name
	 * @return \self
	 */
	public static function getInstance($moduleName = '')
	{
		$class = get_called_class();
		$instance = new $class();
		if ($moduleName) {
			$instance->moduleName = $moduleName;
		}
		return $instance;
	}

	/**
	 * Set without translations
	 * @param string $content
	 * @return $this
	 */
	public function withoutTranslations($type = true)
	{
		$this->withoutTranslations = $type;
		return $this;
	}

	/**
	 * Set language
	 * @param string $name
	 * @return $this
	 */
	public function setLanguage($name = true)
	{
		$this->language = $name;
		return $this;
	}

	/**
	 * Set parser type
	 * @param string $type
	 * @return $this
	 */
	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * Set additional params
	 * @param array $params
	 * @return $this
	 */
	public function setParams($params)
	{
		$this->params = $params;
		return $this;
	}

	/**
	 * Get additional params
	 * @param string $key
	 * @return mixed
	 */
	public function getParam($key)
	{
		return isset($this->params[$key]) ? $this->params[$key] : false;
	}

	/**
	 * Set source record
	 * @param int $record
	 * @param string|bool $moduleName
	 * @return $this
	 */
	public function setSourceRecord($record, $moduleName = false, $recordModel = false)
	{
		$this->sourceRecordModel = $recordModel ? $recordModel : \Vtiger_Record_Model::getInstanceById($record, $moduleName ? $moduleName : Record::getType($record));
		return $this;
	}

	/**
	 * Set content
	 * @param string $content
	 * @return $this
	 */
	public function setContent($content)
	{
		$this->rawContent = $this->content = str_replace('%20%3A%20', ' : ', $content);
		return $this;
	}

	/**
	 * Get content 
	 */
	public function getContent($trim = false)
	{
		return $trim ? trim($this->content) : $this->content;
	}

	/**
	 * Text parse function
	 * @return $this
	 */
	public function parse()
	{
		if (empty($this->content)) {
			return $this;
		}
		if (isset($this->language)) {
			$currentLanguage = \App\Language::getLanguage();
			\App\Language::setLanguage($this->language);
		}
		$this->content = preg_replace_callback('/\$\((\w+) : ([,"\[\]\&\w\s\|]+)\)\$/', function ($matches) {
			list($fullText, $function, $params) = array_pad($matches, 3, '');
			if (in_array($function, static::$baseFunctions)) {
				return $this->$function($params);
			}
			return '';
		}, $this->content);
		if (!empty($currentLanguage)) {
			\App\Language::setLanguage($currentLanguage);
		}
		return $this;
	}

	/**
	 * Text parse function
	 * @return $this
	 */
	public function parseTranslations()
	{
		if (isset($this->language)) {
			$currentLanguage = \App\Language::getLanguage();
			\App\Language::setLanguage($this->language);
		}
		$this->content = preg_replace_callback('/\$\(translate : ([\&\w\s\|]+)\)\$/', function ($matches) {
			list($fullText, $params) = $matches;
			return $this->translate($params);
		}, $this->content);
		if (!empty($currentLanguage)) {
			\App\Language::setLanguage($currentLanguage);
		}
		return $this;
	}

	/**
	 * Parsing translations
	 * @param string $params
	 * @return string
	 */
	protected function translate($params)
	{
		if (strpos($params, '|') === false) {
			return Language::translate($params);
		}
		$aparams = explode('|', $params);
		$moduleName = array_shift($aparams);
		if (Module::getModuleId($moduleName) !== false) {
			$params = reset($aparams);
			return Language::translate($params, $moduleName, $this->language);
		}
		return Language::translate($params);
	}

	/**
	 * Parsing organization detail
	 * @param string $fieldName
	 * @return string
	 */
	protected function organization($fieldName)
	{
		$id = false;
		if (strpos($fieldName, '|') !== false) {
			$params = explode('|', $fieldName);
			$fieldName = array_shift($params);
			$id = array_shift($params);
		}
		$company = Company::getInstanceById($id);
		if ($fieldName === 'mailLogo' || $fieldName === 'loginLogo') {
			$fieldName = ($fieldName === 'mailLogo') ? 'logo_mail' : 'logo_main';
			$logo = $company->getLogo($fieldName, true);
			if (!$logo) {
				return '';
			}
			$logoName = $logo->get('imageUrl');
			$logoTitle = $company->get('name');
			$logoAlt = Language::translate('LBL_COMPANY_LOGO_TITLE');
			$logoHeight = $company->get($fieldName . '_height');
			return "<img class=\"organizationLogo\" src=\"$logoName\" title=\"$logoTitle\" alt=\"$logoAlt\" height=\"{$logoHeight}px\">";
		} elseif (in_array($fieldName, ['logo_login', 'logo_main', 'logo_mail'])) {
			return Company::$logoPath . $company->get($fieldName);
		}
		return $company->get($fieldName);
	}

	/**
	 * Parsing employee detail
	 * @param string $fieldName
	 * @return mixed
	 */
	protected function employee($fieldName)
	{
		$userId = User::getCurrentUserId();
		if (Cache::has('TextParserEmployeeDetail', $userId . $fieldName)) {
			return Cache::get('TextParserEmployeeDetail', $userId . $fieldName);
		}
		if (Cache::has('TextParserEmployeeDetailRows', $userId)) {
			$employee = Cache::get('TextParserEmployeeDetailRows', $userId);
		} else {
			$employee = (new Db\Query())->select(['crmid'])->from('vtiger_crmentity')->where(['deleted' => 0, 'setype' => 'OSSEmployees', 'smownerid' => $userId])
					->limit(1)->scalar();
			Cache::save('TextParserEmployeeDetailRows', $userId, $employee, Cache::LONG);
		}
		$value = '';
		if ($employee) {
			$relatedRecordModel = \Vtiger_Record_Model::getInstanceById($employee, 'OSSEmployees');
			$instance = static::getInstanceByModel($relatedRecordModel);
			foreach (['withoutTranslations', 'language', 'emailoptout'] as $key) {
				if (isset($this->$key)) {
					$instance->$key = $this->$key;
				}
			}
			$value = $instance->record($fieldName);
		}
		Cache::save('TextParserEmployeeDetail', $userId . $fieldName, $value, Cache::LONG);
		return $value;
	}

	/**
	 * Parsing general data
	 * @param string $key
	 * @return mixed
	 */
	protected function general($key)
	{
		switch ($key) {
			case 'CurrentDate': return (new \DateTimeField(null))->getDisplayDate();
			case 'CurrentTime' : return \Vtiger_Util_Helper::convertTimeIntoUsersDisplayFormat(date('h:i:s'));
			case 'SiteUrl' : return \AppConfig::main('site_URL');
			case 'PortalUrl' : return \AppConfig::main('PORTAL_URL');
			case 'BaseTimeZone' : return \DateTimeField::getDBTimeZone();
		}
		return $key;
	}

	/**
	 * Parsing record data
	 * @param string $key
	 * @return string
	 */
	protected function record($key, $isPermitted = true)
	{
		if (!isset($this->recordModel) || ($isPermitted && !Privilege::isPermitted($this->moduleName, 'DetailView', $this->record))) {
			return '';
		}
		if ($this->recordModel->has($key)) {
			$fieldModel = $this->recordModel->getModule()->getField($key);

			if (!$fieldModel || !$this->useValue($fieldModel, $this->moduleName)) {
				return '';
			}
			return $this->getDisplayValueByField($fieldModel);
		}
		switch ($key) {
			case 'CrmDetailViewURL' :
				return \AppConfig::main('site_URL') . 'index.php?module=' . $this->moduleName . '&view=Detail&record=' . $this->record;
			case 'PortalDetailViewURL' :
				$recorIdName = 'id';
				if ($this->moduleName === 'HelpDesk') {
					$recorIdName = 'ticketid';
				} elseif ($this->moduleName === 'Faq') {
					$recorIdName = 'faqid';
				} elseif ($this->moduleName === 'Products') {
					$recorIdName = 'productid';
				}
				return \AppConfig::main('PORTAL_URL') . '/index.php?module=' . $this->moduleName . '&action=index&' . $recorIdName . '=' . $this->record;
			case 'ModuleName' : return $this->moduleName;
			case 'RecordId' : return $this->record;
			case 'RecordLabel' : return $this->recordModel->getName();
			case 'ChangesListChanges':
				foreach ($this->recordModel->getPreviousValue() as $fieldName => $oldValue) {
					$fieldModel = $this->recordModel->getModule()->getField($fieldName);
					if (!$fieldModel) {
						continue;
					}
					$oldValue = $this->getDisplayValueByField($oldValue, $fieldModel);
					$currentValue = $this->getDisplayValueByField($fieldModel);
					if ($this->withoutTranslations !== true) {
						$value .= Language::translate($fieldModel->getFieldLabel(), $this->moduleName, $this->language) . ' ';
						$value .= Language::translate('LBL_FROM') . " $oldValue " . Language::translate('LBL_TO') . " $currentValue" . PHP_EOL;
					} else {
						$value .= "\$(translate : $this->moduleName|{$fieldModel->getFieldLabel()})\$ \$(translate : LBL_FROM)\$ $oldValue \$(translate : LBL_TO)\$ " .
							$currentValue . PHP_EOL;
					}
				}
				return $value;
			case 'ChangesListValues':
				$changes = $this->recordModel->getPreviousValue();
				if (empty($changes)) {
					$changes = array_filter($this->recordModel->getData());
					unset($changes['createdtime'], $changes['modifiedtime'], $changes['id'], $changes['newRecord'], $changes['modifiedby']);
				}
				foreach ($changes as $fieldName => $oldValue) {
					$fieldModel = $this->recordModel->getModule()->getField($fieldName);
					if (!$fieldModel) {
						continue;
					}
					$currentValue = $this->getDisplayValueByField($fieldModel);
					if ($this->withoutTranslations !== true) {
						$value .= Language::translate($fieldModel->getFieldLabel(), $this->moduleName, $this->language) . ": $currentValue" . PHP_EOL;
					} else {
						$value .= "\$(translate : $this->moduleName|{$fieldModel->getFieldLabel()})\$: $currentValue" . PHP_EOL;
					}
				}
				return $value;
			default:
				if (strpos($key, ' ') !== false) {
					list($key, $params) = explode(' ', $key);
				}
				switch ($key) {
					case 'Comments': return $this->getComments($params);
				}
				break;
		}
		return '';
	}

	/**
	 * Parsing related record data
	 * @param string $params
	 * @return mixed
	 */
	protected function relatedRecord($params)
	{
		list($fieldName, $relatedField, $relatedModule) = explode('|', $params);
		if (!isset($this->recordModel) ||
			!\Users_Privileges_Model::isPermitted($this->moduleName, 'DetailView', $this->record) ||
			$this->recordModel->isEmpty($fieldName)) {
			return '';
		}
		$relatedId = $this->recordModel->get($fieldName);
		if (empty($relatedId)) {
			return '';
		}
		if ($relatedModule === 'Users') {
			$userRecordModel = \Users_Privileges_Model::getInstanceById($relatedId);
			$instance = static::getInstanceByModel($userRecordModel);
			foreach (['withoutTranslations', 'language', 'emailoptout'] as $key) {
				if (isset($this->$key)) {
					$instance->$key = $this->$key;
				}
			}
			return $instance->record($relatedField, false);
		}
		$moduleName = Record::getType($relatedId);
		if (!empty($moduleName)) {
			if (($relatedModule && $relatedModule !== $moduleName)) {
				return '';
			}
		}
		$relatedRecordModel = \Vtiger_Record_Model::getInstanceById($relatedId, $moduleName);
		$instance = static::getInstanceByModel($relatedRecordModel);
		foreach (['withoutTranslations', 'language', 'emailoptout'] as $key) {
			if (isset($this->$key)) {
				$instance->$key = $this->$key;
			}
		}
		return $instance->record($relatedField);
	}

	/**
	 * Parsing source record data
	 * @param string $fieldName
	 * @return mixed
	 */
	protected function sourceRecord($fieldName)
	{
		if (empty($this->sourceRecordModel) || !\Users_Privileges_Model::isPermitted($this->sourceRecordModel->getModuleName(), 'DetailView', $this->sourceRecordModel->getId())) {
			return '';
		}
		$instance = static::getInstanceByModel($this->sourceRecordModel);
		foreach (['withoutTranslations', 'language', 'emailoptout'] as $key) {
			if (isset($this->$key)) {
				$instance->$key = $this->$key;
			}
		}
		return $instance->record($fieldName);
	}

	/**
	 * Parsing related records list
	 * @param string $params Parameter construction: RelatedModuleName|Columns|Conditions|CustomViewIdOrName|Limit, Example: Contacts|firstname,lastname,modifiedtime|[[["firstname","a","Tom"]]]||2
	 * @return string
	 */
	protected function relatedRecordsList($params)
	{
		list($reletedModuleName, $columns, $conditions, $viewIdOrName, $limit) = array_pad(explode('|', $params), 5, '');
		$relationListView = \Vtiger_RelationListView_Model::getInstance($this->recordModel, $reletedModuleName, '');
		if (!$relationListView || !Privilege::isPermitted($reletedModuleName)) {
			return '';
		}
		$pagingModel = new \Vtiger_Paging_Model();
		if ((int) $limit) {
			$pagingModel->set('limit', (int) $limit);
		}
		if ($viewIdOrName) {
			if (!is_numeric($viewIdOrName)) {
				$customView = CustomView::getInstance($reletedModuleName);
				if ($cvId = $customView->getViewIdByName($viewIdOrName)) {
					$viewIdOrName = $cvId;
				} else {
					$viewIdOrName = false;
					Log::warning("No view found. Module: $reletedModuleName, view name: $viewIdOrName", 'TextParser');
				}
			}
			if ($viewIdOrName) {
				$relationListView->getQueryGenerator()->initForCustomViewById($viewIdOrName);
			}
		}
		if ($columns) {
			$relationListView->setFields($columns);
		}
		if ($conditions) {
			$transformedSearchParams = $relationListView->getQueryGenerator()->parseBaseSearchParamsToCondition(Json::decode($conditions));
			$relationListView->set('search_params', $transformedSearchParams);
		}
		$rows = $headers = '';
		$fields = $relationListView->getHeaders();
		foreach ($fields as $fieldModel) {
			if ($fieldModel->isViewable()) {
				$headers .= '<th>' . \App\Language::translate($fieldModel->getFieldLabel(), $reletedModuleName) . '</th>';
			}
		}
		foreach ($relationListView->getEntries($pagingModel) as $reletedRecordModel) {
			$rows .= '<tr>';
			foreach ($fields as $fieldModel) {
				$value = $this->getDisplayValueByField($fieldModel, $reletedRecordModel);
				if ($value !== false) {
					$rows .= "<td>$value</td>";
				}
			}
			$rows .= '</tr>';
		}
		return empty($rows) ? '' : "<table><thead><tr>{$headers}</tr></thead><tbody>{$rows}</tbody></table>";
	}

	/**
	 * Parsing records list
	 * @param string $params Parameter construction: ModuleName|Columns|Conditions|CustomViewIdOrName|Limit, Example: Contacts|firstname,lastname,modifiedtime|[[["firstname","a","Tom"]]]||2
	 * @return string
	 */
	protected function recordsList($params)
	{
		list($moduleName, $columns, $conditions, $viewIdOrName, $limit) = array_pad(explode('|', $params), 5, '');
		$cvId = 0;
		if ($viewIdOrName) {
			if (!is_numeric($viewIdOrName)) {
				$customView = CustomView::getInstance($moduleName);
				if ($cvIdByName = $customView->getViewIdByName($viewIdOrName)) {
					$viewIdOrName = $cvIdByName;
				} else {
					$viewIdOrName = false;
					Log::warning("No view found. Module: $moduleName, view name: $viewIdOrName", 'TextParser');
				}
			}
			if ($viewIdOrName) {
				$cvId = $viewIdOrName;
			}
		}
		$listView = \Vtiger_ListView_Model::getInstance($moduleName, $cvId);
		$pagingModel = new \Vtiger_Paging_Model();
		if ((int) $limit) {
			$pagingModel->set('limit', (int) $limit);
		}
		if ($columns) {
			$listView->getQueryGenerator()->setFields(explode(',', $columns));
		}
		if ($conditions) {
			$transformedSearchParams = $listView->getQueryGenerator()->parseBaseSearchParamsToCondition(Json::decode($conditions));
			$listView->set('search_params', $transformedSearchParams);
		}
		$rows = $headers = '';
		$fields = $listView->getListViewHeaders();
		foreach ($fields as $fieldModel) {
			$headers .= '<th>' . \App\Language::translate($fieldModel->getFieldLabel(), $moduleName) . '</th>';
		}
		foreach ($listView->getListViewEntries($pagingModel) as $reletedRecordModel) {
			$rows .= '<tr>';
			foreach ($fields as $fieldModel) {
				$value = $this->getDisplayValueByField($fieldModel, $reletedRecordModel);
				if ($value !== false) {
					$rows .= "<td>$value</td>";
				}
			}
			$rows .= '</tr>';
		}
		return empty($rows) ? '' : "<table><thead><tr>{$headers}</tr></thead><tbody>{$rows}</tbody></table>";
	}

	/**
	 * Get record display value
	 * @param \Vtiger_Field_Model $fieldModel
	 * @param |mixed\Vtiger_Record_Model $value
	 * @return boolean|string
	 */
	protected function getDisplayValueByField(\Vtiger_Field_Model $fieldModel, $value = false)
	{
		if ($value === false) {
			$recordModel = $this->recordModel;
			$value = $this->recordModel->get($fieldModel->getName(), $this->recordModel->getId(), $this->recordModel, true);
			if (!$fieldModel->isViewEnabled()) {
				return '-';
			}
		} elseif (is_object($value)) {
			$recordModel = $value;
			$value = $value->get($fieldModel->getName(), $value->getId(), $value, true);
			if (!$fieldModel->isViewEnabled()) {
				return false;
			}
		}
		if ($value === '') {
			return '-';
		}
		if ($this->withoutTranslations !== true) {
			return $fieldModel->getDisplayValue($value, $recordModel->getId(), $recordModel, true);
		}
		return $this->getDisplayValueByType($value, $recordModel, $fieldModel);
	}

	protected function getDisplayValueByType($value, \Vtiger_Record_Model $recordModel, \Vtiger_Field_Model $fieldModel)
	{
		switch ($fieldModel->getFieldDataType()) {
			case 'boolean':
				$value = ($value === 1) ? 'LBL_YES' : 'LBL_NO';
				$value = "$(translate : $value)$";
				break;
			case 'multipicklist':
				$value = explode(' |##| ', $value);
				$trValue = [];
				$countValue = count($value);
				for ($i = 0; $i < $countValue; $i++) {
					$trValue[] = "$(translate : {$recordModel->getModuleName()}|{$value[$i]})$";
				}
				if (is_array($trValue)) {
					$trValue = implode(' |##| ', $trValue);
				}
				$value = str_ireplace(' |##| ', ', ', $trValue);
				break;
			case 'picklist':
				$value = "$(translate : {$recordModel->getModuleName()}|$value)$";
				break;
			case 'time':
				$userModel = Users_Privileges_Model::getCurrentUserModel();
				$value = DateTimeField::convertToUserTimeZone(date('Y-m-d') . ' ' . $value)->format('H:i:s');
				if ($userModel->get('hour_format') === '12') {
					if ($value) {
						list($hours, $minutes, $seconds) = explode(':', $value);
						$format = '$(translate : PM)$';
						if ($hours > 12) {
							$hours = (int) $hours - 12;
						} else if ($hours < 12) {
							$format = '$(translate : AM)$';
						}
						//If hours zero then we need to make it as 12 AM
						if ($hours == '00') {
							$hours = '12';
							$format = '$(translate : AM)$';
						}
						$value = "$hours:$minutes $format";
					} else {
						$value = '';
					}
				}
				break;
			case 'tree':
				$template = $fieldModel->getFieldParams();
				$row = Fields\Tree::getValueByTreeId($template, $value);
				$value = $parentName = '';
				if ($row) {
					if ($row['depth'] > 0) {
						$parenttrre = $row['parenttrre'];
						$pieces = explode('::', $parenttrre);
						end($pieces);
						$parent = prev($pieces);
						$parentRow = Fields\Tree::getValueByTreeId($template, $parent);
						$parentName = "($(translate : {$recordModel->getModuleName()}|{$parentRow['name']})$) ";
					}
					$value = $parentName . "$(translate : {$recordModel->getModuleName()}|{$row['name']})$";
				}
				break;
			default:
				return $fieldModel->getDisplayValue($value, $recordModel->getId(), $recordModel, true);
				break;
		}
		return $value;
	}

	/**
	 * Get last comments
	 * @param int|bool $limit
	 * @return string
	 */
	protected function getComments($limit = false)
	{
		$query = (new \App\Db\Query())->select(['commentcontent'])->from('vtiger_modcomments')->where(['related_to' => $this->record])->orderBy(['modcommentsid' => SORT_DESC]);
		if ($limit) {
			$query->limit($limit);
		}
		$commentsList = '';
		foreach ($query->column() as $comment) {
			if ($comment != '') {
				$commentsList .= '<br /><br />' . nl2br($comment);
			}
		}
		return ltrim($commentsList, '<br /><br />');
	}

	/**
	 * Check if this content can be used
	 * @param \Vtiger_Field_Model $fieldModel
	 * @param string $moduleName
	 * @return boolean
	 */
	protected function useValue($fieldModel, $moduleName)
	{
		return true;
	}

	/**
	 * Parsing params
	 * @param string $params
	 * @return string
	 */
	protected function params($params)
	{
		if (isset($this->params[$params])) {
			return $this->params[$params];
		}
		return '';
	}

	/**
	 * Parsing custom
	 * @param string $params
	 * @return string
	 */
	protected function custom($params)
	{
		$params = explode('|', $params);
		$parserName = array_shift($params);
		$aparams = $params;
		$moduleName = array_shift($params);


		if (Module::getModuleId($moduleName)) {
			$handlerClass = \Vtiger_Loader::getComponentClassName('TextParser', $parserName, $this->moduleName, false);
			if (!$handlerClass) {
				Log::error("Not found custom class: $parserName|{$this->moduleName}");
			}
			$instance = new $handlerClass($this, $params);
		} else {
			$className = "\App\TextParser\\$parserName";
			if (!class_exists($className)) {
				Log::error("Not found custom class $parserName");
				return '';
			}
			$instance = new $className($this, $aparams);
		}



		if ($instance->isActive()) {
			return $instance->process();
		}
		return '';
	}

	/**
	 * Get record variables
	 * @param bool|string $fieldType
	 * @return array
	 */
	public function getRecordVariable($fieldType = false)
	{
		$cacheKey = "$this->moduleName|$fieldType";
		if (isset(static::$recordVariable[$cacheKey])) {
			return static::$recordVariable[$cacheKey];
		}
		$variables = [];
		if (!$fieldType) {
			foreach (static::$variableEntity as $key => $name) {
				$variables['LBL_ENTITY_VARIABLES'][] = [
					'var_value' => "$(record : $key)$",
					'var_label' => "$(translate : $name)$",
					'label' => $name
				];
			}
		}
		$moduleModel = \Vtiger_Module_Model::getInstance($this->moduleName);
		foreach ($moduleModel->getBlocks() as $blockModel) {
			foreach ($blockModel->getFields() as $fieldModel) {
				if ($fieldModel->isViewable() && !($fieldType && $fieldModel->getFieldDataType() !== $fieldType)) {
					$variables[$blockModel->get('label')][] = [
						'var_value' => "$(record : {$fieldModel->getName()})$",
						'var_label' => "$(translate : {$this->moduleName}|{$fieldModel->getFieldLabel()})$",
						'label' => $fieldModel->getFieldLabel()
					];
				}
			}
		}
		static::$recordVariable[$cacheKey] = $variables;
		return $variables;
	}

	/**
	 * Get source variables
	 * @return array
	 */
	public function getSourceVariable()
	{
		if (empty(\App\TextParser::$sourceModules[$this->moduleName])) {
			return false;
		}
		$variables = [];
		foreach (static::$variableEntity as $key => $name) {
			$variables['LBL_ENTITY_VARIABLES'][] = [
				'var_value' => "$(sourceRecord : $key)$",
				'var_label' => "$(translate : $name)$",
				'label' => Language::translate($name)
			];
		}
		foreach (\App\TextParser::$sourceModules[$this->moduleName] as $moduleName) {
			$moduleModel = \Vtiger_Module_Model::getInstance($moduleName);
			foreach ($moduleModel->getBlocks() as $blockModel) {
				foreach ($blockModel->getFields() as $fieldModel) {
					if ($fieldModel->isViewable()) {
						$variables[$moduleName][$blockModel->get('label')][] = [
							'var_value' => "$(sourceRecord : {$fieldModel->getName()})$",
							'var_label' => "$(translate : $moduleName|{$fieldModel->getFieldLabel()})$",
							'label' => Language::translate($fieldModel->getFieldLabel(), $moduleName)
						];
					}
				}
			}
		}
		return $variables;
	}

	/**
	 * Get related variables
	 * @param bool|string $fieldType
	 * @return array
	 */
	public function getRelatedVariable($fieldType = false)
	{
		$cacheKey = "$this->moduleName|$fieldType";
		if (isset(static::$relatedVariable[$cacheKey])) {
			return static::$relatedVariable[$cacheKey];
		}
		$moduleModel = \Vtiger_Module_Model::getInstance($this->moduleName);
		$variables = [];
		$entityVariables = Language::translate('LBL_ENTITY_VARIABLES');
		foreach ($moduleModel->getFieldsByType(array_merge(\Vtiger_Field_Model::$referenceTypes, ['owner', 'multireference'])) as $parentFieldName => $field) {
			if ($field->getFieldDataType() === 'owner') {
				$relatedModules = ['Users'];
			} else {
				$relatedModules = $field->getReferenceList();
			}
			$parentFieldNameLabel = Language::translate($field->getFieldLabel(), $this->moduleName);
			if (!$fieldType) {
				foreach (static::$variableEntity as $key => $name) {
					$variables[$parentFieldName]["$parentFieldNameLabel - $entityVariables"][] = [
						'var_value' => "$(relatedRecord : $parentFieldName|$key)$",
						'var_label' => "$(translate : $key)$",
						'label' => $parentFieldNameLabel . ': ' . Language::translate($name)
					];
				}
			}
			foreach ($relatedModules as $relatedModule) {
				$relatedModuleLang = Language::translate($relatedModule, $relatedModule);
				$moduleModel = \Vtiger_Module_Model::getInstance($relatedModule);
				foreach ($moduleModel->getBlocks() as $blockModel) {
					foreach ($blockModel->getFields() as $fieldName => $fieldModel) {
						if ($fieldModel->isViewable() && !($fieldType && $fieldModel->getFieldDataType() !== $fieldType)) {
							$labelGroup = "$parentFieldNameLabel: ($relatedModuleLang) " . Language::translate($blockModel->get('label'), $relatedModule);
							$variables[$parentFieldName][$labelGroup][] = [
								'var_value' => "$(relatedRecord : $parentFieldName|$fieldName|$relatedModule)$",
								'var_label' => "$(translate : $relatedModule|{$fieldModel->getFieldLabel()})$",
								'label' => "$parentFieldNameLabel: ($relatedModuleLang) " . Language::translate($fieldModel->getFieldLabel(), $relatedModule)
							];
						}
					}
				}
			}
		}
		static::$relatedVariable[$cacheKey] = $variables;
		return $variables;
	}

	/**
	 * Get general variables
	 * @return array
	 */
	public function getGeneralVariable()
	{
		$variables = [
			'LBL_ENTITY_VARIABLES' => array_map(function($value) {
					return Language::translate($value);
				}, array_flip(static::$variableGeneral))
		];
		$companyDetails = Company::getInstanceById()->getData();
		unset($companyDetails['id'], $companyDetails['logo_login'], $companyDetails['logo_login_height'], $companyDetails['logo_main'], $companyDetails['logo_main_height'], $companyDetails['logo_mail'], $companyDetails['logo_mail_height'], $companyDetails['default']);
		$companyVariables = [];
		foreach (array_keys($companyDetails) as $name) {
			$companyVariables["$(organization : $name)$"] = Language::translate('LBL_' . strtoupper($name), 'Settings:Companies');
		}
		$companyVariables['$(organization : mailLogo)$'] = Language::translate('LBL_LOGO_IMG_MAIL', 'Settings:Companies');
		$companyVariables['$(organization : loginLogo)$'] = Language::translate('LBL_LOGO_IMG_LOGIN', 'Settings:Companies');
		$companyVariables['$(organization : logo_login)$'] = Language::translate('LBL_LOGO_PATH_LOGIN', 'Settings:Companies');
		$companyVariables['$(organization : logo_main)$'] = Language::translate('LBL_LOGO_PATH_MAIN', 'Settings:Companies');
		$companyVariables['$(organization : logo_mail)$'] = Language::translate('LBL_LOGO_PATH_MAIL', 'Settings:Companies');
		$variables['LBL_COMPANY_VARIABLES'] = $companyVariables;
		$variables['LBL_CUSTOM_VARIABLES'] = array_merge($this->getBaseGeneralVariable(), $this->getModuleGeneralVariable());
		return $variables;
	}

	/**
	 * Get general variables base function
	 * @return array
	 */
	protected function getBaseGeneralVariable()
	{
		$variables = [];
		foreach ((new \DirectoryIterator(__DIR__ . DIRECTORY_SEPARATOR . 'TextParser')) as $fileInfo) {
			$fileName = $fileInfo->getBasename('.php');
			if ($fileInfo->getType() !== 'dir' && $fileName !== 'Base' && $fileInfo->getExtension() === 'php') {
				$className = '\App\TextParser\\' . $fileName;
				if (!class_exists($className)) {
					Log::warning('Not found custom class');
					continue;
				}
				$instance = new $className($this);
				if (isset($this->type) && $this->type !== $instance->type) {
					continue;
				}
				$variables["$(custom : $fileName)$"] = Language::translate($instance->name);
			}
		}
		return $variables;
	}

	/**
	 * Get general variables module function
	 * @return array
	 */
	protected function getModuleGeneralVariable()
	{
		$variables = [];
		if ($this->moduleName && is_dir(("modules/{$this->moduleName}/textParsers/"))) {
			foreach ((new \DirectoryIterator("modules/{$this->moduleName}/textParsers/")) as $fileInfo) {
				$fileName = $fileInfo->getBasename('.php');
				if ($fileInfo->getType() !== 'dir' && $fileInfo->getExtension() === 'php') {
					$handlerClass = \Vtiger_Loader::getComponentClassName('TextParser', $fileName, $this->moduleName);
					$instanceClass = new $handlerClass($this);
					if (isset($this->type) && $this->type !== $instanceClass->type) {
						continue;
					}
					$variables["$(custom : $fileName|{$this->moduleName})$"] = Language::translate($instanceClass->name, $this->moduleName);
				}
			}
		}
		return $variables;
	}

	/**
	 * Get related modules list
	 * @return array
	 */
	public function getRelatedListVariable()
	{
		$moduleModel = \Vtiger_Module_Model::getInstance($this->moduleName);
		$variables = [];
		$relationModels = $moduleModel->getRelations();
		foreach ($relationModels as $relation) {
			$variables[] = [
				'key' => '$(relatedRecordsList : ' . $relation->get('relatedModuleName') . ')$',
				'label' => Language::translate($relation->get('label'), $relation->get('relatedModuleName'))
			];
		}
		return $variables;
	}

	/**
	 * Get base modules list
	 * @return array
	 */
	public function getBaseListVariable()
	{
		$variables = [];
		foreach (\vtlib\Functions::getAllModules() as $module) {
			$variables[] = [
				'key' => "$(recordsList : {$module['name']})$",
				'label' => Language::translate($module['name'], $module['name'])
			];
		}
		return $variables;
	}
}
