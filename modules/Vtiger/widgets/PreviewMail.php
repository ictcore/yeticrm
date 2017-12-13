<?php

/**
 * Vtiger PreviewMail widget class
 * @package YetiForce.Widget
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Vtiger_PreviewMail_Widget extends Vtiger_Basic_Widget
{

	public $allowedModules = ['PreviewMail'];
	public $dbParams = [];

	public function getUrl()
	{
		return 'module=' . $this->Module . '&view=sview&noloadlibs=true&record=' . $this->Record;
	}

	public function getWidget()
	{
		$this->Config['url'] = $this->getUrl();
		return $this->Config;
	}

	public function getConfigTplName()
	{
		return 'PreviewMailConfig';
	}
}
