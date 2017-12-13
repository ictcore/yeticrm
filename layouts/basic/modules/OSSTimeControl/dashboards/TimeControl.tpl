{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
<script type="text/javascript">
	YetiForce_Bar_Widget_Js('YetiForce_Timecontrol_Widget_Js',{}, {
		loadChart: function () {
			var thisInstance = this;
			var chartData = thisInstance.generateData();
			var options = {
				xaxis: {
					minTickSize: 1,
					ticks: chartData['ticks']
				},
				yaxis: {
					min: 0,
					tickDecimals: 0
				},
				grid: {
					hoverable: true,
					clickable: true
				},
				series: {
					bars: {
						show: true,
						barWidth: 0.8,
						dataLabels: false,
						align: "center",
						lineWidth: 0,
					},
					stack: true
				},
				legend: {
					show: true,
					labelFormatter: function (label, series) {
						return('<b>' + label + '</b>: ' + app.parseNumberToShow(chartData['legend'][label]) + ' h');
					}
				}
			};
			thisInstance.plotInstance = $.plot(thisInstance.getPlotContainer(false), chartData['chartData'], options);
		}
	});
</script>
<div class="dashboardWidgetHeader">
	{foreach key=index item=cssModel from=$STYLES}
		<link rel="{$cssModel->getRel()}" href="{$cssModel->getHref()}" type="{$cssModel->getType()}" media="{$cssModel->getMedia()}" />
	{/foreach}
	{foreach key=index item=jsModel from=$SCRIPTS}
		<script type="{$jsModel->getType()}" src="{$jsModel->getSrc()}"></script>
	{/foreach}
	<div class="row">
		<div class="col-md-8">
			<div class="dashboardTitle" title="{\App\Language::translate($WIDGET->getTitle(), $MODULE_NAME)}"><strong>&nbsp;&nbsp;{\App\Language::translate($WIDGET->getTitle(),$MODULE_NAME)}</strong></div>
		</div>
		<div class="col-md-4">
			<div class="box pull-right">
				{if Users_Privileges_Model::isPermitted('OSSTimeControl', 'CreateView')}
					<a class="btn btn-xs btn-default" onclick="Vtiger_Header_Js.getInstance().quickCreateModule('OSSTimeControl');
							return false;">
						<span class='glyphicon glyphicon-plus' border='0' title="{\App\Language::translate('LBL_ADD_RECORD')}" alt="{\App\Language::translate('LBL_ADD_RECORD')}"></span>
					</a>
				{/if}
				<a class="btn btn-xs btn-default" href="javascript:void(0);" name="drefresh" data-url="{$WIDGET->getUrl()}&linkid={$WIDGET->get('linkid')}&content=data">
					<span class="glyphicon glyphicon-refresh" hspace="2" border="0" align="absmiddle" title="{\App\Language::translate('LBL_REFRESH')}" alt="{\App\Language::translate('LBL_REFRESH')}"></span>
				</a>
				{if !$WIDGET->isDefault()}
					<a class="btn btn-xs btn-default" name="dclose" class="widget" data-url="{$WIDGET->getDeleteUrl()}">
						<span class="glyphicon glyphicon-remove" hspace="2" border="0" align="absmiddle" title="{\App\Language::translate('LBL_CLOSE')}" alt="{\App\Language::translate('LBL_CLOSE')}"></span>
					</a>
				{/if}
			</div>
		</div>
	</div>
	<hr class="widgetHr"/>
	<div class="row" >
		<div class="col-md-6">
			<div class="input-group input-group-sm">
				<span class=" input-group-addon"><span class="glyphicon glyphicon-calendar iconMiddle "></span></span>
				<input type="text" name="time" title="{\App\Language::translate('LBL_CHOOSE_DATE')}" class="dateRangeField widgetFilter width90 form-control" value="{implode(',',$DTIME)}"/>
			</div>	
		</div>
		<div class="col-md-6">
			{if $SOURCE_MODULE && AppConfig::performance('SEARCH_SHOW_OWNER_ONLY_IN_LIST')}
				{assign var=USERS_GROUP_LIST value=\App\Fields\Owner::getInstance($SOURCE_MODULE)->getUsersAndGroupForModuleList(false,$USER_CONDITIONS)}
				{assign var=ACCESSIBLE_USERS value=$USERS_GROUP_LIST['users']}
			{else}
				{assign var=ACCESSIBLE_USERS value=\App\Fields\Owner::getInstance()->getAccessibleUsers()}
			{/if}
			<div class="input-group input-group-sm">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user iconMiddle"></span></span>
				<select class="widgetFilter width90 form-control select2" title="{\App\Language::translate('LBL_SELECT_USER')}" name="user" style="margin-bottom:0;" 
					{if AppConfig::performance('SEARCH_OWNERS_BY_AJAX')}
						data-ajax-search="1" data-ajax-url="index.php?module={$MODULE_NAME}&action=Fields&mode=getOwners&type=Edit&result[]=users" data-minimum-input="{AppConfig::performance('OWNER_MINIMUM_INPUT_LENGTH')}"
					{/if}>
					{if !AppConfig::performance('SEARCH_OWNERS_BY_AJAX')}
						<optgroup label="{\App\Language::translate('LBL_USERS')}">
							{foreach key=OWNER_ID item=OWNER_NAME from=$ACCESSIBLE_USERS}
								<option title="{$OWNER_NAME}" {if $OWNER_ID eq $USERID } selected {/if} value="{$OWNER_ID}">
									{$OWNER_NAME}
								</option>
							{/foreach}
						</optgroup>
					{/if}
				</select>
			</div>
		</div>
	</div>
</div>
<div class="dashboardWidgetContent">
	{include file="dashboards/TimeControlContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>
