<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:20:43
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/InstallPreProcess.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279a4bb76b42_79654866',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '92eef8b77edf5c2f3b7b1e21fbfcbe3b35ec0d26' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/InstallPreProcess.tpl',
      1 => 1502282096,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:Header.tpl' => 1,
  ),
),false)) {
function content_5a279a4bb76b42_79654866 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_subTemplateRender('file:Header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<div class="container page-container"><div class="row"><div class="col-md-6"><div class="logo"><img src="../<?php echo \App\Layout::getPublicUrl('layouts/resources/Logo/logo_yetiforce.png');?>
" style="height: 70px;" /></div></div><div class="col-md-6"><div class="head pull-right"><h3><?php echo \App\Language::translate('LBL_INSTALLATION_WIZARD','Install');?>
</h3></div></div></div><?php if ($_smarty_tpl->tpl_vars['MODE']->value === 'Step7') {?><div id="progressIndicator" class="row main-container"><div class="inner-container"><div class="inner-container"><div class="row"><div class="span12 welcome-div alignCenter"><h3><?php echo \App\Language::translate('LBL_INSTALLATION_IN_PROGRESS','Install');?>
...</h3><br /><img src="../<?php echo \App\Layout::getPublicUrl('layouts/basic/skins/images/install_loading.gif');?>
" alt="Install loading"/><h6><?php echo \App\Language::translate('LBL_PLEASE_WAIT','Install');?>
.... </h6></div></div></div></div></div><?php }
}
}
