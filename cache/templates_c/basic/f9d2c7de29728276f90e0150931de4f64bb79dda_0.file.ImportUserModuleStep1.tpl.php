<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:27:43
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ModuleManager/ImportUserModuleStep1.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279bef5e9dd6_72193326',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f9d2c7de29728276f90e0150931de4f64bb79dda' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ModuleManager/ImportUserModuleStep1.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279bef5e9dd6_72193326 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="" id="importModules"><div class="widget_header row"><div class="col-xs-12"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
if (isset($_smarty_tpl->tpl_vars['SELECTED_PAGE']->value)) {
echo \App\Language::translate($_smarty_tpl->tpl_vars['SELECTED_PAGE']->value->get('description'),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);
}?></div></div><?php $_smarty_tpl->_assignInScope('MAXUPLOADSIZE', vtlib\Functions::getMaxUploadSize());
if ($_smarty_tpl->tpl_vars['MAXUPLOADSIZE']->value < 5242880) {?><div class="alert alert-block alert-danger fade in"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><?php echo \App\Language::translate('LBL_TOO_SMALL_UPLOAD_LIMIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h4><p><?php echo \App\Language::translate('LBL_TOO_SMALL_UPLOAD_LIMIT_DESC',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value,vtlib\Functions::showBytes($_smarty_tpl->tpl_vars['MAXUPLOADSIZE']->value));?>
</p></div><?php }?><div class="contents"><div><form class="form-horizontal contentsBackground" id="importUserModule" name="importUserModule" action='index.php' method="POST" enctype="multipart/form-data"><input type="hidden" name="module" value="ModuleManager" /><input type="hidden" name="moduleAction" value="Import"/><input type="hidden" name="parent" value="Settings" /><input type="hidden" name="view" value="ModuleImport" /><input type="hidden" name="mode" value="importUserModuleStep2" /><div name='uploadUserModule'><div class="modal-body tabbable"><div class="tab-content massEditContent"><table class="massEditTable table table-bordered"><tr><td class="fieldLabel alignMiddle"><?php echo \App\Language::translate('LBL_IMPORT_MODULE_FROM_FILE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</td><td class="fieldValue"><input type="file" name="moduleZip" id="moduleZip" size="80px" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-validator=<?php echo \App\Json::encode(array(array('name'=>'UploadModuleZip')));?>
/></td></tr></table></div></div></div><div class="modal-footer"><div class="col-md-1 pull-right cancelLinkContainer"><a class="cancelLink btn btn-warning" href="index.php?module=ModuleManager&parent=Settings&view=List"><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></div><button class="btn btn-success" type="submit" name="saveButton"><strong><?php echo \App\Language::translate('LBL_IMPORT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></div></form></div></div></div>
<?php }
}
