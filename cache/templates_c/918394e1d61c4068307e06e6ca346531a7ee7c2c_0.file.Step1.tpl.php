<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:08:54
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step1.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279786152258_31291406',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '918394e1d61c4068307e06e6ca346531a7ee7c2c' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step1.tpl',
      1 => 1502282094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279786152258_31291406 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="row main-container"><div class="inner-container"><form class="form-horizontal" name="step1" method="post" action="Install.php"><div class="row"><div class="col-md-9"><h4><?php echo \App\Language::translate('LBL_WELCOME','Install');?>
</h4></div><div class="col-md-3"><select name="lang" class="chzn-select" style="width: 250px;"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LANGUAGES']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['LANG']->value == $_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div><hr><div class="pull-right"><a class="helpBtn" href="https://yetiforce.com/en/implementer/installation-updates.html" target="_blank"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a></div><input type="hidden" name="mode" value="Step2" /><div class="col-md-4 welcome-image"><img src="../<?php echo \App\Layout::getPublicUrl('layouts/resources/Logo/logo_yetiforce.png');?>
" alt="Yetiforce Logo"/></div><div class="col-md-8"><div class="welcome-div"><h3><?php echo \App\Language::translate('LBL_WELCOME_TO_VTIGER6_SETUP_WIZARD','Install');?>
</h3><p><?php echo \App\Language::translate('LBL_VTIGER6_SETUP_WIZARD_DESCRIPTION','Install');?>
</p></div></div><div class="row"><div class="button-container"><a href="#" class="btn btn-sm btn-primary bt_install"><?php echo \App\Language::translate('LBL_INSTALL_BUTTON','Install');?>
</a><?php if ($_smarty_tpl->tpl_vars['IS_MIGRATE']->value) {?><a style="" href="#" class="btn btn-sm btn-primary bt_migrate"><?php echo \App\Language::translate('LBL_MIGRATION','Install');?>
</a><?php }?></div></div></form></div></div>
<?php }
}
