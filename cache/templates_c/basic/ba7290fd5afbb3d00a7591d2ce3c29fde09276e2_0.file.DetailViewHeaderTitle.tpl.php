<?php
/* Smarty version 3.1.31, created on 2017-12-08 15:22:11
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Documents/DetailViewHeaderTitle.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a67d35251b0_61305948',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ba7290fd5afbb3d00a7591d2ce3c29fde09276e2' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Documents/DetailViewHeaderTitle.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a67d35251b0_61305948 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="col-md-12 paddingLRZero row"><div class="col-xs-12 col-sm-12 col-md-8"><div class="moduleIcon"><span class="detailViewIcon <?php echo $_smarty_tpl->tpl_vars['EXTENSION_ICON']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['COLORLISTHANDLERS']->value) {?>style="background-color: <?php echo $_smarty_tpl->tpl_vars['COLORLISTHANDLERS']->value['background'];?>
;color: <?php echo $_smarty_tpl->tpl_vars['COLORLISTHANDLERS']->value['text'];?>
;"<?php }?>></span></div><div class="paddingLeft5px"><h4 class="recordLabel textOverflowEllipsis pushDown marginbottomZero" title="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
"><span class="moduleColor_<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
</span></h4><?php if ($_smarty_tpl->tpl_vars['MODULE_NAME']->value) {?><div class="paddingLeft5px"><span class="muted"><?php echo \App\Language::translate('Assigned To',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('assigned_user_id');
$_smarty_tpl->_assignInScope('SHOWNERS', $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('shownerid'));
if ($_smarty_tpl->tpl_vars['SHOWNERS']->value != '') {?><br /><?php echo \App\Language::translate('Share with users',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['SHOWNERS']->value;
}?></span></div><?php }?></div></div><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('DetailViewHeaderFields.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div>
<?php }
}
