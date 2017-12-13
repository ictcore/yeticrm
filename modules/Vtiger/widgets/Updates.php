<?php

/**
 * Vtiger Updates widget class
 * @package YetiForce.Widget
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Vtiger_Updates_Widget extends Vtiger_Basic_Widget
{

	public function getUrl()
	{
		return 'module=' . $this->Module . '&view=Detail&record=' . $this->Record . '&mode=showRecentActivities&page=1&limit=5&skipHeader=true';
	}

	public function getWidget()
	{
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$moduelName = 'ModTracker';
		$this->Config['tpl'] = 'Updates.tpl';
		$this->Config['moduleBaseName'] = $moduelName;
		$this->Config['url'] = $this->getUrl();
		$this->Config['newChanege'] = ModTracker_Record_Model::isNewChange($this->Record, $currentUser->getRealId());
		$this->Config['switchHeader'] = [];
		$this->Config['switchHeader']['on'] = 'changes';
		$this->Config['switchHeader']['off'] = 'review';
		$this->Config['switchHeaderLables']['on'] = \App\Language::translate('LBL_UPDATES', $moduelName);
		$this->Config['switchHeaderLables']['off'] = \App\Language::translate('LBL_REVIEW_HISTORY', $moduelName);
		return $this->Config;
	}
}
