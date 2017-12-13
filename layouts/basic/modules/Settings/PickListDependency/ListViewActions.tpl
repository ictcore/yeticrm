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
	<div class="pull-right listViewActions col-xs-8 paddingLRZero">
		<select class="chzn-select pickListSupportedModules form-control">
			<option value="">{\App\Language::translate('LBL_ALL', $QUALIFIED_MODULE)}</option>
			{foreach item=MODULE_MODEL from=$PICKLIST_MODULES_LIST}
				{assign var=MODULE_NAME value=$MODULE_MODEL->get('name')}
				<option value="{$MODULE_NAME}" {if $MODULE_NAME eq $FOR_MODULE} selected {/if}>
					{if $MODULE_MODEL->get('label') eq 'Calendar'}
						{\App\Language::translate('LBL_TASK', $MODULE_MODEL->get('label'))}
					{else}
						{\App\Language::translate($MODULE_MODEL->get('label'), $MODULE_MODEL->get('label'))}
					{/if}
				</option>
			{/foreach}
		</select>
	</div>
{/strip}
