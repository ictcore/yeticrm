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

class Vtiger_SaveAjax_Action extends Vtiger_Save_Action
{

	/**
	 * Function process
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$recordModel = $this->saveRecord($request);
		$fieldModelList = $recordModel->getModule()->getFields();
		$result = [];
		foreach ($fieldModelList as $fieldName => &$fieldModel) {
			$recordFieldValue = $recordModel->get($fieldName);

			if (is_array($recordFieldValue) && $fieldModel->getFieldDataType() === 'multipicklist') {
				$recordFieldValue = implode(' |##| ', $recordFieldValue);
			} elseif (is_array($recordFieldValue) && in_array($fieldModel->getFieldDataType(), ['sharedOwner', 'taxes'])) {
				$recordFieldValue = implode(',', $recordFieldValue);
			}
			$fieldValue = $displayValue = Vtiger_Util_Helper::toSafeHTML($recordFieldValue);
			if ($fieldModel->getFieldDataType() === 'currency') {
				$displayValue = Vtiger_Util_Helper::toSafeHTML($fieldModel->getDisplayValue($recordFieldValue, $recordModel->getId()));
			} else {
				$displayValue = $fieldModel->getDisplayValue($recordFieldValue, $recordModel->getId(), $recordModel);
			}
			$result[$fieldName] = ['value' => $fieldValue, 'display_value' => $displayValue];
		}
		$result['_recordLabel'] = $recordModel->getName();
		$result['_recordId'] = $recordModel->getId();
		$recordModel->clearPrivilegesCache();
		$result['isEditable'] = $recordModel->isEditable();

		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		$response->setResult($result);
		$response->emit();
	}

	/**
	 * Function to get the record model based on the request parameters
	 * @param \App\Request $request
	 * @return Vtiger_Record_Model or Module specific Record Model instance
	 */
	public function getRecordModelFromRequest(\App\Request $request)
	{
		$recordId = $request->get('record');
		if (!empty($recordId)) {
			$moduleName = $request->getModule();
			$recordModel = $this->record ? $this->record : Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
			$fieldModel = $recordModel->getModule()->getFieldByName($request->get('field'));
			if ($fieldModel && $fieldModel->isEditable()) {
				$recordModel->set($fieldModel->getName(), $fieldModel->getUITypeModel()->getDBValue($request->get('value'), $recordModel));
				if ($request->getBoolean('setRelatedFields') && $fieldModel->isReferenceField()) {
					$recordModel = $this->setRelatedFieldsInHierarchy($recordModel, $fieldModel->getName());
				}
			}
		} else {
			$recordModel = parent::getRecordModelFromRequest($request);
		}
		return $recordModel;
	}

	/**
	 * Replenishment of related fields
	 * @param \Vtiger_Record_Model $recordModel
	 * @param string $fieldName
	 * @return \Vtiger_Record_Model
	 */
	public function setRelatedFieldsInHierarchy($recordModel, $fieldName)
	{
		$fieldValue = $recordModel->get($fieldName);
		$relatedModules = \App\ModuleHierarchy::getRelationFieldByHierarchy($recordModel->getModuleName(), $fieldName);
		if ($relatedModules && !empty($fieldValue) && $recordModel->getPreviousValue($fieldName) !== $fieldValue) {
			$sourceModule = \App\Record::getType($fieldValue);
			foreach ($relatedModules as $relatedModule => $relatedFields) {
				if ($relatedModule === $sourceModule) {
					$relRecordModel = \Vtiger_Record_Model::getInstanceById($fieldValue, $sourceModule);
					foreach ($relatedFields as $to => $from) {
						$toModel = $recordModel->getModule()->getFieldByName($to);
						$relFieldModel = $relRecordModel->getModule()->getFieldByName($from[0]);
						$relFieldValue = $relRecordModel->get($from[0]);
						if ($relFieldValue && $relFieldModel && $toModel && $toModel->isWritable()) {
							if ($toModel->isReferenceField() || $relFieldModel->isReferenceField()) {
								$sourceType = \App\Record::getType($relFieldValue);
								if (in_array($sourceType, $toModel->getReferenceList())) {
									$recordModel->set($toModel->getName(), $relFieldValue);
								}
							} else {
								$recordModel->set($toModel->getName(), $relFieldValue);
							}
						}
					}
				}
			}
		}
		return $recordModel;
	}
}
