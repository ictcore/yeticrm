{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<input type="hidden" id="pageStartRange" value="{$PAGING_MODEL->getRecordStartRange()}" />
	<input type="hidden" id="pageEndRange" value="{$PAGING_MODEL->getRecordEndRange()}" />
	<input type="hidden" id="previousPageExist" value="{$PAGING_MODEL->isPrevPageExists()}" />
	<input type="hidden" id="nextPageExist" value="{$PAGING_MODEL->isNextPageExists()}" />
	<input type="hidden" id="totalCount" value="{$LISTVIEW_COUNT}" />
	<input type="hidden" id="listMaxEntriesMassEdit" value="{vglobal('listMaxEntriesMassEdit')}" />
	<input type="hidden" id="autoRefreshListOnChange" value="{AppConfig::performance('AUTO_REFRESH_RECORD_LIST_ON_SELECT_CHANGE')}" />
	<input type='hidden' value="{$PAGE_NUMBER}" id='pageNumber'>
	<input type='hidden' value="{$PAGING_MODEL->getPageLimit()}" id='pageLimit'>
	<input type="hidden" value="{$LISTVIEW_ENTRIES_COUNT}" id="noOfEntries">

	{include file=vtemplate_path('ListViewAlphabet.tpl',$MODULE_NAME)}
	<div class="clearfix"></div>
	<div id="selectAllMsgDiv" class="alert-block msgDiv noprint">
		<strong><a id="selectAllMsg">{\App\Language::translate('LBL_SELECT_ALL',$MODULE)}&nbsp;{\App\Language::translate($MODULE ,$MODULE)}&nbsp;(<span id="totalRecordsCount"></span>)</a></strong>
	</div>
	<div id="deSelectAllMsgDiv" class="alert-block msgDiv noprint">
		<strong><a id="deSelectAllMsg">{\App\Language::translate('LBL_DESELECT_ALL_RECORDS',$MODULE)}</a></strong>
	</div>
	<div class="contents-topscroll noprint stick" data-position="top">
		<div class="topscroll-div"></div>
	</div>
	<div class="listViewEntriesDiv contents-bottomscroll">
		<div class="bottomscroll-div">
			<input type="hidden" value="{$ORDER_BY}" id="orderBy">
			<input type="hidden" value="{$SORT_ORDER}" id="sortOrder">
			<div class="listViewLoadingImageBlock hide modal noprint" id="loadingListViewModal">
				<img class="listViewLoadingImage" src="{vimage_path('loading.gif')}" alt="no-image" title="{\App\Language::translate('LBL_LOADING')}"/>
				<p class="listViewLoadingMsg">{\App\Language::translate('LBL_LOADING_LISTVIEW_CONTENTS')}........</p>
			</div>
			{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}
			<table class="table table-bordered listViewEntriesTable {$WIDTHTYPE}">
				<thead>
					<tr class="listViewHeaders">
						<th>
							<input type="checkbox" id="listViewEntriesMainCheckBox" title="{\App\Language::translate('LBL_SELECT_ALL')}" />
						</th>
						{foreach item=LISTVIEW_HEADER from=$LISTVIEW_HEADERS}
							<th {if $LISTVIEW_HEADER@last}colspan="2"{/if} class="noWrap {if $COLUMN_NAME eq $LISTVIEW_HEADER->get('column')}columnSorted{/if}">
								<a href="javascript:void(0);" class="listViewHeaderValues pull-left" {if $LISTVIEW_HEADER->isListviewSortable()}data-nextsortorderval="{if $COLUMN_NAME eq $LISTVIEW_HEADER->get('column')}{$NEXT_SORT_ORDER}{else}ASC{/if}"{/if} data-columnname="{$LISTVIEW_HEADER->get('column')}">{\App\Language::translate($LISTVIEW_HEADER->get('label'), $MODULE)}
									&nbsp;&nbsp;{if $COLUMN_NAME eq $LISTVIEW_HEADER->get('column')}<span class="{$SORT_IMAGE}"></span>{/if}</a>
									{if $LISTVIEW_HEADER->getFieldDataType() eq 'tree' || $LISTVIEW_HEADER->getFieldDataType() eq 'categoryMultipicklist'}
									{assign var=LISTVIEW_HEADER_NAME value=$LISTVIEW_HEADER->getName()}
									<div class='pull-left'>
										<span class="pull-right popoverTooltip delay0"  data-placement="top" data-original-title="{\App\Language::translate($LISTVIEW_HEADER->get('label'), $MODULE)}" 
											  data-content="{\App\Language::translate('LBL_SEARCH_IN_SUBCATEGORIES',$MODULE_NAME)}">
											<span class="glyphicon glyphicon-info-sign"></span>
										</span>
										<input type="checkbox" id="searchInSubcategories{$LISTVIEW_HEADER_NAME}" title="{\App\Language::translate('LBL_SEARCH_IN_SUBCATEGORIES',$MODULE_NAME)}" name="searchInSubcategories" class="pull-right searchInSubcategories" value="1" data-columnname="{$LISTVIEW_HEADER->get('column')}" {if !empty($SEARCH_DETAILS[$LISTVIEW_HEADER_NAME]['specialOption'])} checked {/if}>
									</div>
								{/if}
							</th>
						{/foreach}
					</tr>
				</thead>
				{if $MODULE_MODEL->isQuickSearchEnabled()}
					<tr>
						<td>
							<a class="btn btn-default" data-trigger="listSearch" href="javascript:void(0);"><span class="glyphicon glyphicon-search"></span></a>
						</td>
						{foreach item=LISTVIEW_HEADER from=$LISTVIEW_HEADERS}
							<td>
								{assign var=FIELD_UI_TYPE_MODEL value=$LISTVIEW_HEADER->getUITypeModel()}
								{include file=vtemplate_path($FIELD_UI_TYPE_MODEL->getListSearchTemplateName(),$MODULE_NAME)
                    FIELD_MODEL= $LISTVIEW_HEADER SEARCH_INFO=$SEARCH_DETAILS[$LISTVIEW_HEADER->getName()] USER_MODEL=$USER_MODEL}
							</td>
						{/foreach}
						<td>
							<a class="btn btn-default" href="index.php?view=List&module={$MODULE}" >
								<span class="glyphicon glyphicon-remove"></span>
							</a>
						</td>
					</tr>
				{/if}
				{assign var="LISTVIEW_HEADER_COUNT" value=count($LISTVIEW_HEADERS)}
				{foreach item=LISTVIEW_ENTRY from=$LISTVIEW_ENTRIES name=listview}
					{assign var="RECORD_ID" value=$LISTVIEW_ENTRY->getId()}
					<tr class="listViewEntries" data-id='{$LISTVIEW_ENTRY->getId()}' data-recordUrl='{$LISTVIEW_ENTRY->getDetailViewUrl()}' id="{$MODULE}_listView_row_{$smarty.foreach.listview.index+1}" {if $LISTVIEW_ENTRY->colorList}style="background-color: {$LISTVIEW_ENTRY->colorList['background']};color: {$LISTVIEW_ENTRY->colorList['text']};"{/if}>
						{if array_key_exists('password',$LISTVIEW_HEADERS)}
							{$PASS_ID="{$LISTVIEW_ENTRY->get('id')}"}
						{/if}
						<td class="{$WIDTHTYPE} noWrap leftRecordActions">
							{include file=vtemplate_path('ListViewLeftSide.tpl',$MODULE_NAME)}
						</td>
						{foreach item=LISTVIEW_HEADER from=$LISTVIEW_HEADERS name=listHeaderForeach}
							{assign var=LISTVIEW_HEADERNAME value=$LISTVIEW_HEADER->get('name')}
							<td class="listViewEntryValue noWrap {$WIDTHTYPE}" data-field-type="{$LISTVIEW_HEADER->getFieldDataType()}" {if $LISTVIEW_HEADERNAME eq 'password'} id="{$PASS_ID}" {/if} {if $smarty.foreach.listHeaderForeach.iteration eq $LISTVIEW_HEADER_COUNT}colspan="2"{/if} data-raw-value="{Vtiger_Util_Helper::toSafeHTML($LISTVIEW_ENTRY->get($LISTVIEW_HEADERNAME))}">
								{if ($LISTVIEW_HEADER->isNameField() eq true or $LISTVIEW_HEADER->get('uitype') eq '4') && $MODULE_MODEL->isListViewNameFieldNavigationEnabled() eq true && $LISTVIEW_ENTRY->isViewable()}
									<a {if $LISTVIEW_HEADER->isNameField() eq true}class="moduleColor_{$MODULE}"{/if} href="{$LISTVIEW_ENTRY->getDetailViewUrl()}">
										{$LISTVIEW_ENTRY->getListViewDisplayValue($LISTVIEW_HEADERNAME)}
									</a>
								{else}
									{if $LISTVIEW_HEADERNAME eq 'password'}
										{str_repeat('*', 10)}
									{else}
										{$LISTVIEW_ENTRY->getListViewDisplayValue($LISTVIEW_HEADERNAME)}
									{/if}
								{/if}
							</td>
						{/foreach}
					</tr>
				{/foreach}
			</table>

			<!--added this div for Temporarily -->
			{if $LISTVIEW_ENTRIES_COUNT eq '0'}
				<table class="emptyRecordsDiv">
					<tbody>
						<tr>
							<td>
								{\App\Language::translate('LBL_RECORDS_NO_FOUND')}.{if $IS_MODULE_EDITABLE} <a href="{$MODULE_MODEL->getCreateRecordUrl()}">{\App\Language::translate('LBL_CREATE_SINGLE_RECORD')}</a>{/if}
							</td>
						</tr>
					</tbody>
				</table>
			{/if}
		</div>
	</div>
{/strip}

