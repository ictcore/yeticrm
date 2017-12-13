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
<div id="sendSmsContainer" class='modelContainer'>
	<div class="modal-header contentsBackground">
        <button data-dismiss="modal" class="close" title="{vtranslate('LBL_CLOSE')}">&times;</button>
		<h3>ICT Brodcaset</h3>
	</div>
	<form class="form-horizontal" id="massSave1" method="post" action="index.php">
		<input type="hidden" name="module" value="{$MODULE}" />
		<input type="hidden" name="source_module" value="{$SOURCE_MODULE}" />
		<input type="hidden" name="action" value="MassSaveAjax" />
		<input type="hidden" name="viewname" value="{$VIEWNAME}" />
		<input type="hidden" name="selected_ids" value={ZEND_JSON::encode($SELECTED_IDS)}>
		<input type="hidden" name="excluded_ids" value={ZEND_JSON::encode($EXCLUDED_IDS)}>
        <input type="hidden" name="search_key" value= "{$SEARCH_KEY}" />
        <input type="hidden" name="operator" value="{$OPERATOR}" />
        <input type="hidden" name="search_value" value="{$ALPHABET_VALUE}" />
		<div class="modal-body tabbable">

			<div>
				<span><strong>New Contact Group</strong></span>
				&nbsp;:&nbsp;
				
			</div>
			<input type="text" name="group" class="chzn-text">
		<!--	<select name="fields[]" data-placeholder="{vtranslate('LBL_ADD_MORE_FIELDS',$MODULE)}" multiple class="chzn-select">
				<optgroup>
					{foreach item=PHONE_FIELD from=$PHONE_FIELDS}
						{assign var=PHONE_FIELD_NAME value=$PHONE_FIELD->get('name')}
						<option value="{$PHONE_FIELD_NAME}">
							{if !empty($SINGLE_RECORD)}
								{assign var=FIELD_VALUE value=$SINGLE_RECORD->get($PHONE_FIELD_NAME)}
							{/if}
							{vtranslate($PHONE_FIELD->get('label'), $SOURCE_MODULE)}{if !empty($FIELD_VALUE)} ({$FIELD_VALUE}){/if}
						</option>
					{/foreach}
				</optgroup>


              <optgroup>
              foreach $contact as $key => $value
					{foreach $NAME_FIELDS as $key=>$NAME_FIELD}
						{assign var=FIELD_NAME value=$NAME_FIELD->get('name')}
						<option value="{$FIELD_NAME}">
						
						{if !empty($SINGLE_RECORD)}
								{assign var=FIELD_VALUE1 value=$SINGLE_RECORD->get($FIELD_NAME)}
							{/if}

							{vtranslate($NAME_FIELD->get('label'), $SOURCE_MODULE)}{if !empty($FIELD_VALUE1)} ({$FIELD_VALUE1}){/if}
						</option>
					{/foreach}
				</optgroup>
			

			</select>-->

			<hr>
			<div>
				<span><strong>Select Campaign Type</strong></span>
				&nbsp;:&nbsp;
				
			</div>
		<select name="campaing_type" class="chzn-select">
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
		<div class="modal-footer">
			<div class=" pull-right cancelLinkContainer">
				<a class="cancelLink" type="reset" data-dismiss="modal">Cancel</a>
			</div>
			<button class="btn btn-success" type="submit" name="saveButton"><strong>New Campaign</strong></button>
		</div>
	</form>
</div>

{/strip}