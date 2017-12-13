<?php
/* Smarty version 3.1.31, created on 2017-12-07 09:42:11
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/QuickCreate.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28c6a3a993f9_40177327',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c5fd4a88c1dd4146e1feadc3bba8cb99b0b26cfd' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/QuickCreate.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28c6a3a993f9_40177327 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SCRIPTS']->value, 'jsModel', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['jsModel']->value) {
echo '<script'; ?>
 type="<?php echo $_smarty_tpl->tpl_vars['jsModel']->value->getType();?>
" src="<?php echo $_smarty_tpl->tpl_vars['jsModel']->value->getSrc();?>
"><?php echo '</script'; ?>
><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
$_smarty_tpl->_assignInScope('WIDTHTYPE', $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('rowheight'));
?><div class="modelContainer modal fade quickCreateContainer" tabindex="-1"><div class="modal-dialog modal-full"><div class="modal-content"><form class="form-horizontal recordEditView" name="QuickCreate" method="post" action="index.php"><div class="modal-header"><div class="pull-left divQuickCreate"><h3 class="modal-title quickCreateTitle"><?php echo \App\Language::translate('LBL_QUICK_CREATE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
:&nbsp <p class="textTransform"><b><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['SINGLE_MODULE']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
<b></p></h3></div><div class="pull-right quickCreateActions pullRight"><?php $_smarty_tpl->_assignInScope('EDIT_VIEW_URL', $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getCreateRecordUrl());
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['QUICKCREATE_LINKS']->value['QUICKCREATE_VIEW_HEADER'], 'LINK');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['LINK']->value) {
$_smarty_tpl->_subTemplateRender(vtemplate_path('ButtonLink.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('BUTTON_VIEW'=>'quickcreateViewHeader'), 0, true);
?>
&nbsp;&nbsp;<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
<button class="btn btn-default goToFullFormOne" id="goToFullForm" data-edit-view-url="<?php echo $_smarty_tpl->tpl_vars['EDIT_VIEW_URL']->value;?>
" type="button"><strong><?php echo \App\Language::translate('LBL_GO_TO_FULL_FORM',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>&nbsp;<button class="btn btn-success" type="submit" title="<?php echo \App\Language::translate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><strong><span class="glyphicon glyphicon-ok"></span></strong></button><button class="cancelLink  btn btn-warning" aria-hidden="true" data-dismiss="modal" type="button" title="<?php echo \App\Language::translate('LBL_CLOSE');?>
"><span class="glyphicon glyphicon-remove"></span></button></div><div class="clearfix"></div></div><?php if (!empty($_smarty_tpl->tpl_vars['PICKIST_DEPENDENCY_DATASOURCE']->value)) {?><input type="hidden" name="picklistDependency" value='<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKIST_DEPENDENCY_DATASOURCE']->value);?>
' /><?php }
if (!empty($_smarty_tpl->tpl_vars['MAPPING_RELATED_FIELD']->value)) {?><input type="hidden" name="mappingRelatedField" value='<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['MAPPING_RELATED_FIELD']->value);?>
' /><?php }?><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
"><input type="hidden" name="action" value="SaveAjax"><div class="quickCreateContent"><div class="modal-body row no-margin"><div class="massEditTable row no-margin"><div class="col-xs-12 paddingLRZero fieldRow"><?php $_smarty_tpl->_assignInScope('COUNTER', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value, 'FIELD_MODEL', false, 'FIELD_NAME', 'blockfields', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_NAME']->value => $_smarty_tpl->tpl_vars['FIELD_MODEL']->value) {
if ($_smarty_tpl->tpl_vars['COUNTER']->value == 2) {?></div><div class="col-xs-12 paddingLRZero fieldRow"><?php $_smarty_tpl->_assignInScope('COUNTER', 1);
} else {
$_smarty_tpl->_assignInScope('COUNTER', $_smarty_tpl->tpl_vars['COUNTER']->value+1);
}?><div class="col-xs-12 col-md-6 fieldsLabelValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
 paddingLRZero"><div class="fieldLabel col-xs-12 col-sm-5"><?php $_smarty_tpl->_assignInScope('HELPINFO', explode(',',$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('helpinfo')));
$_smarty_tpl->_assignInScope('HELPINFO_LABEL', (($_smarty_tpl->tpl_vars['MODULE']->value).('|')).($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label')));
?><label class="muted pull-left-xs pull-right-sm pull-right-lg"><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory() == true) {?> <span class="redColor">*</span><?php }
if (in_array($_smarty_tpl->tpl_vars['VIEW']->value,$_smarty_tpl->tpl_vars['HELPINFO']->value) && \App\Language::translate($_smarty_tpl->tpl_vars['HELPINFO_LABEL']->value,'HelpInfo') != $_smarty_tpl->tpl_vars['HELPINFO_LABEL']->value) {?><a href="#" class="HelpInfoPopover pull-right" title="" data-placement="auto top" data-content="<?php echo htmlspecialchars(\App\Language::translate((($_smarty_tpl->tpl_vars['MODULE']->value).('|')).($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label')),'HelpInfo'));?>
" data-original-title='<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get("label"),$_smarty_tpl->tpl_vars['MODULE']->value);?>
'><span class="glyphicon glyphicon-info-sign"></span></a><?php }
echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label></div><div class="fieldValue col-xs-12 col-sm-7" ><?php $_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getTemplateName(),$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
if ($_smarty_tpl->tpl_vars['COUNTER']->value == 1) {?><div class="col-xs-12 col-md-6 fieldsLabelValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
 paddingLRZero"></div><?php }?></div></div></div></div><?php if (!empty($_smarty_tpl->tpl_vars['SOURCE_RELATED_FIELD']->value)) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SOURCE_RELATED_FIELD']->value, 'RELATED_FIELD_MODEL', false, 'RELATED_FIELD_NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['RELATED_FIELD_NAME']->value => $_smarty_tpl->tpl_vars['RELATED_FIELD_MODEL']->value) {
?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['RELATED_FIELD_NAME']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_FIELD_MODEL']->value->get('fieldvalue');?>
" data-fieldtype="<?php echo $_smarty_tpl->tpl_vars['RELATED_FIELD_MODEL']->value->getFieldDataType();?>
" /><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?></form></div></div></div>
<?php }
}
