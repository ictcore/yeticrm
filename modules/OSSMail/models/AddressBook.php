<?php

/**
 * Address book model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMail_AddressBook_Model
{

	const TABLE = 'u_yf_mail_address_book';
	const LAST_RECORD_CACHE = 'cache/addressBook.php';

	public static function createABFile()
	{
		$mails = [];
		$adb = PearDatabase::getInstance();
		$result = $adb->query(sprintf('SELECT * FROM %s', self::TABLE));
		while ($row = $adb->getRow($result)) {
			$name = $row['name'];
			$email = $row['email'];
			$users = $row['users'];
			if (!empty($users)) {
				$users = explode(',', ltrim($users, ','));
				foreach ($users as &$user) {
					$mails[$user] .= "'" . addslashes($name) . " <$email>',";
				}
			}
		}
		$fstart = '<?php $bookMails = [';
		$fend = '];';

		foreach ($mails as $user => $file) {
			file_put_contents('cache/addressBook/mails_' . $user . '.php', $fstart . $file . $fend);
		}
	}

	public static function getLastRecord()
	{
		if (file_exists(self::LAST_RECORD_CACHE)) {
			return require self::LAST_RECORD_CACHE;
		}
		return false;
	}

	public static function saveLastRecord($record, $module)
	{
		file_put_contents(self::LAST_RECORD_CACHE, "<?php return ['module' => '$module','record' => $record];");
	}

	public static function clearLastRecord()
	{
		unlink(self::LAST_RECORD_CACHE);
	}
}
