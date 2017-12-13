<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/widgets/Updates.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d49d485d3_36597259',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6abb2f9698a489c83a7ba22acad9ed1c8584400' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/widgets/Updates.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d49d485d3_36597259 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="summaryWidgetContainer"><div class="widgetContainer_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 widgetContentBlock" data-url="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['WIDGET']->value['url']);?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['label'];?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['type'];?>
"><div class="widget_header"><div class="row"><div class="col-xs-9 col-md-5 col-sm-6"><div class="widgetTitle textOverflowEllipsis"><h4 class="moduleColor_<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['label'];?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['WIDGET']->value['label'],$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></div></div><?php if (isset($_smarty_tpl->tpl_vars['WIDGET']->value['switchHeader'])) {?><div class="col-xs-8 col-md-4 col-sm-3 paddingBottom10"><input class="switchBtn switchBtnReload filterField" type="checkbox" checked="" data-size="small" data-label-width="5" data-on-text="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['switchHeaderLables']['on'];?>
" data-off-text="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['switchHeaderLables']['off'];?>
" data-urlparams="whereCondition" data-on-val='<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['switchHeader']['on'];?>
' data-off-val='<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['switchHeader']['off'];?>
'></div><?php }?><div class="col-md-3 col-sm-3 pull-right paddingBottom10"><div class="pull-right"><div class="btn-group"><?php if ($_smarty_tpl->tpl_vars['WIDGET']->value['newChanege'] && $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isPermitted('ReviewingUpdates') && $_smarty_tpl->tpl_vars['USER_MODEL']->value->getId() == $_smarty_tpl->tpl_vars['USER_MODEL']->value->getRealId()) {?><div class="pull-right btn-group"><button id="btnChangesReviewedOn" type="button" class="btn btn-success btn-sm btnChangesReviewedOn" title="<?php echo \App\Language::translate('BTN_CHANGES_REVIEWED_ON',$_smarty_tpl->tpl_vars['WIDGET']->value['moduleBaseName']);?>
"><span class="glyphicon glyphicon-ok-circle"></span></button></div><?php }?></div></div></div></div><hr class="widgetHr"/></div><div class="widget_contents"></div></div></div>
<?php }
}
