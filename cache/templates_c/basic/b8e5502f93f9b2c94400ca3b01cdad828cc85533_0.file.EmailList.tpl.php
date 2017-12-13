<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:29
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/widgets/EmailList.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d49d24ca4_58716425',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b8e5502f93f9b2c94400ca3b01cdad828cc85533' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/widgets/EmailList.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d49d24ca4_58716425 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('CONFIG', OSSMail_Module_Model::getComposeParameters());
?><div class="summaryWidgetContainer"><div class="widgetContainer_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 widgetContentBlock" data-url="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['url'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['label'];?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['type'];?>
"><div class="widget_header"><input type="hidden" name="relatedModule" value="<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['data']['relatedmodule'];?>
" /><div class="widgetTitle row"><div class="col-xs-7"><h4 class="moduleColor_<?php echo $_smarty_tpl->tpl_vars['WIDGET']->value['label'];?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['WIDGET']->value['label'],$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></div><div class="col-xs-5"><div class="pull-right"><button type="button" class="btn btn-sm btn-default showMailsModal" data-url="index.php?module=OSSMailView&view=MailsPreview&smodule=<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
&srecord=<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getId();?>
&mode=showEmailsList"><span class="body-icon glyphicon glyphicon-search" title="<?php echo \App\Language::translate('LBL_SHOW_PREVIEW_EMAILS','OSSMailView');?>
"></span></button>&nbsp;<?php if (AppConfig::main('isActiveSendingMails') && Users_Privileges_Model::isPermitted('OSSMail')) {
if ($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('internal_mailer') == 1) {
$_smarty_tpl->_assignInScope('URLDATA', OSSMail_Module_Model::getComposeUrl($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['RECORD']->value->getId(),'Detail','new'));
?><button type="button" class="btn btn-sm btn-default sendMailBtn" data-url="<?php echo $_smarty_tpl->tpl_vars['URLDATA']->value;?>
" data-module="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" data-record="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getId();?>
" data-popup="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['popup'];?>
" title="<?php echo \App\Language::translate('LBL_CREATEMAIL','OSSMailView');?>
"><span class="glyphicon glyphicon-envelope" title="<?php echo \App\Language::translate('LBL_CREATEMAIL','OSSMailView');?>
"></span></button>&nbsp;<?php } else {
$_smarty_tpl->_assignInScope('URLDATA', OSSMail_Module_Model::getExternalUrl($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['RECORD']->value->getId(),'Detail','new'));
if ($_smarty_tpl->tpl_vars['URLDATA']->value) {?><a class="btn btn-sm btn-default" href="<?php echo $_smarty_tpl->tpl_vars['URLDATA']->value;?>
" title="<?php echo \App\Language::translate('LBL_CREATEMAIL','OSSMailView');?>
"><span class="glyphicon glyphicon-envelope" title="<?php echo \App\Language::translate('LBL_CREATEMAIL','OSSMailView');?>
"></span></a>&nbsp;<?php }
}
}
if (\App\Privilege::isPermitted('OSSMailView','ReloadRelationRecord')) {?><button type="button" class="btn btn-sm btn-default resetRelationsEmail"><span class="body-icon glyphicon glyphicon-retweet" title="<?php echo \App\Language::translate('BTN_RESET_RELATED_MAILS','OSSMailView');?>
"></span></button><?php }?></div></div></div><hr class="rowHr"/><div class="row"><div class="col-xs-6 paddingRightZero"><select name="mail-type" title="<?php echo \App\Language::translate('LBL_CHANGE_MAIL_TYPE');?>
" class="form-control input-sm"><option value="All" <?php if ($_smarty_tpl->tpl_vars['TYPE']->value == 'all') {?> selected="selected"<?php }?>><?php echo \App\Language::translate('LBL_ALL','OSSMailView');?>
</option><option value="0" <?php if ($_smarty_tpl->tpl_vars['TYPE']->value == '0') {?> selected="selected"<?php }?>><?php echo \App\Language::translate('LBL_OUTCOMING','OSSMailView');?>
</option><option value="1" <?php if ($_smarty_tpl->tpl_vars['TYPE']->value == '1') {?> selected="selected"<?php }?>><?php echo \App\Language::translate('LBL_INCOMING','OSSMailView');?>
</option><option value="2" <?php if ($_smarty_tpl->tpl_vars['TYPE']->value == '2') {?> selected="selected"<?php }?>><?php echo \App\Language::translate('LBL_INTERNAL','OSSMailView');?>
</option></select></div><div class="col-xs-6"><?php if ($_smarty_tpl->tpl_vars['MODULE_NAME']->value == 'Accounts') {?><select name="mailFilter" title="<?php echo \App\Language::translate('LBL_CHANGE_FILTER','OSSMailView');?>
" class="form-control input-sm"><option value="All"><?php echo \App\Language::translate('LBL_FILTER_ALL','OSSMailView');?>
</option><option value="Accounts"><?php echo \App\Language::translate('LBL_FILTER_ACCOUNTS','OSSMailView');?>
</option><option value="Contacts"><?php echo \App\Language::translate('LBL_FILTER_CONTACTS','OSSMailView');?>
</option></select><?php }?></div></div></div><div class="hide modalView"><div class="modelContainer modal fade" tabindex="-1"><div class="modal-dialog modal-blg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['WIDGET']->value['label'],$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></div><div class="modal-body modalViewBody">_modalContent_</div></div></div></div></div><div class="widget_contents widgetContent mailsList"></div></div></div>
<?php }
}
