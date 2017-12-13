<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:19:40
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step6.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279a0cacd367_38532888',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a85d3bbeec16957e818cfc728f178eb70bc093a9' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step6.tpl',
      1 => 1502282094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279a0cacd367_38532888 (Smarty_Internal_Template $_smarty_tpl) {
?>

<form class="form-horizontal" name="step6" method="post" action="Install.php"><input type="hidden" name="mode" value="Step7" /><input type="hidden" name="auth_key" value="<?php echo $_smarty_tpl->tpl_vars['AUTH_KEY']->value;?>
" /><input type="hidden" name="lang" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value;?>
" /><div class="row main-container"><div class="inner-container"><h4><?php echo \App\Language::translate('LBL_CONFIGURATION_COMPANY_DETAILS','Install');?>
</h4><hr><div class="offset2"><div class="row"><table class="config-table input-table"><tbody><tr><td class="text-right"><?php echo App\Language::translate('LBL_NAME','Settings:Companies');?>
&nbsp;<span class="no">*</span></td><td><input type="text" name="company_name" class="form-control" data-validation-engine="validate[required]"></td></tr><tr><td><?php echo App\Language::translate('LBL_INDUSTRY','Settings:Companies');?>
</td><td><select class="select2 form-control" name="company_industry" data-validation-engine="validate[required]"><option value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value;?>
"><?php echo App\Language::translate($_smarty_tpl->tpl_vars['ITEM']->value);?>
</option><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['INDUSTRY']->value, 'ITEM');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ITEM']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value;?>
"><?php echo App\Language::translate($_smarty_tpl->tpl_vars['ITEM']->value);?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></td></tr><tr><td><?php echo App\Language::translate('LBL_STREET','Settings:Companies');?>
&nbsp;<span class="no">*</span></td><td><input type="text" name="company_street" class="form-control" data-validation-engine="validate[required]"></td></tr><tr><td><?php echo App\Language::translate('LBL_CITY','Settings:Companies');?>
&nbsp;<span class="no">*</span></td><td><input type="text" name="company_city" class="form-control" data-validation-engine="validate[required]"></td></tr><tr><td><?php echo App\Language::translate('LBL_CODE','Settings:Companies');?>
&nbsp;<span class="no">*</span></td><td><input type="text" name="company_code" class="form-control" data-validation-engine="validate[required]"></td></tr><tr><td><?php echo App\Language::translate('LBL_STATE','Settings:Companies');?>
</td><td><input type="text" name="company_state" class="form-control"></td></tr><tr><td><?php echo App\Language::translate('LBL_COUNTRY','Settings:Companies');?>
&nbsp;<span class="no">*</span></td><td><input type="text" name="company_country" class="form-control" data-validation-engine="validate[required]"></td></tr><tr><td><?php echo App\Language::translate('LBL_PHONE','Settings:Companies');?>
</td><td><input type="text" name="company_phone" class="form-control" data-validation-engine="validate[custom[phone]]"></td></tr><tr><td><?php echo App\Language::translate('LBL_WEBSITE','Settings:Companies');?>
</td><td><input type="text" name="company_website" class="form-control" data-validation-engine="validate[custom[url]]" ></td></tr><tr><td><?php echo App\Language::translate('LBL_EMAIL','Settings:Companies');?>
&nbsp;<span class="no">*</span></td><td><input type="text" name="company_email" class="form-control" data-validation-engine="validate[required,custom[email]]"></td></tr><tr><td><?php echo App\Language::translate('LBL_VATID','Settings:Companies');?>
</td><td><input type="text" name="company_vatid" class="form-control"></td></tr></tbody></table></div><div class="row"><div class="col-md-12"><div class="button-container"><input type="button" class="btn btn-sm btn-default" value="<?php echo \App\Language::translate('LBL_BACK','Install');?>
" onclick="window.history.back()"/><input type="button" class="btn btn-sm btn-primary" value="<?php echo \App\Language::translate('LBL_NEXT','Install');?>
" name="step7"/></div></div></div></div></div></div></form><div id="progressIndicator" class="row main-container hide"><div class="inner-container"><div class="inner-container"><div class="row"><div class="span12 welcome-div alignCenter"><h3><?php echo \App\Language::translate('LBL_INSTALLATION_IN_PROGRESS','Install');?>
...</h3><br /><img src="../<?php echo \App\Layout::getPublicUrl('layouts/basic/skins/images/install_loading.gif');?>
" alt="Install loading"/><h6><?php echo \App\Language::translate('LBL_PLEASE_WAIT','Install');?>
.... </h6></div></div></div></div></div>
<?php }
}
