<?php
/**
 * Clear browsing history cron
 * @package YetiForce.Cron
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Michał Lorencik <m.lorencik@yetiforce.com>
 */
$deleteAfter = AppConfig::performance('BROWSING_HISTORY_DELETE_AFTER');
$deleteAfter = date('Y-m-d ', strtotime("-$deleteAfter DAY")) . '00:00:00';

\App\Db::getInstance()->createCommand()->delete('u_#__browsinghistory', ['<', 'date', $deleteAfter])->execute();
