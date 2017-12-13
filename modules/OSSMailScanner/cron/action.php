<?php
/**
 * Action
 * @package YetiForce.Cron
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
require_once 'include/main/WebUI.php';
$recordModel = Vtiger_Record_Model::getCleanInstance('OSSMailScanner');
$user_name = '';
if (PHP_SAPI == 'cgi-fcgi') {
	$user_name = Users_Record_Model::getCurrentUserModel()->user_name;
}
$recordModel->executeCron(PHP_SAPI . ' - ' . $user_name);
