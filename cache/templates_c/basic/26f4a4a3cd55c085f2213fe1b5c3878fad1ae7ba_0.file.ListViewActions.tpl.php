<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:30:26
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/ListViewActions.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279c92d506c7_04011425',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '26f4a4a3cd55c085f2213fe1b5c3878fad1ae7ba' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/ListViewActions.tpl',
      1 => 1467785442,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279c92d506c7_04011425 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="listViewActions pull-right paginationDiv paddingLeft5px"><?php if ((method_exists($_smarty_tpl->tpl_vars['MODULE_MODEL']->value,'isPagingSupported') && ($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isPagingSupported() == true)) || !method_exists($_smarty_tpl->tpl_vars['MODULE_MODEL']->value,'isPagingSupported')) {?><div class=""><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('Pagination.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div><?php }?></div><div class="clearfix"></div><input type="hidden" id="recordsCount" value=""/><input type="hidden" id="selectedIds" name="selectedIds" /><input type="hidden" id="excludedIds" name="excludedIds" />
<?php }
}
