<?php
/* Smarty version 3.1.31, created on 2017-12-08 10:10:03
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Import/Import_Basic_Buttons.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1eab0bf389_60728880',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'daa335a2863c8ed86409d4319a5c2b2cad63924d' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Import/Import_Basic_Buttons.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1eab0bf389_60728880 (Smarty_Internal_Template $_smarty_tpl) {
?>


<button type="submit" name="next"  class="btn btn-success"
		onclick="return ImportJs.uploadAndParse();"><strong><?php echo \App\Language::translate('LBL_NEXT_BUTTON_LABEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>
&nbsp;&nbsp;
<button class="btn btn-warning" type="reset"
		<?php if ($_smarty_tpl->tpl_vars['FOR_MODULE']->value == 'Users') {?>
			onclick="location.href = 'index.php?module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&view=List&parent=Settings'"
		<?php } else { ?>
			onclick="location.href = 'index.php?module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&view=List'"
		<?php }?>
><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button>
<?php }
}
