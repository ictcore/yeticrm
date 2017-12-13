<?php
/* Smarty version 3.1.31, created on 2017-12-08 09:33:58
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/EditViewInventoryItem.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1636e20bf3_13650121',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '88109ef3a10c7b0265e8f51b4130cfaa38cd9bf7' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/EditViewInventoryItem.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1636e20bf3_13650121 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (!empty($_smarty_tpl->tpl_vars['ITEM_DATA']->value['name'])) {
$_smarty_tpl->_assignInScope('REFERENCE_MODULE', vtlib\Functions::getCRMRecordType($_smarty_tpl->tpl_vars['ITEM_DATA']->value['name']));
} elseif ($_smarty_tpl->tpl_vars['MAIN_PARAMS']->value) {
$_smarty_tpl->_assignInScope('REFERENCE_MODULE', $_smarty_tpl->tpl_vars['INVENTORY_FIELD']->value->getDefaultModule($_smarty_tpl->tpl_vars['MAIN_PARAMS']->value));
}
if ($_smarty_tpl->tpl_vars['REFERENCE_MODULE']->value) {?><tr class="inventoryRow" numrow="<?php echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
"><td><span class="glyphicon glyphicon-trash deleteRow cursorPointer <?php if (!$_smarty_tpl->tpl_vars['IS_OPTIONAL_ITEMS']->value && $_smarty_tpl->tpl_vars['KEY']->value == 0) {?>hide<?php }?>" title="<?php echo \App\Language::translate('LBL_DELETE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></span>&nbsp;&nbsp;<a class="dragHandle"><img src="<?php echo vimage_path('drag.png');?>
" border="0" alt="<?php echo \App\Language::translate('LBL_DRAG',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"/></a><input name="seq<?php echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" class="sequence" /><?php if ($_smarty_tpl->tpl_vars['COUNT_FIELDS2']->value > 0) {?><br /><br /><span class="btn btn-default btn-xs toggleVisibility" data-status="0" href="#"><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></span><?php }?></td><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['FIELDS']->value[1], 'FIELD');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD']->value) {
?><td class="col<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getName();
if (!$_smarty_tpl->tpl_vars['FIELD']->value->isEditable()) {?> hide<?php }?> textAlignRight fieldValue"><?php $_smarty_tpl->_assignInScope('FIELD_TPL_NAME', ("inventoryfields/").($_smarty_tpl->tpl_vars['FIELD']->value->getTemplateName('EditView',$_smarty_tpl->tpl_vars['MODULE']->value)));
$_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FIELD_TPL_NAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('ITEM_VALUE'=>$_smarty_tpl->tpl_vars['ITEM_DATA']->value[$_smarty_tpl->tpl_vars['FIELD']->value->get('columnname')]), 0, true);
?>
</td><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</tr><?php if ($_smarty_tpl->tpl_vars['FIELDS']->value[2] != 0) {?><tr class="inventoryRowExpanded numRow<?php echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
 hide" numrowex="<?php echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
"><td class="colExpanded" colspan="<?php echo $_smarty_tpl->tpl_vars['COUNT_FIELDS1']->value+1;?>
"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['FIELDS']->value[2], 'FIELD');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD']->value) {
$_smarty_tpl->_assignInScope('FIELD_TPL_NAME', ("inventoryfields/").($_smarty_tpl->tpl_vars['FIELD']->value->getTemplateName('EditView',$_smarty_tpl->tpl_vars['MODULE']->value)));
$_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FIELD_TPL_NAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('ITEM_VALUE'=>$_smarty_tpl->tpl_vars['ITEM_DATA']->value[$_smarty_tpl->tpl_vars['FIELD']->value->get('columnname')]), 0, true);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</td></tr><?php }
}
}
}
