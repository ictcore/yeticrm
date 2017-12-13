<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:17:19
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step4.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a27997f0fc1b7_57993954',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '649d4492cf69c20559caf60ce86cc1b721570e23' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step4.tpl',
      1 => 1502282094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a27997f0fc1b7_57993954 (Smarty_Internal_Template $_smarty_tpl) {
?>

<form class="form-horizontal" name="step4" method="post" action="Install.php"><input type="hidden" name="mode" value="Step5" /><input type="hidden" name="lang" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value;?>
" /><div class="row main-container"><div class="inner-container"><h4><?php echo \App\Language::translate('LBL_SYSTEM_CONFIGURATION','Install');?>
 </h4><hr><div class="row hide" id="errorMessage"></div><div class="row"><div class="col-md-6"><table class="config-table input-table"><thead><tr><th colspan="2"><?php echo \App\Language::translate('LBL_DATABASE_INFORMATION','Install');?>
</th></tr></thead><tbody><tr><td><?php echo \App\Language::translate('LBL_DATABASE_TYPE','Install');?>
<span class="no">*</span></td><td><?php echo \App\Language::translate('MySQL','Install');?>
<input type="hidden" value="mysql" name="db_type"></td></tr><tr><td><?php echo \App\Language::translate('LBL_HOST_NAME','Install');?>
<span class="no">*</span></td><td><input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['DB_HOSTNAME']->value;?>
" name="db_hostname"></td></tr><tr><td><?php echo \App\Language::translate('LBL_HOST_PORT','Install');?>
<span class="no">*</span></td><td><input type="text" class="form-control" value="3306" name="db_port"></td></tr><tr><td><?php echo \App\Language::translate('LBL_USERNAME','Install');?>
<span class="no">*</span></td><td><input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['DB_USERNAME']->value;?>
" name="db_username"></td></tr><tr><td><?php echo \App\Language::translate('LBL_PASSWORD','Install');?>
</td><td><input type="password" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['DB_PASSWORD']->value;?>
" name="db_password"></td></tr><tr><td><?php echo \App\Language::translate('LBL_DB_NAME','Install');?>
<span class="no">*</span></td><td><input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['DB_NAME']->value;?>
" name="db_name"></td></tr><tr><td colspan="2"><input type="checkbox" name="create_db"/><div class="chkbox"></div><label for="checkbox-1"><?php echo \App\Language::translate('LBL_CREATE_NEW_DB','Install');?>
</label></td></tr><tr class="hide" id="root_user"><td><?php echo \App\Language::translate('LBL_ROOT_USERNAME','Install');?>
<span class="no">*</span></td><td><input type="text" class="form-control" value="" name="db_root_username"></td></tr><tr class="hide" id="root_password"><td><?php echo \App\Language::translate('LBL_ROOT_PASSWORD','Install');?>
</td><td><input type="password" class="form-control" value="" name="db_root_password"></td></tr><!--tr><td colspan="2"><input type="checkbox" checked name="populate"/><div class="chkbox"></div><label for="checkbox-1"> Populate database with demo data</label></td--></tr></tbody></table></div><div class="col-md-6"><table class="config-table input-table"><thead><tr><th colspan="2"><?php echo \App\Language::translate('LBL_SYSTEM_INFORMATION','Install');?>
</th></tr></thead><tbody><tr><td><?php echo \App\Language::translate('LBL_CURRENCIES','Install');?>
<span class="no">*</span></td><td><select name="currency_name" class="select2" style="width:220px;"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['CURRENCIES']->value, 'CURRENCY_INFO', false, 'CURRENCY_NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['CURRENCY_NAME']->value => $_smarty_tpl->tpl_vars['CURRENCY_INFO']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['CURRENCY_NAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['CURRENCY_NAME']->value == 'Euro') {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['CURRENCY_NAME']->value;?>
 (<?php echo $_smarty_tpl->tpl_vars['CURRENCY_INFO']->value[1];?>
)</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></td></tr></tbody></table><table class="config-table input-table"><thead><tr><th colspan="2"><?php echo \App\Language::translate('LBL_ADMIN_INFORMATION','Install');?>
</th></tr></thead><tbody><tr><td><?php echo \App\Language::translate('LBL_USERNAME','Install');?>
</td><td>admin<input type="hidden" class="form-control" name="<?php echo $_smarty_tpl->tpl_vars['ADMIN_NAME']->value;?>
" value="admin" /></td></tr><tr><td><?php echo \App\Language::translate('LBL_PASSWORD','Install');?>
<span class="no">*</span></td><td><input type="password" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN_PASSWORD']->value;?>
" name="password" /></td></tr><tr><td><?php echo \App\Language::translate('LBL_RETYPE_PASSWORD','Install');?>
 <span class="no">*</span></td><td><input type="password" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN_PASSWORD']->value;?>
" name="retype_password" /><span id="passwordError" class="no"></span></td></tr><tr><td><?php echo \App\Language::translate('First Name','Install');?>
</td><td><input type="text" value="" class="form-control" name="firstname" /></td></tr><tr><td><?php echo \App\Language::translate('Last Name','Install');?>
 <span class="no">*</span></td><td><input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN_LASTNAME']->value;?>
" name="lastname" /></td></tr><tr><td><?php echo \App\Language::translate('LBL_EMAIL','Install');?>
 <span class="no">*</span></td><td><input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN_EMAIL']->value;?>
" name="admin_email"></td></tr><tr><td><?php echo \App\Language::translate('LBL_DATE_FORMAT','Install');?>
 <span class="no">*</span></td><td><select class="select2 form-control" style="width:220px;" name="dateformat"><option>yyyy-mm-dd</option><option>dd-mm-yyyy</option><option>mm-dd-yyyy</option><option>yyyy.mm.dd</option><option>dd.mm.yyyy</option><option>mm.dd.yyyy</option><option>yyyy/mm/dd</option><option>dd/mm/yyyy</option><option>mm/dd/yyyy</option></select></td></tr><tr><td><?php echo \App\Language::translate('LBL_TIME_ZONE','Install');?>
 <span class="no">*</span></td><td><select class="select2 form-control" name="timezone"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['TIMEZONES']->value, 'TIMEZONE');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['TIMEZONE']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['TIMEZONE']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['TIMEZONE']->value == 'Europe/London') {?>selected<?php }?>><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['TIMEZONE']->value,'Users');?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></td></tr></tbody></table><div class="button-container"><a class="btn btn-sm btn-default" href="Install.php" ><?php echo \App\Language::translate('LBL_BACK','Install');?>
</a><input type="button" class="btn btn-sm btn-primary" value="<?php echo \App\Language::translate('LBL_NEXT','Install');?>
" name="step5"/></div></div></div></div></div></form>
<?php }
}
