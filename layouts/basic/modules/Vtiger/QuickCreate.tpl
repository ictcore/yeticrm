{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
* Contributor(s): YetiForce.com
********************************************************************************/
-->*}
{strip}
	{foreach key=index item=jsModel from=$SCRIPTS}
		<script type="{$jsModel->getType()}" src="{$jsModel->getSrc()}"></script>
	{/foreach}
	{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}
	<div class="modelContainer modal fade quickCreateContainer" tabindex="-1">
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<form class="form-horizontal recordEditView" name="QuickCreate" method="post" action="index.php">
					<div class="modal-header">
						<div class="pull-left divQuickCreate">
							<h3 class="modal-title quickCreateTitle">{\App\Language::translate('LBL_QUICK_CREATE', $MODULE)}:&nbsp <p class="textTransform"><b>{\App\Language::translate($SINGLE_MODULE, $MODULE)}<b></p></h3>
						</div>
						<div class="pull-right quickCreateActions pullRight">
							{assign var="EDIT_VIEW_URL" value=$MODULE_MODEL->getCreateRecordUrl()}
							{foreach item=LINK from=$QUICKCREATE_LINKS['QUICKCREATE_VIEW_HEADER']}
								{include file='ButtonLink.tpl'|@vtemplate_path:$MODULE BUTTON_VIEW='quickcreateViewHeader'}
								&nbsp;&nbsp;
							{/foreach}
							<button class="btn btn-default goToFullFormOne" id="goToFullForm" data-edit-view-url="{$EDIT_VIEW_URL}" type="button"><strong>{\App\Language::translate('LBL_GO_TO_FULL_FORM', $MODULE)}</strong></button>&nbsp;
							<button class="btn btn-success" type="submit" title="{\App\Language::translate('LBL_SAVE', $MODULE)}"><strong><span class="glyphicon glyphicon-ok"></span></strong></button>
							<button class="cancelLink  btn btn-warning" aria-hidden="true" data-dismiss="modal" type="button" title="{\App\Language::translate('LBL_CLOSE')}"><span class="glyphicon glyphicon-remove"></span></button>
						</div>
						<div class="clearfix"></div>
					</div>
					{if !empty($PICKIST_DEPENDENCY_DATASOURCE)}
						<input type="hidden" name="picklistDependency" value='{Vtiger_Util_Helper::toSafeHTML($PICKIST_DEPENDENCY_DATASOURCE)}' />
					{/if}
					{if !empty($MAPPING_RELATED_FIELD)}
						<input type="hidden" name="mappingRelatedField" value='{Vtiger_Util_Helper::toSafeHTML($MAPPING_RELATED_FIELD)}' />
					{/if}
					<input type="hidden" name="module" value="{$MODULE}">
					<input type="hidden" name="action" value="SaveAjax">
					<div class="quickCreateContent">
						<div class="modal-body row no-margin">
							<div class="massEditTable row no-margin">
								<div class="col-xs-12 paddingLRZero fieldRow">
									{assign var=COUNTER value=0}
									{foreach key=FIELD_NAME item=FIELD_MODEL from=$RECORD_STRUCTURE name=blockfields}
										{if $COUNTER eq 2}
										</div>
										<div class="col-xs-12 paddingLRZero fieldRow">
											{assign var=COUNTER value=1}
										{else}
											{assign var=COUNTER value=$COUNTER+1}
										{/if}
										<div class="col-xs-12 col-md-6 fieldsLabelValue {$WIDTHTYPE} paddingLRZero">
											<div class="fieldLabel col-xs-12 col-sm-5">
												{assign var=HELPINFO value=explode(',',$FIELD_MODEL->get('helpinfo'))}
												{assign var=HELPINFO_LABEL value=$MODULE|cat:'|'|cat:$FIELD_MODEL->get('label')}

												<label class="muted pull-left-xs pull-right-sm pull-right-lg">
													{if $FIELD_MODEL->isMandatory() eq true} <span class="redColor">*</span>{/if}
													{if in_array($VIEW,$HELPINFO) && \App\Language::translate($HELPINFO_LABEL, 'HelpInfo') neq $HELPINFO_LABEL}
														<a href="#" class="HelpInfoPopover pull-right" title="" data-placement="auto top" data-content="{htmlspecialchars(\App\Language::translate($MODULE|cat:'|'|cat:$FIELD_MODEL->get('label'), 'HelpInfo'))}" data-original-title='{\App\Language::translate($FIELD_MODEL->get("label"), $MODULE)}'><span class="glyphicon glyphicon-info-sign"></span></a>{/if}
															{\App\Language::translate($FIELD_MODEL->get('label'), $MODULE)}
													</label>
												</div>
												<div class="fieldValue col-xs-12 col-sm-7" >
													{include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(),$MODULE)}
												</div>
											</div>
											{/foreach}
												{if $COUNTER eq 1}
													<div class="col-xs-12 col-md-6 fieldsLabelValue {$WIDTHTYPE} paddingLRZero"></div>
												{/if}
											</div>
										</div>
									</div>
								</div>
								{if !empty($SOURCE_RELATED_FIELD)}
									{foreach key=RELATED_FIELD_NAME item=RELATED_FIELD_MODEL from=$SOURCE_RELATED_FIELD}
										<input type="hidden" name="{$RELATED_FIELD_NAME}" value="{$RELATED_FIELD_MODEL->get('fieldvalue')}" data-fieldtype="{$RELATED_FIELD_MODEL->getFieldDataType()}" />
									{/foreach}
								{/if}
							</form>
						</div>
					</div>
				</div>
				{/strip}
