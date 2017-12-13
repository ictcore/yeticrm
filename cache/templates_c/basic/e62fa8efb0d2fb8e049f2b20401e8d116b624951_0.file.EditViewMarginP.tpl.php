<?php
/* Smarty version 3.1.31, created on 2017-12-08 09:33:59
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewMarginP.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a16370369b7_26992659',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e62fa8efb0d2fb8e049f2b20401e8d116b624951' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewMarginP.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a16370369b7_26992659 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('VALUE', $_smarty_tpl->tpl_vars['FIELD']->value->getValue($_smarty_tpl->tpl_vars['ITEM_VALUE']->value));
?><div class="input-group input-group-sm"><input name="marginp<?php echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getEditValue($_smarty_tpl->tpl_vars['VALUE']->value);?>
" type="text" class="marginp form-control input-sm" readonly="readonly"/><span class="input-group-addon cursorPointer">%</span></div>
<?php }
}
