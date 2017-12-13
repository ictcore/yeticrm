{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="summaryWidgetContainer">
		<div class="widgetContainer_{$key} widgetContentBlock" data-url="{$WIDGET['url']}" data-name="{$WIDGET['label']}" data-type="{$WIDGET['type']}">
			<div class="widget_header">
				<div class="widgetTitle row">
					<div class="col-xs-4">
						<h4 class="moduleColor_{$WIDGET['label']}">{\App\Language::translate($WIDGET['label'],$MODULE_NAME)}</h4>
					</div>
					<div class="col-xs-7">
						<select class="select2 relatedHistoryTypes" multiple>
							{foreach from=Vtiger_HistoryRelation_Widget::getActions() item=ACTIONS}
								<option selected value="{$ACTIONS}">{\App\Language::translate($ACTIONS, $ACTIONS)}</option>	
							{/foreach}
						</select>
					</div>
					<div class="col-xs-1 text-right">
						<button type="button" title="{\App\Language::translate('LBL_FULLSCREEN')}" data-title="{\App\Language::translate($WIDGET['label'],$MODULE_NAME)}" class="widgetFullscreen btn btn-sm btn-default">
							<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
						</button>
					</div>	
				</div>
			</div>
			<hr class="widgetHr">
			<div class="widget_contents widgetContent">
			</div>
		</div>
	</div>
{/strip}
