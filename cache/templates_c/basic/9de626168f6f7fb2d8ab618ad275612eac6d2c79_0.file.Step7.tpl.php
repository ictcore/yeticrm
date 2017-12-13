<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:26:36
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step7.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279bac401947_55793030',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9de626168f6f7fb2d8ab618ad275612eac6d2c79' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step7.tpl',
      1 => 1502282094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279bac401947_55793030 (Smarty_Internal_Template $_smarty_tpl) {
?>

<form class="form-horizontal" name="step7" method="post" action="../index.php?module=Users&action=Login"><input type="hidden" name="mode" value="install" ><input type="hidden" name="username" value="admin" ><input type="hidden" name="password" value="<?php echo $_smarty_tpl->tpl_vars['PASSWORD']->value;?>
" ></form><?php echo '<script'; ?>
 type="text/javascript">
		window.localStorage.removeItem('yetiforce_install');
		jQuery(function () { /* Delay to let page load complete */
			setTimeout(function () {
				jQuery('form[name="step7"]').submit();
			}, 150);
		});
	<?php echo '</script'; ?>
>
<?php }
}
