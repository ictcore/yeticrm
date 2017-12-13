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
<div class='widget_header row '>
	<div class="col-xs-12">
		{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
	</div>
</div>
{literal}
<script type="text/javascript">
jQuery(document).ready(function() {
	setTimeout(function() {
		jQuery("[name=importStatusForm]").get(0).submit();
		}, 2000);
});
</script>
{/literal}
<div style="padding-left: 15px;">
	<form onsubmit="VtigerJS_DialogBox.block();" action="index.php" enctype="multipart/form-data" method="POST" name="importStatusForm">
		<input type="hidden" name="module" value="{$FOR_MODULE}" />
		<input type="hidden" name="view" value="Import" />
		{if $CONTINUE_IMPORT eq 'true'}
		<input type="hidden" name="mode" value="continueImport" />
		{else}
		<input type="hidden" name="mode" value="" />
		{/if}
	</form>
	<table style=" width:90%;margin-left: 5% " cellpadding="10" class="searchUIBasic well">
		<tr>
			<td class="font-x-large" align="left" colspan="2">
				{\App\Language::translate('LBL_IMPORT', $MODULE)} {\App\Language::translate($FOR_MODULE, $FOR_MODULE)} -
				<span class="redColor">{\App\Language::translate('LBL_RUNNING', $MODULE)} ... </span>
			</td>
		</tr>
		{if $ERROR_MESSAGE neq ''}
		<tr>
			<td class="style1" align="left" colspan="2">
				{$ERROR_MESSAGE}
			</td>
		</tr>
		{/if}
		<tr>
			<td valign="top">
				<table cellpadding="10" cellspacing="0" align="center" class="dvtSelectedCell thickBorder importContents">
					<tr>
						<td>{\App\Language::translate('LBL_TOTAL_RECORDS_IMPORTED', $MODULE)}</td>
						<td width="10%">:</td>
						<td width="30%">{$IMPORT_RESULT.IMPORTED} / {$IMPORT_RESULT.TOTAL}</td>
					</tr>
					<tr>
						<td colspan="3">
							<table cellpadding="10" cellspacing="0" class="calDayHour">
								<tr>
									<td>{\App\Language::translate('LBL_NUMBER_OF_RECORDS_CREATED', $MODULE)}</td>
									<td width="10%">:</td>
									<td width="10%">{$IMPORT_RESULT.CREATED}</td>
								</tr>
								<tr>
									<td>{\App\Language::translate('LBL_NUMBER_OF_RECORDS_UPDATED', $MODULE)}</td>
									<td width="10%">:</td>
									<td width="10%">{$IMPORT_RESULT.UPDATED}</td>
								</tr>
								{if in_array($FOR_MODULE, $INVENTORY_MODULES) eq FALSE}
								<tr>
									<td>{\App\Language::translate('LBL_NUMBER_OF_RECORDS_SKIPPED', $MODULE)}</td>
									<td width="10%">:</td>
									<td width="10%">{$IMPORT_RESULT.SKIPPED}</td>
								</tr>
								<tr>
									<td>{\App\Language::translate('LBL_NUMBER_OF_RECORDS_MERGED', $MODULE)}</td>
									<td width="10%">:</td>
									<td width="10%">{$IMPORT_RESULT.MERGED}</td>
								</tr>
								{/if}
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="right">
			<button name="cancel" class="delete btn btn-danger"
				onclick="location.href='index.php?module={$FOR_MODULE}&view=Import&mode=cancelImport&import_id={$IMPORT_ID}'"><strong>{\App\Language::translate('LBL_CANCEL_IMPORT', $MODULE)}</strong></button>
			</td>
		</tr>
	</table>
</div>
{/strip}
