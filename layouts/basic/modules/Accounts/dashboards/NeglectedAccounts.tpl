{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
<div class="dashboardWidgetHeader">
	<div class="row">
		<div class="col-md-8">
			<div class="dashboardTitle" title="{\App\Language::translate($WIDGET->getTitle(), $MODULE_NAME)}"><strong>&nbsp;&nbsp;{\App\Language::translate($WIDGET->getTitle(),$MODULE_NAME)}</strong></div>
		</div>
		<div class="col-md-4">
			<div class="box pull-right">
				{if Users_Privileges_Model::isPermitted('Accounts', 'CreateView')}
					<a class="btn btn-xs btn-default" onclick="Vtiger_Header_Js.getInstance().quickCreateModule('Accounts'); return false;">
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
	<div class="row">
		<div class="col-sm-6">
			{include file="dashboards/SelectAccessibleTemplate.tpl"|@vtemplate_path:$MODULE_NAME}
		</div>
	</div>
</div>
<div class="dashboardWidgetContent noSpaces">
	{include file="dashboards/NeglectedAccountsContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

