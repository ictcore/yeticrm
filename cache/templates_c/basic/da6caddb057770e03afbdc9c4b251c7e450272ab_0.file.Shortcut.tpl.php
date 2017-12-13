<?php
/* Smarty version 3.1.31, created on 2017-12-07 12:44:08
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/menu/Shortcut.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28f14802cb66_19740174',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'da6caddb057770e03afbdc9c4b251c7e450272ab' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/menu/Shortcut.tpl',
      1 => 1512632534,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28f14802cb66_19740174 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('ICON', Vtiger_Menu_Model::getMenuIcon($_smarty_tpl->tpl_vars['MENU']->value,Vtiger_Menu_Model::vtranslateMenu($_smarty_tpl->tpl_vars['MENU']->value['name'],$_smarty_tpl->tpl_vars['MENU_MODULE']->value)));
?><li class="menuShortcut <?php if (!$_smarty_tpl->tpl_vars['HASCHILDS']->value) {?>hasParentMenu<?php }?>" data-id="<?php echo $_smarty_tpl->tpl_vars['MENU']->value['id'];?>
" role="menuitem" tabindex="<?php echo $_smarty_tpl->tpl_vars['TABINDEX']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['HASCHILDS']->value) {?>aria-haspopup="<?php echo $_smarty_tpl->tpl_vars['HASCHILDS']->value;?>
"<?php }?>><a class="<?php if (isset($_smarty_tpl->tpl_vars['MENU']->value['hotkey'])) {?>hotKey<?php }?> <?php if ($_smarty_tpl->tpl_vars['MENU']->value['active']) {?>active<?php }
if ($_smarty_tpl->tpl_vars['ICON']->value) {?> hasIcon<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['MENU']->value['hotkey'])) {?> data-hotkeys="<?php echo $_smarty_tpl->tpl_vars['MENU']->value['hotkey'];?>
"<?php }?> href="<?php echo $_smarty_tpl->tpl_vars['MENU']->value['dataurl'];?>
" <?php if ($_smarty_tpl->tpl_vars['MENU']->value['newwindow'] == 1 || $_smarty_tpl->tpl_vars['MENU']->value['name'] == 'LBL_YETIFORCE_SHOP') {?>target="_blank" <?php }?>><?php echo $_smarty_tpl->tpl_vars['ICON']->value;?>
<span class="menuName"><?php echo Vtiger_Menu_Model::vtranslateMenu($_smarty_tpl->tpl_vars['MENU']->value['name'],$_smarty_tpl->tpl_vars['MENU_MODULE']->value);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['DEVICE']->value == 'Desktop') {
$_smarty_tpl->_subTemplateRender(vtemplate_path('menu/SubMenu.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('DEVICE'=>$_smarty_tpl->tpl_vars['DEVICE']->value), 0, true);
}?></li><?php if ($_smarty_tpl->tpl_vars['DEVICE']->value == 'Desktop') {
$_smarty_tpl->_subTemplateRender(vtemplate_path('menu/SubMenu.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('DEVICE'=>$_smarty_tpl->tpl_vars['DEVICE']->value), 0, true);
}?>

<?php }
}
