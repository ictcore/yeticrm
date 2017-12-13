<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:20:43
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279a4bb885b8_25398104',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7a2605da65846bb6bc61668f2fcd4fcbc422ff9e' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Header.tpl',
      1 => 1502282096,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279a4bb885b8_25398104 (Smarty_Internal_Template $_smarty_tpl) {
?>

<!DOCTYPE html><html lang="<?php echo $_smarty_tpl->tpl_vars['HTMLLANG']->value;?>
"><head><title>YetiForce</title><link REL="SHORTCUT ICON" HREF="../<?php echo vimage_path('favicon.ico');?>
"><meta name="viewport" content="width=device-width, initial-scale=1.0" /><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['STYLES']->value, 'cssModel', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['cssModel']->value) {
?><link rel="<?php echo $_smarty_tpl->tpl_vars['cssModel']->value->getRel();?>
" href="../<?php echo $_smarty_tpl->tpl_vars['cssModel']->value->getHref();?>
" /><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['HEADER_SCRIPTS']->value, 'jsModel', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['jsModel']->value) {
echo '<script'; ?>
 type="<?php echo $_smarty_tpl->tpl_vars['jsModel']->value->getType();?>
" src="../<?php echo $_smarty_tpl->tpl_vars['jsModel']->value->getSrc();?>
"><?php echo '</script'; ?>
><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
<style type="text/css">@media print {.noprint { display:none; }}</style><!--[if IE]><?php echo '<script'; ?>
 type="text/javascript" src="public_html/libraries/html5shim/html5shiv.min.js"><?php echo '</script'; ?>
><?php echo '<script'; ?>
 type="text/javascript" src="public_html/libraries/html5shim/respond.min.js"><?php echo '</script'; ?>
><![endif]--></head><body data-language="<?php echo $_smarty_tpl->tpl_vars['LANGUAGE']->value;?>
"><div id="js_strings" class="hide noprint"><?php echo \App\Json::encode($_smarty_tpl->tpl_vars['LANGUAGE_STRINGS']->value);?>
</div><input type="hidden" id="start_day" value="" /><input type="hidden" id="row_type" value="" /><input type="hidden" id="current_user_id" value="" /><div id="page">
<?php }
}
