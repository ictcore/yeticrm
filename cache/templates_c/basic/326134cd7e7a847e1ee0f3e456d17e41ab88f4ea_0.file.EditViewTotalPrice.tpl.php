<?php
/* Smarty version 3.1.31, created on 2017-12-08 09:33:59
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewTotalPrice.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a16370213c3_39844420',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '326134cd7e7a847e1ee0f3e456d17e41ab88f4ea' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewTotalPrice.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a16370213c3_39844420 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('VALUE', $_smarty_tpl->tpl_vars['FIELD']->value->getValue($_smarty_tpl->tpl_vars['ITEM_VALUE']->value));
?><input name="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getColumnName();
echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getEditValue($_smarty_tpl->tpl_vars['VALUE']->value);?>
" class="totalPrice" <?php if ($_smarty_tpl->tpl_vars['FIELD']->value->get('displaytype') == 10) {?>readonly="readonly"<?php }?> /><span class="totalPriceText"><?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getEditValue($_smarty_tpl->tpl_vars['VALUE']->value);?>
</span>
<?php }
}
