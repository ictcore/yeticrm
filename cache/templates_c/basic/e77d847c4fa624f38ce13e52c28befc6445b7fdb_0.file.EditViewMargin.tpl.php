<?php
/* Smarty version 3.1.31, created on 2017-12-08 09:33:59
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewMargin.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a163703f3d1_89410222',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e77d847c4fa624f38ce13e52c28befc6445b7fdb' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewMargin.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a163703f3d1_89410222 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('VALUE', $_smarty_tpl->tpl_vars['FIELD']->value->getValue($_smarty_tpl->tpl_vars['ITEM_VALUE']->value));
?><input name="margin<?php echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getEditValue($_smarty_tpl->tpl_vars['VALUE']->value);?>
" type="text" class="margin form-control input-sm" readonly="readonly"/>
<?php }
}
