<?php
/* Smarty version 3.1.31, created on 2017-12-08 10:10:03
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Import/Import_Step3.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1eab0b4f63_47980331',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9577a93ba0650726211ecdd0e52d4eb876856031' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Import/Import_Step3.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1eab0b4f63_47980331 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="col-xs-12 paddingLRZero"><div class='col-xs-2 paddingLRZero'><strong><?php echo \App\Language::translate('LBL_IMPORT_STEP_3',$_smarty_tpl->tpl_vars['MODULE']->value);?>
:</strong>&nbsp;&nbsp;&nbsp;<input type="checkbox" class="font-x-small" id="auto_merge" title="<?php echo \App\Language::translate('LBL_IMPORT_STEP_3',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" name="auto_merge" onclick="ImportJs.toogleMergeConfiguration();" /></div><div class="col-xs-10"><span><?php echo \App\Language::translate('LBL_IMPORT_STEP_3_DESCRIPTION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span><span class="font-x-small">(<?php echo \App\Language::translate('LBL_IMPORT_STEP_3_DESCRIPTION_DETAILED',$_smarty_tpl->tpl_vars['MODULE']->value);?>
).</span></div><div class="col-xs-12"><div class='row' id="duplicates_merge_configuration" style="display:none;"><div class='col-xs-12 paddingBottom10'><div><div class="col-md-6 paddingLRZero"><span class="font-x-small"><?php echo \App\Language::translate('LBL_SPECIFY_MERGE_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span>&nbsp;&nbsp;</div><div class="col-md-6 paddingLRZero"><select name="merge_type" id="merge_type" class="font-x-small form-control" title="<?php echo \App\Language::translate('LBL_SPECIFY_MERGE_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['AUTO_MERGE_TYPES']->value, '_MERGE_TYPE_LABEL', false, '_MERGE_TYPE');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_MERGE_TYPE']->value => $_smarty_tpl->tpl_vars['_MERGE_TYPE_LABEL']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['_MERGE_TYPE']->value;?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['_MERGE_TYPE_LABEL']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div></div><div class='col-xs-12'><div class="font-x-small"><?php echo \App\Language::translate('LBL_SELECT_MERGE_FIELDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</div></div><div class='col-xs-12'><div class="row calDayHour"><div class='col-xs-12 '><div><strong><?php echo \App\Language::translate('LBL_AVAILABLE_FIELDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></div><div><strong><?php echo \App\Language::translate('LBL_SELECTED_FIELDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></div></div><div class='col-xs-12 row'><div class='col-xs-5'><select id="available_fields" multiple size="10" name="available_fields" title="<?php echo \App\Language::translate('LBL_AVAILABLE_FIELDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
'" class="txtBox" style="width: 100%"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['AVAILABLE_BLOCKS']->value, '_FIELDS', false, 'BLOCK_NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['BLOCK_NAME']->value => $_smarty_tpl->tpl_vars['_FIELDS']->value) {
?><optgroup label="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['BLOCK_NAME']->value,$_smarty_tpl->tpl_vars['FOR_MODULE']->value);?>
"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_FIELDS']->value, '_FIELD_INFO', false, '_FIELD_NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_FIELD_NAME']->value => $_smarty_tpl->tpl_vars['_FIELD_INFO']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['_FIELD_NAME']->value;?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['_FIELD_INFO']->value->getFieldLabel(),$_smarty_tpl->tpl_vars['FOR_MODULE']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</optgroup><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div><div class='col-xs-1'><div align="center"><input type="button" name="Button" value="&nbsp;&rsaquo;&rsaquo;&nbsp;" onClick="ImportJs.copySelectedOptions('#available_fields', '#selected_merge_fields')" class="crmButton font-x-small importButton" /><br /><br /><input type="button" name="Button1" value="&nbsp;&lsaquo;&lsaquo;&nbsp;" onClick="ImportJs.removeSelectedOptions('#selected_merge_fields')" class="crmButton font-x-small importButton" /><br /><br /></div></div><div class='col-xs-5'><input type="hidden" id="merge_fields" size="10" name="merge_fields" value="" /><select id="selected_merge_fields" size="10" name="selected_merge_fields" title="<?php echo \App\Language::translate('lBL_SELECTED_FIELDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" multiple class="txtBox" style="width: 100%"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['FOR_MODULE_MODEL']->value->getNameFields(), 'FIELD_NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_NAME']->value) {
$_smarty_tpl->_assignInScope('FIELD', $_smarty_tpl->tpl_vars['FOR_MODULE_MODEL']->value->getFieldByName($_smarty_tpl->tpl_vars['FIELD_NAME']->value));
?><option value="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD']->value->getFieldLabel(),$_smarty_tpl->tpl_vars['FOR_MODULE']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div></div></div></div></div></div>
<?php }
}
