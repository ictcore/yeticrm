<?php
/* Smarty version 3.1.31, created on 2017-12-08 09:33:58
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewName.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1636ebb339_04422590',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6eee2b0944007dec34963816de992f825bb3f63' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewName.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1636ebb339_04422590 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if ($_smarty_tpl->tpl_vars['REFERENCE_MODULE']->value) {?><div class="rowName"><?php ob_start();
echo $_smarty_tpl->tpl_vars['FIELD']->value->getColumnName();
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('FIELD_NAME', ($_prefixVariable1).($_smarty_tpl->tpl_vars['ROW_NO']->value));
$_smarty_tpl->_assignInScope('FIELD_INFO', Vtiger_Util_Helper::toSafeHTML(\App\Json::encode(array('mandatory'=>true))));
$_smarty_tpl->_assignInScope('CRMEntity', CRMEntity::getInstance($_smarty_tpl->tpl_vars['REFERENCE_MODULE']->value));
?><div class="input-group"><input name="popupReferenceModule" type="hidden" data-multi-reference="1" data-field="<?php echo $_smarty_tpl->tpl_vars['CRMEntity']->value->table_index;?>
" value="<?php echo $_smarty_tpl->tpl_vars['REFERENCE_MODULE']->value;?>
" /><input name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['ITEM_VALUE']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['ITEM_VALUE']->value;?>
" class="sourceField" data-type="inventory" data-displayvalue='<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getEditValue($_smarty_tpl->tpl_vars['ITEM_VALUE']->value);?>
' data-fieldinfo='<?php echo $_smarty_tpl->tpl_vars['FIELD_INFO']->value;?>
' data-columnname="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getColumnName();?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD']->value->get('displaytype') == 10) {?>readonly="readonly"<?php }?> /><?php $_smarty_tpl->_assignInScope('displayId', $_smarty_tpl->tpl_vars['ITEM_VALUE']->value);
if ($_smarty_tpl->tpl_vars['FIELD']->value->get('displaytype') != 10) {?><span class="input-group-addon clearReferenceSelection cursorPointer"><span id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_clear" class="glyphicon glyphicon-remove-sign" title="<?php echo \App\Language::translate('LBL_CLEAR',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></span></span><?php }?><input id="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_display" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_display" type="text" title="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getEditValue($_smarty_tpl->tpl_vars['ITEM_VALUE']->value);?>
" class="marginLeftZero input-sm form-control autoComplete recordLabel" <?php if (!empty($_smarty_tpl->tpl_vars['ITEM_VALUE']->value)) {?>readonly="true"<?php }?>value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['FIELD']->value->getEditValue($_smarty_tpl->tpl_vars['ITEM_VALUE']->value));?>
" data-validation-engine="validate[<?php if (!$_smarty_tpl->tpl_vars['IS_OPTIONAL_ITEMS']->value && $_smarty_tpl->tpl_vars['FIELD']->value->isMandatory()) {?> required,<?php }?>funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"data-fieldinfo="<?php echo $_smarty_tpl->tpl_vars['FIELD_INFO']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD']->value->get('displaytype') != 10) {?>placeholder="<?php echo \App\Language::translate('LBL_TYPE_SEARCH',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"<?php }
if ($_smarty_tpl->tpl_vars['FIELD']->value->get('displaytype') == 10) {?>readonly="readonly"<?php }?>/><?php if ($_smarty_tpl->tpl_vars['FIELD']->value->get('displaytype') != 10) {?><span class="input-group-addon relatedPopup cursorPointer"><span id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_select" class="glyphicon glyphicon-search relatedPopup" title="<?php echo \App\Language::translate('LBL_SELECT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" ></span></span><?php }
$_smarty_tpl->_assignInScope('REFERENCE_MODULE_MODEL', Vtiger_Module_Model::getInstance($_smarty_tpl->tpl_vars['REFERENCE_MODULE']->value));
if ($_smarty_tpl->tpl_vars['REFERENCE_MODULE_MODEL']->value->isQuickCreateSupported() && $_smarty_tpl->tpl_vars['FIELD']->value->get('displaytype') != 10) {?><span class="input-group-addon cursorPointer createReferenceRecord"><span id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_create" class="glyphicon glyphicon-plus" title="<?php echo \App\Language::translate('LBL_CREATE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></span></span><?php }?></div><div class="subProductsContainer"><ul class="pull-left"></ul></div></div><?php }
}
}
