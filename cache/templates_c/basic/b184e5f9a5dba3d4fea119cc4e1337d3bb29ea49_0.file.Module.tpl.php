<?php
/* Smarty version 3.1.31, created on 2017-12-07 11:21:15
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Menu/types/Module.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28dddba4bcd2_52595009',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b184e5f9a5dba3d4fea119cc4e1337d3bb29ea49' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Menu/types/Module.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28dddba4bcd2_52595009 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="form-group">
	<label class="col-md-4 control-label"><?php echo \App\Language::translate('LBL_SELECT_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
:</label>
	<div class="col-md-7">
		<select name="module" class="select2 type form-control">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getModulesList(), 'ITEM');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ITEM']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['tabid'];?>
" <?php if ($_smarty_tpl->tpl_vars['RECORD']->value && $_smarty_tpl->tpl_vars['ITEM']->value['tabid'] == $_smarty_tpl->tpl_vars['RECORD']->value->get('module')) {?> selected="" <?php }?>><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['ITEM']->value['name'],$_smarty_tpl->tpl_vars['ITEM']->value['name']);?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label"><?php echo \App\Language::translate('LBL_LABEL_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
:</label>
	<div class="col-md-7">
		<input name="label" class="form-control" type="text" value="<?php if ($_smarty_tpl->tpl_vars['RECORD']->value) {
echo $_smarty_tpl->tpl_vars['RECORD']->value->get('label');
}?>" />
	</div>
</div>
<?php $_smarty_tpl->_subTemplateRender(vtemplate_path('fields/Newwindow.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender(vtemplate_path('fields/Hotkey.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_assignInScope('FILTERS', explode(',',$_smarty_tpl->tpl_vars['RECORD']->value->get('filters')));
?>
<div class="form-group">
	<label class="col-md-4 control-label"><?php echo \App\Language::translate('LBL_AVAILABLE_FILTERS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
:</label>
	<div class="col-md-7">
		<select name="filters" multiple class="select2 type form-control">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getCustomViewList(), 'ITEM');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ITEM']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['cvid'];?>
" <?php if ($_smarty_tpl->tpl_vars['RECORD']->value && in_array($_smarty_tpl->tpl_vars['ITEM']->value['cvid'],$_smarty_tpl->tpl_vars['FILTERS']->value)) {?> selected="" <?php }?> data-tabid="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['tabid'];?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['ITEM']->value['viewname'],$_smarty_tpl->tpl_vars['ITEM']->value['entitytype']);?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label"><?php echo \App\Language::translate('LBL_ICON_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
:</label>
	<div class="col-md-7">
		<div class="input-group">
			<input name="icon" class="form-control" type="text" value="<?php if ($_smarty_tpl->tpl_vars['RECORD']->value) {
echo $_smarty_tpl->tpl_vars['RECORD']->value->get('icon');
}?>"/>
			<span class="input-group-btn">
				<button id="selectIconButton" class="btn btn-default" title="<?php echo \App\Language::translate('LBL_SELECT_ICON',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" type="button"><span class="glyphicon glyphicon-info-sign"></span></button>
			</span>
		</div>
	</div>
</div>
<?php }
}
