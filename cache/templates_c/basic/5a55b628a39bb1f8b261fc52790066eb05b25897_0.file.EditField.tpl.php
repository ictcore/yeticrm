<?php
/* Smarty version 3.1.31, created on 2017-12-07 12:48:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/LayoutEditor/EditField.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28f24d27a122_90716134',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5a55b628a39bb1f8b261fc52790066eb05b25897' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/LayoutEditor/EditField.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28f24d27a122_90716134 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-title"><?php echo App\Language::translate('LBL_EDIT_CUSTOM_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><div class="modal-body row"><div class="col-md-12"><form class="form-horizontal fieldDetailsForm sendByAjax validateForm" method="POST"><input type="hidden" name="module" value="LayoutEditor"><input type="hidden" name="parent" value="Settings"><input type="hidden" name="action" value="Field"><input type="hidden" name="mode" value="save"><input type="hidden" name="fieldid" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getId();?>
"><input type="hidden" name="sourceModule" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
"><?php $_smarty_tpl->_assignInScope('IS_MANDATORY', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory());
$_smarty_tpl->_assignInScope('FIELD_INFO', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo());
?><strong><?php echo App\Language::translate('LBL_LABEL_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
:&nbsp;</strong><?php echo App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldLabel(),$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
<br /><strong><?php echo App\Language::translate('LBL_FIELD_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
:&nbsp;</strong><?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
<hr class="marginTop10"><div class="checkbox"><input type="hidden" name="mandatory" value="O" /><label><input type="checkbox" name="mandatory" <?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value) {?> checked <?php }?> <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatoryOptionDisabled()) {?> readonly="readonly" <?php }?> value="M" />&nbsp;<?php echo App\Language::translate('LBL_MANDATORY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></div><div class="checkbox"><input type="hidden" name="presence" value="1" /><label><input type="checkbox" name="presence" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isViewable()) {?> checked <?php }?>  
							   <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isActiveOptionDisabled()) {?> readonly="readonly" class="optionDisabled"<?php }?> <?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value) {?> readonly="readonly" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('presence');?>
" />&nbsp;
						<?php echo App\Language::translate('LBL_ACTIVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

					</label>
				</div>

				<div class="checkbox">
					<input type="hidden" name="quickcreate" value="1" />
					<label>
						<input type="checkbox" name="quickcreate" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isQuickCreateEnabled()) {?> checked <?php }?> 
							   <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isQuickCreateOptionDisabled()) {?> readonly="readonly" class="optionDisabled"<?php }?> <?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value) {?> readonly="readonly" <?php }?> value="2" />&nbsp;
						<?php echo App\Language::translate('LBL_QUICK_CREATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

					</label>
				</div>
				<div class="checkbox">
					<input type="hidden" name="summaryfield" value="0"/>
					<label>
						<input type="checkbox" name="summaryfield" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isSummaryField()) {?> checked <?php }?> 
							   <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isSummaryFieldOptionDisabled()) {?> readonly="readonly" class="optionDisabled"<?php }?> value="1" />&nbsp;
						<?php echo App\Language::translate('LBL_SUMMARY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

					</label>
				</div>
				<div class="checkbox">
					<input type="hidden" name="header_field" value="0"/>
					<label>
						<input type="checkbox" name="header_field" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isHeaderField()) {?> checked <?php }?> value="btn-default" />&nbsp;
						<?php echo App\Language::translate('LBL_HEADER_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

					</label>
				</div>
				<div class="checkbox">
					<input type="hidden" name="masseditable" value="2" />
					<label>
						<input type="checkbox" name="masseditable" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMassEditable()) {?> checked <?php }?>  
							   <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMassEditOptionDisabled()) {?> readonly="readonly" <?php }?> value="1" />&nbsp;
						<?php echo App\Language::translate('LBL_MASS_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

					</label>
				</div>

				<div class="checkbox">
					<input type="hidden" name="defaultvalue" value="" />
					<label>
						<input type="checkbox" name="defaultvalue" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> checked <?php }?>  
							   <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isDefaultValueOptionDisabled()) {?> readonly="readonly" <?php }?> value="" />&nbsp;
						<?php echo App\Language::translate('LBL_DEFAULT_VALUE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

					</label>
					<div class="marginLeft20 defaultValueUi <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> zeroOpacity <?php }?>">
						<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isDefaultValueOptionDisabled() != "true") {?>
							<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType() == "picklist") {?>
								<?php $_smarty_tpl->_assignInScope('PICKLIST_VALUES', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues());
?>
								<select class="col-md-2 select2" name="fieldDefaultValue" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> disabled="" <?php }?> data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='<?php echo Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value));?>
'>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value, 'PICKLIST_VALUE', false, 'PICKLIST_NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value) {
?>
										<option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value);?>
" <?php if (decode_html($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue')) == $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value) {?> selected <?php }?>><?php echo App\Language::translate($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

								</select>
							<?php } elseif ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType() == "multipicklist") {?>
								<?php $_smarty_tpl->_assignInScope('PICKLIST_VALUES', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues());
?>
								<?php $_smarty_tpl->_assignInScope('FIELD_VALUE_LIST', explode(' |##| ',$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue')));
?>
								<select multiple class="col-md-2 select2" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> disabled="" <?php }?>  name="fieldDefaultValue" data-fieldinfo='<?php echo Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value));?>
'>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value, 'PICKLIST_VALUE');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value) {
?>
										<option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value);?>
" <?php if (in_array(Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value),$_smarty_tpl->tpl_vars['FIELD_VALUE_LIST']->value)) {?> selected <?php }?>><?php echo App\Language::translate($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

								</select>
							<?php } elseif ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType() == "boolean") {?>
								<div class="checkbox">
									<input type="hidden" name="fieldDefaultValue" value="" />
									<label>
										<input type="checkbox" name="fieldDefaultValue" value="1" 
											   <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue') == 1) {?> checked <?php }?> data-fieldinfo='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' />
									</label>
								</div>
							<?php } elseif ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType() == "time") {?>
								<div class="input-group time">
									<input type="text" class="input-sm form-control clockPicker" data-format="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('hour_format');?>
" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> disabled="" <?php }?> data-toregister="time" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" name="fieldDefaultValue" data-fieldinfo='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
'/>
									<span class="input-group-addon cursorPointer">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							<?php } elseif ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType() == "date") {?>
								<div class="input-group date">
									<?php $_smarty_tpl->_assignInScope('FIELD_NAME', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name'));
?>
									<input type="text" class="form-control dateField" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> disabled="" <?php }?> name="fieldDefaultValue" data-toregister="date" data-date-format="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('date_format');?>
" data-fieldinfo='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' 
										   value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getEditViewDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue'));?>
" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							<?php } elseif ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType() == "percentage") {?>
								<div class="input-group">
									<input type="number" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> disabled="" <?php }?>  class="form-control" name="fieldDefaultValue" 
										   value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" data-fieldinfo='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' step="any" />
									<span class="input-group-addon">%</span>
								</div>
							<?php } elseif ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType() == "currency") {?>
								<div class="input-group">
									<span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('currency_symbol');?>
</span>
									<input type="text" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> disabled="" <?php }?>  class="form-control" name="fieldDefaultValue" 
										   data-fieldinfo='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getEditViewDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue'));?>
"
										   data-decimal-separator='<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('currency_decimal_separator');?>
' data-group-separator='<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('currency_grouping_separator');?>
' />
								</div>
							<?php } elseif ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype') == 19) {?>
								<textarea class="input-medium" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> disabled="" <?php }?>  name="fieldDefaultValue" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" data-fieldinfo='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
'></textarea>
							<?php } else { ?>
								<input type="text" class="input-medium form-control" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()) {?> disabled="" <?php }?>  name="fieldDefaultValue" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" data-fieldinfo='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
'/>
							<?php }?>
						<?php }?>
					</div>
				</div>
				<?php if (in_array($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType(),array('string','phone','currency','url','integer','double'))) {?>
					<div>
						<strong><?php echo App\Language::translate('LBL_FIELD_MASK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>&nbsp;
						<div class="marginLeft20 input-group marginBottom10px">
							<input type="text" class="form-control" name="fieldMask" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldparams');?>
" />
							<span class="input-group-addon"><span class="glyphicon glyphicon-info-sign popoverTooltip" data-placement="top" data-content="<?php echo App\Language::translate('LBL_FIELD_MASK_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></span></span>
						</div>
					</div>
				<?php }?>
				<div>
					<strong><?php echo App\Language::translate('LBL_MAX_LENGTH_TEXT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
					<div class="marginLeft20">
						<input type="text" class="form-control" name="maxlengthtext" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('maxlengthtext');?>
" />&nbsp;
					</div>
				</div>
				<div>
					<strong><?php echo App\Language::translate('LBL_MAX_WIDTH_COLUMN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
					<div class="marginLeft20">
						<input type="text" class="form-control" name="maxwidthcolumn" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('maxwidthcolumn');?>
" />&nbsp;
					</div>
				</div>
				<?php if (AppConfig::developer('CHANGE_GENERATEDTYPE')) {?>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="generatedtype" value="1" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('generatedtype') == 1) {?> checked <?php }?> />&nbsp;
							<?php echo App\Language::translate('LBL_GENERATED_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

						</label>
					</div>
				<?php }?>
				<?php if (AppConfig::developer('CHANGE_VISIBILITY')) {?>
					<label class="checkbox">
						<?php echo App\Language::translate('LBL_DISPLAY_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

						<?php $_smarty_tpl->_assignInScope('DISPLAY_TYPE', Vtiger_Field_Model::showDisplayTypeList());
?>
					</label>
					<div class="marginLeft20 defaultValueUi">
						<select name="displaytype" class="form-control select2">
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['DISPLAY_TYPE']->value, 'DISPLAY_TYPE_VALUE', false, 'DISPLAY_TYPE_KEY');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['DISPLAY_TYPE_KEY']->value => $_smarty_tpl->tpl_vars['DISPLAY_TYPE_VALUE']->value) {
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['DISPLAY_TYPE_KEY']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['DISPLAY_TYPE_KEY']->value == $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('displaytype')) {?> selected <?php }?> ><?php echo App\Language::translate($_smarty_tpl->tpl_vars['DISPLAY_TYPE_VALUE']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

						</select>
					</div>
				<?php }?>
				<?php $_smarty_tpl->_subTemplateRender(vtemplate_path('ModalFooter.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

			</form>
		</div>
	</div>
<?php }
}
