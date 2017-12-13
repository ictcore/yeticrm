{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<form class="form-horizontal validateForm" id="editForm">
		<input type="hidden" id="record" name="record" value="{$RECORD_MODEL->getId()}">
		<div class="modal-header">
			<button class="close" data-dismiss="modal" title="{\App\Language::translate('LBL_CLOSE')}">x</button>
	{if !$RECORD_MODEL->getId()}{assign var="TITLE" value="LBL_ADD_CONFIGURATION"}{else}{assign var="TITLE" value="LBL_EDIT_RECORD"}{/if}
	<h3 class="modal-title">{\App\Language::translate($TITLE, $QUALIFIED_MODULE)}</h3>
</div>
<div class="modal-body">
	<div class="fieldsContainer">
		{foreach from=$RECORD_MODEL->getEditFields() item=LABEL key=FIELD_NAME name=fields}
			{assign var="FIELD_MODEL" value=$RECORD_MODEL->getFieldInstanceByName($FIELD_NAME)->set('fieldvalue',$RECORD_MODEL->get($FIELD_NAME))}
			<div class="form-group">
				<label class="control-label col-md-3">
					{\App\Language::translate($LABEL, $QUALIFIED_MODULE)}
					{if $FIELD_MODEL->isMandatory()}<span class="redColor"> *</span>{/if}
				</label>
				<div class="col-md-8 fieldValue">
					{include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(), $QUALIFIED_MODULE) FIELD_MODEL=$FIELD_MODEL MODULE=$QUALIFIED_MODULE}
				</div>
			</div>
		{/foreach}
		{if $RECORD_MODEL->getId()}
			{assign var="PROVIDER" value=$RECORD_MODEL->getProviderInstance()}
			{foreach from=$PROVIDER->getSettingsEditFieldsModel() item=FIELD_MODEL name=fields}
				{assign var="FIELD_MODEL" value=$FIELD_MODEL->set('fieldvalue',$RECORD_MODEL->get($FIELD_NAME))}
				<div class="form-group" data-provider="{$PROVIDER->getName()}">
					<label class="control-label col-md-3">
						{\App\Language::translate($FIELD_MODEL->get('label'), $QUALIFIED_MODULE)}
						{if $FIELD_MODEL->isMandatory()}<span class="redColor"> *</span>{/if}
					</label>
					<div class="col-md-8 fieldValue">
						{include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(), $QUALIFIED_MODULE) FIELD_MODEL=$FIELD_MODEL MODULE=$QUALIFIED_MODULE}
					</div>
				</div>
			{/foreach}
		{/if}
	</div>
</div>
<div class="modal-footer">
	<button type="submit" class="btn btn-success">{\App\Language::translate('BTN_SAVE', $QUALIFIED_MODULE)}</button>
	<button type="button" class="btn btn-warning dismiss" data-dismiss="modal">{\App\Language::translate('BTN_CLOSE', $QUALIFIED_MODULE)}</button>
</div>
</form>

<div class="providersFields hide">
	{foreach from=$PROVIDERS item=PROVIDER}
		{foreach from=$PROVIDER->getSettingsEditFieldsModel() item=FIELD_MODEL name=fields}
			<div class="form-group" data-provider="{$PROVIDER->getName()}">
				<label class="control-label col-md-3">
					{\App\Language::translate($FIELD_MODEL->get('label'), $QUALIFIED_MODULE)}
					{if $FIELD_MODEL->isMandatory()}<span class="redColor"> *</span>{/if}:
				</label>
				<div class="col-md-8 fieldValue">
					{include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(), $QUALIFIED_MODULE) FIELD_MODEL=$FIELD_MODEL MODULE=$QUALIFIED_MODULE}
				</div>
			</div>
		{/foreach}
	{/foreach}
</div>
{/strip}
