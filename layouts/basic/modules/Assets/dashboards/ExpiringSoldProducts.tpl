{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
<div class="dashboardWidgetHeader">
	<div class="row">
		<div class="col-md-8">
			<div class="dashboardTitle" title="{\App\Language::translate($WIDGET->getTitle(), $MODULE_NAME)}"><b>&nbsp;&nbsp;{\App\Language::translate($WIDGET->getTitle(), $MODULE_NAME)}</b></div>
		</div>
		<div class="col-md-4">
			<div class="box pull-right">
				{if Users_Privileges_Model::isPermitted($MODULE_NAME, 'CreateView')}
					<a class="btn btn-default btn-xs" onclick="Vtiger_Header_Js.getInstance().quickCreateModule('{$MODULE_NAME}'); return false;">
						<i class='glyphicon glyphicon-plus' border='0' title="{\App\Language::translate('LBL_ADD_RECORD')}" alt="{\App\Language::translate('LBL_ADD_RECORD')}"/>
					</a>
				{/if}
				<a class="btn btn-default btn-xs" href="javascript:void(0);" name="drefresh" data-url="{$WIDGET->getUrl()}&linkid={$WIDGET->get('linkid')}&content=data">
					<i class="glyphicon glyphicon-refresh" hspace="2" border="0" align="absmiddle" title="{\App\Language::translate('LBL_REFRESH')}" alt="{\App\Language::translate('LBL_REFRESH')}"></i>
				</a>
				{if !$WIDGET->isDefault()}
					<a class="btn btn-default btn-xs" name="dclose" class="widget" data-url="{$WIDGET->getDeleteUrl()}">
						<i class="glyphicon glyphicon-remove" hspace="2" border="0" align="absmiddle" title="{\App\Language::translate('LBL_CLOSE')}" alt="{\App\Language::translate('LBL_CLOSE')}"></i>
					</a>
				{/if}
			</div>
		</div>
	</div>
	<hr class="widgetHr"/>
	<div class="row" >
		<div class="col-md-12">
			<div class="pull-right">
				<input class="switchBtn calculationsSwitch" type="checkbox" checked="" data-size="mini" data-label-width="5" data-handle-width="75" data-on-text="{\App\Language::translate('LBL_OWNER',$MODULE_NAME)}" data-off-text="{\App\Language::translate('LBL_COMMON',$MODULE_NAME)}" data-on-val="owner" data-off-val="common" data-urlparams="showtype">
			</div>
		</div>
	</div>
</div>
<div class="dashboardWidgetContent">
	{include file="dashboards/ExpiringSoldProductsContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>
