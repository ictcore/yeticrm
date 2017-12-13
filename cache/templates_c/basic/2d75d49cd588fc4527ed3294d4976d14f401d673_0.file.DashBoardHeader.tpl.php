<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:26:37
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/dashboards/DashBoardHeader.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279badf29092_39216154',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2d75d49cd588fc4527ed3294d4976d14f401d673' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/dashboards/DashBoardHeader.tpl',
      1 => 1484198376,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279badf29092_39216154 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="widget_header row"><div class="col-xs-9 col-sm-4 col-md-6"><div class="btn-group listViewMassActions modOn_<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
 pull-left paddingRight10"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('ButtonViewLinks.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('LINKS'=>$_smarty_tpl->tpl_vars['QUICK_LINKS']->value['SIDEBARLINK'],'BTN_GROUP'=>false), 0, true);
?>
</div><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div>
<?php }
}
