<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * ********************************************************************************** */

class Vtiger_RemoveWidget_Action extends Vtiger_IndexAjax_View
{

	public function process(\App\Request $request)
	{
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$linkId = $request->get('linkid');
		$response = new Vtiger_Response();

		if ($request->has('widgetid')) {
			$widget = Vtiger_Widget_Model::getInstanceWithWidgetId($request->get('widgetid'), $currentUser->getId());
		} else {
			$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		}

		if (!$widget->isDefault()) {
			$widget->remove('hide');
			$response->setResult(['linkid' => $linkId,
				'name' => $widget->getName(),
				'url' => $widget->getUrl(),
				'title' => \App\Language::translate($widget->getTitle(), $request->getModule()),
				'id' => $widget->get('id'),
				'deleteFromList' => $widget->get('deleteFromList')
			]);
		} else {
			$response->setError(\App\Language::translate('LBL_CAN_NOT_REMOVE_DEFAULT_WIDGET', $moduleName));
		}
		$response->emit();
	}

	public function validateRequest(\App\Request $request)
	{
		$request->validateWriteAccess();
	}
}
