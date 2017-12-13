<?php

/**
 * Browsing history
 * @package YetiForce.Helpers
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Michał Lorencik <m.lorencik@yetiforce.com>
 */
class Vtiger_BrowsingHistory_Helper
{

	/**
	 * Get browsing history
	 * @return array
	 */
	public static function getHistory()
	{
		$results = (new \App\Db\Query())->from('u_#__browsinghistory')
			->where(['userid' => App\User::getCurrentUserId()])
			->orderBy(['id' => SORT_DESC])
			->limit(AppConfig::performance('BROWSING_HISTORY_VIEW_LIMIT'))
			->all();

		$today = false;
		$yesterday = false;
		$older = false;
		$dateToday = DateTimeField::convertToUserTimeZone('today')->format('U');
		$dateYesterday = DateTimeField::convertToUserTimeZone('yesterday')->format('U');
		foreach ($results as &$value) {
			$userDate = DateTimeField::convertToUserTimeZone($value['date'])->format('Y-m-d H:i:s');
			if (strtotime($userDate) >= $dateToday) {
				$value['hour'] = true;
				if (!$today) {
					$value['viewToday'] = true;
					$today = true;
				}
			} elseif (strtotime($userDate) >= $dateYesterday) {
				$value['hour'] = true;
				if (!$yesterday) {
					$value['viewYesterday'] = true;
					$yesterday = true;
				}
			} else {
				$value['hour'] = false;
				if (!$older) {
					$value['viewOlder'] = true;
					$older = true;
				}
			}
			if ($value['hour']) {
				$value['date'] = (new DateTimeField($userDate))->getDisplayTime();
			} else {
				$value['date'] = DateTimeField::convertToUserFormat($userDate);
			}
		}
		return $results;
	}

	/**
	 * Save step in browsing history
	 * @param string $title
	 */
	public static function saveHistory($title)
	{
		if (empty(App\User::getCurrentUserId())) {
			return false;
		}
		$url = App\RequestUtil::getBrowserInfo()->requestUri;
		if (empty($url)) {
			$url = '/';
		}
		\App\Db::getInstance()->createCommand()
			->insert('u_#__browsinghistory', [
				'userid' => App\User::getCurrentUserId(),
				'date' => date('Y-m-d H:i:s'),
				'title' => $title,
				'url' => $url
			])->execute();
	}

	/**
	 * Clear browsing history for user
	 */
	public static function deleteHistory()
	{
		\App\Db::getInstance()->createCommand()
			->delete('u_#__browsinghistory', ['userid' => App\User::getCurrentUserId()])
			->execute();
	}
}
