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
<span class="customFilterMainSpan btn-group">
	<select id="customFilter"  style="width:350px;" title="{\App\Language::translate('LBL_SELECT_REPORT', $MODULE)}">
		<optgroup id="foldersBlock" label="{\App\Language::translate('LBL_FOLDERS', $MODULE)}">
			<option value="All" data-id="All">{\App\Language::translate('LBL_ALL_REPORTS', $MODULE)}</option>
			{foreach item=FOLDER from=$FOLDERS}
				<option  data-editurl="{$FOLDER->getEditUrl()}" id="filterOptionId_{$FOLDER->getId()}" class="filterOptionId_{$FOLDER->getId()}" data-deletable="{$FOLDER->isDeletable()}" data-editable="{$FOLDER->isEditable()}" data-deleteurl="{$FOLDER->getDeleteUrl()}" value="{$FOLDER->getId()}" data-id="{$FOLDER->getId()}" {if $VIEWNAME eq $FOLDER->getId()}selected=""{/if}>{\App\Language::translate($FOLDER->getName(), $MODULE)}</option>
			{/foreach}
		</optgroup>
	</select>
</span>
<span class="hide filterActionImages pull-right">
	<span title="{\App\Language::translate('LBL_DELETE', $MODULE)}" data-value="delete" class="glyphicon glyphicon-trash alignMiddle deleteFilter filterActionImage pull-right"></span>
	<span title="{\App\Language::translate('LBL_EDIT', $MODULE)}" data-value="edit" class="glyphicon glyphicon-pencil alignMiddle editFilter filterActionImage pull-right"></span>
</span>
{/strip}
