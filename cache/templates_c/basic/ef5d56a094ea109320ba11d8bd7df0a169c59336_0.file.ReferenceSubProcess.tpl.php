<?php
/* Smarty version 3.1.31, created on 2017-12-07 09:42:11
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/ReferenceSubProcess.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28c6a3c0e400_71245518',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ef5d56a094ea109320ba11d8bd7df0a169c59336' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/ReferenceSubProcess.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28c6a3c0e400_71245518 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('FIELD_NAME', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name'));
$_smarty_tpl->_assignInScope('REFERENCE_LIST', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getReferenceList());
$_smarty_tpl->_assignInScope('REFERENCE_LIST_COUNT', count($_smarty_tpl->tpl_vars['REFERENCE_LIST']->value));
$_smarty_tpl->_assignInScope('FIELD_INFO', Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo())));
$_smarty_tpl->_assignInScope('SPECIAL_VALIDATOR', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator());
$_smarty_tpl->_assignInScope('UITYPE_MODEL', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel());
ob_start();
echo $_smarty_tpl->tpl_vars['REFERENCE_LIST_COUNT']->value;
$_prefixVariable3=ob_get_clean();
if ($_prefixVariable3 == 1) {?><input name="popupReferenceModule" type="hidden" data-multi-reference="0" title="<?php echo reset($_smarty_tpl->tpl_vars['REFERENCE_LIST']->value);?>
" value="<?php echo reset($_smarty_tpl->tpl_vars['REFERENCE_LIST']->value);?>
" /><?php }
$_smarty_tpl->_assignInScope('DISPLAYID', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'));
ob_start();
echo $_smarty_tpl->tpl_vars['REFERENCE_LIST_COUNT']->value;
$_prefixVariable4=ob_get_clean();
if ($_prefixVariable4 > 1) {
$_smarty_tpl->_assignInScope('REFERENCED_MODULE_STRUCT', $_smarty_tpl->tpl_vars['UITYPE_MODEL']->value->getReferenceModule($_smarty_tpl->tpl_vars['DISPLAYID']->value));
if (!empty($_smarty_tpl->tpl_vars['REFERENCED_MODULE_STRUCT']->value)) {
$_smarty_tpl->_assignInScope('REFERENCED_MODULE_NAME', $_smarty_tpl->tpl_vars['REFERENCED_MODULE_STRUCT']->value->get('name'));
} else {
$_smarty_tpl->_assignInScope('REFERENCED_MODULE_NAME', '');
}
if (in_array($_smarty_tpl->tpl_vars['REFERENCED_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['REFERENCE_LIST']->value)) {?><input name="popupReferenceModule" type="hidden" data-multi-reference="1" value="<?php echo $_smarty_tpl->tpl_vars['REFERENCED_MODULE_NAME']->value;?>
" /><?php } else { ?><input name="popupReferenceModule" type="hidden" data-multi-reference="1" value="<?php echo $_smarty_tpl->tpl_vars['REFERENCE_LIST']->value[0];?>
" /><?php }
}
$_smarty_tpl->_assignInScope('REFERENCE_MODULE_MODEL', Vtiger_Module_Model::getInstance($_smarty_tpl->tpl_vars['REFERENCE_LIST']->value[0]));
?><input name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue');?>
" title="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue');?>
" class="sourceField" data-type="entity" data-fieldtype="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType();?>
" data-displayvalue="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getEditViewDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'));?>
" data-fieldinfo='<?php echo $_smarty_tpl->tpl_vars['FIELD_INFO']->value;?>
' <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditableReadOnly()) {?>readonly="readonly"<?php }?> /><div class="input-group referenceGroup"><?php if ($_smarty_tpl->tpl_vars['REFERENCE_LIST_COUNT']->value > 1) {?><div class="input-group-addon noSpaces referenceModulesListGroup"><select id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName();?>
_dropDown" class="referenceModulesList" title="<?php echo \App\Language::translate('LBL_RELATED_MODULE_TYPE');?>
" required="required"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['REFERENCE_LIST']->value, 'REFERENCE', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['REFERENCE']->value) {
$_smarty_tpl->_assignInScope('REFERENCE_MODULE_MODEL', Vtiger_Module_Model::getInstance($_smarty_tpl->tpl_vars['REFERENCE']->value));
?><option value="<?php echo $_smarty_tpl->tpl_vars['REFERENCE']->value;?>
" title="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['REFERENCE']->value,$_smarty_tpl->tpl_vars['REFERENCE']->value);?>
" data-is-quickcreate="<?php echo $_smarty_tpl->tpl_vars['REFERENCE_MODULE_MODEL']->value->isQuickCreateSupported();?>
" data-parent="<?php echo $_smarty_tpl->tpl_vars['UITYPE_MODEL']->value->getParentModule($_smarty_tpl->tpl_vars['REFERENCE']->value);?>
" <?php if ($_smarty_tpl->tpl_vars['REFERENCE']->value == $_smarty_tpl->tpl_vars['REFERENCED_MODULE_NAME']->value) {?> selected <?php }?>><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['REFERENCE']->value,$_smarty_tpl->tpl_vars['REFERENCE']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div><?php }?><input id="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_display" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
_display" type="text" title="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getEditViewDisplayValue($_smarty_tpl->tpl_vars['DISPLAYID']->value));?>
" class="marginLeftZero form-control autoComplete" <?php if (!empty($_smarty_tpl->tpl_vars['DISPLAYID']->value)) {?>readonly="true"<?php }?>value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getEditViewDisplayValue($_smarty_tpl->tpl_vars['DISPLAYID']->value));?>
" data-validation-engine="validate[<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory() == true) {?> required,<?php }?>funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"data-fieldinfo='<?php echo $_smarty_tpl->tpl_vars['FIELD_INFO']->value;?>
' <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('displaytype') != 10) {?>placeholder="<?php echo \App\Language::translate('LBL_TYPE_SEARCH',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"<?php }?> <?php if ($_smarty_tpl->tpl_vars['REFERENCE_MODULE_MODEL']->value == false) {?>disabled<?php }
if (!empty($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value)) {?>data-validator='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value);?>
'<?php }?> <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditableReadOnly()) {?>readonly="readonly"<?php }?>/><span class="input-group-btn cursorPointer"><button class="btn btn-default clearReferenceSelection" type="button" <?php if ($_smarty_tpl->tpl_vars['REFERENCE_MODULE_MODEL']->value == false || $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditableReadOnly()) {?>disabled<?php }?>><span id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_clear" class="glyphicon glyphicon-remove-sign" title="<?php echo \App\Language::translate('LBL_CLEAR',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></span></button><button class="btn btn-default relatedPopup" type="button" <?php if ($_smarty_tpl->tpl_vars['REFERENCE_MODULE_MODEL']->value == false || $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditableReadOnly()) {?>disabled<?php }?>><span id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_select" class="glyphicon glyphicon-search" title="<?php echo \App\Language::translate('LBL_SELECT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" ></span></button><!-- Show the add button only if it is edit view  --><?php if ((($_smarty_tpl->tpl_vars['VIEW']->value == 'Edit')) && $_smarty_tpl->tpl_vars['REFERENCE_MODULE_MODEL']->value && $_smarty_tpl->tpl_vars['REFERENCE_MODULE_MODEL']->value->isQuickCreateSupported()) {?><button class="btn btn-default createReferenceRecord" type="button" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditableReadOnly()) {?>disabled<?php }?>><span id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_create" class="glyphicon glyphicon-plus" title="<?php echo \App\Language::translate('LBL_CREATE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></span></button><?php }?></span></div>
<?php }
}
