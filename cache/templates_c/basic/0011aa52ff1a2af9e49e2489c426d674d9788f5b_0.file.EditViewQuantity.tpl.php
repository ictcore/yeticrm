<?php
/* Smarty version 3.1.31, created on 2017-12-08 09:33:58
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewQuantity.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1636f36bb2_49293865',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0011aa52ff1a2af9e49e2489c426d674d9788f5b' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewQuantity.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1636f36bb2_49293865 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('VALUE', $_smarty_tpl->tpl_vars['FIELD']->value->getValue($_smarty_tpl->tpl_vars['ITEM_VALUE']->value));
if ($_smarty_tpl->tpl_vars['ITEM_DATA']->value['unit'] === 'pack' || $_smarty_tpl->tpl_vars['ITEM_DATA']->value['unit'] === 'pcs') {
$_smarty_tpl->_assignInScope('VALIDATION_ENGINE', 'validate[required,funcCall[Vtiger_WholeNumber_Validator_Js.invokeValidation]]');
} else {
$_smarty_tpl->_assignInScope('VALIDATION_ENGINE', 'validate[required,funcCall[Vtiger_NumberUserFormat_Validator_Js.invokeValidation]]');
}?><div class="input-group input-group-sm"><input name="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getColumnName();
echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" type="text" class="qty smallInputBox form-control input-sm" data-validation-engine="<?php echo $_smarty_tpl->tpl_vars['VALIDATION_ENGINE']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getEditValue($_smarty_tpl->tpl_vars['VALUE']->value);?>
" title="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getEditValue($_smarty_tpl->tpl_vars['VALUE']->value);?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD']->value->get('displaytype') == 10) {?>readonly="readonly"<?php }?>/><span class="input-group-btn"><button class="btn btn-default qtyparamButton<?php if ($_smarty_tpl->tpl_vars['ITEM_DATA']->value['qtyparam']) {?> active<?php }
if ($_smarty_tpl->tpl_vars['ITEM_DATA']->value['unit'] !== 'pack') {?> hidden<?php }?>" data-rownum="<?php echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" type="button"><?php echo \App\Language::translate('pcs','Products');?>
</button></span></div><input type="checkbox" name="qtyparam<?php echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" value="1" class="qtyparam hidden" <?php if ($_smarty_tpl->tpl_vars['ITEM_DATA']->value['qtyparam']) {?> checked<?php }?> />
<?php }
}
