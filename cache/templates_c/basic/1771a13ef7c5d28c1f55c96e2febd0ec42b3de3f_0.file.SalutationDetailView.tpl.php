<?php
/* Smarty version 3.1.31, created on 2017-12-08 10:57:55
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/SalutationDetailView.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a29e32a4219_65097018',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1771a13ef7c5d28c1f55c96e2febd0ec42b3de3f' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/SalutationDetailView.tpl',
      1 => 1485289192,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a29e32a4219_65097018 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('salutationtype');?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'),$_smarty_tpl->tpl_vars['RECORD']->value->getId(),$_smarty_tpl->tpl_vars['RECORD']->value);?>

<?php }
}
