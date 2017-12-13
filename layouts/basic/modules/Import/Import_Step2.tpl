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
<div class='col-md-12 paddingLRZero'>
	<div>
		<div><strong>{\App\Language::translate('LBL_IMPORT_STEP_2', $MODULE)}: </strong> {\App\Language::translate('LBL_IMPORT_STEP_2_DESCRIPTION', $MODULE)}</div>
		<div>&nbsp;</div>
	</div>
	<div id="file_type_container">
		<div class="col-md-4"><span>{\App\Language::translate('LBL_FILE_TYPE', $MODULE)}</span></div>
		<div class="col-md-6 paddingBottom10">
			<select name="type" class="form-control" id="type" title="{\App\Language::translate('LBL_FILE_TYPE', $MODULE)}" onchange="ImportJs.handleFileTypeChange();">
				{foreach item=_FILE_TYPE from=$SUPPORTED_FILE_TYPES}
				<option value="{$_FILE_TYPE}">{\App\Language::translate($_FILE_TYPE, $MODULE)}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div  id="file_encoding_container">
		<div class="col-md-4"><span>{\App\Language::translate('LBL_CHARACTER_ENCODING', $MODULE)}</span></div>
		<div class="col-md-6 paddingBottom10">
			<select name="file_encoding" class="form-control" id="file_encoding" title="{\App\Language::translate('{LBL_CHARACTER_ENCODING', $MODULE)}">
				{foreach key=_FILE_ENCODING item=_FILE_ENCODING_LABEL from=$SUPPORTED_FILE_ENCODING}
				<option value="{$_FILE_ENCODING}">{\App\Language::translate($_FILE_ENCODING_LABEL, $MODULE)}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div  id="delimiter_container">
		<div class="col-md-4"><span>{\App\Language::translate('LBL_DELIMITER', $MODULE)}</span></div>
		<div class="col-md-6 paddingBottom10">
			<select name="delimiter" class="form-control" id="delimiter" title="{\App\Language::translate('LBL_DELIMITER', $MODULE)}">
				{foreach key=_DELIMITER item=_DELIMITER_LABEL from=$SUPPORTED_DELIMITERS}
				<option value="{$_DELIMITER}">{\App\Language::translate($_DELIMITER_LABEL, $MODULE)}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div id="zipExtension" class="hide">
		<div class="col-md-4"><span>{\App\Language::translate('LBL_EXTENSION_TYPE', $MODULE)}</span></div>
		<div class="col-md-6 paddingBottom10">
			<select name="extension" class="chzn-select" id="extension" title="{\App\Language::translate('LBL_EXTENSION_TYPE', $MODULE)}">
				<option value="xml">XML</option>
			</select>
		</div>
	</div>
	<div id="xml_tpl" class="hide">
		<div class="col-md-4"><span>{\App\Language::translate('LBL_XML_EXPORT_TPL', $MODULE)}</span></div>
		<div class="col-md-6 paddingBottom10">
			<select name="xml_import_tpl" class="chzn-select" id="xml_import_tpl" title="{\App\Language::translate('LBL_XML_EXPORT_TPL', $MODULE)}">
				<option value="">{\App\Language::translate('LBL_NONE', 'Import')}</option>
				{foreach key=key item=item from=$XML_IMPORT_TPL}
					<option value="{$item}">{\App\Language::translate($item, 'Import')}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div id="has_header_container">
		<div class="col-md-4"><span>{\App\Language::translate('LBL_HAS_HEADER', $MODULE)}</span></div>
		<div class="col-md-6"><input type="checkbox" id="has_header" name="has_header" title="{\App\Language::translate('LBL_HAS_HEADER', $MODULE)}" checked /></div>
	</div>
</div>
{/strip}
