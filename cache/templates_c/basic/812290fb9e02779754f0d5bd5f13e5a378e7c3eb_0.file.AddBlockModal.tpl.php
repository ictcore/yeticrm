<?php
/* Smarty version 3.1.31, created on 2017-12-07 09:37:51
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/LayoutEditor/AddBlockModal.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28c59f8a4e75_01383098',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '812290fb9e02779754f0d5bd5f13e5a378e7c3eb' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/LayoutEditor/AddBlockModal.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28c59f8a4e75_01383098 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="modal addBlockModal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header contentsBackground"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3><?php echo App\Language::translate('LBL_ADD_CUSTOM_BLOCK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><form class="form-horizontal addCustomBlockForm"><div class="modal-body"><div class="form-group"><div class="col-md-3 control-label"><span class="redColor">*</span><span><?php echo App\Language::translate('LBL_BLOCK_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></div><div class="col-md-8 controls"><input type="text" name="label" class="form-control" data-validation-engine="validate[required]" /></div></div><div class="form-group"><div class="col-md-3 control-label"><?php echo App\Language::translate('LBL_ADD_AFTER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div><div class="col-md-8 controls"><select class="form-control" name="beforeBlockId"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ALL_BLOCK_LABELS']->value, 'BLOCK_LABEL', false, 'BLOCK_ID');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['BLOCK_ID']->value => $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['BLOCK_ID']->value;?>
" data-label="<?php echo $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value;?>
"><?php echo App\Language::translate($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div></div><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</form></div></div></div><?php }
}
