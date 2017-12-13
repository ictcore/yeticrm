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
	{assign var=MAPPING_PANEL value=$TASK_OBJECT->mappingPanel}
	<input type="hidden" id="taskFields" value="{Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($TASK_OBJECT->getFieldNames()))}"/>
	<input type="hidden" id="mappingPanel" value="{$MAPPING_PANEL}"/>

	<div class="form-group text-center">
		<div class="radio-inline">
			<label>
				<input type="radio" name="mappingPanel" data-hide="getFromPanelMapp"  data-show="createOwnMapp" id="optionsRadios1" value="0" {if !$MAPPING_PANEL}checked{/if}>
				{\App\Language::translate('LBL_CREATE_CUSTOM_MAPPING', $QUALIFIED_MODULE)}
			</label>
		</div>
		<div class="radio-inline"></div>
		<div class="radio-inline">
			<label>
				<input type="radio" name="mappingPanel" data-hide="createOwnMapp"  data-show="getFromPanelMapp" id="optionsRadios2" value="1"{if $MAPPING_PANEL} checked{/if}>
				{\App\Language::translate('LBL_GET_FROM_PANEL_MAPPING', $QUALIFIED_MODULE)}
			</label>
		</div>
	</div>
	<hr><br />
	<div class="createOwnMapp{if $MAPPING_PANEL} hide{/if}">
		<div class="row">
			<label class="col-md-4 control-label">
				<strong>{\App\Language::translate('LBL_MODULES_TO_CREATE_RECORD',$QUALIFIED_MODULE)}
					<span class="redColor">*</span>
				</strong>
			</label>
			<div class="col-md-6">
				{assign var=RELATED_MODULES_INFO value=$WORKFLOW_MODEL->getDependentModules()}
				{assign var=RELATED_MODULES value=$RELATED_MODULES_INFO|array_keys}
				{assign var=RELATED_MODULE_MODEL_NAME value=$TASK_OBJECT->entity_type}
				<select class="chzn-select createEntityModule" id="createEntityModule" name="entity_type" data-validation-engine='validate[required]' {if $MAPPING_PANEL} disabled{/if}>
					<option value="">{\App\Language::translate('LBL_NONE', $QUALIFIED_MODULE)}</option>
					{foreach from=$RELATED_MODULES item=MODULE}
						<option {if $TASK_OBJECT->entity_type eq $MODULE} selected="" {/if} value="{$MODULE}">{\App\Language::translate($MODULE,$MODULE)}</option>
					{/foreach}	
				</select>
			</div>
		</div><br />
	</div>
	<div class="getFromPanelMapp{if !$MAPPING_PANEL} hide{/if}">
		<div class="row">
			<label class="col-md-4 control-label">
				<strong>{\App\Language::translate('LBL_SELECT_TEMPLATE_FOR_MODULE',$QUALIFIED_MODULE)}
					<span class="redColor">*</span>
				</strong>
			</label>
			<div class="col-md-6">
				<select class="chzn-select createEntityModule" id="templatesMapp" name="entity_type" data-validation-engine='validate[required]'{if !$MAPPING_PANEL} disabled{/if}>
					<option value="">{\App\Language::translate('LBL_NONE', $QUALIFIED_MODULE)}</option>
					{foreach from=$TEMPLATES_MAPPING key=ID item=TEMPLATE}
						{assign var=TEMPLATE_RELATED_MODULE_NAME value=$TEMPLATE->getRelatedName()}
						<option {if $TASK_OBJECT->entity_type eq $TEMPLATE_RELATED_MODULE_NAME} selected="" {/if} value="{$TEMPLATE_RELATED_MODULE_NAME}">{\App\Language::translate($TEMPLATE_RELATED_MODULE_NAME, $TEMPLATE_RELATED_MODULE_NAME)}</option>
					{/foreach}	
				</select>
			</div>
		</div><br />
	</div>
	<div id="addCreateEntityContainer">
		{include file="CreateEntity.tpl"|@vtemplate_path:$QUALIFIED_MODULE}
	</div>
{/strip}
