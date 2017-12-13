<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 * *********************************************************************************** */

class Settings_Workflows_Field_Model extends Vtiger_Field_Model
{

	/**
	 * Function to get all the supported advanced filter operations
	 * @return <Array>
	 */
	public static function getAdvancedFilterOptions()
	{
		return Vtiger_AdvancedFilter_Helper::getAdvancedFilterOptions();
	}

	/**
	 * Function to get the advanced filter option names by Field type
	 * @return <Array>
	 */
	public static function getAdvancedFilterOpsByFieldType()
	{
		return Vtiger_AdvancedFilter_Helper::getAdvancedFilterOpsByFieldType();
	}

	/**
	 * Function to get comment field which will useful in creating conditions
	 * @param Vtiger_Module_Model $moduleModel
	 * @return <Vtiger_Field_Model>
	 */
	public static function getCommentFieldForFilterConditions($moduleModel)
	{
		$commentField = new Vtiger_Field_Model();
		$commentField->set('name', '_VT_add_comment');
		$commentField->set('label', 'Comment');
		$commentField->setModule($moduleModel);
		$commentField->fieldDataType = 'comment';

		return $commentField;
	}

	/**
	 * Function to get comment fields list which are useful in tasks
	 * @param Vtiger_Module_Model $moduleModel
	 * @return <Array> list of Field models <Vtiger_Field_Model>
	 */
	public static function getCommentFieldsListForTasks($moduleModel)
	{
		$commentsFieldsInfo = array('$(record : Comments 1)$' => 'Last Comment', 'last5Comments' => '$(record : Comments 5)$', 'allComments' => '$(record : Comments)$');

		$commentFieldModelsList = [];
		foreach ($commentsFieldsInfo as $fieldName => $fieldLabel) {
			$commentField = new Vtiger_Field_Model();
			$commentField->setModule($moduleModel);
			$commentField->set('name', $fieldName);
			$commentField->set('label', $fieldLabel);
			$commentFieldModelsList[$fieldName] = $commentField;
		}
		return $commentFieldModelsList;
	}
}
