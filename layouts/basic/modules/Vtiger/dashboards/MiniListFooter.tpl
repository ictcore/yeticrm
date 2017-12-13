{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="widgetFooterContent">
		<div class="row no-margin">
			{if $OWNER eq false}
				{assign var="MINILIST_WIDGET_RECORDS" value=[]}
			{else}
				{assign var="MINILIST_WIDGET_RECORDS" value=$MINILIST_WIDGET_MODEL->getRecords($OWNER)}
			{/if}
			<div class="col-md-4">
				<button class="btn btn-xs btn-default recordCount" data-url="{Vtiger_Util_Helper::toSafeHTML($MINILIST_WIDGET_MODEL->getTotalCountURL($OWNER))}">
					<span class="glyphicon glyphicon-equalizer" title="{\App\Language::translate('LBL_WIDGET_FILTER_TOTAL_COUNT_INFO')}"></span>
					<a class="pull-left hide" href="{Vtiger_Util_Helper::toSafeHTML($MINILIST_WIDGET_MODEL->getListViewURL($OWNER))}"><span class="count badge pull-left"></span></a>
				</button>
			</div>
			{if count($MINILIST_WIDGET_RECORDS) >= $MINILIST_WIDGET_MODEL->getRecordLimit()}
				<div class="col-md-8">
					<a class="btn btn-xs btn-primary pull-right" href="{Vtiger_Util_Helper::toSafeHTML($MINILIST_WIDGET_MODEL->getListViewURL($OWNER))}">
						<span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>&nbsp;&nbsp;
						{\App\Language::translate('LBL_MORE')}
					</a>
				</div>
			{else}&nbsp;{/if}
		</div>
	</div>
{/strip}
