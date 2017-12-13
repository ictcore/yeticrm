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
    {assign var=CURRENCY_MODEL_EXISTS value=true}
    {assign var=CURRENCY_ID value=$RECORD_MODEL->getId()}
    {if empty($CURRENCY_ID)}
        {assign var=CURRENCY_MODEL_EXISTS value=false}
    {/if}
    <div class="currencyModalContainer modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header contentsBackground">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					{if $CURRENCY_MODEL_EXISTS}
						<h3 class="modal-title">{\App\Language::translate('LBL_EDIT_CURRENCY', $QUALIFIED_MODULE)}</h3>
					{else}
						<h3 class="modal-title">{\App\Language::translate('LBL_ADD_NEW_CURRENCY', $QUALIFIED_MODULE)}</h3>
					{/if}
				</div>
				<form id="editCurrency" class="form-horizontal" method="POST">
					<input type="hidden" name="record" value="{$CURRENCY_ID}" />
					<div class="modal-body">
						<div class="">
							<div class="form-group">
								<label class="muted col-md-4 control-label">
									<span class="redColor">*</span>&nbsp;{\App\Language::translate('LBL_CURRENCY_NAME', $QUALIFIED_MODULE)}
								</label>
								<div class="controls col-md-6">
									<select class="chzn-select form-control" name="currency_name">
										{foreach key=CURRENCY_ID item=CURRENCY_MODEL from=$ALL_CURRENCIES name=currencyIterator}
											{if !$CURRENCY_MODEL_EXISTS && $smarty.foreach.currencyIterator.first}
												{assign var=RECORD_MODEL value=$CURRENCY_MODEL}
											{/if}
											<option value="{$CURRENCY_MODEL->get('currency_name')}" data-code="{$CURRENCY_MODEL->get('currency_code')}" 
													data-symbol="{$CURRENCY_MODEL->get('currency_symbol')}" {if $RECORD_MODEL->get('currency_name') == $CURRENCY_MODEL->get('currency_name')} selected {/if}>
												{\App\Language::translate($CURRENCY_MODEL->get('currency_name'), $QUALIFIED_MODULE)}&nbsp;({$CURRENCY_MODEL->get('currency_symbol')})</option>
											{/foreach}
									</select>
								</div>	
							</div>
							<div class="form-group">
								<label class="muted col-md-4 control-label"><span class="redColor">*</span>&nbsp;{\App\Language::translate('LBL_CURRENCY_CODE', $QUALIFIED_MODULE)}</label>
								<div class="col-md-6 controls">
									<input type="text" name="currency_code" class="form-control" readonly value="{$RECORD_MODEL->get('currency_code')}" data-validation-engine='validate[required]]' />
								</div>	
							</div>
							<div class="form-group">
								<label class="muted col-md-4 control-label"><span class="redColor">*</span>&nbsp;{\App\Language::translate('LBL_CURRENCY_SYMBOL', $QUALIFIED_MODULE)}</label>
								<div class="col-md-6 controls">
									<input type="text" name="currency_symbol" class="form-control" readonly  value="{$RECORD_MODEL->get('currency_symbol')}" data-validation-engine='validate[required]' />
								</div>	
							</div>
							<div class="form-group">
								<label class="muted col-md-4 control-label"><span class="redColor">*</span>&nbsp;{\App\Language::translate('LBL_CONVERSION_RATE', $QUALIFIED_MODULE)}</label>
								<div class="col-md-6 controls">
									<input type="text" name="conversion_rate" class="form-control" placeholder="{\App\Language::translate('LBL_ENTER_CONVERSION_RATE', $QUALIFIED_MODULE)}" 
										   value="{$RECORD_MODEL->get('conversion_rate')}" data-validation-engine='validate[required, funcCall[Vtiger_GreaterThanZero_Validator_Js.invokeValidation]]' />
									<br /><span class="muted">({\App\Language::translate('LBL_BASE_CURRENCY', $QUALIFIED_MODULE)} - {$BASE_CURRENCY_MODEL->get('currency_name')})</span>
								</div>	
							</div>
							<div class="form-group">
								<label class="muted col-md-4 col-xs-2 control-label">{\App\Language::translate('LBL_STATUS', $QUALIFIED_MODULE)}</label>
								<div class="col-xs-6 col-md-6 controls">
									<label class="checkbox">
										<input type="hidden" name="currency_status" value="Inactive" />
										<input type="checkbox" name="currency_status" value="Active" class="currencyStatus alignBottom" 
								{if !$CURRENCY_MODEL_EXISTS} checked {else}{$RECORD_MODEL->get('currency_status')}{if $RECORD_MODEL->get('currency_status') == 'Active'} checked {/if}{/if} />
							<span>&nbsp;{\App\Language::translate('LBL_CURRENCY_STATUS_DESC', $QUALIFIED_MODULE)}</span>
						</label>
					</div>	
				</div>
				<div class="form-group transferCurrency hide">
					<label class="muted col-md-4 control-label"><span class="redColor">*</span>&nbsp;
						{\App\Language::translate('LBL_TRANSFER_CURRENCY', $QUALIFIED_MODULE)}&nbsp;{\App\Language::translate('LBL_TO', $QUALIFIED_MODULE)}</label>
					<div class="col-md-6 controls row">
						<select class="select2 form-control" name="transform_to_id">
							{foreach key=CURRENCY_ID item=CURRENCY_MODEL from=$OTHER_EXISTING_CURRENCIES}
								<option value="{$CURRENCY_ID}">{\App\Language::translate($CURRENCY_MODEL->get('currency_name'), $QUALIFIED_MODULE)}</option>
							{/foreach}
						</select>
					</div>	
				</div>
			</div>
					</div>
					{include file='ModalFooter.tpl'|@vtemplate_path:'Vtiger'}
				</form>
			</div>
		</div>
	</div>
{/strip}
