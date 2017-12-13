<?php
/* Smarty version 3.1.31, created on 2017-12-08 10:10:03
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Import/Import_Step2.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1eab084646_43034088',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '55aadf589700fe907c9b3378a5021cea318e231c' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Import/Import_Step2.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1eab084646_43034088 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class='col-md-12 paddingLRZero'><div><div><strong><?php echo \App\Language::translate('LBL_IMPORT_STEP_2',$_smarty_tpl->tpl_vars['MODULE']->value);?>
: </strong> <?php echo \App\Language::translate('LBL_IMPORT_STEP_2_DESCRIPTION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</div><div>&nbsp;</div></div><div id="file_type_container"><div class="col-md-4"><span><?php echo \App\Language::translate('LBL_FILE_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></div><div class="col-md-6 paddingBottom10"><select name="type" class="form-control" id="type" title="<?php echo \App\Language::translate('LBL_FILE_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" onchange="ImportJs.handleFileTypeChange();"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SUPPORTED_FILE_TYPES']->value, '_FILE_TYPE');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_FILE_TYPE']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['_FILE_TYPE']->value;?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['_FILE_TYPE']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div><div id="file_encoding_container"><div class="col-md-4"><span><?php echo \App\Language::translate('LBL_CHARACTER_ENCODING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></div><div class="col-md-6 paddingBottom10"><select name="file_encoding" class="form-control" id="file_encoding" title="<?php echo \App\Language::translate('{LBL_CHARACTER_ENCODING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SUPPORTED_FILE_ENCODING']->value, '_FILE_ENCODING_LABEL', false, '_FILE_ENCODING');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_FILE_ENCODING']->value => $_smarty_tpl->tpl_vars['_FILE_ENCODING_LABEL']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['_FILE_ENCODING']->value;?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['_FILE_ENCODING_LABEL']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div><div id="delimiter_container"><div class="col-md-4"><span><?php echo \App\Language::translate('LBL_DELIMITER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></div><div class="col-md-6 paddingBottom10"><select name="delimiter" class="form-control" id="delimiter" title="<?php echo \App\Language::translate('LBL_DELIMITER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SUPPORTED_DELIMITERS']->value, '_DELIMITER_LABEL', false, '_DELIMITER');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['_DELIMITER']->value => $_smarty_tpl->tpl_vars['_DELIMITER_LABEL']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['_DELIMITER']->value;?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['_DELIMITER_LABEL']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div><div id="zipExtension" class="hide"><div class="col-md-4"><span><?php echo \App\Language::translate('LBL_EXTENSION_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></div><div class="col-md-6 paddingBottom10"><select name="extension" class="chzn-select" id="extension" title="<?php echo \App\Language::translate('LBL_EXTENSION_TYPE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><option value="xml">XML</option></select></div></div><div id="xml_tpl" class="hide"><div class="col-md-4"><span><?php echo \App\Language::translate('LBL_XML_EXPORT_TPL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></div><div class="col-md-6 paddingBottom10"><select name="xml_import_tpl" class="chzn-select" id="xml_import_tpl" title="<?php echo \App\Language::translate('LBL_XML_EXPORT_TPL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><option value=""><?php echo \App\Language::translate('LBL_NONE','Import');?>
</option><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['XML_IMPORT_TPL']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['item']->value,'Import');?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div><div id="has_header_container"><div class="col-md-4"><span><?php echo \App\Language::translate('LBL_HAS_HEADER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></div><div class="col-md-6"><input type="checkbox" id="has_header" name="has_header" title="<?php echo \App\Language::translate('LBL_HAS_HEADER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" checked /></div></div></div>
<?php }
}
