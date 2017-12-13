{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
<div class="targetFieldsTableContainer">
	<div class="widget_header row">
		<div class="col-xs-12">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
			{\App\Language::translate('LBL_HIDEBLOCKS_DESCRIPTION', $QUALIFIED_MODULE)}
		</div>
	</div>
	<form method="post" action="index.php?module={$MODULE}&parent=Settings&view=Conditions">
	<input type="hidden" name="record" value="{$RECORD_ID}"/>
	<div class="listViewEntriesDiv contents-bottomscroll" style="overflow-x: visible !important;">
		<div class="bottomscroll-div table-responsive">
			<table class="table table-bordered" width="100%" name="targetModuleFields">
				<tr class="blockHeader">
					<th class="blockHeader" colspan="2">
						{if $MODE}
							{\App\Language::translate('LBL_EDIT_BLOCK', $QUALIFIED_MODULE)}
						{else}
							{\App\Language::translate('LBL_NEW_BLOCK', $QUALIFIED_MODULE)}
						{/if}
					</th>
				</tr>
				<tr name="fieldHeaders">
					<td><b>{\App\Language::translate('LBL_BLOCK', $QUALIFIED_MODULE)}</b></td>
					<td>
						<div class="col-md-5">
							<select class="chzn-select form-control" name="blockid">
								{foreach from=$BLOCKS item=MODULES key=key}
									<optgroup label="{\App\Language::translate($key, $key)}">
									{foreach from=$MODULES item=item key=key}
										<option value="{$key}" {if $BLOCK_ID == $key}selected=""{/if}>{\App\Language::translate($item['blocklabel'],$item['module'])}</option>
									{/foreach}
									</optgroup>
								{/foreach}
							</select>
						</div>
					</td>
				</tr>
				<tr name="fieldHeaders">
					<td><b>{\App\Language::translate('LBL_ENABLED', $QUALIFIED_MODULE)}</b></td>
					<td>
						<div class="col-md-5">
							<input type="checkbox" name="enabled" value="true" {if $ENABLED}checked{/if} />
						</div>
					</td>
				</tr>
				<tr name="fieldHeaders">
					<td><b>{\App\Language::translate('LBL_VIEW', $QUALIFIED_MODULE)}</b></td>
					<td class="col-md-10">
						<div class="col-md-5">
							<select multiple class="chzn-select form-control" name="views[]">
								{foreach from=$VIEWS item=LABEL key=VIEW_NAME}
									<option value="{$VIEW_NAME}" {if in_array($VIEW_NAME,$SELECTED_VIEWS)}selected=""{/if}>{\App\Language::translate($LABEL,$QUALIFIED_MODULE)}</option>
								{/foreach}
							</select>
						</div>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	<br />	
	<div class="">
		<div class="pull-right">
			<button class="btn btn-success" type="submit"><strong>{\App\Language::translate('LBL_NEXT', $QUALIFIED_MODULE)}</strong></button>
			<button class="cancelLink btn btn-warning" type="reset" onclick="javascript:window.history.back();">{\App\Language::translate('LBL_CANCEL', $QUALIFIED_MODULE)}</button>
		</div>
		<div class="clearfix"></div>
	</div>
    </form>	
</div>
{/strip}
