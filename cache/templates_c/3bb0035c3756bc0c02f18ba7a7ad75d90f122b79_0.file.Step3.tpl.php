<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:09:11
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step3.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279797038be3_65644618',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3bb0035c3756bc0c02f18ba7a7ad75d90f122b79' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/Step3.tpl',
      1 => 1502282094,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279797038be3_65644618 (Smarty_Internal_Template $_smarty_tpl) {
?>

<form class="form-horizontal" name="step3" method="post" action="Install.php"><input type="hidden" name="mode" value="Step4" /><input type="hidden" name="lang" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value;?>
" /><div class="row main-container"><div class="inner-container"><div class="pull-right"><a class="helpBtn" href="https://yetiforce.com/en/implementer/installation-updates/103-web-server-requirements.html" target="_blank"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a></div><h4><?php echo App\Language::translate('LBL_INSTALL_PREREQUISITES','Install');?>
</h4><hr><div><div class="offset2"><div class="pull-right"><div class="button-container"><a href ="#"><input type="button" class="btn btn-default" value="<?php echo App\Language::translate('LBL_RECHECK','Install');?>
" id='recheck'/></a></div></div></div><div class="clearfix"></div><div class="offset2"><div><?php $_smarty_tpl->_assignInScope('LIBRARY', Settings_ConfReport_Module_Model::getConfigurationLibrary());
?><table class="config-table table"><thead><tr><th><label><?php echo App\Language::translate('LBL_LIBRARY','Settings::ConfReport');?>
</label></th><th><label><?php echo App\Language::translate('LBL_INSTALLED','Settings::ConfReport');?>
</label></th><th><label><?php echo App\Language::translate('LBL_MANDATORY','Settings::ConfReport');?>
</label></th></tr></thead><tbody><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LIBRARY']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?><tr <?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 'LBL_NO') {?>class="danger"<?php }?>><td><?php echo App\Language::translate($_smarty_tpl->tpl_vars['key']->value,'Settings::ConfReport');?>
</td><td><?php echo App\Language::translate($_smarty_tpl->tpl_vars['item']->value['status'],'Settings::ConfReport');?>
</td><td><?php if ($_smarty_tpl->tpl_vars['item']->value['mandatory']) {
echo App\Language::translate('LBL_MANDATORY','Settings::ConfReport');
} else {
echo App\Language::translate('LBL_OPTIONAL','Settings::ConfReport');
}?></td></tr><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</tbody></table><?php $_smarty_tpl->_assignInScope('STABILITY_CONF', Settings_ConfReport_Module_Model::getSecurityConf(true));
?><br /><table class="config-table table"><thead><tr><th><?php echo App\Language::translate('LBL_SECURITY_RECOMMENDED_SETTINGS','Install');?>
</th><th><?php echo App\Language::translate('LBL_REQUIRED_VALUE','Install');?>
</th><th><?php echo App\Language::translate('LBL_PRESENT_VALUE','Install');?>
</th></tr></thead><tbody><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['STABILITY_CONF']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?><tr <?php if ($_smarty_tpl->tpl_vars['item']->value['status']) {?>class="danger"<?php }?>><td><label><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</label><?php if (isset($_smarty_tpl->tpl_vars['item']->value['help'])) {?><a href="#" class="popoverTooltip pull-right" data-placement="rigth" data-content="<?php echo App\Language::translate($_smarty_tpl->tpl_vars['item']->value['help'],'Settings::ConfReport');?>
"><i class="glyphicon glyphicon-info-sign"></i></a><?php }?></td><td><label><?php echo App\Language::translate($_smarty_tpl->tpl_vars['item']->value['prefer'],'Settings::ConfReport');?>
</label></td><td><label><?php echo App\Language::translate($_smarty_tpl->tpl_vars['item']->value['current'],'Settings::ConfReport');?>
</label></td></tr><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</tbody></table><?php $_smarty_tpl->_assignInScope('STABILITY_CONF', Settings_ConfReport_Module_Model::getStabilityConf(true));
?><br /><table class="config-table table"><thead><tr><th><?php echo App\Language::translate('LBL_PHP_RECOMMENDED_SETTINGS','Install');?>
</th><th><?php echo App\Language::translate('LBL_REQUIRED_VALUE','Install');?>
</th><th><?php echo App\Language::translate('LBL_PRESENT_VALUE','Install');?>
</th></tr></thead><tbody><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['STABILITY_CONF']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?><tr <?php if ($_smarty_tpl->tpl_vars['item']->value['status']) {?>class="danger"<?php }?>><td><label><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</label><?php if (isset($_smarty_tpl->tpl_vars['item']->value['help'])) {?><a href="#" class="popoverTooltip pull-right" data-placement="rigth" data-content="<?php echo App\Language::translate($_smarty_tpl->tpl_vars['item']->value['help'],'Settings::ConfReport');?>
"><i class="glyphicon glyphicon-info-sign"></i></a><?php }?></td><td><label><?php echo App\Language::translate($_smarty_tpl->tpl_vars['item']->value['prefer'],'Settings::ConfReport');?>
</label></td><td><label><?php echo App\Language::translate($_smarty_tpl->tpl_vars['item']->value['current'],'Settings::ConfReport');?>
</label></td></tr><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</tbody></table><?php if ($_smarty_tpl->tpl_vars['FAILED_FILE_PERMISSIONS']->value) {?><table class="config-table table"><thead><tr class="blockHeader"><th colspan="1" class="mediumWidthType"><span><?php echo App\Language::translate('LBL_READ_WRITE_ACCESS','Install');?>
</span></th><th colspan="1" class="mediumWidthType"><span><?php echo App\Language::translate('LBL_PATH','Settings::ConfReport');?>
</span></th><th colspan="1" class="mediumWidthType"><span><?php echo App\Language::translate('LBL_PERMISSION','Settings::ConfReport');?>
</span></th></tr></thead><tbody><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['FAILED_FILE_PERMISSIONS']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?><tr <?php if ($_smarty_tpl->tpl_vars['item']->value['permission'] == 'FailedPermission') {?>class="danger"<?php }?>><td width="23%"><label class="marginRight5px"><?php echo App\Language::translate($_smarty_tpl->tpl_vars['key']->value,'Settings::ConfReport');?>
</label></td><td width="23%"><label class="marginRight5px"><?php echo App\Language::translate($_smarty_tpl->tpl_vars['item']->value['path'],'Settings::ConfReport');?>
</label></td><td width="23%"><label class="marginRight5px"><?php if ($_smarty_tpl->tpl_vars['item']->value['permission'] == 'FailedPermission') {
echo App\Language::translate('LBL_FAILED_PERMISSION','Settings::ConfReport');
} else {
echo App\Language::translate('LBL_TRUE_PERMISSION','Settings::ConfReport');
}?></label></td></tr><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</tbody></table><?php }?></div></div></div><div class="row"><div class="button-container"><a class="btn btn-sm btn-default" href="Install.php" ><?php echo App\Language::translate('LBL_BACK','Install');?>
</a><input type="button" class="btn btn-sm btn-primary" value="<?php echo App\Language::translate('LBL_NEXT','Install');?>
" name="step4"/></div></div></div></div></form>
<?php }
}
