{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}

<style>
	.blockHeader th{
		text-align:center !important; 
		vertical-align:middle !important; 
	}
	.confTable td, label, span{
		text-align:center !important; 
		vertical-align:middle !important; 
	}	
</style>
<div class="">
	<div class="widget_header row">
		<div class="col-md-7">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
			{if isset($SELECTED_PAGE)}
				{\App\Language::translate($SELECTED_PAGE->get('description'),$QUALIFIED_MODULE)}
			{/if}
		</div>
		<div class="col-md-5">
			<div class="pull-right">
				<a class="btn btn-success addMenu" href="{Settings_ModuleManager_Module_Model::getUserModuleImportUrl()}"><strong>{\App\Language::translate('LBL_IMPORT_UPDATE', $QUALIFIED_MODULE)}</strong></a>
			</div>
		</div>
	</div>
	<hr>
	<table class="table tableRWD table-bordered table-condensed themeTableColor">
		<thead>
			<tr class="blockHeader">
				<th colspan="1" class="mediumWidthType">
					<span>{\App\Language::translate('LBL_TIME', $MODULE)}</span>
				</th>
				<th colspan="1" class="mediumWidthType">
					<span>{\App\Language::translate('LBL_USER', $MODULE)}</span>
				</th>
				<th colspan="1" class="mediumWidthType">
					<span>{\App\Language::translate('LBL_NAME', $MODULE)}</span>
				</th>
				</th>
				<th colspan="1" class="mediumWidthType">
					<span>{\App\Language::translate('LBL_FROM_VERSION', $MODULE)}</span>
				</th>
				<th colspan="1" class="mediumWidthType">
					<span>{\App\Language::translate('LBL_TO_VERSION', $MODULE)}</span>
				</th>
				<th colspan="1" class="mediumWidthType">
					<span>{\App\Language::translate('LBL_RESULT', $MODULE)}</span>
				</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$UPDATES key=key item=foo}
				<tr>
					<td width="16%"><label class="marginRight5px">{$foo.time}</label></td>
					<td width="16%"><label class="marginRight5px">{$foo.user}</label></td>
					<td width="16%"><label class="marginRight5px">{$foo.name}</label></td>
					<td width="16%"><label class="marginRight5px">{$foo.from_version}</label></td>
					<td width="16%"><label class="marginRight5px">{$foo.to_version}</label></td>
					<td width="16%"><label class="marginRight5px">{if $foo.result eq 1}{\App\Language::translate('LBL_YES', $MODULE)}{else}{\App\Language::translate('LBL_NO', $MODULE)}{/if}</label></td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>
