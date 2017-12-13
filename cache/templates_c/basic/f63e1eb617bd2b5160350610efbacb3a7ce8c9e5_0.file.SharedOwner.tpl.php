<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:30:40
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/SharedOwner.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279ca047a504_10588149',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f63e1eb617bd2b5160350610efbacb3a7ce8c9e5' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/SharedOwner.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279ca047a504_10588149 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('FIELD_INFO', Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo())));
$_smarty_tpl->_assignInScope('SPECIAL_VALIDATOR', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator());
if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype') == '120') {
$_smarty_tpl->_assignInScope('ALL_ACTIVEUSER_LIST', \App\Fields\Owner::getInstance($_smarty_tpl->tpl_vars['MODULE']->value)->getAccessibleUsers('',$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()));
$_smarty_tpl->_assignInScope('ALL_ACTIVEGROUP_LIST', \App\Fields\Owner::getInstance($_smarty_tpl->tpl_vars['MODULE']->value)->getAccessibleGroups('',$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()));
$_smarty_tpl->_assignInScope('ASSIGNED_USER_ID', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name'));
$_smarty_tpl->_assignInScope('CURRENT_USER_ID', $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('id'));
$_smarty_tpl->_assignInScope('FIELD_VALUE', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'));
if ($_smarty_tpl->tpl_vars['FIELD_VALUE']->value != '') {
$_smarty_tpl->_assignInScope('FIELD_VALUE', vtlib\Functions::getArrayFromValue($_smarty_tpl->tpl_vars['FIELD_VALUE']->value));
$_smarty_tpl->_assignInScope('NOT_DISPLAY_LIST', array_diff_key(array_flip($_smarty_tpl->tpl_vars['FIELD_VALUE']->value),$_smarty_tpl->tpl_vars['ALL_ACTIVEUSER_LIST']->value,$_smarty_tpl->tpl_vars['ALL_ACTIVEGROUP_LIST']->value));
} else {
$_smarty_tpl->_assignInScope('FIELD_VALUE', array());
}?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
" value="" /><select class="select2 form-control <?php if (!empty($_smarty_tpl->tpl_vars['NOT_DISPLAY_LIST']->value)) {?>hideSelected<?php }?> <?php echo $_smarty_tpl->tpl_vars['ASSIGNED_USER_ID']->value;?>
" title="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-validation-engine="validate[<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory() == true) {?> required,<?php }?>funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-name="<?php echo $_smarty_tpl->tpl_vars['ASSIGNED_USER_ID']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['ASSIGNED_USER_ID']->value;?>
[]" data-fieldinfo='<?php echo $_smarty_tpl->tpl_vars['FIELD_INFO']->value;?>
' multiple <?php if (!empty($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value)) {?>  data-validator=<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value);
}
if (AppConfig::performance('SEARCH_OWNERS_BY_AJAX')) {?>data-ajax-search="1" data-ajax-url="index.php?module=<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
&action=Fields&mode=getOwners&type=Edit" data-minimum-input="<?php echo AppConfig::performance('OWNER_MINIMUM_INPUT_LENGTH');?>
"<?php }?>><?php if (AppConfig::performance('SEARCH_OWNERS_BY_AJAX')) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['FIELD_VALUE']->value, 'USER');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['USER']->value) {
$_smarty_tpl->_assignInScope('OWNER_NAME', vtlib\Functions::getOwnerRecordLabel($_smarty_tpl->tpl_vars['USER']->value));
?><option value="<?php echo $_smarty_tpl->tpl_vars['USER']->value;?>
" data-picklistvalue="<?php echo $_smarty_tpl->tpl_vars['OWNER_NAME']->value;?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['OWNER_NAME']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
} else { ?><optgroup label="<?php echo \App\Language::translate('LBL_USERS');?>
"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ALL_ACTIVEUSER_LIST']->value, 'OWNER_NAME', false, 'OWNER_ID');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['OWNER_ID']->value => $_smarty_tpl->tpl_vars['OWNER_NAME']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['OWNER_ID']->value;?>
" data-picklistvalue="<?php echo $_smarty_tpl->tpl_vars['OWNER_NAME']->value;?>
"<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['FIELD_VALUE']->value, 'USER');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['USER']->value) {
if ($_smarty_tpl->tpl_vars['USER']->value == $_smarty_tpl->tpl_vars['OWNER_ID']->value) {?> selected <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
><?php echo $_smarty_tpl->tpl_vars['OWNER_NAME']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</optgroup><optgroup label="<?php echo \App\Language::translate('LBL_GROUPS');?>
"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ALL_ACTIVEGROUP_LIST']->value, 'OWNER_NAME', false, 'OWNER_ID');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['OWNER_ID']->value => $_smarty_tpl->tpl_vars['OWNER_NAME']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['OWNER_ID']->value;?>
" data-picklistvalue="<?php echo $_smarty_tpl->tpl_vars['OWNER_NAME']->value;?>
"<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['FIELD_VALUE']->value, 'GROUP');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['GROUP']->value) {
if ($_smarty_tpl->tpl_vars['GROUP']->value == $_smarty_tpl->tpl_vars['OWNER_ID']->value) {?> selected <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['OWNER_NAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</optgroup><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['NOT_DISPLAY_LIST']->value, 'OWNER_NAME', false, 'OWNER_ID');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['OWNER_ID']->value => $_smarty_tpl->tpl_vars['OWNER_NAME']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['OWNER_ID']->value;?>
" <?php if (in_array(Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['OWNER_NAME']->value),$_smarty_tpl->tpl_vars['FIELD_VALUE']->value)) {?>selected<?php }?> disabled class="hide"><?php echo $_smarty_tpl->tpl_vars['OWNER_NAME']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?></select><?php }
}
}
