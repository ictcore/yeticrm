<?php
/* Smarty version 3.1.31, created on 2017-12-08 10:57:55
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Contacts/DetailViewHeaderTitle.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a29e32453e4_03391319',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4a414e1d8168176d0af11be98a2e042d321aca7a' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Contacts/DetailViewHeaderTitle.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a29e32453e4_03391319 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="col-md-12 paddingLRZero row"><div class="col-xs-12 col-sm-12 col-md-8"><div><div class="pull-left spanModuleIcon moduleIcon<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
"><span class="moduleIcon"><?php $_smarty_tpl->_assignInScope('IMAGE_DETAILS', $_smarty_tpl->tpl_vars['RECORD']->value->getImageDetails());
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['IMAGE_DETAILS']->value, 'IMAGE_INFO', false, 'ITER');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ITER']->value => $_smarty_tpl->tpl_vars['IMAGE_INFO']->value) {
if (!empty($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'])) {?><img src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path']));?>
" class="pushDown" alt="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
" title="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
" width="65" height="80" align="left"><br /><?php }
}
} else {
?>
<span class="detailViewIcon userIcon-<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['COLORLISTHANDLERS']->value) {?>style="background-color: <?php echo $_smarty_tpl->tpl_vars['COLORLISTHANDLERS']->value['background'];?>
;color: <?php echo $_smarty_tpl->tpl_vars['COLORLISTHANDLERS']->value['text'];?>
;"<?php }?>></span><?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</span></div><h4 class="recordLabel pushDown marginbottomZero textOverflowEllipsis" title="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('salutationtype');?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
"><?php if ($_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('salutationtype')) {?><span class="salutation"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('salutationtype');?>
</span>&nbsp;<?php }?><span class="moduleColor_<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
</span></h4></div><div class="paddingLeft5px"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('parent_id');?>
<div><span class="muted"><?php echo \App\Language::translate('Assigned To',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('assigned_user_id');
$_smarty_tpl->_assignInScope('SHOWNERS', $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('shownerid'));
if ($_smarty_tpl->tpl_vars['SHOWNERS']->value != '') {?><br /><?php echo \App\Language::translate('Share with users',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['SHOWNERS']->value;
}?></span></div></div></div><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('DetailViewHeaderFields.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div>
<?php }
}
