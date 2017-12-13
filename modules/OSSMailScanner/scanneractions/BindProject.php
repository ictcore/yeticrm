<?php

/**
 * Mail scanner action bind Project
 * @package YetiForce.MailScanner
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMailScanner_BindProject_ScannerAction extends OSSMailScanner_PrefixScannerAction_Model
{

	public $moduleName = 'Project';
	public $tableName = 'vtiger_project';
	public $tableColumn = 'project_no';

	public function process(OSSMail_Mail_Model $mail)
	{
		$this->mail = $mail;
		return parent::findAndBind();
	}
}
