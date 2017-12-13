{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<input id="addFilterUrl" type="hidden" value="{$MODULE_MODEL->getCreateFilterUrl($SOURCE_MODULE_ID)}"/>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-condensed listViewEntriesTable">
			<thead>
				<tr class="blockHeader">
					<th></th>
					<th><strong>{\App\Language::translate('ViewName',$QUALIFIED_MODULE)}</strong></th>
					<th><strong>{\App\Language::translate('SetDefault',$QUALIFIED_MODULE)}</strong></th>
					<th><strong>{\App\Language::translate('Privileges',$QUALIFIED_MODULE)}</strong></th>
					<th><strong>{\App\Language::translate('LBL_FEATURED_LABELS',$QUALIFIED_MODULE)}</strong></th>
					<th><strong>{\App\Language::translate('LBL_SORTING',$QUALIFIED_MODULE)}</strong></th>
					<th><strong>{\App\Language::translate('LBL_CREATED_BY',$QUALIFIED_MODULE)}</strong></th>
					<th><strong>{\App\Language::translate('Actions',$QUALIFIED_MODULE)}</strong></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$MODULE_MODEL->getCustomViews($SOURCE_MODULE_ID) item=item key=key}
					<tr data-cvid="{$key}" data-mod="{$item['entitytype']}">
						<td>
							<img src="{vimage_path('drag.png')}" title="{\App\Language::translate('LBL_DRAG',$QUALIFIED_MODULE)}"/>
						</td>
						{if $item['viewname'] eq 'All'}
							<td>{\App\Language::translate('All',$item['entitytype'])}</td>
						{else}
							<td>{$item['viewname']}</td>
						{/if}
						<td>
							<input class="switchBtn updateField" type="checkbox" name="setdefault" {if $item['setdefault']}checked disabled="disabled"{/if} data-size="small" data-label-width="5" data-on-text="{\App\Language::translate('LBL_YES')}" data-off-text="{\App\Language::translate('LBL_NO')}" value="1">
							&nbsp;&nbsp;
							<button type="button" class="btn btn-default btn-sm showModal" data-url="{$MODULE_MODEL->getUrlDefaultUsers($SOURCE_MODULE_ID,$key, $item['setdefault'])}"><span class="glyphicon glyphicon-user"></span></button>
						</td>
						<td>
							<input class="switchBtn updateField" type="checkbox" name="privileges" {if $item['privileges']}checked{/if} data-size="small" data-label-width="5" data-on-text="{\App\Language::translate('LBL_YES')}" data-off-text="{\App\Language::translate('LBL_NO')}" value="1">
						</td>
						<td>
							<input class="switchBtn updateField" type="checkbox" name="featured" {if $item['featured']}checked{/if} data-size="small" data-label-width="5" data-on-text="{\App\Language::translate('LBL_YES')}" data-off-text="{\App\Language::translate('LBL_NO')}" value="1">
							&nbsp;&nbsp;
							<button type="button" class="btn btn-default btn-sm showModal" data-url="{$MODULE_MODEL->getFeaturedFilterUrl($SOURCE_MODULE_ID,$key)}"><span class="glyphicon glyphicon-user"></span></button>
						</td>
						<td>
							<button type="button" id="sort" name="sort" class="btn btn-default btn-sm showModal" data-url="{$MODULE_MODEL->getSortingFilterUrl($SOURCE_MODULE_ID,$key)}"><span class="glyphicon glyphicon-sort"></span></button>
						</td>
						<td>{vtlib\Functions::getOwnerRecordLabel($item['userid'])}</td>
						<td>
							<button class="btn btn-primary marginLeftZero btn-sm update" data-cvid="{$key}" data-editurl="{$MODULE_MODEL->GetUrlToEdit($item['entitytype'],$key)}">{\App\Language::translate('Edit',$QUALIFIED_MODULE)}</button>
							{if $item['presence'] eq 1}
								<button class="btn btn-danger marginLeftZero btn-sm delete marginRight10" data-cvid="{$key}">{\App\Language::translate('Delete',$QUALIFIED_MODULE)}</button>
							{/if}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{/strip}
