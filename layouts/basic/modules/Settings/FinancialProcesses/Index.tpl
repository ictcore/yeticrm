{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}

 <div class="supportProcessesContainer">
	<div class="widget_header row">
		<div class="col-xs-12">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}	
			{\App\Language::translate('LBL_FINANCIAL_PROCESSES_DESCRIPTION', $QUALIFIED_MODULE)}
		</div>
	</div>
	<ul id="tabs" class="nav nav-tabs " data-tabs="tabs">
		<li class="active"><a href="#configuration" data-toggle="tab">{\App\Language::translate('LBL_GENERAL', $QUALIFIED_MODULE)} </a></li>
	</ul>
	<br />
	<div class="tab-content">
		<div class='editViewContainer tab-pane active' id="configuration">
		</div>
	</div>
</div>
