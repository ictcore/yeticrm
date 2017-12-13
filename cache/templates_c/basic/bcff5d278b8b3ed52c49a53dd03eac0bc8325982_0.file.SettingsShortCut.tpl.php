<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:26:48
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Vtiger/SettingsShortCut.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279bb8e996e7_39134078',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bcff5d278b8b3ed52c49a53dd03eac0bc8325982' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Vtiger/SettingsShortCut.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279bb8e996e7_39134078 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="shortcut_<?php echo $_smarty_tpl->tpl_vars['SETTINGS_SHORTCUT']->value->getId();?>
" style="margin-left: 20px !important;" data-actionurl="<?php echo $_smarty_tpl->tpl_vars['SETTINGS_SHORTCUT']->value->getPinUnpinActionUrl();?>
" class="col-md-3 contentsBackground well cursorPointer moduleBlock" data-url="<?php echo $_smarty_tpl->tpl_vars['SETTINGS_SHORTCUT']->value->getUrl();?>
"><button data-id="<?php echo $_smarty_tpl->tpl_vars['SETTINGS_SHORTCUT']->value->getId();?>
" title="<?php echo \App\Language::translate('LBL_REMOVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" title="Close" type="button" class="unpin close">x</button><h5 class="themeTextColor"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['SETTINGS_SHORTCUT']->value->get('name'),Vtiger_Menu_Model::getModuleNameFromUrl($_smarty_tpl->tpl_vars['SETTINGS_SHORTCUT']->value->get('linkto')));?>
</h5><div><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['SETTINGS_SHORTCUT']->value->get('description'),Vtiger_Menu_Model::getModuleNameFromUrl($_smarty_tpl->tpl_vars['SETTINGS_SHORTCUT']->value->get('linkto')));?>
</div></div>	
<?php }
}
