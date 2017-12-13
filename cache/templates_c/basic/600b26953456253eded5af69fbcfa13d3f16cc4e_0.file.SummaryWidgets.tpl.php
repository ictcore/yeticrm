<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:31
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/SummaryWidgets.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d4b9c6729_34456588',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '600b26953456253eded5af69fbcfa13d3f16cc4e' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/SummaryWidgets.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d4b9c6729_34456588 (Smarty_Internal_Template $_smarty_tpl) {
?>

<input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->get('page');?>
" /><input type="hidden" name="pageLimit" value="<?php echo $_smarty_tpl->tpl_vars['LIMIT']->value;?>
" /><input type="hidden" name="col" value="<?php echo $_smarty_tpl->tpl_vars['COLUMNS']->value;?>
" /><input type="hidden" name="relatedModule" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value;?>
" /><input type="hidden" name="relatedModuleName" class="relatedModuleName" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value;?>
" /><?php if ($_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value && $_smarty_tpl->tpl_vars['RELATED_RECORDS']->value) {
$_smarty_tpl->_assignInScope('FILENAME', "SummaryWidgetsContent.tpl");
$_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FILENAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('RELATED_RECORDS'=>$_smarty_tpl->tpl_vars['RELATED_RECORDS']->value), 0, true);
} elseif ($_smarty_tpl->tpl_vars['PAGING_MODEL']->value->get('nrt') == 1) {?><div class="summaryWidgetContainer"><p class="textAlignCenter"><?php echo \App\Language::translate('LBL_NO_RELATED',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo \App\Language::translate($_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value);?>
</p></div><?php }
$_smarty_tpl->_assignInScope('NUMBER_OF_RECORDS', count($_smarty_tpl->tpl_vars['RELATED_RECORDS']->value));
if ($_smarty_tpl->tpl_vars['NUMBER_OF_RECORDS']->value == 0) {?><div class="summaryWidgetContainer noCommentsMsgContainer"><p class="textAlignCenter"><?php echo \App\Language::translate('LBL_NO_RECORDS_FOUND',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</p></div><?php }
if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value && $_smarty_tpl->tpl_vars['LIMIT']->value != 'no_limit' && $_smarty_tpl->tpl_vars['NUMBER_OF_RECORDS']->value >= $_smarty_tpl->tpl_vars['LIMIT']->value) {?><div class="container-fluid"><div class="pull-right"><button type="button" class="btn btn-primary btn-xs moreRecentRecords" data-label-key="<?php echo $_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value;?>
" ><?php echo \App\Language::translate('LBL_MORE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</button></div></div><?php }
}
}
