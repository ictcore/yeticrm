<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:31
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/RelatedActivities.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d4b603c74_21950478',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '10a4b4b2712bbfdd399a150e291a99675f6bf4e1' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/RelatedActivities.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d4b603c74_21950478 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/usr/ictcore/wwwroot/YetiForceCRM/vendor/smarty/smarty/libs/plugins/modifier.truncate.php';
?>

<?php $_smarty_tpl->_assignInScope('MODULE_NAME', "Calendar");
if (count($_smarty_tpl->tpl_vars['ACTIVITIES']->value) != '0') {
if ($_smarty_tpl->tpl_vars['PAGE_NUMBER']->value == 1) {?><input type="hidden" class="totaltActivities" value="<?php echo $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->get('totalCount');?>
"><input type="hidden" class="pageLimit" value="<?php echo $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->getPageLimit();?>
"><?php }?><input type="hidden" class="countActivities" value="<?php echo count($_smarty_tpl->tpl_vars['ACTIVITIES']->value);?>
"><input type="hidden" class="currentPage" value="<?php echo $_smarty_tpl->tpl_vars['PAGE_NUMBER']->value;?>
"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ACTIVITIES']->value, 'RECORD', false, 'KEY', 'activities', array (
  'first' => true,
  'last' => true,
  'index' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['KEY']->value => $_smarty_tpl->tpl_vars['RECORD']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['index'];
$_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['total'];
if ($_smarty_tpl->tpl_vars['PAGE_NUMBER']->value != 1 && (isset($_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['first'] : null)) {?><hr><?php }
$_smarty_tpl->_assignInScope('START_DATE', $_smarty_tpl->tpl_vars['RECORD']->value->get('date_start'));
$_smarty_tpl->_assignInScope('START_TIME', $_smarty_tpl->tpl_vars['RECORD']->value->get('time_start'));
$_smarty_tpl->_assignInScope('END_DATE', $_smarty_tpl->tpl_vars['RECORD']->value->get('due_date'));
$_smarty_tpl->_assignInScope('END_TIME', $_smarty_tpl->tpl_vars['RECORD']->value->get('time_end'));
$_smarty_tpl->_assignInScope('STATUS', $_smarty_tpl->tpl_vars['RECORD']->value->get('status'));
$_smarty_tpl->_assignInScope('SHAREDOWNER', Vtiger_SharedOwner_UIType::getSharedOwners($_smarty_tpl->tpl_vars['RECORD']->value->get('crmid'),$_smarty_tpl->tpl_vars['RECORD']->value->getModuleName()));
?><div class="activityEntries padding5"<?php $_prefixVariable1=$_smarty_tpl->tpl_vars['COLOR_LIST']->value[$_smarty_tpl->tpl_vars['RECORD']->value->getId()];
if (!empty($_prefixVariable1)) {?>style="background: <?php echo $_smarty_tpl->tpl_vars['COLOR_LIST']->value[$_smarty_tpl->tpl_vars['RECORD']->value->getId()]['background'];?>
; color: <?php echo $_smarty_tpl->tpl_vars['COLOR_LIST']->value[$_smarty_tpl->tpl_vars['RECORD']->value->getId()]['text'];?>
"<?php }?>><input type="hidden" class="activityId" value="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('activityid');?>
"/><div class="row"><span class="col-md-6"><strong title='<?php echo Vtiger_Util_Helper::formatDateTimeIntoDayString(((string)$_smarty_tpl->tpl_vars['START_DATE']->value)." ".((string)$_smarty_tpl->tpl_vars['START_TIME']->value));?>
'><span class="glyphicon glyphicon-time"></span>&nbsp;&nbsp;<?php echo Vtiger_Util_Helper::formatDateIntoStrings($_smarty_tpl->tpl_vars['START_DATE']->value,$_smarty_tpl->tpl_vars['START_TIME']->value);?>
</strong></span><span class="col-md-6 rightText"><strong title='<?php echo Vtiger_Util_Helper::formatDateTimeIntoDayString(((string)$_smarty_tpl->tpl_vars['END_DATE']->value)." ".((string)$_smarty_tpl->tpl_vars['END_TIME']->value));?>
'><span class="glyphicon glyphicon-time"></span>&nbsp;&nbsp;<?php echo Vtiger_Util_Helper::formatDateIntoStrings($_smarty_tpl->tpl_vars['END_DATE']->value,$_smarty_tpl->tpl_vars['END_TIME']->value);?>
</strong></span></div><div class="summaryViewEntries"><?php $_smarty_tpl->_assignInScope('ACTIVITY_TYPE', $_smarty_tpl->tpl_vars['RECORD']->value->get('activitytype'));
$_smarty_tpl->_assignInScope('ACTIVITY_UPPERCASE', mb_strtoupper($_smarty_tpl->tpl_vars['ACTIVITY_TYPE']->value, 'UTF-8'));
?><img src="<?php echo Vtiger_Theme::getOrignOrDefaultImgPath($_smarty_tpl->tpl_vars['ACTIVITY_TYPE']->value,'Calendar');?>
" width="14px" class="textOverflowEllipsis" alt="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"/>&nbsp;&nbsp;<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['ACTIVITY_TYPE']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
&nbsp;-&nbsp;<?php if ($_smarty_tpl->tpl_vars['RECORD']->value->isViewable()) {?><a href="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDetailViewUrl();?>
" ><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('subject');?>
</a><?php } else {
echo $_smarty_tpl->tpl_vars['RECORD']->value->get('subject');
}?>&nbsp;<?php if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value && $_smarty_tpl->tpl_vars['RECORD']->value->isEditable()) {?><a href="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getEditViewUrl();?>
" class="fieldValue"><span class="glyphicon glyphicon-pencil summaryViewEdit" title="<?php echo \App\Language::translate('LBL_EDIT',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"></span></a><?php }
if ($_smarty_tpl->tpl_vars['RECORD']->value->isViewable()) {?>&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getDetailViewUrl();?>
" class="fieldValue"><span title="<?php echo \App\Language::translate('LBL_SHOW_COMPLETE_DETAILS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" class="glyphicon glyphicon-th-list summaryViewEdit"></span></a><?php }?></div><div class="row"><div class="activityStatus col-md-12"><?php if ($_smarty_tpl->tpl_vars['RECORD']->value->get('activitytype') == 'Task') {
$_smarty_tpl->_assignInScope('MODULE_NAME', $_smarty_tpl->tpl_vars['RECORD']->value->getModuleName());
?><input type="hidden" class="activityModule" value="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getModuleName();?>
"/><input type="hidden" class="activityType" value="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('activitytype');?>
"/><?php if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value && $_smarty_tpl->tpl_vars['RECORD']->value->isEditable()) {?><div><strong><span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<span class="value"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['RECORD']->value->get('status'),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</span></strong>&nbsp;&nbsp;<?php if ($_smarty_tpl->tpl_vars['DATA_TYPE']->value != 'history') {?><span class="editDefaultStatus pull-right cursorPointer popoverTooltip delay0" data-url="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getActivityStateModalUrl();?>
" data-content="<?php echo \App\Language::translate('LBL_SET_RECORD_STATUS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"><span class="glyphicon glyphicon-ok"></span></span><?php }?></div><?php }
} else {
$_smarty_tpl->_assignInScope('MODULE_NAME', "Events");
?><input type="hidden" class="activityModule" value="Events"/><input type="hidden" class="activityType" value="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('activitytype');?>
"/><?php if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value && $_smarty_tpl->tpl_vars['RECORD']->value->isEditable()) {?><div><strong><span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<span class="value"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['RECORD']->value->get('status'),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</span></strong>&nbsp;&nbsp;<?php if ($_smarty_tpl->tpl_vars['DATA_TYPE']->value != 'history') {?><span class="editDefaultStatus pull-right cursorPointer popoverTooltip delay0" data-url="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getActivityStateModalUrl();?>
" data-content="<?php echo \App\Language::translate('LBL_SET_RECORD_STATUS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"><span class="glyphicon glyphicon-ok"></span></span><?php }?></div><?php }
}?></div></div><div class="activityDescription"><div><span class="value"><span class="glyphicon glyphicon-align-justify"></span>&nbsp;&nbsp;<?php if ($_smarty_tpl->tpl_vars['RECORD']->value->get('description') != '') {
echo smarty_modifier_truncate(\App\Language::translate($_smarty_tpl->tpl_vars['RECORD']->value->get('description'),$_smarty_tpl->tpl_vars['MODULE_NAME']->value),120,'...');
} else { ?><span class="muted"><?php echo \App\Language::translate('LBL_NO_DESCRIPTION',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</span><?php }?></span>&nbsp;&nbsp;<?php if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value) {?><span class="editDescription cursorPointer"><span class="glyphicon glyphicon-pencil" title="<?php echo \App\Language::translate('LBL_EDIT',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"></span></span><?php }?><span class="pull-right popoverTooltip delay0" data-placement="top" data-original-title="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['RECORD']->value->get('activitytype'),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('subject');?>
"data-content="<?php echo \App\Language::translate('Status',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <?php echo \App\Language::translate($_smarty_tpl->tpl_vars['STATUS']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
<br /><?php echo \App\Language::translate('Start Time','Calendar');?>
: <?php echo $_smarty_tpl->tpl_vars['START_DATE']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['START_TIME']->value;?>
<br /><?php echo \App\Language::translate('End Time','Calendar');?>
: <?php echo $_smarty_tpl->tpl_vars['END_DATE']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['END_TIME']->value;?>
<hr /><?php echo \App\Language::translate('Created By',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <?php echo vtlib\Functions::getOwnerRecordLabel($_smarty_tpl->tpl_vars['RECORD']->value->get('smcreatorid'));?>
<br /><?php echo \App\Language::translate('Assigned To',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
: <?php echo vtlib\Functions::getOwnerRecordLabel($_smarty_tpl->tpl_vars['RECORD']->value->get('smownerid'));
if ($_smarty_tpl->tpl_vars['SHAREDOWNER']->value) {?><div><?php echo \App\Language::translate('Share with users',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
:&nbsp;<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SHAREDOWNER']->value, 'SOWNERID', false, NULL, 'sowner', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['SOWNERID']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_sowner']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_sowner']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_sowner']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_sowner']->value['total'];
if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_sowner']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_sowner']->value['last'] : null)) {?>,&nbsp;<?php }
echo \App\Fields\Owner::getUserLabel($_smarty_tpl->tpl_vars['SOWNERID']->value);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div><?php }
if ($_smarty_tpl->tpl_vars['MODULE_NAME']->value == 'Events') {
if (count($_smarty_tpl->tpl_vars['RECORD']->value->get('selectedusers')) > 0) {?><br /><?php echo \App\Language::translate('LBL_INVITE_RECORDS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
:<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RECORD']->value->get('selectedusers'), 'USER', false, 'KEY');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['KEY']->value => $_smarty_tpl->tpl_vars['USER']->value) {
if ($_smarty_tpl->tpl_vars['USER']->value) {
echo vtlib\Functions::getOwnerRecordLabel($_smarty_tpl->tpl_vars['USER']->value);
}
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}?>"><span class="glyphicon glyphicon-info-sign"></span></span><?php if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value && $_smarty_tpl->tpl_vars['RECORD']->value->isEditable()) {?><span class="2 edit hide row"><?php $_smarty_tpl->_assignInScope('FIELD_MODEL', $_smarty_tpl->tpl_vars['RECORD']->value->getModule()->getField('description'));
$_smarty_tpl->_assignInScope('FIELD_VALUE', $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->set('fieldvalue',$_smarty_tpl->tpl_vars['RECORD']->value->get('description')));
$_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getTemplateName(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('FIELD_MODEL'=>$_smarty_tpl->tpl_vars['FIELD_MODEL']->value,'USER_MODEL'=>$_smarty_tpl->tpl_vars['USER_MODEL']->value,'MODULE'=>$_smarty_tpl->tpl_vars['MODULE_NAME']->value), 0, true);
if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType() == 'multipicklist') {?><input type="hidden" class="fieldname" value='<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
[]' data-prev-value='<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'));?>
' /><?php } else { ?><input type="hidden" class="fieldname" value='<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
' data-prev-value='<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'));?>
' /><?php }?></span><?php }
if ($_smarty_tpl->tpl_vars['RECORD']->value->get('location') != '') {?><a target="_blank" href="https://www.google.com/maps/search/<?php echo urlencode($_smarty_tpl->tpl_vars['RECORD']->value->get('location'));?>
" class="pull-right popoverTooltip delay0" data-original-title="<?php echo \App\Language::translate('Location','Calendar');?>
" data-content="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('location');?>
"><span class="icon-map-marker"></span>&nbsp</a><?php }?></div></div></div><?php if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_activities']->value['last'] : null)) {?><hr><?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
} else { ?><div class="summaryWidgetContainer"><p class="textAlignCenter"><?php echo \App\Language::translate('LBL_NO_PENDING_ACTIVITIES',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</p></div><?php }
if ($_smarty_tpl->tpl_vars['PAGING_MODEL']->value->isNextPageExists()) {?><div class="row"><div class="pull-right"><button type="button" class="btn btn-primary btn-xs moreRecentActivities marginTop10 marginRight10"><?php echo \App\Language::translate('LBL_MORE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
..</button></div></div><?php }
}
}
