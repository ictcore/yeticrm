{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="listViewPageDiv" id="listViewContainer">
		<div class="listViewTopMenuDiv">
			<div class="row widget_header">
				<div class="col-xs-12">
					{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
					{\App\Language::translate('LBL_PDF_DESCRIPTION', $QUALIFIED_MODULE)}
				</div>
			</div>
			{if Settings_ModuleManager_Library_Model::checkLibrary('mPDF')}
				<div class="alert alert-danger" role="alert">
					<div>
						<h4>{\App\Language::translate('ERR_NO_REQUIRED_LIBRARY', 'Settings:Vtiger','mPDF')}</h4>
					</div>
				</div>
				<hr>
			{/if}
			<div class="row">
				<div class="col-md-4 btn-toolbar">
					<button class="btn btn-default addButton" id="addButton" data-url="{Settings_PDF_Module_Model::getCreateRecordUrl()}">
						<i class="glyphicon glyphicon-plus"></i>&nbsp;
						<strong>{\App\Language::translate('LBL_NEW', $QUALIFIED_MODULE)} {\App\Language::translate('LBL_PDF_TEMPLATE',$QUALIFIED_MODULE)}</strong>
					</button>
					<button class="btn btn-default importButton" id="importButton" data-url="{Settings_PDF_Module_Model::getImportViewUrl()}" title="{\App\Language::translate('LBL_IMPORT_TEMPLATE', $QUALIFIED_MODULE)}">
						<i class="glyphicon glyphicon-import"></i>
					</button>
				</div>
				<div class="col-md-4 btn-toolbar">
					<select class="chzn-select" id="moduleFilter" >
						<option value="">{\App\Language::translate('LBL_ALL', $QUALIFIED_MODULE)}</option>
						{foreach item=MODULE_MODEL key=TAB_ID from=$SUPPORTED_MODULE_MODELS}
							<option {if $SOURCE_MODULE eq $MODULE_MODEL->getName()} selected="" {/if} value="{$MODULE_MODEL->getName()}">
								{if $MODULE_MODEL->getName() eq 'Calendar'}
									{\App\Language::translate('LBL_TASK', $MODULE_MODEL->getName())}
								{else}
									{\App\Language::translate($MODULE_MODEL->getName(),$MODULE_MODEL->getName())}
								{/if}
							</option>
						{/foreach}
					</select>
				</div>
				<div class="col-md-4 btn-toolbar">
					{include file='ListViewActions.tpl'|@vtemplate_path}
				</div>
			</div>
		</div>
		<div class="listViewContentDiv" id="listViewContents">
		{/strip}
