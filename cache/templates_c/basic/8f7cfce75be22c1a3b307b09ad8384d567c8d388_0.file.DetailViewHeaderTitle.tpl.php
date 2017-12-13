<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Leads/DetailViewHeaderTitle.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d49834de6_46865430',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8f7cfce75be22c1a3b307b09ad8384d567c8d388' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Leads/DetailViewHeaderTitle.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d49834de6_46865430 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="col-md-12 paddingLRZero row"><input type="hidden" id="conversion_available_status" value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['CONVERSION_AVAILABLE_STATUS']->value);?>
"><div class="col-xs-12 col-sm-12 col-md-8"><div class="moduleIcon"><span class="detailViewIcon userIcon-<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['COLORLISTHANDLERS']->value) {?>style="background-color: <?php echo $_smarty_tpl->tpl_vars['COLORLISTHANDLERS']->value['background'];?>
;color: <?php echo $_smarty_tpl->tpl_vars['COLORLISTHANDLERS']->value['text'];?>
;"<?php }?>></span></div><div class="paddingLeft5px"><h4 class="recordLabel textOverflowEllipsis pushDown marginbottomZero" title="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
"><span class="moduleColor_<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
</span></h4><div class="paddingLeft5px"><span class="designation_label"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('designation');?>
</span><?php if ($_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('designation') && $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('company')) {?>&nbsp;<?php echo \App\Language::translate('LBL_AT');?>
&nbsp;<?php }?><span class="company_label"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('company');?>
</span></div><div class="paddingLeft5px"><span class="muted"><?php echo \App\Language::translate('Assigned To',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('assigned_user_id');
$_smarty_tpl->_assignInScope('SHOWNERS', $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('shownerid'));
if ($_smarty_tpl->tpl_vars['SHOWNERS']->value != '') {?><br /><?php echo \App\Language::translate('Share with users',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['SHOWNERS']->value;
}?></span></div></div></div><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('DetailViewHeaderFields.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div>
<?php }
}
