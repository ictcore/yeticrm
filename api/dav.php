<?php
/**
 * @package YetiForce.Webservice
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
chdir(__DIR__ . '/../');
require('include/ConfigUtils.php');
if (!in_array('dav', $enabledServices)) {
	require('include/main/WebUI.php');
	$apiLog = new \Exception\NoPermittedToApi();
	$apiLog->stop('Dav - Service is not active');
}
AppConfig::iniSet('error_log', ROOT_DIRECTORY . '/cache/logs/davPhpError.log');
/* Database */
$pdo = new PDO('mysql:host=' . $dbconfig['db_server'] . ';dbname=' . $dbconfig['db_name'] . ';charset=utf8', $dbconfig['db_username'], $dbconfig['db_password']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

set_error_handler(['App\Dav\Debug', 'exceptionErrorHandler']);
$enableWebDAV = false;
// Backends
$authBackend = new App\Dav\DAV_Auth_Backend_PDO($pdo);
$principalBackend = new App\Dav\DAVACL_PrincipalBackend_PDO($pdo);
$nodes = [
	new Sabre\DAVACL\PrincipalCollection($principalBackend)
];
if ($enableCalDAV) {
	$calendarBackend = new App\Dav\CalDAV_Backend_PDO($pdo);
	$nodes[] = new Sabre\CalDAV\Principal\Collection($principalBackend);
	$nodes[] = new Sabre\CalDAV\CalendarRoot($principalBackend, $calendarBackend);
}
if ($enableCardDAV) {
	$carddavBackend = new App\Dav\CardDAV_Backend_PDO($pdo);
	$nodes[] = new Sabre\CardDAV\AddressBookRoot($principalBackend, $carddavBackend);
}
if ($enableWebDAV) {
	$exData = new stdClass();
	$exData->pdo = $pdo;
	$exData->storageDir = $davStorageDir;
	$exData->historyDir = $davHistoryDir;
	$exData->localStorageDir = ROOT_DIRECTORY . $exData->storageDir;
	$exData->localHistoryDir = ROOT_DIRECTORY . $exData->historyDir;
	$directory = new App\Dav\WebDAV_Directory('files', $exData);
	$directory->getRootChild();
	$nodes[] = $directory;
}
// The object tree needs in turn to be passed to the server class
$server = new App\Dav\DAV_Server($nodes);
$server->setBaseUri($_SERVER['SCRIPT_NAME']);
$server->debugExceptions = AppConfig::debug('DAV_DEBUG_EXCEPTIONS');
// Plugins
$server->addPlugin(new Sabre\DAV\Auth\Plugin($authBackend));
$server->addPlugin(new Sabre\DAVACL\Plugin());
if ($enableBrowser) {
	$server->addPlugin(new Sabre\DAV\Browser\Plugin());
}
if ($enableCardDAV) {//CardDav integration
	$server->addPlugin(new Sabre\CardDAV\Plugin());
}
if ($enableCalDAV) {//CalDAV integration
	$server->addPlugin(new Sabre\CalDAV\Plugin());
	$server->addPlugin(new Sabre\CalDAV\Subscriptions\Plugin());
	$server->addPlugin(new Sabre\CalDAV\Schedule\Plugin());
}
if ($enableWebDAV) {//WebDAV integration
	$server->addPlugin(new Sabre\DAV\Sync\Plugin());
}
if (AppConfig::debug('DAV_DEBUG_PLUGIN')) {
	$server->addPlugin(new App\Dav\Debug());
}
// And off we go!
$server->exec();
