<?php
/* Smarty version 3.1.31, created on 2017-12-07 12:57:19
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/TreeFieldSearchView.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28f45fc04bc9_06412970',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '573e0ef629da7d4a47313e655e63b9ff3a9843c7' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/uitypes/TreeFieldSearchView.tpl',
      1 => 1502273912,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28f45fc04bc9_06412970 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('FIELD_INFO', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo());
$_smarty_tpl->_assignInScope('ALL_VALUES', $_smarty_tpl->tpl_vars['FIELD_INFO']->value['picklistvalues']);
if (isset($_smarty_tpl->tpl_vars['SEARCH_INFO']->value['searchValue'])) {
$_smarty_tpl->_assignInScope('SEARCH_VALUES', explode(',',$_smarty_tpl->tpl_vars['SEARCH_INFO']->value['searchValue']));
} else {
$_smarty_tpl->_assignInScope('SEARCH_VALUES', array());
}?><div class="picklistSearchField"><select id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
" class="select2noactive listSearchContributor tree form-control" title="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
" multiple name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
"  data-fieldinfo='<?php echo htmlspecialchars(\App\Json::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value), ENT_QUOTES, 'UTF-8', true);?>
'><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ALL_VALUES']->value, 'LABEL', false, 'KEY');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['KEY']->value => $_smarty_tpl->tpl_vars['LABEL']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['KEY']->value;?>
"  data-parent="<?php echo $_smarty_tpl->tpl_vars['LABEL']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['KEY']->value,$_smarty_tpl->tpl_vars['SEARCH_VALUES']->value) && ($_smarty_tpl->tpl_vars['KEY']->value != '')) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['LABEL']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div>
<?php }
}
