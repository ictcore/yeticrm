<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:08:54
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/JSResources.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a27978616ce97_03125013',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e22d0604649870bc34852aba8a307dcf870f3ba1' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/JSResources.tpl',
      1 => 1502282096,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a27978616ce97_03125013 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['FOOTER_SCRIPTS']->value, 'jsModel', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['jsModel']->value) {
echo '<script'; ?>
 type="<?php echo $_smarty_tpl->tpl_vars['jsModel']->value->getType();?>
" src="../<?php echo $_smarty_tpl->tpl_vars['jsModel']->value->getSrc();?>
"><?php echo '</script'; ?>
><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div>
<?php }
}
