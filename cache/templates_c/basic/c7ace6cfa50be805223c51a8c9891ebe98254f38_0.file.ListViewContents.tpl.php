<?php
/* Smarty version 3.1.31, created on 2017-12-07 13:25:46
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/WebserviceUsers/ListViewContents.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28fb0ad0c3f0_21883397',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c7ace6cfa50be805223c51a8c9891ebe98254f38' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/WebserviceUsers/ListViewContents.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28fb0ad0c3f0_21883397 (Smarty_Internal_Template $_smarty_tpl) {
?>

<br /><div class="editViewContainer tab-pane active" id="<?php echo $_smarty_tpl->tpl_vars['TYPE_API']->value;?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['TYPE_API']->value;?>
"><div class="listViewActionsDiv row"><div class="col-md-8 tn-toolbar"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LISTVIEW_LINKS']->value['LISTVIEWBASIC'], 'LINK');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['LINK']->value) {
$_smarty_tpl->_subTemplateRender(vtemplate_path('ButtonLink.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('BUTTON_VIEW'=>'listViewBasic'), 0, true);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div><div class="col-md-4"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('ListViewActions.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div><div class="listViewContentDiv listViewPageDiv" id="listViewContents"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('ListViewContents.tpl','Settings:Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div></div>

<?php }
}
