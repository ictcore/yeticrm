<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/widgets/Basic.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d49b81f73_88335350',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ad0d65ec0c2990694cab2b5410c1ef63a68a6b87' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/widgets/Basic.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d49b81f73_88335350 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="summaryWidgetContainer"><div class="widgetContainer_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 widgetContentBlock" data-url="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['WIDGET']->value['url']);?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['label'];?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['type'];?>
"><div class="widget_header"><input type="hidden" name="relatedModule" value="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['data']['relatedmodule'];?>
" /><div class="row"><div class="col-xs-9 col-md-5 col-sm-6"><div class="widgetTitle textOverflowEllipsis"><h4 class="moduleColor_<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['label'];?>
"><?php if ($_smarty_tpl->tpl_vars['WIDGET']->value['label'] == '') {
echo \App\Language::translate(vtlib\Functions::getModuleName($_smarty_tpl->tpl_vars['WIDGET']->value['data']['relatedmodule']),vtlib\Functions::getModuleName($_smarty_tpl->tpl_vars['WIDGET']->value['data']['relatedmodule']));
} else {
echo \App\Language::translate($_smarty_tpl->tpl_vars['WIDGET']->value['label'],$_smarty_tpl->tpl_vars['MODULE_NAME']->value);
}?></h4></div></div><?php if (isset($_smarty_tpl->tpl_vars['WIDGET']->value['switchHeader'])) {?><div class="col-xs-8 col-md-4 col-sm-3 paddingBottom10"><input class="switchBtn switchBtnReload filterField" type="checkbox" checked="" data-size="small" data-label-width="5" data-on-text="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['switchHeaderLables']['on'];?>
" data-off-text="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['switchHeaderLables']['off'];?>
" data-urlparams="search_params" data-on-val='<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['switchHeader']['on'];?>
' data-off-val='<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['switchHeader']['off'];?>
'></div><?php }?><div class="col-md-3 col-sm-3 pull-right paddingBottom10"><div class="pull-right"><div class="btn-group"><?php if (isset($_smarty_tpl->tpl_vars['WIDGET']->value['data']['actionSelect']) || isset($_smarty_tpl->tpl_vars['WIDGET']->value['data']['action'])) {
$_smarty_tpl->_assignInScope('VRM', Vtiger_Record_Model::getInstanceById($_smarty_tpl->tpl_vars['RECORD']->value->getId(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value));
$_smarty_tpl->_assignInScope('VRMM', Vtiger_RelationListView_Model::getInstance($_smarty_tpl->tpl_vars['VRM']->value,$_smarty_tpl->tpl_vars['WIDGET']->value['data']['relatedmodule']));
$_smarty_tpl->_assignInScope('RELATIONMODEL', $_smarty_tpl->tpl_vars['VRMM']->value->getRelationModel());
if ($_smarty_tpl->tpl_vars['WIDGET']->value['data']['actionSelect'] == 1) {
$_smarty_tpl->_assignInScope('RESTRICTIONS_FIELD', $_smarty_tpl->tpl_vars['RELATIONMODEL']->value->getRestrictionsPopupField($_smarty_tpl->tpl_vars['VRM']->value));
?><button class="btn btn-sm btn-default selectRelation" type="button" data-modulename="<?php echo $_smarty_tpl->tpl_vars['RELATIONMODEL']->value->getRelationModuleName();?>
" <?php if ($_smarty_tpl->tpl_vars['RESTRICTIONS_FIELD']->value) {?>data-rf='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['RESTRICTIONS_FIELD']->value);?>
'<?php }?> title="<?php echo \App\Language::translate('LBL_SELECT_OPTION',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" alt="<?php echo \App\Language::translate('LBL_SELECT_OPTION',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"><span class="glyphicon glyphicon-search"></span></button><?php }
if ($_smarty_tpl->tpl_vars['WIDGET']->value['data']['action'] == 1) {
$_smarty_tpl->_assignInScope('RELATION_FIELD', $_smarty_tpl->tpl_vars['RELATIONMODEL']->value->getRelationField());
$_smarty_tpl->_assignInScope('AUTOCOMPLETE_FIELD', $_smarty_tpl->tpl_vars['RELATIONMODEL']->value->getAutoCompleteField($_smarty_tpl->tpl_vars['VRM']->value));
?><button class="btn btn-sm btn-default createRecordFromFilter" type="button" data-url="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['actionURL'];?>
"<?php if ($_smarty_tpl->tpl_vars['RELATION_FIELD']->value) {?> data-prf="<?php echo $_smarty_tpl->tpl_vars['RELATION_FIELD']->value->getName();?>
" <?php }?> <?php if ($_smarty_tpl->tpl_vars['AUTOCOMPLETE_FIELD']->value) {?> data-acf='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['AUTOCOMPLETE_FIELD']->value);?>
'<?php }?> title="<?php echo \App\Language::translate('LBL_ADD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" alt="<?php echo \App\Language::translate('LBL_ADD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"><span class="glyphicon glyphicon-plus"></span></button><?php }
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['WIDGET']->value['buttonHeader'], 'LINK');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['LINK']->value) {
$_smarty_tpl->_subTemplateRender(vtemplate_path('ButtonLink.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('BUTTON_VIEW'=>'detailViewBasic'), 0, true);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?></div></div></div></div><hr class="widgetHr"/><div class="row"><?php if ((isset($_smarty_tpl->tpl_vars['WIDGET']->value['data']['filter']) && $_smarty_tpl->tpl_vars['WIDGET']->value['data']['filter'] != '-') && (isset($_smarty_tpl->tpl_vars['WIDGET']->value['data']['checkbox']) && $_smarty_tpl->tpl_vars['WIDGET']->value['data']['checkbox'] != '-')) {
$_smarty_tpl->_assignInScope('span', 'col-xs-6');
} else {
$_smarty_tpl->_assignInScope('span', 'col-xs-12');
}
if (isset($_smarty_tpl->tpl_vars['WIDGET']->value['data']['filter']) && $_smarty_tpl->tpl_vars['WIDGET']->value['data']['filter'] != '-') {?><div class="<?php echo $_smarty_tpl->tpl_vars['span']->value;?>
 form-group-sm"><?php $_smarty_tpl->_assignInScope('filter', $_smarty_tpl->tpl_vars['WIDGET']->value['data']['filter']);
$_smarty_tpl->_assignInScope('RELATED_MODULE_MODEL', Vtiger_Module_Model::getInstance($_smarty_tpl->tpl_vars['WIDGET']->value['data']['relatedmodule']));
$_smarty_tpl->_assignInScope('FIELD_MODEL', $_smarty_tpl->tpl_vars['RELATED_MODULE_MODEL']->value->getField($_smarty_tpl->tpl_vars['filter']->value));
$_smarty_tpl->_assignInScope('FIELD_INFO', \App\Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo()));
$_smarty_tpl->_assignInScope('PICKLIST_VALUES', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues());
$_smarty_tpl->_assignInScope('SPECIAL_VALIDATOR', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator());
?><select class="select2 filterField form-control input-sm" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
" data-validation-engine="validate[<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory() == true) {?> required,<?php }?>funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD_INFO']->value, ENT_QUOTES, 'UTF-8', true);?>
' <?php if (!empty($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value)) {?>data-validator='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value);?>
'<?php }?> data-fieldlable='<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['WIDGET']->value['data']['relatedmodule']);?>
' data-filter="<?php echo (($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('table')).('.')).($_smarty_tpl->tpl_vars['filter']->value);?>
" data-urlparams="whereCondition"><option><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['WIDGET']->value['data']['relatedmodule']);?>
</option><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value, 'PICKLIST_VALUE', false, 'PICKLIST_NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue') == $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div><?php }
if (isset($_smarty_tpl->tpl_vars['WIDGET']->value['data']['checkbox']) && $_smarty_tpl->tpl_vars['WIDGET']->value['data']['checkbox'] != '-') {?><div class="<?php echo $_smarty_tpl->tpl_vars['span']->value;?>
 small-select"><?php $_smarty_tpl->_assignInScope('checkbox', $_smarty_tpl->tpl_vars['WIDGET']->value['data']['checkbox']);
?><input type="hidden" name="checkbox_data" value="<?php echo $_smarty_tpl->tpl_vars['checkbox']->value;?>
" /><div class="pull-right"><input class="switchBtn switchBtnReload filterField" type="checkbox" checked="" data-size="mini" data-label-width="5" data-on-text="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['checkboxLables']['on'];?>
" data-off-text="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['checkboxLables']['off'];?>
" data-urlparams="search_params" data-on-val='<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['checkbox']['on'];?>
' data-off-val='<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['checkbox']['off'];?>
'></div></div><?php }?></div></div><div class="widget_contents"></div></div></div>
<?php }
}
