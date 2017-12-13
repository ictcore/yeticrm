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
    <div id="layoutEditorContainer">
        <input id="selectedModuleName" type="hidden" value="{$SELECTED_MODULE_NAME}" />
        <div class="widget_header row">
			<div class="col-md-6">
				{include file='BreadCrumbs.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
				{if isset($SELECTED_PAGE)}
					{App\Language::translate($SELECTED_PAGE->get('description'),$QUALIFIED_MODULE)}
				{/if}
			</div>
			<div class="pull-right col-md-6 form-inline">
				<div class="form-group pull-right col-md-6">
					<select class="select2 form-control" name="layoutEditorModules">
						{foreach item=MODULE_NAME from=$SUPPORTED_MODULES}
							<option value="{$MODULE_NAME}" {if $MODULE_NAME eq $SELECTED_MODULE_NAME} selected {/if}>{App\Language::translate($MODULE_NAME, $MODULE_NAME)}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group pull-right">
					<input id="inventorySwitch" title="{App\Language::translate('LBL_CHANGE_BLOCK_ADVANCED', $QUALIFIED_MODULE)}" class="switchBtn" type="checkbox" data-label-width="5" data-handle-width="100" data-on-text="{App\Language::translate('LBL_BASIC_MODULE',$QUALIFIED_MODULE)}" data-off-text="{App\Language::translate('LBL_ADVANCED_MODULE',$QUALIFIED_MODULE)}" {if !$IS_INVENTORY}checked{/if} >
				</div>
			</div>
        </div>
        <hr>
        <div class="contents tabbable">
            <ul class="nav nav-tabs layoutTabs massEditTabs">
                <li class="active"><a data-toggle="tab" href="#detailViewLayout"><strong>{App\Language::translate('LBL_DETAILVIEW_LAYOUT', $QUALIFIED_MODULE)}</strong></a></li>
				{if $IS_INVENTORY}
					<li class="inventoryNav"><a data-toggle="tab" href="#inventoryViewLayout"><strong>{App\Language::translate('LBL_MANAGING_AN_ADVANCED_BLOCK', $QUALIFIED_MODULE)}</strong></a></li>
				{/if}
            </ul>
            <div class="tab-content layoutContent padding20 themeTableColor overflowVisible">
                <div class="tab-pane active" id="detailViewLayout">
                    {assign var=FIELD_TYPE_INFO value=$SELECTED_MODULE_MODEL->getAddFieldTypeInfo()}
                    {assign var=IS_SORTABLE value=$SELECTED_MODULE_MODEL->isSortableAllowed()}
                    {assign var=IS_BLOCK_SORTABLE value=$SELECTED_MODULE_MODEL->isBlockSortableAllowed()}
                    {assign var=ALL_BLOCK_LABELS value=[]}
                    {if $IS_SORTABLE}
                        <div class="btn-toolbar" id="layoutEditorButtons">
                            <button class="btn btn-success addButton addCustomBlock" type="button">
                                <span class="glyphicon glyphicon-plus"></span>&nbsp;
                                <strong>{App\Language::translate('LBL_ADD_CUSTOM_BLOCK', $QUALIFIED_MODULE)}</strong>
                            </button>
                            <span class="pull-right">
                                <button class="btn btn-success saveFieldSequence hide" type="button">
                                    <strong>{App\Language::translate('LBL_SAVE_FIELD_SEQUENCE', $QUALIFIED_MODULE)}</strong>
                                </button>
                            </span>
                        </div>
                    {/if}
                    <div class="moduleBlocks">
                        {foreach key=BLOCK_LABEL_KEY item=BLOCK_MODEL from=$BLOCKS}
                            {assign var=FIELDS_LIST value=$BLOCK_MODEL->getLayoutBlockActiveFields()}
                            {assign var=BLOCK_ID value=$BLOCK_MODEL->get('id')}
                            {$ALL_BLOCK_LABELS[$BLOCK_ID] = $BLOCK_LABEL_KEY}
                            <div id="block_{$BLOCK_ID}" class="editFieldsTable block_{$BLOCK_ID} marginBottom10px border1px {if $IS_BLOCK_SORTABLE} blockSortable{/if}" data-block-id="{$BLOCK_ID}" data-sequence="{$BLOCK_MODEL->get('sequence')}" style="border-radius: 4px;background: white;">
                                <div class="row layoutBlockHeader no-margin">
                                    <div class="blockLabel col-md-6 col-sm-6 padding10 marginLeftZero">
                                        {if $IS_BLOCK_SORTABLE}
											<img class="alignMiddle" src="{vimage_path('drag.png')}" alt=""/>&nbsp;&nbsp;
										{/if}
                                        <strong>{App\Language::translate($BLOCK_LABEL_KEY, $SELECTED_MODULE_NAME)}</strong>
                                    </div>
                                    <div class="col-md-6 col-sm-6 marginLeftZero">
										<div class="pull-right btn-toolbar blockActions" style="margin: 4px;">
                                            {if $BLOCK_MODEL->isAddCustomFieldEnabled()}
                                                <div class="btn-group">
                                                    <button class="btn btn-success addCustomField" type="button">
                                                        <strong>{App\Language::translate('LBL_ADD_CUSTOM_FIELD', $QUALIFIED_MODULE)}</strong>
                                                    </button>
                                                </div>
                                            {/if}
                                            {if $BLOCK_MODEL->isActionsAllowed()}
                                                <div class="btn-group"><button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                                        <strong>{App\Language::translate('LBL_ACTIONS', $QUALIFIED_MODULE)}</strong>&nbsp;&nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li class="blockVisibility" data-visible="{if !$BLOCK_MODEL->isHidden()}1{else}0{/if}" data-block-id="{$BLOCK_MODEL->get('id')}">
                                                            <a href="javascript:void(0)">
                                                                <span class="glyphicon glyphicon-ok {if $BLOCK_MODEL->isHidden()} hide {/if}"></span>&nbsp;
                                                                {App\Language::translate('LBL_ALWAYS_SHOW', $QUALIFIED_MODULE)}
                                                            </a>
                                                        </li>
                                                        <li class="inActiveFields">
                                                            <a href="javascript:void(0)">{App\Language::translate('LBL_INACTIVE_FIELDS', $QUALIFIED_MODULE)}</a>
                                                        </li>
                                                        {if $BLOCK_MODEL->isCustomized()}
                                                            <li class="deleteCustomBlock">
                                                                <a href="javascript:void(0)">{App\Language::translate('LBL_DELETE_CUSTOM_BLOCK', $QUALIFIED_MODULE)}</a>
                                                            </li>
                                                        {/if}
                                                    </ul>
                                                </div>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                                <div class="blockFieldsList blockFieldsSortable row no-margin" style="padding:5px;min-height: 27px">
                                    <ul name="{if $SELECTED_MODULE_MODEL->isFieldsSortableAllowed($BLOCK_LABEL_KEY)}sortable1{/if}" class="sortTableUl connectedSortable col-md-6">
                                        {foreach item=FIELD_MODEL from=$FIELDS_LIST name=fieldlist}
                                            {if $smarty.foreach.fieldlist.index % 2 eq 0}
                                                <li>
                                                    <div class="opacity editFields marginLeftZero border1px" data-block-id="{$BLOCK_ID}" data-field-id="{$FIELD_MODEL->get('id')}" data-sequence="{$FIELD_MODEL->get('sequence')}">
                                                        <div class="row padding1per">
                                                            {assign var=IS_MANDATORY value=$FIELD_MODEL->isMandatory()}
                                                            <div class="col-xs-2 col-sm-2">&nbsp;
                                                                {if $FIELD_MODEL->isEditable()}
                                                                    <a>
                                                                        <img src="{vimage_path('drag.png')}" border="0" alt="{App\Language::translate('LBL_DRAG',$QUALIFIED_MODULE)}"/>
                                                                    </a>
                                                                {/if}
                                                            </div>
                                                            <div class="col-xs-10 col-sm-10 marginLeftZero fieldContainer" style="word-wrap: break-word;">
                                                                <span class="fieldLabel">{App\Language::translate($FIELD_MODEL->get('label'), $SELECTED_MODULE_NAME)}&nbsp;[{$FIELD_MODEL->get('name')}]
																	{if $IS_MANDATORY}
																		<span class="redColor">*</span>
																	{/if}
																</span>
																<span class="pull-right actions">
																	<input type="hidden" value="{$FIELD_MODEL->get('name')}" id="relatedFieldValue{$FIELD_MODEL->get('id')}" />
																	<button class="btn btn-primary btn-xs copyFieldLabel pull-right marginLeft5" data-target="relatedFieldValue{$FIELD_MODEL->get('id')}">
																		<span class="glyphicon glyphicon-copy" title="{App\Language::translate('LBL_COPY', $QUALIFIED_MODULE)}"></span>
																	</button>
																	{if $FIELD_MODEL->isEditable()}
																		<button class="btn btn-success btn-xs editFieldDetails marginLeft5">
																			<span class="glyphicon glyphicon-pencil" title="{App\Language::translate('LBL_EDIT', $QUALIFIED_MODULE)}"></span>
																		</button>
																	{/if}
																	{if $FIELD_MODEL->isCustomField() eq 'true'}
																		<button class="btn btn-danger btn-xs deleteCustomField marginLeft5" data-field-id="{$FIELD_MODEL->get('id')}">
																			<span class="glyphicon glyphicon-trash" title="{App\Language::translate('LBL_DELETE', $QUALIFIED_MODULE)}"></span>
																		</button>
																	{/if}
																</span>
															</div>
														</div>
													</div>
												</li>
											{/if}
										{/foreach}
									</ul>
									<ul {if $SELECTED_MODULE_MODEL->isFieldsSortableAllowed($BLOCK_LABEL_KEY)}name="sortable2"{/if} class="connectedSortable sortTableUl col-md-6">
										{foreach item=FIELD_MODEL from=$FIELDS_LIST name=fieldlist1}
											{if $smarty.foreach.fieldlist1.index % 2 neq 0}
												<li>
													<div class="opacity editFields marginLeftZero border1px" data-block-id="{$BLOCK_ID}" data-field-id="{$FIELD_MODEL->get('id')}" data-sequence="{$FIELD_MODEL->get('sequence')}">
														<div class="row padding1per">
															{assign var=IS_MANDATORY value=$FIELD_MODEL->isMandatory()}
															<div class="col-xs-2 col-sm-2">&nbsp;
																{if $FIELD_MODEL->isEditable()}
																	<a>
																		<img src="{vimage_path('drag.png')}" border="0" alt="{App\Language::translate('LBL_DRAG',$QUALIFIED_MODULE)}"/>
																	</a>
																{/if}
															</div>
															<div class="col-xs-10 col-sm-10 marginLeftZero fieldContainer" style="word-wrap: break-word;">
																<span class="fieldLabel">{App\Language::translate($FIELD_MODEL->get('label'), $SELECTED_MODULE_NAME)}&nbsp;[{$FIELD_MODEL->get('name')}]
																	{if $IS_MANDATORY}
																		<span class="redColor">*</span>
																	{/if}
																</span>
																<span class="pull-right actions">
																	<button class="btn btn-primary btn-xs copyFieldLabel pull-right marginLeft5" data-target="relatedFieldValue{$FIELD_MODEL->get('id')}">
																		<span class="glyphicon glyphicon-copy" title="{App\Language::translate('LBL_COPY', $QUALIFIED_MODULE)}"></span>
																	</button>
																	<input type="hidden" value="{$FIELD_MODEL->get('name')}" id="relatedFieldValue{$FIELD_MODEL->get('id')}" />
																	{if $FIELD_MODEL->isEditable()}
																		<button class="btn btn-success btn-xs editFieldDetails marginLeft5">
																			<span class="glyphicon glyphicon-pencil" title="{App\Language::translate('LBL_EDIT', $QUALIFIED_MODULE)}"></span>
																		</button>
																	{/if}
																	{if $FIELD_MODEL->isCustomField() eq 'true'}
																		<button class="btn btn-danger btn-xs deleteCustomField marginLeft5" data-field-id="{$FIELD_MODEL->get('id')}">
																			<span class="glyphicon glyphicon-trash" title="{App\Language::translate('LBL_DELETE', $QUALIFIED_MODULE)}"></span>
																		</button>
																	{/if}
																</span>
															</div>
														</div>
													</div>
												</li>
											{/if}
										{/foreach}
									</ul>
								</div>
							</div>
						{/foreach}
					</div>
					<input type="hidden" class="inActiveFieldsArray" value='{\App\Json::encode($IN_ACTIVE_FIELDS)}' />
					{include file='NewCustomBlock.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
					{include file='NewCustomField.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
					{include file='AddBlockModal.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
					{include file='CreateFieldModal.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
					{include file='InactiveFieldModal.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
				</div>
				{if $IS_INVENTORY}
					<div class="tab-pane" id="inventoryViewLayout">
						{include file='Inventory.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
					</div>	
				{/if}
			</div>
		</div>
	</div>
{/strip}
