<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:26:38
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/BreadCrumbs.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279bae01e5b3_99261178',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '03d15d5a929368378671f51f68081714f8f027e3' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/BreadCrumbs.tpl',
      1 => 1502273912,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279bae01e5b3_99261178 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (AppConfig::main('breadcrumbs') == 'true') {?><div class="breadCrumbs" ><?php if (isset($_smarty_tpl->tpl_vars['BREADCRUMB_TITLE']->value)) {
$_smarty_tpl->_assignInScope('BREADCRUMBS', Vtiger_Menu_Model::getBreadcrumbs($_smarty_tpl->tpl_vars['BREADCRUMB_TITLE']->value));
} else {
$_smarty_tpl->_assignInScope('BREADCRUMBS', Vtiger_Menu_Model::getBreadcrumbs());
}
$_smarty_tpl->_assignInScope('HOMEICON', 'userIcon-Home');
if ($_smarty_tpl->tpl_vars['BREADCRUMBS']->value) {?><div class="breadcrumbsContainer"><h2 class="breadcrumbsLinks textOverflowEllipsis"><a href="<?php echo AppConfig::main('site_URL');?>
"><span class="<?php echo $_smarty_tpl->tpl_vars['HOMEICON']->value;?>
"></span></a>&nbsp;|&nbsp;<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['BREADCRUMBS']->value, 'item', false, 'key', 'breadcrumbs', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
if ($_smarty_tpl->tpl_vars['key']->value != 0 && $_smarty_tpl->tpl_vars['ITEM_PREV']->value) {?><span class="separator">&nbsp;<?php echo vglobal('breadcrumbs_separator');?>
&nbsp;</span><?php }
if (isset($_smarty_tpl->tpl_vars['item']->value['url'])) {?><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
"><span><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</span></a><?php } else { ?><span><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</span><?php }
$_smarty_tpl->_assignInScope('ITEM_PREV', $_smarty_tpl->tpl_vars['item']->value['name']);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</h2></div><?php }
$_smarty_tpl->_assignInScope('MENUSCOLOR', Users_Colors_Model::getModulesColors(true));
if ($_smarty_tpl->tpl_vars['MENUSCOLOR']->value) {?><div class="menusColorContainer"><style><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MENUSCOLOR']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>.moduleColor_<?php echo $_smarty_tpl->tpl_vars['item']->value['module'];?>
{color: <?php echo $_smarty_tpl->tpl_vars['item']->value['color'];?>
 !important;}<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</style></div><?php }?></div><?php }
}
}
