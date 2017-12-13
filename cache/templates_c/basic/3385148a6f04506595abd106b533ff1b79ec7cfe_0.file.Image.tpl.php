<?php
/* Smarty version 3.1.31, created on 2017-12-08 09:35:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/Image.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1691214b31_53954171',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3385148a6f04506595abd106b533ff1b79ec7cfe' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/Image.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1691214b31_53954171 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('FIELD_INFO', Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo())));
$_smarty_tpl->_assignInScope('SPECIAL_VALIDATOR', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator());
?><input type="file" class="input-large <?php if ($_smarty_tpl->tpl_vars['MODULE']->value == 'Products') {?>multi" title="<?php echo \App\Language::translate('LBL_SELECT_FILE');?>
" maxlength="6"<?php } else { ?>"<?php }?> name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue');?>
"data-validation-engine="validate[<?php if (($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory() == true) && (empty($_smarty_tpl->tpl_vars['IMAGE_DETAILS']->value))) {?> required,<?php }?>funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"data-fieldinfo='<?php echo $_smarty_tpl->tpl_vars['FIELD_INFO']->value;?>
' <?php if (!empty($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value)) {?>data-validator=<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value);
}?> /><?php if ($_smarty_tpl->tpl_vars['MODULE']->value == 'Products') {?><div id="MultiFile1_wrap_list" class="MultiFile-list"></div><?php }
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['IMAGE_DETAILS']->value, 'IMAGE_INFO', false, 'ITER');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ITER']->value => $_smarty_tpl->tpl_vars['IMAGE_INFO']->value) {
?><div class="row"><?php ob_start();
echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];
$_prefixVariable1=ob_get_clean();
if (!empty($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path']) && !empty($_prefixVariable1)) {?><span class="col-md-8" name="existingImages"><img src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path']));?>
" alt="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
" data-image-id="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['id'];?>
" class="img-responsive"></span><span class="col-md-12"><span class="">[<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['name'];?>
]</span>&nbsp;<span class=""><input type="button" id="file_<?php echo $_smarty_tpl->tpl_vars['ITER']->value;?>
" value="<?php echo \App\Language::translate('LBL_DELETE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" class="imageDelete"></span></span><?php }?></div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

<?php }
}
