<?php
/* Smarty version 3.1.31, created on 2017-12-08 10:58:34
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Calendar/uitypes/ActivityPicklistFieldSearchView.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a2a0a90c967_03631829',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ee9b9033362ee3e35b7459f28935026a2b4f655' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Calendar/uitypes/ActivityPicklistFieldSearchView.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a2a0a90c967_03631829 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('FIELD_INFO', \App\Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo()));
$_smarty_tpl->_assignInScope('PICKLIST_VALUES', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues());
$_smarty_tpl->_assignInScope('SEARCH_VALUES', explode(',',$_smarty_tpl->tpl_vars['SEARCH_INFO']->value['searchValue']));
?><div class="picklistSearchField"><select class="select2 listSearchContributor" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
" title="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
" multiple data-fieldinfo='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD_INFO']->value, ENT_QUOTES, 'UTF-8', true);?>
'><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value, 'PICKLIST_LABEL', false, 'PICKLIST_KEY');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_KEY']->value => $_smarty_tpl->tpl_vars['PICKLIST_LABEL']->value) {
?><option title="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['PICKLIST_LABEL']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
" value="<?php echo $_smarty_tpl->tpl_vars['PICKLIST_KEY']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['PICKLIST_KEY']->value,$_smarty_tpl->tpl_vars['SEARCH_VALUES']->value)) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['PICKLIST_LABEL']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
<option value="Task" title="<?php echo \App\Language::translate('LBL_TODOS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" <?php if (in_array("Task",$_smarty_tpl->tpl_vars['SEARCH_VALUES']->value)) {?> selected<?php }?>><?php echo \App\Language::translate('LBL_TODOS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option></select></div>

<?php }
}
