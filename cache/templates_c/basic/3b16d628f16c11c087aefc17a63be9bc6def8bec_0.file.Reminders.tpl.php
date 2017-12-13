<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:26:40
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Notification/Reminders.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279bb0cfdfa7_31206608',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3b16d628f16c11c087aefc17a63be9bc6def8bec' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Notification/Reminders.tpl',
      1 => 1502273912,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279bb0cfdfa7_31206608 (Smarty_Internal_Template $_smarty_tpl) {
?>

<style><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['COLORS']->value, 'VALUE', false, 'NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['NAME']->value => $_smarty_tpl->tpl_vars['VALUE']->value) {
?>.headingColor<?php echo $_smarty_tpl->tpl_vars['NAME']->value;?>
{background-color: <?php echo $_smarty_tpl->tpl_vars['VALUE']->value;?>
 !important;border-color: <?php echo $_smarty_tpl->tpl_vars['VALUE']->value;?>
;background: linear-gradient(-10deg, #fff, transparent 70%)}<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</style><div class="remindersContent"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RECORDS']->value, 'RECORD');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['RECORD']->value) {
?><div class="panel headingColor<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('notification_type');?>
" data-record="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getId();?>
"><div class="panel-body padding0"><div class="col-xs-2 notificationIcon"><span class="glyphicon <?php if ($_smarty_tpl->tpl_vars['RECORD']->value->get('notification_type') == 'PLL_SYSTEM') {?>glyphicon-hdd<?php } else { ?>glyphicon-user<?php }?>" aria-hidden="true"></span></div><div class="col-xs-10 paddingLR5 notiContent"><div class="col-xs-6 paddingLRZero marginTB3 font-larger"><strong class="pull-left"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['RECORD']->value->get('notification_type'),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></div><div class="col-xs-6 paddingLRZero marginTB3 font-larger"><strong class="pull-right"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDisplayValue('createdtime');?>
</strong></div><div class="col-xs-12 paddingLRZero marginBottom5"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getTitle();?>
<div class="moreContent"><?php $_smarty_tpl->_assignInScope('FULL_TEXT', $_smarty_tpl->tpl_vars['RECORD']->value->getMessage());
?><span class="teaserContent"><?php if (strlen(strip_tags($_smarty_tpl->tpl_vars['FULL_TEXT']->value)) <= 200) {
echo $_smarty_tpl->tpl_vars['FULL_TEXT']->value;
$_smarty_tpl->_assignInScope('SHOW_BUTTON', false);
} else {
echo substr(Vtiger_Util_Helper::toSafeHTML(strip_tags($_smarty_tpl->tpl_vars['FULL_TEXT']->value)),0,200);
$_smarty_tpl->_assignInScope('SHOW_BUTTON', true);
}?></span><?php if ($_smarty_tpl->tpl_vars['SHOW_BUTTON']->value) {?><span class="fullContent hide"><?php echo $_smarty_tpl->tpl_vars['FULL_TEXT']->value;?>
</span>&nbsp;<button type="button" class="btn btn-info btn-xs moreBtn" data-on="<?php echo \App\Language::translate('LBL_MORE_BTN');?>
" data-off="<?php echo \App\Language::translate('LBL_HIDE_BTN');?>
"><?php echo \App\Language::translate('LBL_MORE_BTN');?>
</button><?php }?></div></div><div class="col-xs-12 paddingLRZero marginBottom5 "><div class="col-xs-10 paddingLRZero textOverflowEllipsis"><strong class=""><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['RECORD']->value->getModule()->getField('smcreatorid')->get('label'),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getCreatorUser();?>
</strong></div><div class="col-xs-2 paddingLRZero"><button type="button" class="btn btn-success btn-xs pull-right setAsMarked" title="<?php echo \App\Language::translate('LBL_MARK_AS_READ',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></div></div></div></div></div><?php
}
} else {
?>
<div class="alert alert-info"><?php echo \App\Language::translate('LBL_NO_UNREAD_NOTIFICATIONS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</div><?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div>
<?php }
}
