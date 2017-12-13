<?php
/* Smarty version 3.1.31, created on 2017-12-07 13:25:16
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/MailSmtp/Edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28faec142d87_78801294',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '35e39aa21a7a91b49168d847f257f9a4bd90dade' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/MailSmtp/Edit.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28faec142d87_78801294 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="row widget_header"><div class="col-xs-12"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
if ($_smarty_tpl->tpl_vars['RECORD_ID']->value) {
echo App\Language::translate('LBL_MAILSMTP_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);
}?></div></div><div class="editViewContainer"><form name="EditMailSmtp" id="EditView" class="form-horizontal validateForm"><div class="alert alert-block alert-danger fade in " hidden=""><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><?php echo \App\Language::translate('LBL_ERROR',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h4><p></p></div><input type="hidden" name="module" value="MailSmtp"><input type="hidden" name="parent" value="Settings" /><input type="hidden" name="action" value="Save"><input type="hidden" name="mode" value="save"><input type="hidden" name="record" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
"><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor"> *</label><div class="controls col-md-8"></span><input class="form-control" type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('name');?>
" data-validation-engine="validate[required]"></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_MAILER_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><select class="select2 form-control sourceModule col-md-8" name="mailer_type" id="mailerType"><option <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('mailer_type') == 'smtp') {?> selected <?php }?> value="smtp"><?php echo \App\Language::translate('LBL_SMTP',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('mailer_type') == 'sendmail') {?> selected <?php }?> value="sendmail"><?php echo \App\Language::translate('LBL_SENDMAIL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('mailer_type') == 'mail') {?> selected <?php }?> value="mail"><?php echo \App\Language::translate('LBL_MAIL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('mailer_type') == 'qmail') {?> selected <?php }?> value="qmail"><?php echo \App\Language::translate('LBL_QMAIL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option></select></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_DEFAULT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input type="checkbox" name="default" value="1" <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('default') == 1) {?> checked <?php }?>></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_HOST',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input class="form-control" type="text" name="host" placeholder="smtp.gmail.com" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('host');?>
" ></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_PORT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input class="form-control" type="text" name="port" placeholder="587" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('port');?>
"  data-validation-engine="validate[custom[integer]]"></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_AUTHENTICATION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input type="checkbox" name="authentication" value="1"  <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('authentication') == 1) {?> checked <?php }?>></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_USERNAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input class="form-control" type="text" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('username');?>
" name="username" ></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_PASSWORD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input class="form-control" type="password" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('password');?>
" name="password" ></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_INDIVIDUAL_DELIVERY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
&nbsp;<span class="popoverTooltip" data-placement="top" data-content="<?php echo \App\Language::translate('LBL_INDIVIDUAL_DELIVERY_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><span class="glyphicon glyphicon-info-sign"></span></span></label><div class="controls col-md-8"><input type="checkbox" name="individual_delivery" value="1" <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('individual_delivery') == 1) {?> checked <?php }?>></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_SECURE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><select class="select2 form-control sourceModule col-md-8" name="secure" id="secure"><option value=""><?php echo \App\Language::translate('LBL_SELECT_OPTION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('secure') == 'tls') {?> selected <?php }?> value="tls"><?php echo \App\Language::translate('LBL_TLS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('secure') == 'ssl') {?> selected <?php }?> value="ssl"><?php echo \App\Language::translate('LBL_SSL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option></select></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_FROM_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input class="form-control" type="text" name="from_name" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('from_name');?>
"></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_FROM_EMAIL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input class="form-control" type="text" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('from_email');?>
" name="from_email" data-validation-engine="validate[custom[email]]"></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_REPLY_TO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input class="form-control" type="text" name="reply_to" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('reply_to');?>
" data-validation-engine="validate[custom[email]]"></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_OPTIONS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
&nbsp;<span class="popoverTooltip delay0" data-placement="top" data-content="<?php echo \App\Language::translate('LBL_OPTIONS_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><span class="glyphicon glyphicon-info-sign"></span></span></label><div class="controls col-md-8"><textarea class="form-control" name="options"><?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('options');?>
</textarea></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_SAVE_SEND_MAIL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
&nbsp;<span class="popoverTooltip" data-placement="top" data-content="<?php echo \App\Language::translate('LBL_SAVE_SEND_MAIL_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><span class="glyphicon glyphicon-info-sign"></span></span></label><div class="controls col-md-8"><input type="checkbox" name="save_send_mail" class="saveSendMail" value="1" <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('save_send_mail') == 1) {?> checked <?php }?>></div></div><div class="saveMailContent <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('save_send_mail') != 1) {?>hide<?php }?>"><hr><div class="form-group"><div class="col-md-3"></div><label class="col-md-6"><h4><?php echo \App\Language::translate('LBL_IMAP_SAVE_MAIL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h4></label></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_HOST',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor"> *</label><div class="controls col-md-8"><input class="form-control" type="text" name="smtp_host" placeholder="ssl://imap.gmail.com" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('smtp_host');?>
" ></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_PORT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor"> *</label><div class="controls col-md-8"><input class="form-control" type="text" name="smtp_port" placeholder="993" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('smtp_port');?>
"  data-validation-engine="validate[custom[integer]]"></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_USERNAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor"> *</label><div class="controls col-md-8"><input class="form-control" type="text" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('smtp_username');?>
" name="smtp_username" ></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_PASSWORD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor"> *</label><div class="controls col-md-8"><input class="form-control" type="password" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('smtp_password');?>
" name="smtp_password" ></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_SEND_FOLDER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor"> *</label><div class="controls col-md-8"><input class="form-control" type="text" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('smtp_folder');?>
" placeholder="Send" name="smtp_folder" ></div></div><div class="form-group"><label class="control-label col-md-3"><?php echo \App\Language::translate('LBL_VALIDATE_CERT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls col-md-8"><input type="checkbox" name="smtp_validate_cert" value="1" <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('smtp_validate_cert') == 1) {?> checked <?php }?>></div></div></div><div class="row"><div class="col-md-5 pull-right"><span class="pull-right"><button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;<strong><?php echo App\Language::translate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button><button class="cancelLink btn btn-warning" type="reset" onclick="javascript:window.history.back();"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;<?php echo App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></span></div></div></form></div>
<?php }
}
