{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
<div class=" editViewContainer">
	<form class="form-horizontal recordEditView" id="EditView" name="EditView" method="post" action="index.php" enctype="multipart/form-data">
	<input type="hidden" name="module" value="TreesManager"/>
	<input type="hidden" name="parent" value="Settings"/>
	<input type="hidden" name="action" value="Save"/>
	<input type="hidden" name="record" value="{$RECORD_ID}" />
	<input type="hidden" id="treeLastID" value="{$LAST_ID}" />
	<input type="hidden" id="access" value="{$ACCESS}" />
	<input type="hidden" name="tree" id="treeValues" value='{Vtiger_Util_Helper::toSafeHTML($TREE)}' />
	<input type="hidden" name="replace" id="replaceIds" value="" />
	<div class='widget_header row '>
		<div class="col-xs-12">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
				{if isset($SELECTED_PAGE)}
					{\App\Language::translate($SELECTED_PAGE->get('description'),$QUALIFIED_MODULE)}
				{/if}
		</div>
	</div>
	<div class="row">
		<label class="col-md-3"><strong><span class="redColor">*</span>{\App\Language::translate('LBL_NAME', $QUALIFIED_MODULE)}: </strong></label>
		<div class="col-md-4">
			<input type="text" class="fieldValue form-control" name="name" id="treeename" value="{$RECORD_MODEL->get('name')}" data-validation-engine='validate[required]'  />
		</div>
	</div>
	<br />
	{assign var="SUPPORTED_MODULE_MODELS" value=Settings_Workflows_Module_Model::getSupportedModules()}
	<div class="row">
		<div class="col-md-3">
			<label class=""><strong>{\App\Language::translate('LBL_MODULE', $QUALIFIED_MODULE)}: </strong></label>
		</div>
		<div class="col-md-4 fieldValue">
			<select class="chzn-select form-control" name="templatemodule" {if !$ACCESS} disabled {/if} >
				{foreach item=MODULE_MODEL key=TAB_ID from=$SUPPORTED_MODULE_MODELS}
					<option {if $SOURCE_MODULE eq $TAB_ID} selected="" {/if} value="{$TAB_ID}">
						{if $MODULE_MODEL->getName() eq 'Calendar'}
							{\App\Language::translate('LBL_TASK', $MODULE_MODEL->getName())}
						{else}
							{\App\Language::translate($MODULE_MODEL->getName(),$MODULE_MODEL->getName())}
						{/if}
					</option>
				{/foreach}
			</select>
			{if !$ACCESS} 
				<input type="text" class="fieldValue form-control hide" name="templatemodule" value="{$SOURCE_MODULE}"/>
			{/if}
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-3">
			<label class=""><strong>{\App\Language::translate('LBL_SHARE_WITH', $QUALIFIED_MODULE)}: </strong></label>
		</div>
		<div class="col-md-4 fieldValue">
			<select class="select2 form-control" name="share[]" multiple>
				{foreach item=MODULE_MODEL key=TAB_ID from=$SUPPORTED_MODULE_MODELS}
					<option {if in_array($TAB_ID, $RECORD_MODEL->get('share'))} selected="" {/if} value="{$TAB_ID}">
						{if $MODULE_MODEL->getName() eq 'Calendar'}
							{\App\Language::translate('LBL_TASK', $MODULE_MODEL->getName())}
						{else}
							{\App\Language::translate($MODULE_MODEL->getName(),$MODULE_MODEL->getName())}
						{/if}
					</option>
				{/foreach}
			</select>
		</div>
	</div>
	<br />
	<hr>
	<div class="row">
		<div class="col-md-3">
			<label class=""><strong>{\App\Language::translate('LBL_ADD_ITEM_TREE', $QUALIFIED_MODULE)}</strong></label>
		</div>
		<div class="col-md-8">
			<div class="col-xs-4 col-sm-4 col-md-3 paddingLRZero">
				<input type="text" class="fieldValue col-md-4 addNewElement form-control">
			</div>
			<div class="col-xs-6 paddingLeft5px">
				<a class="btn btn-default addNewElementBtn"><strong>{\App\Language::translate('LBL_ADD_TO_TREES', $QUALIFIED_MODULE)}</strong></a>
			</div>
		</div>
	</div>
	<hr>
	<div class="modal-header contentsBackground" tabindex="-1">
		<div id="treeContents"></div>
	</div>
	<br />
	<div class="pull-right">
		<button class="btn btn-success saveTree"><strong>{\App\Language::translate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></button>
		<button class="cancelLink btn btn-warning" type="reset" onclick="javascript:window.history.back();">{\App\Language::translate('LBL_CANCEL', $QUALIFIED_MODULE)}</button>
	</div>
	<div class="clearfix"></div>
</div>
{/strip}
