<?php

/**
 *
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMail_Record_Model extends Vtiger_Record_Model
{

	/**
	 * Return accounts array
	 * @param int|bool $user
	 * @param bool $onlyMy
	 * @param bool $password
	 * @return array
	 */
	public static function getAccountsList($user = false, $onlyMy = false, $password = false)
	{
		$users = [];
		$query = (new \App\Db\Query())->from('roundcube_users');
		if ($user) {
			$query->where(['user_id' => $user]);
		}
		if ($onlyMy) {
			$query->andWhere(['crm_user_id' => \App\User::getCurrentUserId()]);
		}
		if ($password) {
			$query->andWhere(['<>', 'password', '']);
		}
		$dataReader = $query->createCommand()->query();
		while ($row = $dataReader->read()) {
			$row['actions'] = empty($row['actions']) ? [] : explode(',', $row['actions']);
			$users[] = $row;
		}
		return $users;
	}

	/**
	 * Returns Roundcube configuration
	 * @return array
	 */
	public static function load_roundcube_config()
	{
		include 'public_html/modules/OSSMail/roundcube/config/defaults.inc.php';
		include 'config/modules/OSSMail.php';
		return $config;
	}

	/**
	 * Imap connection cache
	 * @var array
	 */
	protected static $imapConnectCache = [];

	/**
	 * $imapConnectMailbox
	 * @var string
	 */
	public static $imapConnectMailbox = '';

	/**
	 * Return imap connection resource
	 * @param string $user
	 * @param string $password
	 * @param string $host
	 * @param string $folder
	 * @param bool $dieOnError
	 * @param array $config
	 * @return resource
	 */
	public static function imapConnect($user, $password, $host = false, $folder = 'INBOX', $dieOnError = true, $config = false)
	{
		\App\Log::trace("Entering OSSMail_Record_Model::imapConnect($user , $password , $folder) method ...");
		if (!$config) {
			$config = self::load_roundcube_config();
		}
		$cacheName = $user . $host . $folder;
		if (isset(self::$imapConnectCache[$cacheName])) {
			return self::$imapConnectCache[$cacheName];
		}
		if (!$host) {
			$host = key($config['default_host']);
		}
		$parseHost = parse_url($host);
		$validatecert = '';
		if (!empty($parseHost['host'])) {
			$host = $parseHost['host'];
			$sslMode = (isset($parseHost['scheme']) && in_array($parseHost['scheme'], ['ssl', 'imaps', 'tls'])) ? $parseHost['scheme'] : null;
			if (!empty($parseHost['port'])) {
				$port = $parseHost['port'];
			} else if ($sslMode && $sslMode !== 'tls' && (!$config['default_port'] || $config['default_port'] == 143)) {
				$port = 993;
			}
		} else {
			if ($config['default_port'] == 993) {
				$sslMode = 'ssl';
			} else {
				$sslMode = 'tls';
			}
		}
		if (empty($port)) {
			$port = $config['default_port'];
		}
		if (!$config['validate_cert'] && $config['imap_open_add_connection_type']) {
			$validatecert = '/novalidate-cert';
		}
		if ($config['imap_open_add_connection_type']) {
			$sslMode = '/' . $sslMode;
		} else {
			$sslMode = '';
		}
		imap_timeout(IMAP_OPENTIMEOUT, 5);
		$maxRetries = $options = 0;
		if (isset($config['imap_max_retries'])) {
			$maxRetries = $config['imap_max_retries'];
		}
		$params = [];
		if (isset($config['imap_params'])) {
			$params = $config['imap_params'];
		}
		static::$imapConnectMailbox = "{{$host}:{$port}/imap{$sslMode}{$validatecert}}{$folder}";
		\App\Log::trace("imap_open(({" . static::$imapConnectMailbox . ", $user , $password. $options, $maxRetries, " . var_export($params, true) . ') method ...');
		$mbox = @imap_open(static::$imapConnectMailbox, $user, $password, $options, $maxRetries, $params);
		if (!$mbox) {
			\App\Log::error('Error OSSMail_Record_Model::imapConnect(): ' . imap_last_error());
			if ($dieOnError) {
				throw new \Exception\AppException(\App\Language::translate('IMAP_ERROR', 'OSSMailScanner') . ': ' . imap_last_error());
			}
		}
		self::$imapConnectCache[$cacheName] = $mbox;
		\App\Log::trace('Exit OSSMail_Record_Model::imapConnect() method ...');
		return $mbox;
	}

	/**
	 * Update mailbox mesages info for users
	 * @param array $users
	 * @return boolean
	 */
	public static function updateMailBoxmsgInfo($users)
	{

		\App\Log::trace(__METHOD__ . ' - Start');
		$dbCommand = \App\Db::getInstance()->createCommand();
		if (count($users) == 0) {
			return false;
		}
		$sUsers = implode(',', $users);
		$query = (new \App\Db\Query())->from('yetiforce_mail_quantities')->where(['userid' => $sUsers, 'status' => 1]);
		if (!$query->count()) {
			return false;
		}
		$dbCommand->update('yetiforce_mail_quantities', ['status' => 1], ['userid' => $sUsers])->execute();
		foreach ($users as $user) {
			$account = self::getMailAccountDetail($user);
			if ($account !== false) {
				$result = (new \App\Db\Query())->from('yetiforce_mail_quantities')->where(['userid' => $user])->count();
				$mbox = self::imapConnect($account['username'], $account['password'], $account['mail_host'], 'INBOX', false);
				if ($mbox) {
					$info = imap_mailboxmsginfo($mbox);
					if ($result > 0) {
						$dbCommand->update('yetiforce_mail_quantities', ['num' => $info->Unread, 'status' => 0], ['userid' => $user])->execute();
					} else {
						$dbCommand->insert('yetiforce_mail_quantities', ['num' => $info->Unread, 'userid' => $user])->execute();
					}
				}
			}
		}
		\App\Log::trace(__METHOD__ . ' - End');
		return true;
	}

	/**
	 * Return users messages count
	 * @param array $users
	 * @return array
	 */
	public static function getMailBoxmsgInfo($users)
	{

		$query = (new \App\Db\Query())->select(['userid', 'num'])->from('yetiforce_mail_quantities')->where(['userid' => $users]);
		return $query->createCommand()->queryAllByGroup(0);
	}

	/**
	 *
	 * @param resource $mbox
	 * @param int $id
	 * @param int $msgno
	 * @return boolean|\OSSMail_Mail_Model
	 */
	public static function getMail($mbox, $id, $msgno = false)
	{
		if (!$msgno) {
			$msgno = imap_msgno($mbox, $id);
		}
		if (!$id) {
			$id = imap_uid($mbox, $msgno);
		}
		if (!$msgno) {
			return false;
		}
		$header = imap_header($mbox, $msgno);
		$structure = self::_get_body_attach($mbox, $id, $msgno);

		$msgid = '';
		if (property_exists($header, 'message_id')) {
			$msgid = $header->message_id;
		}
		$mail = new OSSMail_Mail_Model();
		$mail->set('header', $header);
		$mail->set('id', $id);
		$mail->set('Msgno', $header->Msgno);
		$mail->set('message_id', $msgid);
		$mail->set('toaddress', $mail->getEmail('to'));
		$mail->set('fromaddress', $mail->getEmail('from'));
		$mail->set('reply_toaddress', $mail->getEmail('reply_to'));
		$mail->set('ccaddress', $mail->getEmail('cc'));
		$mail->set('bccaddress', $mail->getEmail('bcc'));
		$mail->set('senderaddress', $mail->getEmail('sender'));
		$mail->set('subject', self::_decode_text($header->subject));
		$mail->set('MailDate', $header->MailDate);
		$mail->set('date', $header->date);
		$mail->set('udate', $header->udate);
		$mail->set('udate_formated', date('Y-m-d H:i:s', $header->udate));
		$mail->set('Recent', $header->Recent);
		$mail->set('Unseen', $header->Unseen);
		$mail->set('Flagged', $header->Flagged);
		$mail->set('Answered', $header->Answered);
		$mail->set('Deleted', $header->Deleted);
		$mail->set('Draft', $header->Draft);
		$mail->set('Size', $header->Size);
		$mail->set('body', $structure['body']);
		$mail->set('attachments', $structure['attachment']);

		$clean = '';
		$msgs = imap_fetch_overview($mbox, $msgno);
		foreach ($msgs as $msg) {
			$clean .= imap_fetchheader($mbox, $msg->msgno);
		}
		$mail->set('clean', $clean);
		return $mail;
	}

	/**
	 * Users cache
	 * @var array
	 */
	protected static $usersCache = [];

	/**
	 * Return user account detal
	 * @param int $userid
	 * @return array
	 */
	public static function getMailAccountDetail($userid)
	{
		if (isset(self::$usersCache[$userid])) {
			return self::$usersCache[$userid];
		}
		$user = (new \App\Db\Query())->from('roundcube_users')->where(['user_id' => $userid])->one();

		self::$usersCache[$userid] = $user;
		return $user;
	}

	/**
	 * Convert text encoding
	 * @param string $text
	 * @return string
	 */
	public static function _decode_text($text)
	{
		$data = imap_mime_header_decode($text);
		$text = '';
		foreach ($data as &$row) {
			$charset = ($row->charset == 'default') ? 'ASCII' : $row->charset;
			if (function_exists('mb_convert_encoding') && in_array($charset, mb_list_encodings())) {
				$text .= mb_convert_encoding($row->text, 'utf-8', $charset);
			} else {
				$text .= iconv($charset, 'UTF-8', $row->text);
			}
		}
		return $text;
	}

	/**
	 * Return full name
	 * @param string $text
	 * @return string
	 */
	public static function get_full_name($text)
	{
		$return = '';
		foreach ($text as $row) {
			if ($return != '') {
				$return .= ',';
			}
			if ($row->personal == '') {
				$return .= $row->mailbox . '@' . $row->host;
			} else {
				$return .= self::_decode_text($row->personal) . ' - ' . $row->mailbox . '@' . $row->host;
			}
		}
		return $return;
	}

	/**
	 * Return body and attachments
	 * @param resource $mbox
	 * @param int $id
	 * @param int $msgno
	 * @return array
	 */
	public static function _get_body_attach($mbox, $id, $msgno)
	{
		$struct = imap_fetchstructure($mbox, $id, FT_UID);
		$mail = ['id' => $id];
		if (empty($struct->parts)) {
			$mail = self::initMailPart($mbox, $mail, $struct, 0);
		} else {
			foreach ($struct->parts as $partNum => $partStructure) {
				$mail = self::initMailPart($mbox, $mail, $partStructure, $partNum + 1);
			}
		}
		$body = '';
		$body = (!empty($mail['textPlain'])) ? $mail['textPlain'] : $body;
		$body = (!empty($mail['textHtml'])) ? $mail['textHtml'] : $body;
		$attachment = (isset($mail['attachments'])) ? $mail['attachments'] : [];
		return [
			'body' => $body,
			'attachment' => $attachment,
		];
	}

	/**
	 * Init mail part
	 * @param resource $mbox
	 * @param array $mail
	 * @param object $partStructure
	 * @param int $partNum
	 * @return array
	 */
	protected static function initMailPart($mbox, $mail, $partStructure, $partNum)
	{
		$data = $partNum ? imap_fetchbody($mbox, $mail['id'], $partNum, FT_UID | FT_PEEK) : imap_body($mbox, $mail['id'], FT_UID | FT_PEEK);
		if ($partStructure->encoding == 1) {
			$data = imap_utf8($data);
		} elseif ($partStructure->encoding == 2) {
			$data = imap_binary($data);
		} elseif ($partStructure->encoding == 3) {
			$data = imap_base64($data);
		} elseif ($partStructure->encoding == 4) {
			$data = imap_qprint($data);
		}
		$params = [];
		if (!empty($partStructure->parameters)) {
			foreach ($partStructure->parameters as $param) {
				$params[strtolower($param->attribute)] = $param->value;
			}
		}
		if (!empty($partStructure->dparameters)) {
			foreach ($partStructure->dparameters as $param) {
				$paramName = strtolower(preg_match('~^(.*?)\*~', $param->attribute, $matches) ? $matches[1] : $param->attribute);
				if (isset($params[$paramName])) {
					$params[$paramName] .= $param->value;
				} else {
					$params[$paramName] = $param->value;
				}
			}
		}
		if (!empty($params['charset']) && strtolower($params['charset']) !== 'utf-8') {
			if (function_exists('mb_convert_encoding') && in_array($params['charset'], mb_list_encodings())) {
				$encodedData = mb_convert_encoding($data, 'UTF-8', $params['charset']);
			} else {
				$encodedData = iconv($params['charset'], 'UTF-8', $data);
			}
			if ($encodedData) {
				$data = $encodedData;
			}
		}
		$attachmentId = $partStructure->ifid ? trim($partStructure->id, ' <>') : (isset($params['filename']) || isset($params['name']) ? mt_rand() . mt_rand() : null);
		if ($attachmentId) {
			if (empty($params['filename']) && empty($params['name'])) {
				$fileName = $attachmentId . '.' . strtolower($partStructure->subtype);
			} else {
				$fileName = !empty($params['filename']) ? $params['filename'] : $params['name'];
				$fileName = self::_decode_text($fileName);
				$fileName = self::decodeRFC2231($fileName);
			}
			$mail['attachments'][$attachmentId]['filename'] = $fileName;
			$mail['attachments'][$attachmentId]['attachment'] = $data;
		} elseif ($partStructure->type == 0 && $data) {
			if (preg_match('/^([a-zA-Z0-9]{76} )+[a-zA-Z0-9]{76}$/', $data) && base64_decode($data, true)) {
				$data = base64_decode($data);
			}
			if (strtolower($partStructure->subtype) == 'plain') {
				$uuDecode = self::uuDecode($data);
				if (isset($uuDecode['attachments'])) {
					$mail['attachments'] = $uuDecode['attachments'];
				}
				if (!isset($mail['textPlain'])) {
					$mail['textPlain'] = '';
				}
				$mail['textPlain'] .= $uuDecode['text'];
			} else {
				if (!isset($mail['textHtml'])) {
					$mail['textHtml'] = '';
				}
				$mail['textHtml'] .= $data;
			}
		} elseif ($partStructure->type == 2 && $data) {
			if (!isset($mail['textPlain'])) {
				$mail['textPlain'] = '';
			}
			$mail['textPlain'] .= trim($data);
		}
		if (!empty($partStructure->parts)) {
			foreach ($partStructure->parts as $subPartNum => $subPartStructure) {
				if ($partStructure->type == 2 && $partStructure->subtype == 'RFC822') {
					$mail = self::initMailPart($mbox, $mail, $subPartStructure, $partNum);
				} else {
					$mail = self::initMailPart($mbox, $mail, $subPartStructure, $partNum . '.' . ($subPartNum + 1));
				}
			}
		}
		return $mail;
	}

	/**
	 * Decode string
	 * @param string $input
	 * @return array
	 */
	protected static function uuDecode($input)
	{
		$attachments = $parts = [];
		$uu_regexp_begin = '/begin [0-7]{3,4} ([^\r\n]+)\r?\n/s';
		$uu_regexp_end = '/`\r?\nend((\r?\n)|($))/s';

		while (preg_match($uu_regexp_begin, $input, $matches, PREG_OFFSET_CAPTURE)) {
			$startpos = $matches[0][1];
			if (!preg_match($uu_regexp_end, $input, $m, PREG_OFFSET_CAPTURE, $startpos)) {
				break;
			}

			$endpos = $m[0][1];
			$begin_len = strlen($matches[0][0]);
			$end_len = strlen($m[0][0]);

			// extract attachment body
			$filebody = substr($input, $startpos + $begin_len, $endpos - $startpos - $begin_len - 1);
			$filebody = str_replace("\r\n", "\n", $filebody);

			// remove attachment body from the message body
			$input = substr_replace($input, '', $startpos, $endpos + $end_len - $startpos);

			// add attachments to the structure
			$attachments[] = [
				'filename' => trim($matches[1][0]),
				'attachment' => convert_uudecode($filebody)
			];
		}
		return ['attachments' => $attachments, 'text' => $input];
	}

	/**
	 * Check if url is encoded
	 * @param string $string
	 * @return bool
	 */
	public static function isUrlEncoded($string)
	{
		$string = str_replace('%20', '+', $string);
		$decoded = urldecode($string);
		return $decoded != $string && urlencode($decoded) == $string;
	}

	/**
	 * decode RFC2231 formatted string
	 * @param string $string
	 * @param string $charset
	 * @return string
	 */
	protected static function decodeRFC2231($string, $charset = 'utf-8')
	{
		if (preg_match("/^(.*?)'.*?'(.*?)$/", $string, $matches)) {
			$encoding = $matches[1];
			$data = $matches[2];
			if (self::isUrlEncoded($data)) {
				$string = iconv(strtoupper($encoding), $charset, urldecode($data));
			}
		}
		return $string;
	}

	/**
	 * Return user folders
	 * @param int $user
	 * @return array
	 */
	public static function getFolders($user)
	{
		$account = self::getAccountsList($user);
		$account = reset($account);
		$folders = false;
		$mbox = self::imapConnect($account['username'], $account['password'], $account['mail_host'], 'INBOX', false);
		if ($mbox) {
			$folders = [];
			$ref = '{' . $account['mail_host'] . '}';
			$list = imap_list($mbox, $ref, '*');
			foreach ($list as $mailboxname) {
				$name = str_replace($ref, '', $mailboxname);
				$folders[$name] = self::convertCharacterEncoding($name, 'UTF-8', 'UTF7-IMAP');
			}
		}
		return $folders;
	}

	/**
	 * Convert string from encoding to encoding
	 * @param string $value
	 * @param string $toCharset
	 * @param string $fromCharset
	 * @return string
	 */
	public static function convertCharacterEncoding($value, $toCharset, $fromCharset)
	{
		if (function_exists('mb_convert_encoding')) {
			$value = mb_convert_encoding($value, $toCharset, $fromCharset);
		} else {
			$value = iconv($toCharset, $fromCharset, $value);
		}
		return $value;
	}

	/**
	 * Return viewable data
	 * @return array
	 */
	public static function getViewableData()
	{
		$return = [];
		include 'config/modules/OSSMail.php';
		foreach ($config as $key => $value) {
			if ($key == 'skin_logo') {
				$return[$key] = $value['*'];
			} else {
				$return[$key] = $value;
			}
		}
		return $return;
	}

	/**
	 * Set config params
	 * @param array $param
	 * @param bool $dbupdate
	 * @return string
	 */
	public static function setConfigData($param, $dbupdate = true)
	{
		$fileName = 'config/modules/OSSMail.php';
		$fileContent = file_get_contents($fileName);
		$Fields = self::getEditableFields();
		foreach ($param as $fieldName => $fieldValue) {
			$type = $Fields[$fieldName]['fieldType'];
			$pattern = '/(\$config\[\'' . $fieldName . '\'\])[\s]+=([^;]+);/';
			if ($type == 'checkbox' || $type == 'int') {
				$patternString = "\$config['%s'] = %s;";
			} elseif ($type == 'multipicklist') {
				if (!is_array($fieldValue)) {
					$fieldValue = [$fieldValue];
				}
				$saveValue = '[';
				foreach ($fieldValue as $value) {
					$saveValue .= "'$value' => '$value',";
				}
				$saveValue .= ']';
				$fieldValue = $saveValue;
				$patternString = "\$config['%s'] = %s;";
			} elseif ($fieldName == 'skin_logo') {
				$patternString = "\$config['%s'] = array(\"*\" => \"%s\");";
			} else {
				$patternString = "\$config['%s'] = '%s';";
			}
			$replacement = sprintf($patternString, $fieldName, $fieldValue);
			$fileContent = preg_replace($pattern, $replacement, $fileContent);
		}
		$filePointer = fopen($fileName, 'w');
		fwrite($filePointer, $fileContent);
		fclose($filePointer);
		if ($dbupdate) {
			\App\Db::getInstance()->createCommand()->update('roundcube_users', ['language' => $param['language']])->execute();
		}
		return \App\Language::translate('JS_save_config_info', 'OSSMailScanner');
	}

	/**
	 * Return editable fields
	 * @return array
	 */
	public function getEditableFields()
	{
		return [
			'product_name' => ['label' => 'LBL_RC_product_name', 'fieldType' => 'text', 'required' => 1],
			'validate_cert' => ['label' => 'LBL_RC_validate_cert', 'fieldType' => 'checkbox', 'required' => 0],
			'imap_open_add_connection_type' => ['label' => 'LBL_RC_imap_open_add_connection_type', 'fieldType' => 'checkbox', 'required' => 0],
			'default_host' => ['label' => 'LBL_RC_default_host', 'fieldType' => 'multipicklist', 'required' => 1],
			'default_port' => ['label' => 'LBL_RC_default_port', 'fieldType' => 'int', 'required' => 1],
			'smtp_server' => ['label' => 'LBL_RC_smtp_server', 'fieldType' => 'text', 'required' => 1],
			'smtp_user' => ['label' => 'LBL_RC_smtp_user', 'fieldType' => 'text', 'required' => 1],
			'smtp_pass' => ['label' => 'LBL_RC_smtp_pass', 'fieldType' => 'text', 'required' => 1],
			'smtp_port' => ['label' => 'LBL_RC_smtp_port', 'fieldType' => 'int', 'required' => 1],
			'language' => ['label' => 'LBL_RC_language', 'fieldType' => 'picklist', 'required' => 1, 'value' => ['ar_SA', 'az_AZ', 'be_BE', 'bg_BG', 'bn_BD', 'bs_BA', 'ca_ES', 'cs_CZ', 'cy_GB', 'da_DK', 'de_CH', 'de_DE', 'el_GR', 'en_CA', 'en_GB', 'en_US', 'es_419', 'es_AR', 'es_ES', 'et_EE', 'eu_ES', 'fa_AF', 'fa_IR', 'fi_FI', 'fr_FR', 'fy_NL', 'ga_IE', 'gl_ES', 'he_IL', 'hi_IN', 'hr_HR', 'hu_HU', 'hy_AM', 'id_ID', 'is_IS', 'it_IT', 'ja_JP', 'ka_GE', 'km_KH', 'ko_KR', 'lb_LU', 'lt_LT', 'lv_LV', 'mk_MK', 'ml_IN', 'mr_IN', 'ms_MY', 'nb_NO', 'ne_NP', 'nl_BE', 'nl_NL', 'nn_NO', 'pl_PL', 'pt_BR', 'pt_PT', 'ro_RO', 'ru_RU', 'si_LK', 'sk_SK', 'sl_SI', 'sq_AL', 'sr_CS', 'sv_SE', 'ta_IN', 'th_TH', 'tr_TR', 'uk_UA', 'ur_PK', 'vi_VN', 'zh_CN', 'zh_TW']],
			'username_domain' => ['label' => 'LBL_RC_username_domain', 'fieldType' => 'text', 'required' => 0],
			'skin_logo' => ['label' => 'LBL_RC_skin_logo', 'fieldType' => 'text', 'required' => 1],
			'ip_check' => ['label' => 'LBL_RC_ip_check', 'fieldType' => 'checkbox', 'required' => 0],
			'enable_spellcheck' => ['label' => 'LBL_RC_enable_spellcheck', 'fieldType' => 'checkbox', 'required' => 0],
			'identities_level' => ['label' => 'LBL_RC_identities_level', 'fieldType' => 'picklist', 'required' => 1, 'value' => [0, 1, 2, 3, 4]],
			'session_lifetime' => ['label' => 'LBL_RC_session_lifetime', 'fieldType' => 'int', 'required' => 1],
		];
	}

	/**
	 * Return site URL
	 * @return string
	 */
	public static function getSiteUrl()
	{
		$site_URL = AppConfig::main('site_URL');
		if (substr($site_URL, -1) != '/') {
			$site_URL = $site_URL . '/';
		}
		return $site_URL;
	}

	/**
	 * Fetch mails from IMAP
	 * @param int $user
	 * @return array
	 */
	public static function getMailsFromIMAP($user = false)
	{
		$account = self::getAccountsList($user, true);
		$mails = [];
		$mailLimit = 5;
		if ($account) {
			$imap = self::imapConnect($account[0]['username'], $account[0]['password'], $account[0]['mail_host']);
			$numMessages = imap_num_msg($imap);
			if ($numMessages < $mailLimit) {
				$mailLimit = $numMessages;
			}
			for ($i = $numMessages; $i > ($numMessages - $mailLimit); $i--) {
				$mail = self::getMail($imap, false, $i);
				$mails[] = $mail;
			}
			imap_close($imap);
		}
		return $mails;
	}

	/**
	 * Get mail account detail by hash ID
	 * @param string $hash
	 * @return boolean|array
	 */
	public static function getAccountByHash($hash)
	{
		if (preg_match("/^[_a-zA-Z0-9.,]+$/", $hash)) {
			$result = (new \App\Db\Query())
				->from('roundcube_users')
				->where(['like', 'preferences', "%:\"$hash\";%", false])
				->one();
			if ($result) {
				return $result;
			}
		}
		return false;
	}
}
