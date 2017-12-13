<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:31
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/OSSMailView/widgets.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d4bb3f152_96350151',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ee8544b78ad649ee9f7b73825e843b441361f78b' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/OSSMailView/widgets.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d4bb3f152_96350151 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="container-fluid"><?php $_smarty_tpl->_assignInScope('COUNT', count($_smarty_tpl->tpl_vars['RECOLDLIST']->value));
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RECOLDLIST']->value, 'ROW', false, 'KEY');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['KEY']->value => $_smarty_tpl->tpl_vars['ROW']->value) {
?><div class="row<?php if ($_smarty_tpl->tpl_vars['KEY']->value%2 != 0) {?> even<?php }?>"><?php if (\App\Privilege::isPermitted('OSSMailView','DetailView',$_smarty_tpl->tpl_vars['ROW']->value['id'])) {?><div class="col-md-12 mailActions"><div class="pull-left"><a title="<?php echo \App\Language::translate('LBL_SHOW_PREVIEW_EMAIL','OSSMailView');?>
" class="showMailBody btn btn-sm btn-default" ><span class="body-icon glyphicon glyphicon-triangle-bottom"></span></a>&nbsp;<button type="button" class="btn btn-sm btn-default showMailModal" data-url="<?php echo $_smarty_tpl->tpl_vars['ROW']->value['url'];?>
" title="<?php echo \App\Language::translate('LBL_SHOW_PREVIEW_EMAIL','OSSMailView');?>
"><span class="body-icon glyphicon glyphicon-search"></span></button></div><div class="pull-right"><?php if (AppConfig::main('isActiveSendingMails') && Users_Privileges_Model::isPermitted('OSSMail')) {
if ($_smarty_tpl->tpl_vars['PRIVILEGESMODEL']->value->internal_mailer == 1) {
$_smarty_tpl->_assignInScope('COMPOSE_URL', OSSMail_Module_Model::getComposeUrl($_smarty_tpl->tpl_vars['SMODULENAME']->value,$_smarty_tpl->tpl_vars['SRECORD']->value,'Detail'));
?><button type="button" class="btn btn-sm btn-default sendMailBtn" data-url="<?php echo $_smarty_tpl->tpl_vars['COMPOSE_URL']->value;?>
&mid=<?php echo $_smarty_tpl->tpl_vars['ROW']->value['id'];?>
&type=reply" data-popup="<?php echo $_smarty_tpl->tpl_vars['POPUP']->value;?>
" title="<?php echo \App\Language::translate('LBL_REPLY','OSSMailView');?>
"><img width="14px" src="<?php echo \App\Layout::getLayoutFile('modules/OSSMailView/previewReply.png');?>
" alt="<?php echo \App\Language::translate('LBL_REPLY','OSSMailView');?>
"></button><button type="button" class="btn btn-sm btn-default sendMailBtn" data-url="<?php echo $_smarty_tpl->tpl_vars['COMPOSE_URL']->value;?>
&mid=<?php echo $_smarty_tpl->tpl_vars['ROW']->value['id'];?>
&type=replyAll" data-popup="<?php echo $_smarty_tpl->tpl_vars['POPUP']->value;?>
" title="<?php echo \App\Language::translate('LBL_REPLYALLL','OSSMailView');?>
"><img width="14px" src="<?php echo \App\Layout::getLayoutFile('modules/OSSMailView/previewReplyAll.png');?>
" alt="<?php echo \App\Language::translate('LBL_REPLYALLL','OSSMailView');?>
"></button><button type="button" class="btn btn-sm btn-default sendMailBtn" data-url="<?php echo $_smarty_tpl->tpl_vars['COMPOSE_URL']->value;?>
&mid=<?php echo $_smarty_tpl->tpl_vars['ROW']->value['id'];?>
&type=forward" data-popup="<?php echo $_smarty_tpl->tpl_vars['POPUP']->value;?>
" title="<?php echo \App\Language::translate('LBL_FORWARD','OSSMailView');?>
"><span class="glyphicon glyphicon-share-alt"></span></button><?php } else { ?><a class="btn btn-sm btn-default" href="<?php echo OSSMail_Module_Model::getExternalUrlForWidget($_smarty_tpl->tpl_vars['ROW']->value,'reply',$_smarty_tpl->tpl_vars['SRECORD']->value,$_smarty_tpl->tpl_vars['SMODULENAME']->value);?>
" title="<?php echo \App\Language::translate('LBL_CREATEMAIL','OSSMailView');?>
"><img width="14px" src="<?php echo \App\Layout::getLayoutFile('modules/OSSMailView/previewReply.png');?>
" alt="<?php echo \App\Language::translate('LBL_REPLY','OSSMailView');?>
"></a><a class="btn btn-sm btn-default" href="<?php echo OSSMail_Module_Model::getExternalUrlForWidget($_smarty_tpl->tpl_vars['ROW']->value,'replyAll',$_smarty_tpl->tpl_vars['SRECORD']->value,$_smarty_tpl->tpl_vars['SMODULENAME']->value);?>
" title="<?php echo \App\Language::translate('LBL_REPLYALLL','OSSMailView');?>
"><img width="14px" src="<?php echo \App\Layout::getLayoutFile('modules/OSSMailView/previewReplyAll.png');?>
" alt="<?php echo \App\Language::translate('LBL_REPLYALLL','OSSMailView');?>
"></a><a class="btn btn-sm btn-default" href="<?php echo OSSMail_Module_Model::getExternalUrlForWidget($_smarty_tpl->tpl_vars['ROW']->value,'forward',$_smarty_tpl->tpl_vars['SRECORD']->value,$_smarty_tpl->tpl_vars['SMODULENAME']->value);?>
" title="<?php echo \App\Language::translate('LBL_FORWARD','OSSMailView');?>
"><span class="glyphicon glyphicon-share-alt"></span></a><?php }
}?></div><div class="clearfix"></div><hr/></div><?php }?><div class="col-md-12"><div class="pull-left"><?php if ($_smarty_tpl->tpl_vars['ROW']->value['type'] == 0) {
$_smarty_tpl->_assignInScope('FIRST_LETTER_CLASS', 'bgDanger');
} elseif ($_smarty_tpl->tpl_vars['ROW']->value['type'] == 1) {
$_smarty_tpl->_assignInScope('FIRST_LETTER_CLASS', 'bgGreen');
} elseif ($_smarty_tpl->tpl_vars['ROW']->value['type'] == 2) {
$_smarty_tpl->_assignInScope('FIRST_LETTER_CLASS', 'bgBlue');
}?><span class="firstLetter <?php echo $_smarty_tpl->tpl_vars['FIRST_LETTER_CLASS']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['ROW']->value['firstLetter'];?>
</span></div><div class="pull-right muted"><small title="<?php echo $_smarty_tpl->tpl_vars['ROW']->value['date'];?>
"><?php echo Vtiger_Util_Helper::formatDateDiffInStrings($_smarty_tpl->tpl_vars['ROW']->value['date']);?>
</small></div><h5 class="textOverflowEllipsis mailTitle mainFrom"><?php echo $_smarty_tpl->tpl_vars['ROW']->value['from'];?>
</h5><div class="pull-right"><?php if ($_smarty_tpl->tpl_vars['ROW']->value['attachments'] == 1) {?><img class="pull-right" src="<?php echo \App\Layout::getLayoutFile('modules/OSSMailView/attachment.png');?>
" /><?php }?><span class="pull-right"><?php if ($_smarty_tpl->tpl_vars['ROW']->value['type'] == 0) {?><img src="<?php echo \App\Layout::getLayoutFile('modules/OSSMailView/outgoing.png');?>
" /><?php } elseif ($_smarty_tpl->tpl_vars['ROW']->value['type'] == 1) {?><img src="<?php echo \App\Layout::getLayoutFile('modules/OSSMailView/incoming.png');?>
" /><?php } elseif ($_smarty_tpl->tpl_vars['ROW']->value['type'] == 2) {?><img src="<?php echo \App\Layout::getLayoutFile('modules/OSSMailView/internal.png');?>
" /><?php }?></span><span class="pull-right smalSeparator"></span></div><h5 class="textOverflowEllipsis mailTitle mainSubject"><?php echo $_smarty_tpl->tpl_vars['ROW']->value['subject'];?>
</h5></div><div class="col-md-12"><hr/></div><div class="col-md-12"><div class="mailTeaser"><?php echo $_smarty_tpl->tpl_vars['ROW']->value['teaser'];?>
</div></div><div class="col-md-12 mailBody hide"><div class="mailBodyContent"><?php echo $_smarty_tpl->tpl_vars['ROW']->value['body'];?>
</div></div><div class="clearfix"></div></div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
if ($_smarty_tpl->tpl_vars['COUNT']->value == 0) {?><p class="textAlignCenter"><?php echo \App\Language::translate('LBL_NO_MAILS','OSSMailView');?>
</p><?php }?></div>
<?php }
}
