<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:30:26
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/ListViewAlphabet.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279c92e6e459_72725760',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '29fea5a4646ba0a07e46647b57047210d67ac2ab' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/ListViewAlphabet.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279c92e6e459_72725760 (Smarty_Internal_Template $_smarty_tpl) {
?>

<input type="hidden" id="alphabetSearchKey" value= "<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getAlphabetSearchField();?>
" /><input type="hidden" id="Operator" value="<?php echo $_smarty_tpl->tpl_vars['OPERATOR']->value;?>
" /><input type="hidden" id="alphabetValue" value="<?php echo $_smarty_tpl->tpl_vars['ALPHABET_VALUE']->value;?>
" /><?php $_smarty_tpl->_assignInScope('ALPHABETS_LABEL', \App\Language::translate('LBL_ALPHABETS','Vtiger'));
$_smarty_tpl->_assignInScope('ALPHABETS', explode(',',$_smarty_tpl->tpl_vars['ALPHABETS_LABEL']->value));
?><div class="alphabetModal" tabindex="-1"><div class="modal fade "><div class="modal-dialog "><div class="modal-content"><div class="modal-header"><div class="row no-margin"><div class="col-md-7 col-xs-10"><h3 class="modal-title"><?php echo \App\Language::translate('LBL_ALPHABETIC_FILTERING',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h3></div><div class="pull-right"><div class="pull-right"><button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</button></div></div></div></div><?php $_smarty_tpl->_assignInScope('COUNT_ALPHABETS', count($_smarty_tpl->tpl_vars['ALPHABETS']->value));
?><div class="modal-body"><div class="alphabetSorting noprint paddingLRZero"><div class="alphabetContents alphabet_<?php echo $_smarty_tpl->tpl_vars['COUNT_ALPHABETS']->value;?>
 row "><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ALPHABETS']->value, 'ALPHABET');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ALPHABET']->value) {
?><div class="alphabetSearch cursorPointer"><a class="btn <?php if (isset($_smarty_tpl->tpl_vars['ALPHABET_VALUE']->value) && $_smarty_tpl->tpl_vars['ALPHABET_VALUE']->value == $_smarty_tpl->tpl_vars['ALPHABET']->value) {?>btn-primary<?php } else { ?>btn-default<?php }?>" id="<?php echo $_smarty_tpl->tpl_vars['ALPHABET']->value;?>
" href="#"><?php echo $_smarty_tpl->tpl_vars['ALPHABET']->value;?>
</a></div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div></div></div><div class="modal-footer"><div class="pull-right"><button class="btn btn-danger removeAlfabetCondition" type="button" title="<?php echo \App\Language::translate('LBL_REMOVE_ALPH_SEARCH_INFO',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" ><?php echo \App\Language::translate('LBL_REMOVE_FILTERING',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</button ></div></div></div></div></div></div>
<?php }
}
