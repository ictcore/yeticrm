{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div  class="summaryWidgetContainer activityWidgetContainer">
		<div class="widget_header row">
			<div class="col-xs-5">
				<h4 class="widgetTitle textOverflowEllipsis">
					{if $WIDGET['label'] eq ''}
						{\App\Language::translate('LBL_COUNT_RECORDS_WIDGET',$MODULE_NAME)}
					{else}	
						{\App\Language::translate($WIDGET['label'],$MODULE_NAME)}
					{/if}
				</h4>
			</div>
		</div>
		<hr class="widgetHr">
		<div class="widgetContainer_{$key} widgetContentBlock" data-url="{$WIDGET['url']}" data-name="{$WIDGET['label']}">
			<div class="widget_contents">
				
			</div>
		</div>
	</div>
{/strip}
