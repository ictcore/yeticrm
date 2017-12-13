{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}
	{if $WIZARD_STEP eq 'step1'}
		<div id="minilistWizardContainer" class='modelContainer modal fade' tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header contentsBackground">
						<button data-dismiss="modal" class="close" title="{\App\Language::translate('LBL_CLOSE')}">&times;</button>
						<h3 class="modal-title" id="massEditHeader">{\App\Language::translate('LBL_MINI_LIST', $MODULE)} {\App\Language::translate($MODULE, $MODULE)}</h3>
					</div>
					<form class="form-horizontal" method="post" action="javascript:;">
						<div class="modal-body">
							<input type="hidden" name="module" value="{$MODULE}" />
							<input type="hidden" name="action" value="MassSave" />

							<table class="table table-bordered">
								<tbody>
									<tr>
										<td class="fieldLabel alignMiddle textAlignCenter" nowrap>{App\Language::translate('LBL_WIDGET_NAME')}</td>
										<td class="fieldValue">
											<input type="text" class="form-control" name="widgetTitle" value="">
										</td>
									</tr>
									<tr>
										<td class="fieldLabel alignMiddle textAlignCenter" nowrap>{App\Language::translate('LBL_SELECT_MODULE')}</td>
										<td class="fieldValue">
											<select class="form-control" name="module">
												<option></option>
												{foreach from=$MODULES item=MODULE_MODEL key=MODULE_NAME}
													<option value="{$MODULE_MODEL['name']}">{App\Language::translate($MODULE_MODEL['name'], $MODULE_MODEL['name'])}</option>
												{/foreach}
											</select>
										</td>
									</tr>
									<tr>
										<td class="fieldLabel alignMiddle textAlignCenter" nowrap>{App\Language::translate('LBL_FILTER')}</td>
										<td class="fieldValue">
											<select class="form-control" name="filterid">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="fieldLabel alignMiddle textAlignCenter" nowrap>{App\Language::translate('LBL_EDIT_FIELDS')}</td>
										<td class="fieldValue">
											<select class="form-control" name="fields" size="2" multiple="true">
												<option></option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="fieldLabel alignMiddle textAlignCenter" nowrap>{App\Language::translate('LBL_FILTER')}</td>
										<td class="fieldValue">
											<select class="form-control" name="filter_fields">
												<option></option>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						{include file='ModalFooter.tpl'|@vtemplate_path:$MODULE}
					</form>
				</div>
			</div>
		</div>
	{elseif $WIZARD_STEP eq 'step2'}
		<option></option>
		{foreach from=$ALLFILTERS item=FILTERS key=FILTERGROUP}
			<optgroup label="{\App\Language::translate($FILTERGROUP,$SELECTED_MODULE)}">
				{foreach from=$FILTERS item=FILTER key=FILTERNAME}
					{if $FILTER->get('setmetrics') eq 1}
						<option value="{$FILTER->getId()}">{\App\Language::translate($FILTER->get('viewname'),$SELECTED_MODULE)}</option>
					{/if}
				{/foreach}
			</optgroup>
		{/foreach}
	{elseif $WIZARD_STEP eq 'step3'}
		<div>
			<select class="form-control" name="fields" size="2" multiple="true">
				<option></option>
				{foreach from=$QUERY_GENERATOR->getListViewFields() item=FIELD key=FIELD_NAME}
					<option value="{$FIELD_NAME}">{\App\Language::translate($FIELD->getFieldLabel(),$SELECTED_MODULE)}</option>
				{/foreach}
			</select>
			<select class="form-control" name="filter_fields">
				<option></option>
				{foreach from=$QUERY_GENERATOR->getModuleModel()->getFieldsByBlocks() item=FIELDS key=BLOCK_NAME}
					<optgroup label="{\App\Language::translate($BLOCK_NAME,$SELECTED_MODULE)}">
						{foreach from=$FIELDS item=FIELD}
							{if $FIELD->isActiveSearchView()}
								<option value="{$FIELD->getId()}">{\App\Language::translate($FIELD->getFieldLabel(),$SELECTED_MODULE)}</option>
							{/if}
						{/foreach}
					</optgroup>
				{/foreach}
			</select>
		</div>
	{/if}
{/strip}
