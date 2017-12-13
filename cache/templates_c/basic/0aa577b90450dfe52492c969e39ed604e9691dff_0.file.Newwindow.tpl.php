<?php
/* Smarty version 3.1.31, created on 2017-12-07 11:21:15
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Menu/fields/Newwindow.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28dddba60d27_49597660',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0aa577b90450dfe52492c969e39ed604e9691dff' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Menu/fields/Newwindow.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28dddba60d27_49597660 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="form-group">
	<label class="col-md-4 control-label"><?php echo \App\Language::translate('LBL_NEW_WINDOW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
:</label>
	<div class="col-md-7 checkboxForm">
		<input name="newwindow" type="checkbox" value="1" <?php if ($_smarty_tpl->tpl_vars['RECORD']->value && $_smarty_tpl->tpl_vars['RECORD']->value->get('newwindow') == 1) {?> checked="checked" <?php }?>/>
	</div>
</div>
<?php }
}
