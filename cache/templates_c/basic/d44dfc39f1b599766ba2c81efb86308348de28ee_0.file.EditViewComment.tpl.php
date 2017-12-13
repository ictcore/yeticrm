<?php
/* Smarty version 3.1.31, created on 2017-12-08 09:33:59
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewComment.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1637053361_39473553',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd44dfc39f1b599766ba2c81efb86308348de28ee' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/inventoryfields/EditViewComment.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1637053361_39473553 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('VALUE', $_smarty_tpl->tpl_vars['FIELD']->value->getValue($_smarty_tpl->tpl_vars['ITEM_VALUE']->value));
?><textarea name="<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getColumnName();
echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" title="<?php echo \App\Language::translate("LBL_ROW_COMMENT",$_smarty_tpl->tpl_vars['MODULE']->value);?>
" id="editView_comment<?php echo $_smarty_tpl->tpl_vars['FIELD']->value->getColumnName();
echo $_smarty_tpl->tpl_vars['ROW_NO']->value;?>
" data-fieldinfo="<?php echo htmlspecialchars(\App\Json::encode(array('mandatory'=>false)), ENT_QUOTES, 'UTF-8', true);?>
"class="comment commentTextarea form-control <?php if ($_smarty_tpl->tpl_vars['INVENTORY_FIELD']->value->isWysiwygType($_smarty_tpl->tpl_vars['REFERENCE_MODULE']->value)) {?>ckEditorSource ckEditorBasic<?php }?>" <?php if ($_smarty_tpl->tpl_vars['FIELD']->value->get('displaytype') == 10) {?>readonly="readonly"<?php }?>><?php echo $_smarty_tpl->tpl_vars['VALUE']->value;?>
</textarea>
<?php }
}
