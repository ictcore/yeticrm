<?php

/**
 * The basic class to delete
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
class Settings_Vtiger_Delete_Action extends Settings_Vtiger_Basic_Action
{

	public function __construct()
	{
		Settings_Vtiger_Tracker_Model::setRecordId(\App\Request::_get('record'));
		Settings_Vtiger_Tracker_Model::addBasic('delete');
		parent::__construct();
	}
}
