<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/widgets/Activities.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d49cb0ca6_93367864',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d1220a4ad6c32700b7c30c94583684e5b3e3849' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/widgets/Activities.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d49cb0ca6_93367864 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="summaryWidgetContainer activityWidgetContainer"><div class="widget_header row"><div class="col-xs-5"><h4 class="widgetTitle textOverflowEllipsis"><?php if ($_smarty_tpl->tpl_vars['WIDGET']->value['label'] == '') {
echo App\Language::translate('LBL_ACTIVITIES',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);
} else {
echo App\Language::translate($_smarty_tpl->tpl_vars['WIDGET']->value['label'],$_smarty_tpl->tpl_vars['MODULE_NAME']->value);
}?></h4></div><div class="col-xs-5"><span class="pull-right"><input class="switchBtn" title="<?php echo App\Language::translate('LBL_CHANGE_ACTIVITY_TYPE');?>
" type="checkbox" checked data-size="small" data-label-width="5" data-handle-width="100" data-on-text="<?php echo App\Language::translate('LBL_CURRENT');?>
" data-off-text="<?php echo App\Language::translate('LBL_HISTORY');?>
" data-basic-texton="<?php echo App\Language::translate('LBL_CURRENT');?>
" data-basic-textoff="<?php echo App\Language::translate('LBL_HISTORY');?>
"></span></div><div class="col-xs-2"><button class="btn btn-sm btn-default pull-right addButton createActivity" data-url="sourceModule=<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getModuleName();?>
&sourceRecord=<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getId();?>
&relationOperation=true" type="button"title="<?php echo App\Language::translate('LBL_ADD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"><span class="glyphicon glyphicon-plus"></span></button></div></div><hr class="widgetHr"><div class="widgetContainer_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 widgetContentBlock" data-url="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['url'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['label'];?>
"><div class="widget_contents"></div></div></div>
<?php }
}
