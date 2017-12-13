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
	<div id="sendSmsContainer" class='modelContainer modal fade' tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" title="{\App\Language::translate('LBL_CLOSE')}">&times;</button>
					<h3 class="modal-title">{\App\Language::translate('ICTBroadcast', $MODULE)}</h3>
				</div>
				<form class="form-horizontal validateForm" id="massSave1" method="post" action="index.php">
					<input type="hidden" name="module" value="{$MODULE}" />
					<input type="hidden" name="source_module" value="{$SOURCE_MODULE}" />
					<input type="hidden" name="action" value="MassSaveAjax" />
					<input type="hidden" name="viewname" value="{$VIEWNAME}" />
					<input type="hidden" name="selected_ids" value='{\App\Json::encode($SELECTED_IDS)}'>
					<input type="hidden" name="excluded_ids" value="{Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($EXCLUDED_IDS))}">
					<input type="hidden" name="search_key" value= "{$SEARCH_KEY}" />
					<input type="hidden" name="operator" value="{$OPERATOR}" />
					<input type="hidden" name="search_value" value="{$ALPHABET_VALUE}" />
					<input type="hidden" name="search_params" value='{\App\Json::encode($SEARCH_PARAMS)}' />

					<div class="modal-body">
						<div class="alert alert-info" role="alert">
							<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;
							{\App\Language::translate('', $MODULE)}
						</div>
						<div class="col-xs-12">
							<div class="form-group">
								
								{\App\Language::translate('New Contact Group',$MODULE)}
								<input type="text" name="group" class="form-control">

							</div>
							<div class="form-group">
								
								{\App\Language::translate('Select Campaign Type',$MODULE)}
								<select name="campaing_type" class = "select2 form-control">
									<!--	{foreach $Campaign_type as $Campaign_types}
										<option value="{$Campaign_types->id}">{$Campaign_types->name}</option>
										{/foreach}-->
								        <option value="voice">Message Campaign</option>
								        <option value="voice_agent">Agent Campaign</option>
								        <option value="voice_interactive">Interactive Campaign</option>
								        <option value="voice_ivr">IVR Campaign</option>
								        <option value="fax">Fax Campaign</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success" type="submit" name="saveButton"><span class="glyphicon glyphicon-ok"></span>&nbsp;<strong>{\App\Language::translate('LBL_SEND', $MODULE)}</strong></button>
						<button class="btn btn-warning" type="reset" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;<strong>{\App\Language::translate('LBL_CANCEL', $MODULE)}</strong></button>
					</div>
				</form>
			</div>
		</div>
	</div>
{/strip}
