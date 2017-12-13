{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
<input type="hidden" id="filterAll" value='{$FILTERS}'>
<input type="hidden" id="checkboxAll" value='{$CHECKBOXS}'>
<input type="hidden" id="switchHeaderAll" value='{$SWITCHES_HEADER}'>
<div class="WidgetsManage">
	<input type="hidden" name="tabid" value="{$SOURCE}">
	<div class="widget_header row">
		<div class="col-md-8">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
			{\App\Language::translate('LBL_MODULE_DESC', $QUALIFIED_MODULE)}
		</div>
		<div class="pull-right col-md-4 h3">
			<select class="select2 col-md-3 form-control" name="ModulesList">
				{foreach from=$MODULE_MODEL->getModulesList() item=item key=key}
					<option value="{$key}" {if $SOURCE eq $key}selected{/if}>{\App\Language::translate($item['tablabel'], $item['name'])}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div>
		<div class="col-md-8 paddingLRZero">
			<h4>{\App\Language::translate('List of widgets for the module', $QUALIFIED_MODULE)}: {\App\Language::translate($SOURCEMODULE, $SOURCEMODULE)}</h4>
		</div>
		<div class="col-md-4 paddingLRZero">
			<button class="btn btn-success addWidget pull-right" type="button"><i class="glyphicon glyphicon-plus"></i>&nbsp;<strong>{\App\Language::translate('Add widget', $QUALIFIED_MODULE)}</strong></button>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="blocks-content padding1per">
		<div class="row">
			{foreach from=$WIDGETS item=WIDGETCOL key=column}
			<div class="blocksSortable col-md-4" data-column="{$column}">
				{foreach from=$WIDGETCOL item=WIDGET key=key}
					<div class="blockSortable" data-id="{$key}">
						<div class="padding1per border1px">
							<div class="row">
								<div class="col-md-5">
									<img class="alignMiddle" src="{vimage_path('drag.png')}" /> &nbsp;&nbsp;{\App\Language::translate($WIDGET['type'], $QUALIFIED_MODULE)}
								</div>
								<div class="col-md-5">
									{if $WIDGET['label'] eq '' && isset($WIDGET['data']['relatedmodule'])}
										{\App\Language::translate(vtlib\Functions::getModuleName($WIDGET['data']['relatedmodule']),vtlib\Functions::getModuleName($WIDGET['data']['relatedmodule']))}
									{else}	
										{\App\Language::translate($WIDGET['label'], $SOURCEMODULE)}&nbsp;
									{/if}									
								</div>
								<div class="col-md-2">
									<span class="pull-right">
										<i class="cursorPointer glyphicon glyphicon-pencil editWidget" title="{\App\Language::translate('Edit', $QUALIFIED_MODULE)}"></i>
										&nbsp;&nbsp;<i class="cursorPointer glyphicon glyphicon-remove removeWidget" title="{\App\Language::translate('Remove', $QUALIFIED_MODULE)}"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				{/foreach}
			</div>
			{/foreach}
		</div>
	</div>
	<div class="clearfix"></div>
{/strip}
