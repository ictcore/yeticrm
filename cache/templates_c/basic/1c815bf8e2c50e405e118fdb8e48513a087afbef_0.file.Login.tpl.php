<?php
/* Smarty version 3.1.31, created on 2017-12-07 09:16:35
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Users/Login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28c0a3560ee4_37618987',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1c815bf8e2c50e405e118fdb8e48513a087afbef' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Users/Login.tpl',
      1 => 1467785442,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28c0a3560ee4_37618987 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('_DefaultLoginTemplate', vtemplate_path('Login.Default.tpl','Users'));
$_smarty_tpl->_assignInScope('_CustomLoginTemplate', vtemplate_path('Login.Custom.tpl','Users'));
$_smarty_tpl->_assignInScope('_CustomLoginTemplateFullPath', "layouts/basic/".((string)$_smarty_tpl->tpl_vars['_CustomLoginTemplate']->value));
?>

<?php if (file_exists($_smarty_tpl->tpl_vars['_CustomLoginTemplateFullPath']->value)) {?>
	<?php $_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['_CustomLoginTemplate']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php } else { ?>
	<?php $_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['_DefaultLoginTemplate']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
}
