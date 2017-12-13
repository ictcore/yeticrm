<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:26:37
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/menu/Module.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279baddd2266_56854355',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd89e5cc7c7c3531392624c567114227ac4d4e40e' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/menu/Module.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279baddd2266_56854355 (Smarty_Internal_Template $_smarty_tpl) {
if (\App\Module::isModuleActive($_smarty_tpl->tpl_vars['MENU']->value['mod']) && ($_smarty_tpl->tpl_vars['PRIVILEGESMODEL']->value->isAdminUser() || $_smarty_tpl->tpl_vars['PRIVILEGESMODEL']->value->hasGlobalReadPermission() || $_smarty_tpl->tpl_vars['PRIVILEGESMODEL']->value->hasModulePermission($_smarty_tpl->tpl_vars['MENU']->value['tabid']))) {
$_smarty_tpl->_assignInScope('ICON', Vtiger_Menu_Model::getMenuIcon($_smarty_tpl->tpl_vars['MENU']->value,Vtiger_Menu_Model::vtranslateMenu($_smarty_tpl->tpl_vars['MENU']->value['name'],$_smarty_tpl->tpl_vars['MENU']->value['mod'])));
?><li class="menuModule moduleColor_<?php echo $_smarty_tpl->tpl_vars['MENU']->value['mod'];?>
 <?php if (!$_smarty_tpl->tpl_vars['HASCHILDS']->value) {?>hasParentMenu<?php }?>" data-id="<?php echo $_smarty_tpl->tpl_vars['MENU']->value['id'];?>
" role="menuitem" tabindex="<?php echo $_smarty_tpl->tpl_vars['TABINDEX']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['HASCHILDS']->value) {?>aria-haspopup="<?php echo $_smarty_tpl->tpl_vars['HASCHILDS']->value;?>
"<?php }?>><a class="<?php if ($_smarty_tpl->tpl_vars['MENU']->value['name'] == $_smarty_tpl->tpl_vars['MODULE']->value) {?>active<?php }?> <?php if ($_smarty_tpl->tpl_vars['ICON']->value) {?>hasIcon<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['MENU']->value['hotkey'])) {?>hotKey<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['MENU']->value['hotkey'])) {?>data-hotkeys="<?php echo $_smarty_tpl->tpl_vars['MENU']->value['hotkey'];?>
"<?php }?> href="<?php echo $_smarty_tpl->tpl_vars['MENU']->value['dataurl'];?>
"<?php if ($_smarty_tpl->tpl_vars['MENU']->value['newwindow'] == 1) {?>target="_blank" <?php }?>><?php echo $_smarty_tpl->tpl_vars['ICON']->value;?>
<span class="menuName"><?php echo Vtiger_Menu_Model::vtranslateMenu($_smarty_tpl->tpl_vars['MENU']->value['name'],$_smarty_tpl->tpl_vars['MENU']->value['mod']);?>
</span></a><?php if ($_smarty_tpl->tpl_vars['DEVICE']->value == 'Desktop') {
$_smarty_tpl->_subTemplateRender(vtemplate_path('menu/SubMenu.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('DEVICE'=>$_smarty_tpl->tpl_vars['DEVICE']->value), 0, true);
}?></li><?php if ($_smarty_tpl->tpl_vars['DEVICE']->value == 'Mobile') {
$_smarty_tpl->_subTemplateRender(vtemplate_path('menu/SubMenu.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('DEVICE'=>$_smarty_tpl->tpl_vars['DEVICE']->value), 0, true);
}
}
}
}
