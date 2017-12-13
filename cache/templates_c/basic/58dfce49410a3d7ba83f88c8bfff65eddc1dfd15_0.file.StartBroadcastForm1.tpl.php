<?php
/* Smarty version 3.1.31, created on 2017-12-09 11:46:15
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/IctBroadcast/StartBroadcastForm1.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2b86b7cbefa9_88977790',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '58dfce49410a3d7ba83f88c8bfff65eddc1dfd15' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/IctBroadcast/StartBroadcastForm1.tpl',
      1 => 1512801948,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2b86b7cbefa9_88977790 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="IctBroadcast" class='modelContainer modal fade' tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button data-dismiss="modal" class="close" title="<?php echo \App\Language::translate('LBL_CLOSE');?>
">&times;</button><h3 class="modal-title"><?php echo \App\Language::translate('ICTBroadcast',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h3></div><!--<form class="form-horizontal" id="massSave1" method="post" action="index.php" enctype="multipart/form-data">--><form class="form-horizontal recordEditView" id="ictbroadcastcampaign" name="EditView" method="post" action="index.php" enctype="multipart/form-data"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="source_module" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_MODULE']->value;?>
" /><input type="hidden" name="action" value="MassSaveAjax" /><input type="hidden" name="viewname" value="<?php echo $_smarty_tpl->tpl_vars['VIEWNAME']->value;?>
" /><input type="hidden" name="selected_ids" value='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SELECTED_IDS']->value);?>
'><input type="hidden" name="excluded_ids" value="<?php echo Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($_smarty_tpl->tpl_vars['EXCLUDED_IDS']->value));?>
"><input type="hidden" name="search_key" value= "<?php echo $_smarty_tpl->tpl_vars['SEARCH_KEY']->value;?>
" /><input type="hidden" name="operator" value="<?php echo $_smarty_tpl->tpl_vars['OPERATOR']->value;?>
" /><input type="hidden" name="search_value" value="<?php echo $_smarty_tpl->tpl_vars['ALPHABET_VALUE']->value;?>
" /><input type="hidden" name="search_params" value='<?php echo \App\Json::encode($_smarty_tpl->tpl_vars['SEARCH_PARAMS']->value);?>
' /><div class="modal-body"><!--<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;<?php echo \App\Language::translate('',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</div>--><div class="col-xs-12"><div class="form-group"><?php echo \App\Language::translate('New Contact Group',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<input type="text" name="group" class="form-control"></div><div class="form-group"><?php echo \App\Language::translate('Select Campaign Type',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<select name="campaing_type" id="c_type" class = "select2 form-control"><!--	<?php
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
--><option value="voice">Message Campaign</option><!-- <option value="voice_agent">Agent Campaign</option>--><option value="voice_interactive">Press 1 Campaign</option><!--  <option value="voice_ivr">IVR Campaign</option>--><option value="fax">Fax Campaign</option></select></div><div class="form-group" id="file"><?php echo \App\Language::translate('Choose File',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<input type="file" name="fle" class="input-large multi MultiFile-applied" ></div><div class="form-group" id="press1" style="display:none"><?php echo \App\Language::translate('Select Extension',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<select name="extension" class="select2 form-control"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Campaign_type']->value, 'Campaign_types');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['Campaign_types']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['Campaign_types']->value->extension_id;?>
"><?php echo $_smarty_tpl->tpl_vars['Campaign_types']->value->name;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div></div><div class="modal-footer"><button class="btn btn-success" type="submit" name="saveButton"><span class="glyphicon glyphicon-ok"></span>&nbsp;<strong><?php echo \App\Language::translate('LBL_SEND',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><button class="btn btn-warning" type="reset" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;<strong><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></div></form></div></div></div>
<?php echo '<script'; ?>
 type="text/javascript">
jQuery(document).ready(function() {

	  $("#c_type").change(function()
    {
        var id=$(this).val();

        var dataString = 'id='+ id;
        // alert(id); 
        if(id=='voice_interactive'){
        	// alert(id); 
          $("#file").show();
          $("#press1").show();

        }else{

        	$("#file").show();
        	$("#press1").hide();

        }
       
    });
});
<?php echo '</script'; ?>
><?php }
}
