<?php
/* Smarty version 3.1.31, created on 2017-12-07 09:36:55
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/ModalFooter.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28c567cdf167_92624858',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5b2d944e6aaa48d65cb4851d36fe3888bd1452de' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/ModalFooter.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28c567cdf167_92624858 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="modal-footer"><button class="btn btn-success" type="submit" name="saveButton"><span class="glyphicon glyphicon-ok"></span>&nbsp;<strong><?php echo \App\Language::translate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><button class="btn btn-warning" type="reset" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;<strong><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></div>
<?php }
}
