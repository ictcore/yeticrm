<?php
/* Smarty version 3.1.31, created on 2017-12-07 09:36:55
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ModuleManager/CreateModule.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28c567c9f2c2_49028682',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aa243cd970bd36a22b88b06b0bfc097737211a7c' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ModuleManager/CreateModule.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28c567c9f2c2_49028682 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="modal addKeyContainer fade" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header contentsBackground"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-title"><?php echo \App\Language::translate('LBL_CREATING_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><div class="modal-body"><form class="form-horizontal"><div class="form-group"><label class="col-sm-3 control-label"><span class="redColor">*</span><?php echo \App\Language::translate('LBL_ENTER_MODULE_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="col-sm-6 controls"><input type="text" class="module_name form-control" data-validation-engine="validate[required, funcCall[Settings_Module_Manager_Js.validateField]]" name="module_name" placeholder="HelpDesk" required="true" ></div></div><div class="form-group"><label class="col-sm-3 control-label"><span class="redColor">*</span><?php echo \App\Language::translate('LBL_ENTER_MODULE_LABEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="col-sm-6 controls"><input type="text" class="module_name form-control" data-validation-engine="validate[required, funcCall[Settings_Module_Manager_Js.validateField]]" name="module_label" placeholder="Help Desk" required="true"></div></div><div class="form-group"><label class="col-sm-3 control-label"><span class="redColor">*</span><?php echo \App\Language::translate('LBL_ENTITY_FIELDNAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="col-sm-6 controls"><input type="text" class="entityfieldname form-control" data-validation-engine="validate[required, funcCall[Settings_Module_Manager_Js.validateField]]" name="entityfieldname" placeholder="title" required="true"></div></div><div class="form-group"><label class="col-sm-3 control-label"><span class="redColor">*</span><?php echo \App\Language::translate('LBL_ENTITY_FIELDLABEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="col-sm-6 controls"><input type="text" class="entityfieldlabel form-control" data-validation-engine="validate[required, funcCall[Settings_Module_Manager_Js.validateField]]"name="entityfieldlabel" placeholder="Title" required="true"></div></div><div class="form-group"><label class="col-sm-3 control-label"><?php echo \App\Language::translate('LBL_MODULE_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="col-sm-6 controls"><select class="chzn-select form-control" title="<?php echo \App\Language::translate('LBL_MODULE_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" name="entitytype"><option value="0" selected><?php echo \App\Language::translate('LBL_BASE_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option value="1"><?php echo \App\Language::translate('LBL_INVENTORY_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option></select></div></div></form></div><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('ModalFooter.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div></div>
<?php }
}
