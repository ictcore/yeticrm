{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="customViewList">
		<div class="widget_header row">
			<div class="col-md-12">
				{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
				{App\Language::translate('LBL_'|cat:$MODULE|upper|cat:'_DESCRIPTION', $QUALIFIED_MODULE)}
			</div>		
		</div>
		<hr>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-6">
						<select class="chzn-select" id="moduleFilter" name="moduleFilter">
							{foreach item=SUPPORTED_MODULE_NAME from=$SUPPORTED_MODULE_MODELS}
								<option {if $SOURCE_MODULE eq $SUPPORTED_MODULE_NAME} selected="" {/if} value="{$SUPPORTED_MODULE_NAME}">
									{App\Language::translate($SUPPORTED_MODULE_NAME, $SUPPORTED_MODULE_NAME)}
								</option>
							{/foreach}
						</select>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6">
						<button class="btn btn-success pull-right createFilter" type="button" data-editurl="{$MODULE_MODEL->getCreateFilterUrl($SOURCE_MODULE_ID)}"><span class="glyphicon glyphicon-plus"></span> {App\Language::translate('LBL_ADD_FILTER',$QUALIFIED_MODULE)}</button>
					</div>
					
				</div>
			</div>
			<div class="panel-body padding5">
				<div class="indexContents">
					{include file='IndexContents.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
{/strip}
