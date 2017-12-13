<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:30:40
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/EditViewActions.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279ca0678007_14836260',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bda50627637a267f59bb36e04c20301f2c560e1c' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/EditViewActions.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279ca0678007_14836260 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div><div class="pull-right"><button class="btn btn-success" type="submit"><strong><?php echo \App\Language::translate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>&nbsp;&nbsp;<button class="btn btn-warning" type="reset" onclick="javascript:window.history.back();"><strong><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></div><div class="clearfix"></div></div><br /></form></div>
<?php }
}
