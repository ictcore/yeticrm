<?php

/**
 *
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMail_Module_Model extends Vtiger_Module_Model
{

	public function getDefaultViewName()
	{
		return 'index';
	}

	public function getSettingLinks()
	{
		Vtiger_Loader::includeOnce('~~modules/com_vtiger_workflow/VTWorkflowUtils.php');
		$settingsLinks = [];
		$fieldId = (new App\Db\Query())->select(['fieldid'])
			->from('vtiger_settings_field')
			->where(['name' => 'OSSMail', 'description' => 'OSSMail'])
			->scalar();
		$settingsLinks[] = [
			'linktype' => 'LISTVIEWSETTING',
			'linklabel' => 'LBL_MODULE_CONFIGURATION',
			'linkurl' => 'index.php?module=OSSMail&parent=Settings&view=index&block=4&fieldid=' . $fieldId,
			'linkicon' => Vtiger_Theme::getImagePath('LayoutEditor.gif')
		];
		return $settingsLinks;
	}

	public static function getDefaultMailAccount($accounts)
	{
		$rcUser = (isset($_SESSION['AutoLoginUser']) && array_key_exists($_SESSION['AutoLoginUser'], $accounts)) ? $accounts[$_SESSION['AutoLoginUser']] : reset($accounts);
		return $rcUser;
	}

	public static function getComposeUrl($moduleName = false, $record = false, $view = false, $type = false)
	{
		$url = 'index.php?module=OSSMail&view=compose';
		if ($moduleName) {
			$url .= '&crmModule=' . $moduleName;
		}
		if ($record) {
			$url .= '&crmRecord=' . $record;
		}
		if ($view) {
			$url .= '&crmView=' . $view;
		}
		if ($type) {
			$url .= '&type=' . $type;
		}
		return $url;
	}

	public static function getComposeParam(\App\Request $request)
	{
		$moduleName = $request->get('crmModule');
		$record = $request->get('crmRecord');
		$type = $request->get('type');

		$return = [];
		if (!empty($record) && isRecordExists($record) && Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $record)) {
			$recordModel_OSSMailView = Vtiger_Record_Model::getCleanInstance('OSSMailView');
			$email = $recordModel_OSSMailView->findEmail($record, $moduleName);
			if (!empty($email)) {
				$return['to'] = $email;
			}
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
			$modulesLevel1 = \App\ModuleHierarchy::getModulesByLevel();
			if (!in_array($moduleName, array_keys($modulesLevel1)) || $moduleName === 'Campaigns') {
				$subject = '';
				if ($type === 'new' || $moduleName === 'Campaigns') {
					$return['title'] = $recordModel->getName();
					$subject .= $recordModel->getName();
				}
				$recordNumber = $recordModel->getRecordNumber();
				if (!empty($recordNumber)) {
					$return['recordNumber'] = $recordNumber;
					$subject = "[$recordNumber] $subject";
				}
				$return['subject'] = $subject;
			}
		}
		if (!empty($moduleName)) {
			$return['crmmodule'] = $moduleName;
		}
		if (!empty($record)) {
			$return['crmrecord'] = $record;
		}
		if (!$request->isEmpty('crmView')) {
			$return['crmview'] = $request->get('crmView');
		}
		if (!$request->isEmpty('mid') && !empty($type)) {
			$return['mailId'] = (int) $request->get('mid');
			$return['type'] = $type;
		}
		if (!$request->isEmpty('pdf_path')) {
			$return['filePath'] = $request->get('pdf_path');
		}
		if (!empty($moduleName)) {
			$currentUser = Users_Record_Model::getCurrentUserModel();
			$moduleConfig = AppConfig::module($moduleName);
			if ($moduleConfig && isset($moduleConfig['SEND_IDENTITY'][$currentUser->get('roleid')])) {
				$return['from'] = $moduleConfig['SEND_IDENTITY'][$currentUser->get('roleid')];
			}
		}
		if (!$request->isEmpty('to')) {
			$return['to'] = $request->get('to');
		}
		if (!$request->isEmpty('cc')) {
			$return['cc'] = $request->get('cc');
		}
		if (!$request->isEmpty('bcc')) {
			$return['bcc'] = $request->get('bcc');
		}
		if (!$request->isEmpty('subject')) {
			$return['subject'] = $request->get('subject');
		}
		if (!$request->isEmpty('emails')) {
			$return['bcc'] = implode(',', $request->get('emails'));
		}
		return $return;
	}

	protected static $composeParam = false;

	/**
	 * Function get compose parameters
	 * @return array
	 */
	public static function getComposeParameters()
	{
		if (!self::$composeParam) {
			$config = (new \App\Db\Query())->select(['parameter', 'value'])->from('vtiger_ossmailscanner_config')
					->where(['conf_type' => 'email_list'])->createCommand()->queryAllByGroup(0);
			$config['popup'] = $config['target'] == '_blank' ? true : false;
			self::$composeParam = $config;
		}
		return self::$composeParam;
	}

	public static function getExternalUrl($moduleName = false, $record = false, $view = false, $type = false)
	{
		$url = 'mailto:';
		if (!empty($record) && isRecordExists($record) && Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $record)) {
			$recordModel_OSSMailView = Vtiger_Record_Model::getCleanInstance('OSSMailView');
			$email = $recordModel_OSSMailView->findEmail($record, $moduleName);
			if (!empty($email)) {
				$url .= $email;
			}
			$url .= '?';
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
			$moduleModel = $recordModel->getModule();

			$modulesLevel1 = \App\ModuleHierarchy::getModulesByLevel();
			if (!in_array($moduleName, array_keys($modulesLevel1))) {
				$fieldName = (new \App\Db\Query)->select(['fieldname'])->from('vtiger_field')->where(['tabid' => $moduleModel->getId(), 'uitype' => 4])->scalar();
				if ($fieldName) {
					$subject = 'subject=';
					if ($type == 'new') {
						switch ($moduleName) {
							case 'HelpDesk':
								$subject .= $recordModel->get('ticket_title') . ' ';
								break;
							case 'SSalesProcesses':
								$subject .= $recordModel->get('subject') . ' ';
								break;
							case 'Project':
								$subject .= $recordModel->get('projectname') . ' ';
								break;
						}
					}
					$subject .= '[' . $fieldName . ']';
					$url .= $subject;
				}
			}
		}
		return $url;
	}

	/**
	 * Get mail url for widget
	 * @param int $record
	 * @param string $type
	 * @param int $srecord
	 * @param string $smoduleName
	 * @return string
	 */
	public static function getExternalUrlForWidget($record, $type, $srecord = false, $smoduleName = false)
	{
		if (is_object($record)) {
			$body = $record->get('content');
			$subject = $record->get('subject');
			$from = $record->get('from_email');
			$to = $record->get('to_email');
			$cc = $record->get('cc_email');
			$date = $record->get('date');
		} else {
			$body = $record['bodyRaw'];
			$subject = $record['subjectRaw'];
			$from = $record['fromRaw'];
			$to = $record['toRaw'];
			$cc = $record['ccRaw'];
			$date = $record['date'];
		}

		if (!empty($srecord) && !empty($smoduleName)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($srecord);
			$moduleModel = $recordModel->getModule();
			$modulesLevel1 = \App\ModuleHierarchy::getModulesByLevel();
			if (!in_array($smoduleName, array_keys($modulesLevel1))) {
				$fieldName = (new \App\Db\Query)->select(['fieldname'])->from('vtiger_field')->where(['tabid' => $moduleModel->getId(), 'uitype' => 4])->scalar();
				if ($fieldName) {
					$subject .= '[' . $fieldName . ']';
				}
			}
		}
		if ($type == 'forward') {
			$url = 'mailto:';
			$subject = 'Fwd: ' . $subject;
		} else {
			$url = 'mailto:' . $from;
			$subject = 'Re: ' . $subject;
		}
		$url .= '?subject=' . $subject;
		if ($type == 'replyAll' && !empty($cc)) {
			$url .= '&cc=' . $cc;
		}
		include_once ('vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php');
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Core.Encoding', vglobal('default_charset'));
		$config->set('Cache.SerializerPath', ROOT_DIRECTORY . '/cache/vtlib');
		$config->set('CSS.AllowTricky', false);
		$config->set('HTML.AllowedElements', 'div,p,br');
		$config->set('HTML.AllowedAttributes', '');
		$purifier = new HTMLPurifier($config);
		$body = $purifier->purify($body);
		$body = str_replace(['<p> </p>', '<p></p>', '</p>', '<br />', '<p>', '<div>', '</div>', PHP_EOL . PHP_EOL, PHP_EOL . PHP_EOL], ['', '', PHP_EOL, PHP_EOL, '', '', PHP_EOL, PHP_EOL, PHP_EOL], nl2br($body));

		$content = '';
		$mailtoLimit = AppConfig::module('Mail', 'MAILTO_LIMIT');

		if ($type == 'forward') {
			$content .= \App\Language::translate('LBL_MAIL_FORWARD_INTRO', 'OSSMailView') . PHP_EOL;
			$content .= \App\Language::translate('Subject', 'OSSMailView') . ': ' . $subject . PHP_EOL;
			$content .= \App\Language::translate('Date', 'OSSMailView') . ': ' . $date . PHP_EOL;
			$content .= \App\Language::translate('From', 'OSSMailView') . ': ' . $from . PHP_EOL;
			$content .= \App\Language::translate('To', 'OSSMailView') . ': ' . $to . PHP_EOL;
			foreach (explode(PHP_EOL, $body) as $line) {
				$line = trim($line);
				if (!empty($line)) {
					$line = '> ' . $line . PHP_EOL;
					if (strlen($url . '&body=' . rawurlencode($content . $line)) > $mailtoLimit) {
						break;
					}
					$content .= $line;
				}
			}
		} else {
			$content .= \App\Language::translate('LBL_MAIL_REPLY_INTRO', 'OSSMailView', $date, $from) . PHP_EOL;
			foreach (explode(PHP_EOL, $body) as $line) {
				$line = trim($line);
				if (!empty($line)) {
					$line = '> ' . $line . PHP_EOL;
					if (strlen($url . '&body=' . rawurlencode($content . $line)) > $mailtoLimit) {
						break;
					}
					$content .= $line;
				}
			}
		}
		$url .= '&body=' . rawurlencode($content);
		return $url;
	}
}
