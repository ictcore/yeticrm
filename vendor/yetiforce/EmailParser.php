<?php
namespace App;

/**
 * Email parser class
 * @package YetiForce.App
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class EmailParser extends TextParser
{

	private static $permissionToSend = [
		'Accounts' => 'emailoptout',
		'Contacts' => 'emailoptout',
		'Users' => 'emailoptout',
		'Leads' => 'noapprovalemails'
	];
	public $emailoptout = true;

	/**
	 * Check if this content can be used
	 * @param \Vtiger_Field_Model $fieldModel
	 * @param string $moduleName
	 * @return boolean
	 */
	protected function useValue($fieldModel, $moduleName)
	{
		if ($this->emailoptout && isset(static::$permissionToSend[$moduleName])) {
			$checkFieldName = static::$permissionToSend[$moduleName];
			$permissionFieldModel = $this->recordModel->getModule()->getField($checkFieldName);
			return ($permissionFieldModel && $permissionFieldModel->isActiveField() && $this->recordModel->has($checkFieldName)) ? (bool) $this->recordModel->get($checkFieldName) : true;
		}
		return true;
	}

	/**
	 * Get content parsed for emails
	 */
	public function getContent($trim = false)
	{
		if (!$trim) {
			return $this->content;
		}
		$emails = [];
		foreach (explode(',', $this->content) as $content) {
			$content = trim($content);
			if (empty($content) || $content === '-') {
				continue;
			}
			if (strpos($content, '&lt;') && strpos($content, '&gt;')) {
				list($fromName, $fromEmail) = explode('&lt;', $content);
				$fromEmail = rtrim($fromEmail, '&gt;');
				$emails[$fromEmail] = $fromName;
			} else {
				$emails[] = $content;
			}
		}
		return $emails;
	}
}
