<?php
/* Smarty version 3.1.31, created on 2017-12-07 10:01:21
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/StartBroadcastForm.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28cb21712585_95081536',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c05bab2f51dbae9e5284400ad7836b2ff5d1701a' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/StartBroadcastForm.tpl',
      1 => 1512622853,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28cb21712585_95081536 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="sendSmsContainer" class='modelContainer modal fade' tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button data-dismiss="modal" class="close" title="<?php echo \App\Language::translate('LBL_CLOSE');?>
">&times;</button><h3 class="modal-title"><?php echo \App\Language::translate('ICTBroadcast',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h3></div><form class="form-horizontal validateForm" id="massSave1" method="post" action="index.php"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="source_module" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_MODULE']->value;?>
" /><input type="hidden" name="action" value="MassSaveAjax" /><input type="hidden" name="viewname" value="<?php echo $_smarty_tpl->tpl_vars['VIEWNAME']->value;?>
" /><input type="hidden" name="selected_ids" value='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SELECTED_IDS']->value);?>
'><input type="hidden" name="excluded_ids" value="<?php echo Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($_smarty_tpl->tpl_vars['EXCLUDED_IDS']->value));?>
"><input type="hidden" name="search_key" value= "<?php echo $_smarty_tpl->tpl_vars['SEARCH_KEY']->value;?>
" /><input type="hidden" name="operator" value="<?php echo $_smarty_tpl->tpl_vars['OPERATOR']->value;?>
" /><input type="hidden" name="search_value" value="<?php echo $_smarty_tpl->tpl_vars['ALPHABET_VALUE']->value;?>
" /><input type="hidden" name="search_params" value='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SEARCH_PARAMS']->value);?>
' /><div class="modal-body"><div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;<?php echo \App\Language::translate('',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</div><div class="col-xs-12"><div class="form-group"><?php echo \App\Language::translate('New Contact Group',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<input type="text" name="group" class="form-control"></div><div class="form-group"><?php echo \App\Language::translate('Select Campaign Type',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<select name="campaing_type" class = "select2 form-control"><!--	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Campaign_type']->value, 'Campaign_types');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['Campaign_types']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['Campaign_types']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['Campaign_types']->value->name;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
--><option value="voice">Message Campaign</option><option value="voice_agent">Agent Campaign</option><option value="voice_interactive">Interactive Campaign</option><option value="voice_ivr">IVR Campaign</option><option value="fax">Fax Campaign</option></select></div></div></div><div class="modal-footer"><button class="btn btn-success" type="submit" name="saveButton"><span class="glyphicon glyphicon-ok"></span>&nbsp;<strong><?php echo \App\Language::translate('LBL_SEND',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><button class="btn btn-warning" type="reset" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;<strong><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></div></form></div></div></div>
<?php }
}
