{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}
{strip}
<div class="dashboardWidgetHeader">
	<div class="row">
		<div class="col-md-8">
			<div class="dashboardTitle textOverflowEllipsis" title="{\App\Language::translate($WIDGET->getTitle(), $MODULE_NAME)}"><strong>{\App\Language::translate($WIDGET->getTitle(), $MODULE_NAME)}</strong></div>
		</div>
		<div class="col-md-4">
			<div class="box pull-right">
				{include file="dashboards/DashboardHeaderIcons.tpl"|@vtemplate_path:$MODULE_NAME}
			</div>
		</div>
	</div>
	<hr class="widgetHr"/>
	<div class="row" >
		<div class="col-md-6 pull-right">
			<select class="widgetFilter form-control input-sm" id="historyType" title="{\App\Language::translate('LBL_HISTORY_TYPE')}" name="type">
				<option title="{\App\Language::translate('LBL_ALL')}" value="all" {if $DATA['type'] eq 'all'}selected{/if}>{\App\Language::translate('LBL_ALL')}</option>
				{if $COMMENTS_MODULE_MODEL->isPermitted('DetailView')}
				<option title="{\App\Language::translate('LBL_COMMENTS')}" value="comments" {if $DATA['type'] eq 'comments'}selected{/if}>{\App\Language::translate('LBL_COMMENTS')}</option>{/if}
				<option value="updates" title="{\App\Language::translate('LBL_UPDATES')}" {if $DATA['type'] eq 'updates'}selected{/if}>{\App\Language::translate('LBL_UPDATES')}</option>
			</select>
		</div>
	</div>
</div>
<div class="dashboardWidgetContent">
	{include file="dashboards/HistoryContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>
{/strip}
