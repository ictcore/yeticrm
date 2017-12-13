<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/DetailViewHeader.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d49803047_99013292',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f425d57ff073e20f5c11ba8722f591f764430ecc' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/DetailViewHeader.tpl',
      1 => 1478117054,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d49803047_99013292 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('MODULE_NAME', $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('name'));
?><input id="recordId" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getId();?>
" /><div class="detailViewContainer"><div class="row detailViewTitle"><div class=""><div class="row"><div class="col-md-12 marginBottom5px widget_header row no-margin"><div class=""><div class="col-md-6 paddingLRZero"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div><div class="col-md-6 col-xs-12 paddingLRZero"><div class="col-xs-12 detailViewToolbar paddingLRZero" style="text-align: right;"><?php ob_start();
echo $_smarty_tpl->tpl_vars['NO_PAGINATION']->value;
$_prefixVariable1=ob_get_clean();
if (!$_prefixVariable1) {?><div class="detailViewPagingButton pull-right"><span class="btn-group pull-right"><button class="btn btn-default" id="detailViewPreviousRecordButton" <?php if (empty($_smarty_tpl->tpl_vars['PREVIOUS_RECORD_URL']->value)) {?> disabled="disabled" <?php } else { ?> onclick="window.location.href = '<?php echo $_smarty_tpl->tpl_vars['PREVIOUS_RECORD_URL']->value;?>
'" <?php }?>><span class="glyphicon glyphicon-chevron-left"></span></button><button class="btn btn-default" id="detailViewNextRecordButton" <?php if (empty($_smarty_tpl->tpl_vars['NEXT_RECORD_URL']->value)) {?> disabled="disabled" <?php } else { ?> onclick="window.location.href = '<?php echo $_smarty_tpl->tpl_vars['NEXT_RECORD_URL']->value;?>
'" <?php }?>><span class="glyphicon glyphicon-chevron-right"></span></button></span></div><?php }?><div class="pull-right-md pull-left-sm pull-right-lg"><div class="btn-toolbar"><span class="btn-group "><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAILVIEWBASIC'], 'LINK');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['LINK']->value) {
$_smarty_tpl->_subTemplateRender(vtemplate_path('ButtonLink.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('BUTTON_VIEW'=>'detailViewBasic'), 0, true);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</span><?php if (count($_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAILVIEW']) > 0) {?><span class="btn-group"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAILVIEW'], 'LINK');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['LINK']->value) {
$_smarty_tpl->_subTemplateRender(vtemplate_path('ButtonLink.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('BUTTON_VIEW'=>'detailView'), 0, true);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</span><?php }?></div></div></div></div></div></div></div></div><?php if (!empty($_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAIL_VIEW_HEADER_WIDGET'])) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAIL_VIEW_HEADER_WIDGET'], 'WIDGET');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['WIDGET']->value) {
?><div class="col-md-12 paddingLRZero"><?php echo Vtiger_Widget_Model::processWidget($_smarty_tpl->tpl_vars['WIDGET']->value,$_smarty_tpl->tpl_vars['RECORD']->value);?>
</div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
$_smarty_tpl->_subTemplateRender(vtemplate_path("DetailViewHeaderTitle.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div><div class="detailViewInfo row"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path("RelatedListButtons.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
<div class="col-md-12 <?php if (!empty($_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAILVIEWTAB']) || !empty($_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAILVIEWRELATED'])) {?> details <?php }?>"><form id="detailView" data-name-fields='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getNameFields());?>
' method="POST"><?php if (!empty($_smarty_tpl->tpl_vars['PICKLIST_DEPENDENCY_DATASOURCE']->value)) {?><input type="hidden" name="picklistDependency" value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_DEPENDENCY_DATASOURCE']->value);?>
"><?php }?><div class="contents">

<?php }
}
