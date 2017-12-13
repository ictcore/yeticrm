<?php
/* Smarty version 3.1.31, created on 2017-12-06 14:22:37
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/SendSMSForm.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a27b6dd943f85_22427229',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c07a91782d1be577c2158236b7f5d4dbd71a810' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/SendSMSForm.tpl',
      1 => 1512552092,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a27b6dd943f85_22427229 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="sendSmsContainer" class='modelContainer modal fade' tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button data-dismiss="modal" class="close" title="<?php echo \App\Language::translate('LBL_CLOSE');?>
">&times;</button><h3 class="modal-title"><?php echo \App\Language::translate('LBL_SEND_SMS_TO_SELECTED_NUMBERS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h3></div><form class="form-horizontal validateForm" id="massSave" method="post" action="index.php"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="source_module" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_MODULE']->value;?>
" /><input type="hidden" name="action" value="MassSaveAjax" /><input type="hidden" name="viewname" value="<?php echo $_smarty_tpl->tpl_vars['VIEWNAME']->value;?>
" /><input type="hidden" name="selected_ids" value='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SELECTED_IDS']->value);?>
'><input type="hidden" name="excluded_ids" value="<?php echo Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($_smarty_tpl->tpl_vars['EXCLUDED_IDS']->value));?>
"><input type="hidden" name="search_key" value= "<?php echo $_smarty_tpl->tpl_vars['SEARCH_KEY']->value;?>
" /><input type="hidden" name="operator" value="<?php echo $_smarty_tpl->tpl_vars['OPERATOR']->value;?>
" /><input type="hidden" name="search_value" value="<?php echo $_smarty_tpl->tpl_vars['ALPHABET_VALUE']->value;?>
" /><input type="hidden" name="search_params" value='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SEARCH_PARAMS']->value);?>
' /><div class="modal-body"><div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;<?php echo \App\Language::translate('LBL_MASS_SEND_SMS_INFO',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</div><div class="col-xs-12"><div class="form-group"><span><strong><?php echo \App\Language::translate('LBL_STEP_1',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></span>&nbsp;:&nbsp;<?php echo \App\Language::translate('LBL_SELECT_THE_PHONE_NUMBER_FIELDS_TO_SEND',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<select name="fields[]" data-placeholder="<?php echo \App\Language::translate('LBL_ADD_MORE_FIELDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" multiple class="select2 form-control" data-validation-engine="validate[ required]"><optgroup><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PHONE_FIELDS']->value, 'PHONE_FIELD');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PHONE_FIELD']->value) {
if ($_smarty_tpl->tpl_vars['PHONE_FIELD']->value->isEditable() == false) {?> <?php
continue 1;?> <?php }
$_smarty_tpl->_assignInScope('PHONE_FIELD_NAME', $_smarty_tpl->tpl_vars['PHONE_FIELD']->value->get('name'));
?><option value="<?php echo $_smarty_tpl->tpl_vars['PHONE_FIELD_NAME']->value;?>
"><?php if (!empty($_smarty_tpl->tpl_vars['SINGLE_RECORD']->value)) {
$_smarty_tpl->_assignInScope('FIELD_VALUE', $_smarty_tpl->tpl_vars['SINGLE_RECORD']->value->get($_smarty_tpl->tpl_vars['PHONE_FIELD_NAME']->value));
}
echo \App\Language::translate($_smarty_tpl->tpl_vars['PHONE_FIELD']->value->get('label'),$_smarty_tpl->tpl_vars['SOURCE_MODULE']->value);
if (!empty($_smarty_tpl->tpl_vars['FIELD_VALUE']->value)) {?> (<?php echo $_smarty_tpl->tpl_vars['FIELD_VALUE']->value;?>
)<?php }?></option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</optgroup></select></div><div class="form-group"><span><strong><?php echo \App\Language::translate('LBL_STEP_2',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></span>&nbsp;:&nbsp;<?php echo \App\Language::translate('LBL_TYPE_THE_MESSAGE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
&nbsp;(&nbsp;<?php echo \App\Language::translate('LBL_SMS_MAX_CHARACTERS_ALLOWED',$_smarty_tpl->tpl_vars['MODULE']->value);?>
&nbsp;)<textarea class="input-xxlarge form-control" name="message" id="message" placeholder="<?php echo \App\Language::translate('LBL_WRITE_YOUR_MESSAGE_HERE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-validation-engine="validate[ required]"></textarea></div></div></div><div class="modal-footer"><button class="btn btn-success" type="submit" name="saveButton"><span class="glyphicon glyphicon-ok"></span>&nbsp;<strong><?php echo \App\Language::translate('LBL_SEND',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><button class="btn btn-warning" type="reset" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;<strong><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></div></form></div></div></div>
<?php }
}
