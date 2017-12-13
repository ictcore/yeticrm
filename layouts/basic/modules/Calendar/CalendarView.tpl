{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
<input type="hidden" id="currentView" value="{$VIEW}" />
<input type="hidden" id="activity_view" value="{$CURRENT_USER->get('activity_view')}" />
<input type="hidden" id="time_format" value="{$CURRENT_USER->get('hour_format')}" />
<input type="hidden" id="start_hour" value="{$CURRENT_USER->get('start_hour')}" />
<input type="hidden" id="end_hour" value="{$CURRENT_USER->get('end_hour')}" />
<input type="hidden" id="date_format" value="{$CURRENT_USER->get('date_format')}" />
<input type="hidden" id="showType" value="current" />
<input type="hidden" id="switchingDays" value="workDays" />
<input type="hidden" id="eventLimit" value="{$EVENT_LIMIT}" />
<input type="hidden" id="weekView" value="{$WEEK_VIEW}" />
<input type="hidden" id="dayView" value="{$DAY_VIEW}" />
<input type="hidden" id="hiddenDays" value="{Vtiger_Util_Helper::toSafeHTML(\App\Json::encode(AppConfig::module('Calendar', 'HIDDEN_DAYS_IN_CALENDAR_VIEW')))}" />
<input type="hidden" id="activityStateLabels" value="{Vtiger_Util_Helper::toSafeHTML($ACTIVITY_STATE_LABELS)}" />
<style>
{foreach from=Settings_Calendar_Module_Model::getCalendarConfig('colors') item=ITEM}
	.calCol_{$ITEM.label}{ border: 1px solid {$ITEM.value}!important; }
	.listCol_{$ITEM.label}{ background: {$ITEM.value}!important; }
{/foreach}
{foreach from=Settings_Calendar_Module_Model::getUserColors('colors') item=ITEM}
	.userCol_{$ITEM.id}{ background: {$ITEM.color}!important; }
{/foreach}
{foreach from=Vtiger_Module_Model::getAll() item=MODULE}
	.modIcon_{$MODULE->get('name')}{ background-image: url("{\App\Layout::getLayoutFile('skins/images/'|cat:$MODULE->get('name')|cat:'.png')}"); }
{/foreach}
</style>
<div class="calendarViewContainer rowContent col-md-12 paddingLefttZero col-xs-12">
	<div class="widget_header row marginbottomZero marginRightMinus20">
		<div class="pull-left paddingLeftMd">
			{include file='ButtonViewLinks.tpl'|@vtemplate_path LINKS=$QUICK_LINKS['SIDEBARLINK'] CLASS='listViewMassActions pull-left paddingLeftMd'}
		</div>
		<div class="col-xs-9 col-sm-6">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE_NAME}
		</div>
		<div class="pull-right col-xs-1 col-sm-1">
			<button class="pull-right btn btn-default btn-sm addButton marginRight10">
				<span class="glyphicon glyphicon-plus"></span>
			</button>
		</div>
	</div>
	<div class="alert alert-info marginTop10 hide" id="moduleCacheAlert" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		{\App\Language::translate('LBL_CACHE_SELECTED_FILTERS', $MODULE_NAME)}&nbsp;
		<button type="button" class="pull-right btn btn-warning btn-xs marginRight10 cacheClear">{\App\Language::translate('LBL_CACHE_CLEAR', $MODULE_NAME)}</button>
	</div>
	<div class="bottom_margin">
		<p><!-- Divider --></p>
		<div id="calendarview"></div>
	</div>
</div>
{/strip}
