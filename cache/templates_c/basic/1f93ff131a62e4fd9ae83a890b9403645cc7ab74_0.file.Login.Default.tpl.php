<?php
/* Smarty version 3.1.31, created on 2017-12-07 09:16:35
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Users/Login.Default.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28c0a36931d1_12141738',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1f93ff131a62e4fd9ae83a890b9403645cc7ab74' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Users/Login.Default.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28c0a36931d1_12141738 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('MODULE', 'Users');
?><div class="container"><div id="login-area" class="login-area"><div class="login-space"></div><div class="logo"><img title="<?php echo $_smarty_tpl->tpl_vars['COMPANY_DETAILS']->value->get('name');?>
" height="<?php echo $_smarty_tpl->tpl_vars['COMPANY_DETAILS']->value->get('logo_login_height');?>
px" class="logo" src="<?php echo $_smarty_tpl->tpl_vars['COMPANY_DETAILS']->value->getLogo('logo_login')->get('imageUrl');?>
" alt="<?php echo $_smarty_tpl->tpl_vars['COMPANY_DETAILS']->value->get('name');?>
"></div><div class="" id="loginDiv"><div class='fieldContainer marginLeft0 marginRight0 row col-md-12'><form class="login-form" action="index.php?module=Users&action=Login" method="POST" <?php if (!AppConfig::security('LOGIN_PAGE_REMEMBER_CREDENTIALS')) {?>autocomplete="off"<?php }?>><div class='marginLeft0  marginRight0 row col-xs-10'><div class="form-group first-group has-feedback"><label for="username" class="sr-only"><?php echo \App\Language::translate('LBL_USER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><input name="username" type="text" id="username" class="form-control input-lg" <?php if (vglobal('systemMode') == 'demo') {?>value="demo"<?php }?> placeholder="<?php echo \App\Language::translate('LBL_USER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" required="" <?php if (!AppConfig::security('LOGIN_PAGE_REMEMBER_CREDENTIALS')) {?>autocomplete="off"<?php }?> autofocus=""><span class="adminIcon-user form-control-feedback" aria-hidden="true"></span></div><div class="form-group <?php if ($_smarty_tpl->tpl_vars['LANGUAGE_SELECTION']->value || $_smarty_tpl->tpl_vars['LAYOUT_SELECTION']->value) {?>first-group <?php }?> has-feedback"><label for="password" class="sr-only"><?php echo \App\Language::translate('Password',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><input name="password" type="password" class="form-control input-lg" title="<?php echo \App\Language::translate('Password',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" id="password" name="password" <?php if (vglobal('systemMode') == 'demo') {?>value="demo"<?php }?> <?php if (!AppConfig::security('LOGIN_PAGE_REMEMBER_CREDENTIALS')) {?>autocomplete="off"<?php }?> placeholder="<?php echo \App\Language::translate('Password',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><span class="userIcon-OSSPasswords form-control-feedback" aria-hidden="true"></span></div><?php $_smarty_tpl->_assignInScope('COUNTERFIELDS', 2);
if ($_smarty_tpl->tpl_vars['LANGUAGE_SELECTION']->value) {
$_smarty_tpl->_assignInScope('COUNTERFIELDS', $_smarty_tpl->tpl_vars['COUNTERFIELDS']->value+1);
$_smarty_tpl->_assignInScope('DEFAULT_LANGUAGE', AppConfig::main('default_language'));
?><div class="form-group <?php if ($_smarty_tpl->tpl_vars['LAYOUT_SELECTION']->value) {?>first-group <?php }?>"><select class="input-lg form-control" title="<?php echo \App\Language::translate('LBL_CHOOSE_LANGUAGE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" name="loginLanguage"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, Vtiger_Language_Handler::getAllLanguages(), 'VALUE', false, 'KEY');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['KEY']->value => $_smarty_tpl->tpl_vars['VALUE']->value) {
?><option <?php if ($_smarty_tpl->tpl_vars['KEY']->value == $_smarty_tpl->tpl_vars['DEFAULT_LANGUAGE']->value) {?> selected <?php }?>  value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['KEY']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['VALUE']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div><?php }
if ($_smarty_tpl->tpl_vars['LAYOUT_SELECTION']->value) {
$_smarty_tpl->_assignInScope('COUNTERFIELDS', $_smarty_tpl->tpl_vars['COUNTERFIELDS']->value+1);
?><div class="form-group"><select class="input-lg form-control" title="<?php echo \App\Language::translate('LBL_SELECT_LAYOUT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" name="layout"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, \App\Layout::getAllLayouts(), 'VALUE', false, 'KEY');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['KEY']->value => $_smarty_tpl->tpl_vars['VALUE']->value) {
?><option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['KEY']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['VALUE']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div><?php }?></div><div class='col-xs-2 marginRight0' ><button class="btn btn-lg btn-primary btn-block heightDiv_<?php echo $_smarty_tpl->tpl_vars['COUNTERFIELDS']->value;?>
" type="submit" title="<?php echo \App\Language::translate('LBL_SIGN_IN',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"><strong>></strong></button></div></form></div><?php if (AppConfig::security('RESET_LOGIN_PASSWORD')) {?><div class="form-group"><div class=""><a href="#" id="forgotpass" ><?php echo \App\Language::translate('ForgotPassword',$_smarty_tpl->tpl_vars['MODULE']->value);?>
?</a></div></div><?php }?><div class="form-group col-xs-12 noPadding"><?php if ($_smarty_tpl->tpl_vars['ERROR']->value == 1) {?><div class="alert alert-warning"><p><?php echo \App\Language::translate('Invalid username or password.',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</p></div><?php }
if ($_smarty_tpl->tpl_vars['ERROR']->value == 2) {?><div class="alert alert-warning"><p><?php echo \App\Language::translate('Too many failed login attempts.',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</p></div><?php }
if ($_smarty_tpl->tpl_vars['FPERROR']->value) {?><div class="alert alert-warning"><p><?php echo \App\Language::translate('Invalid Username or Email address.',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</p></div><?php }
if ($_smarty_tpl->tpl_vars['STATUS']->value) {?><div class="alert alert-success"><p><?php echo \App\Language::translate('LBL_MAIL_WAITING_TO_SENT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</p></div><?php }
if ($_smarty_tpl->tpl_vars['STATUS_ERROR']->value) {?><div class="alert alert-warning"><p><?php echo \App\Language::translate('Outgoing mail server was not configured.',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</p></div><?php }?></div></div><?php if (AppConfig::security('RESET_LOGIN_PASSWORD')) {?><div class="hide" id="forgotPasswordDiv"><div class='fieldContainer marginLeft0 marginRight0 row col-md-12'><form class="login-form" action="modules/Users/actions/ForgotPassword.php" method="POST"><div class='marginLeft0  marginRight0 row col-xs-10'><div class="form-group first-group has-feedback"><label for="username" class="sr-only"><?php echo \App\Language::translate('LBL_USER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><input type="text" class="form-control input-lg" title="<?php echo \App\Language::translate('LBL_USER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" id="username" name="user_name" placeholder="<?php echo \App\Language::translate('LBL_USER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><span class="adminIcon-user form-control-feedback" aria-hidden="true"></span></div><div class="form-group has-feedback"><label for="emailId" class="sr-only"><?php echo \App\Language::translate('LBL_EMAIL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><input type="text" class="form-control input-lg" autocomplete="off" title="<?php echo \App\Language::translate('LBL_EMAIL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" id="emailId" name="emailId" placeholder="Email"><span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span></div></div><div class='col-xs-2 marginRight0' ><button type="submit" style='height:102px' id="retrievePassword" class="btn btn-lg btn-primary btn-block sbutton" title="Retrieve Password"><strong>></strong></button></div></form></div><div class="login-text form-group"><a href="#" id="backButton" ><?php echo \App\Language::translate('LBL_TO_CRM',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></div></div><?php }?></div></div><?php echo '<script'; ?>
>
		jQuery(document).ready(function () {
			jQuery("button.close").click(function () {
				jQuery(".visible-phone").css('visibility', 'hidden');
			});
			jQuery("a#forgotpass").click(function () {
				jQuery("#loginDiv").hide();
				jQuery("#forgotPasswordDiv").removeClass('hide');
				jQuery("#forgotPasswordDiv").show();
			});

			jQuery("a#backButton").click(function () {
				jQuery("#loginDiv").removeClass('hide');
				jQuery("#loginDiv").show();
				jQuery("#forgotPasswordDiv").hide();
			});

			jQuery("input[name='retrievePassword']").click(function () {
				var username = jQuery('#user_name').val();
				var email = jQuery('#emailId').val();
				var email1 = email.replace(/^\s+/, '').replace(/\s+$/, '');
				var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/;
				var illegalChars = /[\(\)\<\>\,\;\:\\\"\[\]]/;

				if (username == '') {
					alert('Please enter valid username');
					return false;
				} else if (!emailFilter.test(email1) || email == '') {
					alert('Please enater valid email address');
					return false;
				} else if (email.match(illegalChars)) {
					alert("The email address contains illegal characters.");
					return false;
				} else {
					return true;
				}
			});
		});
	<?php echo '</script'; ?>
>
<?php }
}
