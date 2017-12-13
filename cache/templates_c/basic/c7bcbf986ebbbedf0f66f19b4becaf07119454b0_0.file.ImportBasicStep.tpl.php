<?php
/* Smarty version 3.1.31, created on 2017-12-08 10:10:03
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Import/ImportBasicStep.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1eab04beb6_20561781',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c7bcbf986ebbbedf0f66f19b4becaf07119454b0' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Import/ImportBasicStep.tpl',
      1 => 1467785440,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1eab04beb6_20561781 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div><form onsubmit="" action="index.php" enctype="multipart/form-data" method="POST" name="importBasic"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
" /><input type="hidden" name="view" value="Import" /><input type="hidden" name="mode" value="uploadAndParse" /><div class='widget_header row '><div class="col-xs-12"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div><div class="col-xs-12 searchUIBasic paddingLRZero" style='margin:0 !important'><?php if ($_smarty_tpl->tpl_vars['ERROR_MESSAGE']->value != '') {?><div class="col-xs-12"><div class="style1"><span class="alert-warning"><?php echo $_smarty_tpl->tpl_vars['ERROR_MESSAGE']->value;?>
</span></div></div><?php }?><div class="importContents col-xs-12"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('Import_Step1.tpl','Import'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div><div class="importContents col-xs-12"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('Import_Step2.tpl','Import'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div><?php if ($_smarty_tpl->tpl_vars['DUPLICATE_HANDLING_NOT_SUPPORTED']->value != 'true') {?><div class="importContents col-xs-12"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('Import_Step3.tpl','Import'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div><?php }?><div class="col-xs-12 paddingBottom10"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('Import_Basic_Buttons.tpl','Import'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div></form></div>
<?php }
}
