{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
{assign var="FIELD_INFO" value=\App\Json::encode($FIELD_MODEL->getFieldInfo())}
{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
{assign var="FIELD_NAME" value=$FIELD_MODEL->get('name')}

<input id="{$MODULE}_editView_fieldName_{$FIELD_NAME}" type="text" 
        class="form-control {if $FIELD_MODEL->isNameField()}nameField{/if}" 
        data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true}required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" 
        name="{$FIELD_MODEL->getFieldName()}" 
        {if $FIELD_NAME eq 'password' } 
        value="{if $RECORD->getId() neq ''}{str_repeat('*', 10)}{/if}" 
        {if $VIEW eq 'Edit' || $VIEW eq 'QuickCreateAjax'}
            onkeyup="passwordStrength('','{$VALIDATE_STRINGS}')"  
            onchange="passwordStrength('','{$VALIDATE_STRINGS}')"  
        {/if}
        {else}
        value="{$FIELD_MODEL->get('fieldvalue')}" 
        {/if}
		{if ($FIELD_MODEL->get('uitype') eq '106' && $MODE neq '') || $FIELD_MODEL->get('uitype') eq '3' 
				|| $FIELD_MODEL->get('uitype') eq '4'|| $FIELD_MODEL->isReadOnly()} 
				readonly 
		{/if} 
data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator={\App\Json::encode($SPECIAL_VALIDATOR)}{/if} />

{if $FIELD_NAME eq 'password' && ($VIEW eq 'Edit'  || $VIEW eq 'QuickCreateAjax')} 
	&nbsp;
	{if $RECORD->getId() neq ''}
		<button class="btn btn-warning btn-xs" 
				onclick="showPassword('{$RECORD->getId()}');return false;" id="show-btn">
			{\App\Language::translate('LBL_ShowPassword', $MODULE)}
		</button>
		&nbsp;
		{* button for copying password to clipboard *}
		<button type="button" class="btn btn-success btn-xs hide" data-copy-target="{$MODULE}_editView_fieldName_{$FIELD_NAME}" id="copy-button" title="{\App\Language::translate('LBL_CopyToClipboardTitle', $MODULE)}">
			<span class="glyphicon glyphicon-download-alt"></span>
		</button>
	{/if}
	<p>
		{if $FIELD_MODEL->get('fieldvalue') eq ''}
		<div id="passwordDescription">{\App\Language::translate('Enter the password', $MODULE)}</div>
		{else}
		<div id="passwordDescription">{\App\Language::translate('Password is hidden', $MODULE)}</div>
		{/if}
		<div id="passwordStrength" class="strength0"></div>
	</p>
{/if}
{/strip}
