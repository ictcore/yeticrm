<?php
/* Smarty version 3.1.31, created on 2017-12-07 13:25:46
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/WebserviceUsers/ListViewHeader.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28fb0acb12f0_13619673',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a86a8137eb6162dd949c938acfe98040d033466b' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/WebserviceUsers/ListViewHeader.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28fb0acb12f0_13619673 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class='widget_header row '><div class="col-xs-12"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div><div class="row no-margin"><ul id="tabs" class="nav nav-tabs " data-tabs="tabs"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, Settings_WebserviceApps_Module_Model::getTypes(), 'VALUE', false, NULL, 'typeLoop', array (
  'first' => true,
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['VALUE']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_typeLoop']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_typeLoop']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_typeLoop']->value['index'];
?><li class="tabApi<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_typeLoop']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_typeLoop']->value['first'] : null)) {?> active<?php }?>" data-typeapi="<?php echo $_smarty_tpl->tpl_vars['VALUE']->value;?>
"><a data-toggle="tab"><strong><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['VALUE']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</ul></div><div class="tab-content listViewContent">
<?php }
}
