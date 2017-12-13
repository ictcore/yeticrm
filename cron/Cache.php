<?php
/**
 * Clear cache cron
 * @package YetiForce.Cron
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
$time = strtotime('-30 day');
$dirs = ['pdf', 'import', 'mail', 'session'];
$exclusion = ['.htaccess', 'index.html'];
foreach ($dirs as $dir) {
	foreach ($iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(ROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . $dir, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST) as $item) {
		if ($item->isFile() && !in_array($item->getBasename(), $exclusion)) {
			if ($item->getMTime() < $time && $item->getATime() < $time) {
				unlink($item->getPathname());
			}
		}
	}
}

