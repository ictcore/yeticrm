<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:26:40
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Calendar/Reminders.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279bb0b85632_16899383',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f5262a898dc845ece1122726fbda895c58658de0' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Calendar/Reminders.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279bb0b85632_16899383 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style><?php if (empty($_smarty_tpl->tpl_vars['COLOR_LIST']->value)) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, Settings_Calendar_Module_Model::getCalendarConfig('colors'), 'ITEM');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ITEM']->value) {
?>.borderColor<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['name'];?>
{border-color: <?php echo $_smarty_tpl->tpl_vars['ITEM']->value['value'];?>
;}.headingColor<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['name'];?>
{background-color: <?php echo $_smarty_tpl->tpl_vars['ITEM']->value['value'];?>
 !important;border-color: <?php echo $_smarty_tpl->tpl_vars['ITEM']->value['value'];?>
;}<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?></style><div class="remindersContent"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RECORDS']->value, 'RECORD');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['RECORD']->value) {
$_smarty_tpl->_assignInScope('START_DATE', $_smarty_tpl->tpl_vars['RECORD']->value->get('date_start'));
$_smarty_tpl->_assignInScope('START_TIME', $_smarty_tpl->tpl_vars['RECORD']->value->get('time_start'));
$_smarty_tpl->_assignInScope('END_DATE', $_smarty_tpl->tpl_vars['RECORD']->value->get('due_date'));
$_smarty_tpl->_assignInScope('END_TIME', $_smarty_tpl->tpl_vars['RECORD']->value->get('time_end'));
$_smarty_tpl->_assignInScope('RECORD_ID', $_smarty_tpl->tpl_vars['RECORD']->value->getId());
?><div class="panel borderColor<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('activitytype');?>
" data-record="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
"><div class="panel-heading headingColor<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('activitytype');?>
"<?php if (!empty($_smarty_tpl->tpl_vars['COLOR_LIST']->value[$_smarty_tpl->tpl_vars['RECORD_ID']->value])) {?>style="background: <?php echo $_smarty_tpl->tpl_vars['COLOR_LIST']->value[$_smarty_tpl->tpl_vars['RECORD_ID']->value]['background'];?>
; color: <?php echo $_smarty_tpl->tpl_vars['COLOR_LIST']->value[$_smarty_tpl->tpl_vars['RECORD_ID']->value]['text'];?>
;"<?php }?>><button class="btn btn-success btn-xs pull-right showModal" data-url="index.php?module=Calendar&view=ActivityStateModal&trigger=Reminders&record=<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getId();?>
"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button><img class="activityTypeIcon" src="<?php echo vimage_path($_smarty_tpl->tpl_vars['RECORD']->value->getActivityTypeIcon());?>
" />&nbsp;<a target="_blank" href="index.php?module=Calendar&view=Detail&record=<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('subject');?>
</a></div><div class="panel-body"><div><?php echo \App\Language::translate('Start Date & Time',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <strong><?php echo Vtiger_Util_Helper::formatDateTimeIntoDayString(((string)$_smarty_tpl->tpl_vars['START_DATE']->value)." ".((string)$_smarty_tpl->tpl_vars['START_TIME']->value),$_smarty_tpl->tpl_vars['RECORD']->value->get('allday'));?>
</strong></div><div><?php echo \App\Language::translate('Due Date',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <strong><?php echo Vtiger_Util_Helper::formatDateTimeIntoDayString(((string)$_smarty_tpl->tpl_vars['END_DATE']->value)." ".((string)$_smarty_tpl->tpl_vars['END_TIME']->value),$_smarty_tpl->tpl_vars['RECORD']->value->get('allday'));?>
</strong></div><?php if ($_smarty_tpl->tpl_vars['RECORD']->value->get('activitystatus') != '') {?><div><?php echo \App\Language::translate('Status',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <strong><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('activitystatus');?>
</strong></div><?php }
if ($_smarty_tpl->tpl_vars['RECORD']->value->get('link') != '') {?><div><?php echo \App\Language::translate('FL_RELATION',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <strong><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('link');?>
</strong><?php if ($_smarty_tpl->tpl_vars['PERMISSION_TO_SENDE_MAIL']->value) {
if ($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('internal_mailer') == 1) {
$_smarty_tpl->_assignInScope('COMPOSE_URL', OSSMail_Module_Model::getComposeUrl(vtlib\Functions::getCRMRecordType($_smarty_tpl->tpl_vars['RECORD']->value->get('link')),$_smarty_tpl->tpl_vars['RECORD']->value->get('link'),'Detail','new'));
?><a target="_blank" class="pull-right btn btn-default btn-xs actionIcon" href="<?php echo $_smarty_tpl->tpl_vars['COMPOSE_URL']->value;?>
" title="<?php echo \App\Language::translate('LBL_SEND_EMAIL');?>
"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a><?php } else {
$_smarty_tpl->_assignInScope('URLDATA', OSSMail_Module_Model::getExternalUrl(vtlib\Functions::getCRMRecordType($_smarty_tpl->tpl_vars['RECORD']->value->get('link')),$_smarty_tpl->tpl_vars['RECORD']->value->get('link'),'Detail','new'));
if ($_smarty_tpl->tpl_vars['URLDATA']->value && $_smarty_tpl->tpl_vars['URLDATA']->value != 'mailto:?') {?><a class="pull-right btn btn-default btn-xs actionIcon" href="<?php echo $_smarty_tpl->tpl_vars['URLDATA']->value;?>
" title="<?php echo \App\Language::translate('LBL_CREATEMAIL','OSSMailView');?>
"><span class="glyphicon glyphicon-envelope" title="<?php echo \App\Language::translate('LBL_CREATEMAIL','OSSMailView');?>
"></span></a><?php }
}
}?></div><?php }
if ($_smarty_tpl->tpl_vars['RECORD']->value->get('process') != '') {?><div><?php echo \App\Language::translate('FL_PROCESS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <strong><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('process');?>
</strong></div><?php }
if ($_smarty_tpl->tpl_vars['RECORD']->value->get('subprocess') != '') {?><div><?php echo \App\Language::translate('FL_SUB_PROCESS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <strong><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('subprocess');?>
</strong></div><?php }
if ($_smarty_tpl->tpl_vars['RECORD']->value->get('location') != '') {?><div><?php echo \App\Language::translate('Location',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
:&nbsp;<strong><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('location');?>
</strong><?php if (App\Privilege::isPermitted('OpenStreetMap')) {?><a class="pull-right btn btn-default btn-xs actionIcon" onclick="Vtiger_Index_Js.showLocation('<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('location');?>
')"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></a><?php }?></div><?php }?><hr /><div class="actionRow text-center"><a class="btn btn-default btn-sm btn-success showModal" data-url="index.php?module=Calendar&view=ActivityStateModal&trigger=Reminders&record=<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getId();?>
"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a><a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="15m">15<?php echo \App\Language::translate('LBL_M',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a><a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="30m">30<?php echo \App\Language::translate('LBL_M',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a><a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="1h">1<?php echo \App\Language::translate('LBL_H',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a><a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="2h">2<?php echo \App\Language::translate('LBL_H',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a><a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="6h">6<?php echo \App\Language::translate('LBL_H',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a><a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="1d">1<?php echo \App\Language::translate('LBL_D',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a></div></div></div><?php
}
} else {
?>
<div class="alert alert-info"><?php echo \App\Language::translate('LBL_NO_CURRENT_ACTIVITIES',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</div><?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div>
<?php }
}
