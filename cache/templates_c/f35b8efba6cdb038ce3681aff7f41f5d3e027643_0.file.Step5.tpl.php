<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:19:28
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step5.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279a007c1d21_65366516',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f35b8efba6cdb038ce3681aff7f41f5d3e027643' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step5.tpl',
      1 => 1502282094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279a007c1d21_65366516 (Smarty_Internal_Template $_smarty_tpl) {
?>

<form class="form-horizontal" name="step5" method="post" action="Install.php"><input type="hidden" name="mode" value="Step6" /><input type="hidden" name="auth_key" value="<?php echo $_smarty_tpl->tpl_vars['AUTH_KEY']->value;?>
" /><input type="hidden" name="lang" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value;?>
" /><div class="row main-container"><div class="inner-container"><h4><?php echo \App\Language::translate('LBL_CONFIRM_CONFIGURATION_SETTINGS','Install');?>
</h4><hr><?php if ($_smarty_tpl->tpl_vars['DB_CONNECTION_INFO']->value['flag'] != true) {?><div class="offset2 row" id="errorMessage"><div class="col-md-12"><div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['DB_CONNECTION_INFO']->value['error_msg'];?>
<br /><?php echo $_smarty_tpl->tpl_vars['DB_CONNECTION_INFO']->value['error_msg_info'];?>
</div></div></div><?php }?><div class="offset2 "><table class="config-table input-table"><thead><tr><th colspan="2"><?php echo \App\Language::translate('LBL_DATABASE_INFORMATION','Install');?>
</th></tr></thead><tbody><tr><td><?php echo \App\Language::translate('LBL_DATABASE_TYPE','Install');?>
</td><td><?php echo \App\Language::translate('MySQL','Install');?>
</td></tr><tr><td><?php echo \App\Language::translate('LBL_HOST_NAME','Install');?>
</td><td><?php echo $_smarty_tpl->tpl_vars['INFORMATION']->value['db_hostname'];?>
</td></tr><tr><td><?php echo \App\Language::translate('LBL_HOST_PORT','Install');?>
</td><td><?php echo $_smarty_tpl->tpl_vars['INFORMATION']->value['db_port'];?>
</td></tr><tr><td><?php echo \App\Language::translate('LBL_DB_NAME','Install');?>
</td><td><?php echo $_smarty_tpl->tpl_vars['INFORMATION']->value['db_name'];?>
</td></tr></tbody></table><table class="config-table input-table"><thead><tr><th colspan="2"><?php echo \App\Language::translate('LBL_SYSTEM_INFORMATION','Install');?>
</th></tr></thead><tbody><tr><td><?php echo \App\Language::translate('LBL_URL','Install');?>
</td><td><a href="#"><?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
</a></td></tr><tr><td><?php echo \App\Language::translate('LBL_CURRENCY','Install');?>
</td><td><?php echo $_smarty_tpl->tpl_vars['INFORMATION']->value['currency_name'];?>
</td></tr></tbody></table><table class="config-table input-table"><thead><tr><th colspan="2"><?php echo \App\Language::translate('LBL_ADMIN_USER_INFORMATION','Install');?>
</th></tr></thead><tbody><tr><td><?php echo \App\Language::translate('LBL_USERNAME','Install');?>
</td><td><?php echo $_smarty_tpl->tpl_vars['INFORMATION']->value['admin'];?>
</td></tr><tr><td><?php echo \App\Language::translate('LBL_EMAIL','Install');?>
</td><td><?php echo $_smarty_tpl->tpl_vars['INFORMATION']->value['admin_email'];?>
</td></tr><tr><td><?php echo \App\Language::translate('LBL_TIME_ZONE','Install');?>
</td><td><?php echo $_smarty_tpl->tpl_vars['INFORMATION']->value['timezone'];?>
</td></tr><tr><td><?php echo \App\Language::translate('LBL_DATE_FORMAT','Install');?>
</td><td><?php echo $_smarty_tpl->tpl_vars['INFORMATION']->value['dateformat'];?>
</td></tr></tbody></table><div class="row"><div class="col-md-12"><div class="button-container"><input type="button" class="btn btn-sm btn-default" value="<?php echo \App\Language::translate('LBL_BACK','Install');?>
" <?php if ($_smarty_tpl->tpl_vars['DB_CONNECTION_INFO']->value['flag'] == true) {?> disabled= "disabled"<?php } else { ?> onclick="window.history.back()"<?php }?> /><?php if ($_smarty_tpl->tpl_vars['DB_CONNECTION_INFO']->value['flag'] == true) {?><input type="button" class="btn btn-sm btn-primary" value="<?php echo \App\Language::translate('LBL_NEXT','Install');?>
" name="step6"/><?php }?></div></div></div></div></div></div></form>
<?php }
}
