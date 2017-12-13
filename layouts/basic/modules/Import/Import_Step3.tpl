{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 ********************************************************************************/
-->*}
{strip}
<div class="col-xs-12 paddingLRZero">
	<div class='col-xs-2 paddingLRZero'>
		<strong>{\App\Language::translate('LBL_IMPORT_STEP_3', $MODULE)}:</strong>&nbsp;&nbsp;&nbsp;
		<input type="checkbox" class="font-x-small" id="auto_merge" title="{\App\Language::translate('LBL_IMPORT_STEP_3', $MODULE)}" name="auto_merge" onclick="ImportJs.toogleMergeConfiguration();" />
	</div>
	<div class="col-xs-10">
		<span>{\App\Language::translate('LBL_IMPORT_STEP_3_DESCRIPTION', $MODULE)}</span>
		<span class="font-x-small">({\App\Language::translate('LBL_IMPORT_STEP_3_DESCRIPTION_DETAILED', $MODULE)}).</span>
	</div>
	<div class="col-xs-12">
			<div class='row' id="duplicates_merge_configuration" style="display:none;">
				<div class='col-xs-12 paddingBottom10'>
					<div>
						<div class="col-md-6 paddingLRZero">
							<span class="font-x-small">{\App\Language::translate('LBL_SPECIFY_MERGE_TYPE', $MODULE)}</span>&nbsp;&nbsp;
						</div>
						<div class="col-md-6 paddingLRZero">
							<select name="merge_type" id="merge_type" class="font-x-small form-control" title="{\App\Language::translate('LBL_SPECIFY_MERGE_TYPE', $MODULE)}">
								{foreach key=_MERGE_TYPE item=_MERGE_TYPE_LABEL from=$AUTO_MERGE_TYPES}
								<option value="{$_MERGE_TYPE}">{\App\Language::translate($_MERGE_TYPE_LABEL, $MODULE)}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<div class='col-xs-12'>
					<div class="font-x-small">{\App\Language::translate('LBL_SELECT_MERGE_FIELDS', $MODULE)}</div>
				</div>
				<div class='col-xs-12'>
						<div class="row calDayHour">
							<div class='col-xs-12 '>
								<div><strong>{\App\Language::translate('LBL_AVAILABLE_FIELDS', $MODULE)}</strong></div>
								<div><strong>{\App\Language::translate('LBL_SELECTED_FIELDS', $MODULE)}</strong></div>
							</div>
							<div class='col-xs-12 row'>
								<div class='col-xs-5'>
									<select id="available_fields" multiple size="10" name="available_fields" title="{\App\Language::translate('LBL_AVAILABLE_FIELDS', $MODULE)}'" class="txtBox" style="width: 100%">
										{foreach key=BLOCK_NAME item=_FIELDS from=$AVAILABLE_BLOCKS}
											<optgroup label="{\App\Language::translate($BLOCK_NAME, $FOR_MODULE)}">
												{foreach key=_FIELD_NAME item=_FIELD_INFO from=$_FIELDS}
													<option value="{$_FIELD_NAME}">{\App\Language::translate($_FIELD_INFO->getFieldLabel(), $FOR_MODULE)}</option>
												{/foreach}
											</optgroup>
										{/foreach}
									</select>
								</div>
								<div class='col-xs-1'>
									<div align="center">
										<input type="button" name="Button" value="&nbsp;&rsaquo;&rsaquo;&nbsp;" onClick="ImportJs.copySelectedOptions('#available_fields', '#selected_merge_fields')" class="crmButton font-x-small importButton" /><br /><br />
										<input type="button" name="Button1" value="&nbsp;&lsaquo;&lsaquo;&nbsp;" onClick="ImportJs.removeSelectedOptions('#selected_merge_fields')" class="crmButton font-x-small importButton" /><br /><br />
									</div>
								</div>
								<div class='col-xs-5'>
									<input type="hidden" id="merge_fields" size="10" name="merge_fields" value="" />
									<select id="selected_merge_fields" size="10" name="selected_merge_fields" title="{\App\Language::translate('lBL_SELECTED_FIELDS', $MODULE)}" multiple class="txtBox" style="width: 100%">
										{foreach item=FIELD_NAME from=$FOR_MODULE_MODEL->getNameFields()}
											{assign var="FIELD" value=$FOR_MODULE_MODEL->getFieldByName($FIELD_NAME)}
											<option value="{$FIELD_NAME}">{\App\Language::translate($FIELD->getFieldLabel(), $FOR_MODULE)}</option>
										{/foreach}
									</select>
								</div>
							</div>
						</div>
				</div>
			</div>
	</div>
</div>
{/strip}
