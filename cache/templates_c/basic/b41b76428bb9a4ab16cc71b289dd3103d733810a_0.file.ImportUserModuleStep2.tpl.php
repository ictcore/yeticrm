<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:47:26
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ModuleManager/ImportUserModuleStep2.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a27a08ec7a1f7_76457385',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b41b76428bb9a4ab16cc71b289dd3103d733810a' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ModuleManager/ImportUserModuleStep2.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a27a08ec7a1f7_76457385 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="" id="importModules"><div class='widget_header row '><div class="col-xs-12"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
if (isset($_smarty_tpl->tpl_vars['SELECTED_PAGE']->value)) {
echo \App\Language::translate($_smarty_tpl->tpl_vars['SELECTED_PAGE']->value->get('description'),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);
}?></div></div><div class="contents"><div><div id="vtlib_modulemanager_import_div"><form method="POST" action="index.php"><input type="hidden" name="module" value="ModuleManager"><input type="hidden" name="parent" value="Settings"><?php if ($_smarty_tpl->tpl_vars['MODULEIMPORT_ERROR']->value != '') {?><div class="alert alert-warning"><div class="modal-header"><h3><?php echo \App\Language::translate('LBL_FAILED',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><div class="modal-body"><p><b><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['MODULEIMPORT_ERROR']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</b></p></div><div class=""><input type="hidden" name="view" value="List"><button class="btn btn-success" type="submit"><strong><?php echo \App\Language::translate('LBL_FINISH',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></div></div><?php } else { ?><table class="table table-bordered"><thead><tr class="blockHeader"><th colspan="2"><strong><?php echo \App\Language::translate('LBL_VERIFY_IMPORT_DETAILS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th></tr></thead><tbody><tr><td style="min-width: 100px;"><b><?php echo \App\Language::translate('LBL_MODULE_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</b></td><td><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['MODULEIMPORT_NAME']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);
if ($_smarty_tpl->tpl_vars['MODULEIMPORT_EXISTS']->value == 'true') {?> <font color=red><b><?php echo \App\Language::translate('LBL_EXISTS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</b></font> <?php }?></td></tr><tr><td><b><?php echo \App\Language::translate('LBL_MODULE_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</b></td><td><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['MODULEIMPORT_PACKAGE']->value->getTypeName(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</td></tr><tr><td><b><?php echo \App\Language::translate('LBL_REQ_YETIFORCE_VERSION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</b></td><td><?php echo $_smarty_tpl->tpl_vars['MODULEIMPORT_DEP_VTVERSION']->value;?>
</td></tr><tr><td><b><?php echo \App\Language::translate('LBL_MODULE_VERSION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</b></td><td><?php echo $_smarty_tpl->tpl_vars['MODULEIMPORT_PACKAGE']->value->getVersion();?>
</td></tr><?php if ($_smarty_tpl->tpl_vars['MODULEIMPORT_PACKAGE']->value->isUpdateType()) {
$_smarty_tpl->_assignInScope('INFO', $_smarty_tpl->tpl_vars['MODULEIMPORT_PACKAGE']->value->getUpdateInfo());
?><tr><td><b><?php echo \App\Language::translate('LBL_UPDATE_FROM_VERSION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</b></td><td><?php echo $_smarty_tpl->tpl_vars['INFO']->value['from'];?>
</td></tr><tr><td><b><?php echo \App\Language::translate('LBL_UPDATE_TO_VERSION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</b></td><td><?php echo $_smarty_tpl->tpl_vars['INFO']->value['to'];?>
</td></tr><?php }
$_smarty_tpl->_assignInScope('need_license_agreement', "false");
if ($_smarty_tpl->tpl_vars['MODULEIMPORT_LICENSE']->value) {
$_smarty_tpl->_assignInScope('need_license_agreement', "true");
?><tr><td width=20<?php echo '%>';
if ($_smarty_tpl->tpl_vars['MODULEIMPORT_PACKAGE']->value->isUpdateType()) {?><b><?php echo \App\Language::translate('Attention');?>
</b><?php } else { ?><b><?php echo \App\Language::translate('LBL_LICENSE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</b><?php }?></td><td><textarea rows="10" readonly class='form-control'><?php echo $_smarty_tpl->tpl_vars['MODULEIMPORT_LICENSE']->value;?>
</textarea><br /><?php if ($_smarty_tpl->tpl_vars['MODULEIMPORT_EXISTS']->value != 'true') {?><input type="checkbox" id="license_agreement" onclick="if (this.form.saveButton) {
															if (this.checked) {
																this.form.saveButton.disabled = false;
															} else {
																this.form.saveButton.disabled = true;
															}
														}"><label for="license_agreement" style="display: inline-block;margin-left: 10px;"> <?php echo \App\Language::translate('LBL_LICENSE_ACCEPT_AGREEMENT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><?php }?></td></tr><?php }
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MODULEIMPORT_PARAMETERS']->value, 'PARAMETER');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PARAMETER']->value) {
?><tr><td colspan="2"><?php if ($_smarty_tpl->tpl_vars['PARAMETER']->value->type == 'checkbox') {?><label><input value="1" autocomplete="off" type="checkbox" name="param_<?php echo $_smarty_tpl->tpl_vars['PARAMETER']->value->name;?>
" <?php if ($_smarty_tpl->tpl_vars['PARAMETER']->value->checked == '1') {?>checked<?php }?>>&nbsp;&nbsp;<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['PARAMETER']->value->lable,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><?php }?></td></tr><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</tbody></table><?php if ($_smarty_tpl->tpl_vars['MODULEIMPORT_DIR_EXISTS']->value == 'true') {?><br /><div class="alert alert-danger" role="alert"><?php echo \App\Language::translate('LBL_DELETE_EXIST_DIRECTORY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div><?php }?><div class="modal-footer"><?php if ($_smarty_tpl->tpl_vars['MODULEIMPORT_EXISTS']->value == 'true' || $_smarty_tpl->tpl_vars['MODULEIMPORT_DIR_EXISTS']->value == 'true') {?><input type="hidden" name="view" value="List"><button class="btn btn-success" class="crmbutton small delete" onclick="this.form.mode.value = '';"><strong><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><?php if ($_smarty_tpl->tpl_vars['MODULEIMPORT_EXISTS']->value == 'true') {?><input type="hidden" name="view" value="ModuleImport"><input type="hidden" name="module_import_file" value="<?php echo $_smarty_tpl->tpl_vars['MODULEIMPORT_FILE']->value;?>
"><input type="hidden" name="module_import_type" value="<?php echo $_smarty_tpl->tpl_vars['MODULEIMPORT_TYPE']->value;?>
"><input type="hidden" name="module_import_name" value="<?php echo $_smarty_tpl->tpl_vars['MODULEIMPORT_NAME']->value;?>
"><input type="hidden" name="mode" value="importUserModuleStep3"><input type="checkbox" class="pull-right" onclick="this.form.mode.value = 'updateUserModuleStep3';this.form.submit();" ><span class="pull-right">I would like to update now.&nbsp;</span><?php }
} else { ?><input type="hidden" name="view" value="ModuleImport"><input type="hidden" name="module_import_file" value="<?php echo $_smarty_tpl->tpl_vars['MODULEIMPORT_FILE']->value;?>
"><input type="hidden" name="module_import_type" value="<?php echo $_smarty_tpl->tpl_vars['MODULEIMPORT_TYPE']->value;?>
"><input type="hidden" name="module_import_name" value="<?php echo $_smarty_tpl->tpl_vars['MODULEIMPORT_NAME']->value;?>
"><input type="hidden" name="mode" value="importUserModuleStep3"><span class="col-md-6 pull-right"><?php echo \App\Language::translate('LBL_PROCEED_WITH_IMPORT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
&nbsp;&nbsp;<div class=" pull-right cancelLinkContainer"><a class="cancelLink btn btn-warning" type="reset" data-dismiss="modal" onclick="javascript:window.history.back();"><?php echo \App\Language::translate('LBL_NO',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></div><button class="btn btn-success" type="submit" name="saveButton"<?php if ($_smarty_tpl->tpl_vars['need_license_agreement']->value == 'true') {?> disabled <?php }?>><strong><?php echo \App\Language::translate('LBL_YES');?>
</strong></button></span><?php }?></div><?php }?></form></div></div></div></div>
<?php }
}
