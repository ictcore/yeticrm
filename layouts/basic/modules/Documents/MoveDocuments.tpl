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
	<div class="modelContainer modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button" title="{\App\Language::translate('LBL_CLOSE')}">x</button>
					<h3 class="modal-title">{\App\Language::translate('LBL_MOVE', $MODULE)} {\App\Language::translate($MODULE, $MODULE)}</h3>
				</div>
				<form class="form-horizontal contentsBackground" id="moveDocuments" method="post" action="index.php">
					<input type="hidden" name="module" value="{$MODULE}" />
					<input type="hidden" name="action" value="MoveDocuments" />
					<input type="hidden" name="selected_ids" value={\App\Json::encode($SELECTED_IDS)} />
					<input type="hidden" name="excluded_ids" value={\App\Json::encode($EXCLUDED_IDS)} />
					<input type="hidden" name="viewname" value="{$VIEWNAME}" />
					<input type="hidden" name="search_key" value= "{$SEARCH_KEY}" />
					<input type="hidden" name="operator" value="{$OPERATOR}" />
					<input type="hidden" name="search_value" value="{$ALPHABET_VALUE}" />
					<div class="modal-body">
						<div class="row verticalBottomSpacing">
							<span class="col-md-4">{\App\Language::translate('LBL_FOLDERS_LIST', $MODULE)}<span class="redColor">*</span></span>
							<span class="col-md-8 row">
								<select class="chzn-select col-md-11 form-control" name="folderid">
									<optgroup label="{\App\Language::translate('LBL_FOLDERS', $MODULE)}">
										{foreach item=FOLDERNAME from=$FOLDERS key=FOLDERID}
											<option value="{$FOLDERID}">{$FOLDERNAME}</option>
										{/foreach}
									</optgroup>
								</select>
							</span>
						</div>
					</div>
					{include file='ModalFooter.tpl'|@vtemplate_path:$MODULE}
				</form>
			</div>
		</div>
	</div>
{/strip}
