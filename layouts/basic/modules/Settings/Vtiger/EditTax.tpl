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
	{assign var=TAX_MODEL_EXISTS value=true}
	{assign var=TAX_ID value=$TAX_RECORD_MODEL->getId()}
	{if empty($TAX_ID)}
		{assign var=TAX_MODEL_EXISTS value=false}
	{/if}
<div class='modelContainer modal fade' id="addTaskContainer" tabindex="-1">
	<div class="modal-dialog">
		<div class="taxModalContainer modal-content">
			<div class="modal-header">
				<button class="close vtButton" data-dismiss="modal" aria-hidden="true" title="{\App\Language::translate('LBL_CLOSE', $QUALIFIED_MODULE)}">&times;</button>
				{if $TAX_MODEL_EXISTS}
					<h3 class="modal-title">{\App\Language::translate('LBL_EDIT_TAX', $QUALIFIED_MODULE)}</h3>
				{else}
					<h3 class="modal-title">{\App\Language::translate('LBL_ADD_NEW_TAX', $QUALIFIED_MODULE)}</h3>
				{/if}
			</div>
			<form id="editTax" class="form-horizontal" method="POST">
				<input type="hidden" name="taxid" value="{$TAX_ID}" />
				<input type="hidden" name="type" value="{$TAX_TYPE}" />
				<div class="modal-body">
					<div class="">
						<div class="form-group">
							<label class="col-md-4 control-label">{\App\Language::translate('LBL_TAX_NAME', $QUALIFIED_MODULE)}</label>
							<div class="col-md-6 controls ">
								<input class="form-control" type="text" name="taxlabel" placeholder="{\App\Language::translate('LBL_ENTER_TAX_NAME', $QUALIFIED_MODULE)}" value="{$TAX_RECORD_MODEL->getName()}" data-validation-engine='validate[required]' />
							</div>	
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">{\App\Language::translate('LBL_TAX_VALUE', $QUALIFIED_MODULE)}</label>
							<div class="col-md-6 controls input-group" style='margin:0px 15px;'>
								<input class="form-control" type="text" name="percentage" class="input-medium" placeholder="{\App\Language::translate('LBL_ENTER_TAX_VALUE', $QUALIFIED_MODULE)}" value="{$TAX_RECORD_MODEL->getTax()}" data-validation-engine='validate[required, funcCall[Vtiger_Percentage_Validator_Js.invokeValidation]]' />
								<span class="input-group-addon">%</span>
							</div>	
						</div>
						{if $TAX_MODEL_EXISTS}
						{assign var=TAX_DELETED value=$TAX_RECORD_MODEL->isDeleted()}
						<div class="form-group">
							<label class="col-md-4 control-label">{\App\Language::translate('LBL_STATUS', $QUALIFIED_MODULE)}</label>
							<div class="col-md-6 controls">
								<input type="hidden" name="deleted" value="1" />
								<input type="checkbox" name="deleted" value="0" class="taxStatus alignBottom" {if !$TAX_DELETED} checked {/if} />
								<span>&nbsp;&nbsp;{\App\Language::translate('LBL_TAX_STATUS_DESC', $QUALIFIED_MODULE)}</span>
							</div>	
						</div>
						{else}
							<input type="hidden" class="addTaxView" value="true" />
							<input type="hidden" name="deleted" value="0" />
						{/if}
					</div>
				</div>
				{include file='ModalFooter.tpl'|@vtemplate_path:'Vtiger'}
			</form>
		</div>
	</div>
</div>
{/strip}
