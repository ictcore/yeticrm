<?php
/* Smarty version 3.1.31, created on 2017-12-06 13:04:26
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/SMSNotifier/Edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a27a48ac44e21_33591001',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cbb6586f58c284cddc8d5224dd584e707988b1c4' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/SMSNotifier/Edit.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a27a48ac44e21_33591001 (Smarty_Internal_Template $_smarty_tpl) {
?>

<form class="form-horizontal validateForm" id="editForm"><input type="hidden" id="record" name="record" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getId();?>
"><div class="modal-header"><button class="close" data-dismiss="modal" title="<?php echo \App\Language::translate('LBL_CLOSE');?>
">x</button><?php if (!$_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getId()) {
$_smarty_tpl->_assignInScope('TITLE', "LBL_ADD_CONFIGURATION");
} else {
$_smarty_tpl->_assignInScope('TITLE', "LBL_EDIT_RECORD");
}?><h3 class="modal-title"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['TITLE']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><div class="modal-body"><div class="fieldsContainer"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getEditFields(), 'LABEL', false, 'FIELD_NAME', 'fields', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_NAME']->value => $_smarty_tpl->tpl_vars['LABEL']->value) {
$_smarty_tpl->_assignInScope('FIELD_MODEL', $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getFieldInstanceByName($_smarty_tpl->tpl_vars['FIELD_NAME']->value)->set('fieldvalue',$_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get($_smarty_tpl->tpl_vars['FIELD_NAME']->value)));
?><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['LABEL']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);
if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory()) {?><span class="redColor"> *</span><?php }?></label><div class="col-md-8 fieldValue"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getTemplateName(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('FIELD_MODEL'=>$_smarty_tpl->tpl_vars['FIELD_MODEL']->value,'MODULE'=>$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), 0, true);
?>
</div></div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getId()) {
$_smarty_tpl->_assignInScope('PROVIDER', $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getProviderInstance());
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PROVIDER']->value->getSettingsEditFieldsModel(), 'FIELD_MODEL', false, NULL, 'fields', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_MODEL']->value) {
$_smarty_tpl->_assignInScope('FIELD_MODEL', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->set('fieldvalue',$_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get($_smarty_tpl->tpl_vars['FIELD_NAME']->value)));
?><div class="form-group" data-provider="<?php echo $_smarty_tpl->tpl_vars['PROVIDER']->value->getName();?>
"><label class="control-label col-md-3"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);
if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory()) {?><span class="redColor"> *</span><?php }?></label><div class="col-md-8 fieldValue"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getTemplateName(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('FIELD_MODEL'=>$_smarty_tpl->tpl_vars['FIELD_MODEL']->value,'MODULE'=>$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), 0, true);
?>
</div></div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?></div></div><div class="modal-footer"><button type="submit" class="btn btn-success"><?php echo \App\Language::translate('BTN_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button><button type="button" class="btn btn-warning dismiss" data-dismiss="modal"><?php echo \App\Language::translate('BTN_CLOSE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></div></form><div class="providersFields hide"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PROVIDERS']->value, 'PROVIDER');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PROVIDER']->value) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PROVIDER']->value->getSettingsEditFieldsModel(), 'FIELD_MODEL', false, NULL, 'fields', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_MODEL']->value) {
?><div class="form-group" data-provider="<?php echo $_smarty_tpl->tpl_vars['PROVIDER']->value->getName();?>
"><label class="control-label col-md-3"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);
if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory()) {?><span class="redColor"> *</span><?php }?>:</label><div class="col-md-8 fieldValue"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getTemplateName(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('FIELD_MODEL'=>$_smarty_tpl->tpl_vars['FIELD_MODEL']->value,'MODULE'=>$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), 0, true);
?>
</div></div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div>
<?php }
}
