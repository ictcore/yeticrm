<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:26:37
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/Body.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279bad855db7_05842030',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '82e7b6c56e47b6d553734011c11de841f91b8806' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/Body.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279bad855db7_05842030 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="container-fluid container-fluid-main"><div class="baseContainer <?php if (AppConfig::module('Users','IS_VISIBLE_USER_INFO_FOOTER')) {?>userInfoFooter<?php }?>"><?php $_smarty_tpl->_assignInScope('LEFTPANELHIDE', $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('leftpanelhide'));
$_smarty_tpl->_subTemplateRender(vtemplate_path('BodyHeaderMobile.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
<div class="mobileLeftPanel noSpaces"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BodyLeft.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('DEVICE'=>'Mobile'), 0, true);
?>
</div><div class="leftPanel noSpaces"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BodyLeft.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('DEVICE'=>'Desktop'), 0, true);
?>
</div><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BodyHeader.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
<div class="basePanel noSpaces <?php if ($_smarty_tpl->tpl_vars['LEFTPANELHIDE']->value) {?> menuOpen<?php }?> <?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['VIEW']->value;?>
"><div class="mainBody <?php if (AppConfig::module('Users','IS_VISIBLE_USER_INFO_FOOTER')) {?>userInfoFooter<?php }?>"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BodyContent.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
