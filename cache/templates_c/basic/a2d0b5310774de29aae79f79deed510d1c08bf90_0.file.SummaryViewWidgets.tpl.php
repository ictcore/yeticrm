<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/SummaryViewWidgets.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d49aa39c7_58481628',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a2d0b5310774de29aae79f79deed510d1c08bf90' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/SummaryViewWidgets.tpl',
      1 => 1467785442,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d49aa39c7_58481628 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="row"><?php $_smarty_tpl->_assignInScope('col1', count($_smarty_tpl->tpl_vars['DETAILVIEW_WIDGETS']->value[1]));
$_smarty_tpl->_assignInScope('col2', count($_smarty_tpl->tpl_vars['DETAILVIEW_WIDGETS']->value[2]));
$_smarty_tpl->_assignInScope('col3', count($_smarty_tpl->tpl_vars['DETAILVIEW_WIDGETS']->value[3]));
$_smarty_tpl->_assignInScope('span', '12');
if ($_smarty_tpl->tpl_vars['col2']->value != 0) {
$_smarty_tpl->_assignInScope('span', '6');
}
if ($_smarty_tpl->tpl_vars['col3']->value != 0) {
$_smarty_tpl->_assignInScope('span', '4');
}
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['DETAILVIEW_WIDGETS']->value, 'WIDGETCOLUMN');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['WIDGETCOLUMN']->value) {
?><div class="col-md-<?php echo $_smarty_tpl->tpl_vars['span']->value;?>
"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['WIDGETCOLUMN']->value, 'WIDGET', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['WIDGET']->value) {
$_smarty_tpl->_assignInScope('FILE', ('widgets/').($_smarty_tpl->tpl_vars['WIDGET']->value['tpl']));
$_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FILE']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div>
<?php }
}
