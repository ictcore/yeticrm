<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/DetailViewPreProcess.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d49736a86_68000222',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6acb71259390b268e1393b1c3f2d1bbc9ce55874' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/DetailViewPreProcess.tpl',
      1 => 1472181892,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d49736a86_68000222 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(vtemplate_path("Header.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
<div class="bodyContents"><div class="mainContainer"><div class="contentsDiv"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path("DetailViewHeader.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
