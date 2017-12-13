{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
<table class="table table-bordered table-condensed listViewEntriesTable">
	<thead>
		<tr class="listViewHeaders" >
			<th width="30%">{\App\Language::translate('LBL_ACTION',$QUALIFIED_MODULE)}</th>
			<th>{\App\Language::translate('LBL_ACTIONDESC',$QUALIFIED_MODULE)}</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	{if !empty($ACTIONS_SELECTED)}
		{foreach from=$ACTIONS_SELECTED item=item key=key}
		<tr class="listViewEntries" data-key="{$key}">
			<td>{Settings_DataAccess_Module_Model::getActionName($item['an'],true)}</td>
			<td>{Settings_DataAccess_Module_Model::getActionName($item['an'],false)}</td>
			<td>
				<a href='index.php?module={$MODULE_NAME}&parent=Settings&action=DeleteAction&id={$TPL_ID}&a={$key}&m={$BASE_MODULE}'  class="pull-right marginRight10px">
					<i type="{\App\Language::translate('REMOVE_TPL', $MODULE_NAME)}" class="glyphicon glyphicon-trash alignMiddle"></i>
				</a>
				{if $item['cf'] != 0}
					<a href='index.php?module={$MODULE_NAME}&parent=Settings&view=ActionConfig&did={$TPL_ID}&aid={$key}&an={$item['an']}&m={$BASE_MODULE}'  class="pull-right edit_tpl">
						<span class="glyphicon glyphicon-pencil alignMiddle" aria-hidden="true" title="{\App\Language::translate('LBL_EDIT')}"></span>&nbsp;
					</a>
				{/if}
			</td>
		<tr>
		{/foreach}
	{else}
		<tr>
			<td class="textAlignCenter" colspan="3">
				{\App\Language::translate('LBL_NO_ACTION',$QUALIFIED_MODULE)}
			</td>
		</tr>
	{/if}
	</tbody>
</table>
