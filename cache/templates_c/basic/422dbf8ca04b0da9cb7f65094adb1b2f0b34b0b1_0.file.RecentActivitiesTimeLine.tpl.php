<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:31
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/RecentActivitiesTimeLine.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d4b7a7b58_33717212',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '422dbf8ca04b0da9cb7f65094adb1b2f0b34b0b1' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/RecentActivitiesTimeLine.tpl',
      1 => 1502273912,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d4b7a7b58_33717212 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="recentActivitiesContainer row no-margin"><input type="hidden" id="updatesCurrentPage" value="<?php echo $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->get('page');?>
" /><input type="hidden" id="updatesPageLimit" value="<?php echo $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->getPageLimit();?>
" /><?php if (!empty($_smarty_tpl->tpl_vars['RECENT_ACTIVITIES']->value)) {?><div id="updates"><ul class="timeline"><?php $_smarty_tpl->_assignInScope('COUNT', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RECENT_ACTIVITIES']->value, 'RECENT_ACTIVITY', false, NULL, 'recentActivites', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value) {
$_smarty_tpl->_assignInScope('PROCEED', TRUE);
if (($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isRelationLink()) || ($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isRelationUnLink())) {
$_smarty_tpl->_assignInScope('RELATION', $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getRelationInstance());
if (!($_smarty_tpl->tpl_vars['RELATION']->value->getLinkedRecord())) {
$_smarty_tpl->_assignInScope('PROCEED', FALSE);
}
}
if ($_smarty_tpl->tpl_vars['PROCEED']->value) {?><li><?php if ($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isReviewed() && !($_smarty_tpl->tpl_vars['COUNT']->value == 0 && $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->get('page') == 1)) {
$_smarty_tpl->_assignInScope('NEW_CHANGE', false);
?><div class="lineOfText marginLeft15"><div><?php echo \App\Language::translate('LBL_REVIEWED',$_smarty_tpl->tpl_vars['MODULE_BASE_NAME']->value);?>
</div></div><?php }
$_smarty_tpl->_assignInScope('COUNT', $_smarty_tpl->tpl_vars['COUNT']->value+1);
if ($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isCreate()) {?><span class="glyphicon glyphicon-plus bgGreen"></span><div class="timeline-item<?php if ($_smarty_tpl->tpl_vars['NEW_CHANGE']->value) {?> bgWarning<?php }?>"><div class="pull-left paddingRight15 imageContainer"><img class="userImage img-circle" src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getModifiedBy()->getImagePath()));?>
" ></div><div class="timeline-body row no-margin"><span class="time pull-right"><span title="<?php echo $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getDisplayActivityTime();?>
"><?php echo Vtiger_Util_Helper::formatDateDiffInStrings($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getParent()->get('createdtime'));?>
</span></span><strong><?php echo $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getModifiedBy()->getName();?>
</strong>&nbsp;<?php echo \App\Language::translate('LBL_CREATED',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getFieldInstances(), 'FIELDMODEL');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['FIELDMODEL']->value) {
if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value && $_smarty_tpl->tpl_vars['FIELDMODEL']->value->getFieldInstance() && $_smarty_tpl->tpl_vars['FIELDMODEL']->value->getFieldInstance()->isViewable() && $_smarty_tpl->tpl_vars['FIELDMODEL']->value->getFieldInstance()->getDisplayType() != '5') {?><div class='font-x-small updateInfoContainer'><span><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELDMODEL']->value->getName(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</span>:&nbsp;<?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('postvalue') != '') {?><strong class="moreContent"><span class="teaserContent"><?php echo Vtiger_Util_Helper::toVtiger6SafeHTML($_smarty_tpl->tpl_vars['FIELDMODEL']->value->getNewValue());?>
</span><?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value->has('fullPostValue')) {?><span class="fullContent hide"><?php echo $_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('fullPostValue');?>
</span><button type="button" class="btn btn-info btn-xs moreBtn" data-on="<?php echo \App\Language::translate('LBL_MORE_BTN');?>
" data-off="<?php echo \App\Language::translate('LBL_HIDE_BTN');?>
"><?php echo \App\Language::translate('LBL_MORE_BTN');?>
</button><?php }?></strong><?php }?></div><?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div></div><?php } elseif ($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isUpdate()) {?><span class="glyphicon glyphicon-pencil bgDarkBlue"></span><div class="timeline-item<?php if ($_smarty_tpl->tpl_vars['NEW_CHANGE']->value) {?> bgWarning<?php }?>"><div class="pull-left paddingRight15 imageContainer"><img class="userImage img-circle" src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getModifiedBy()->getImagePath()));?>
" ></div><div class="timeline-body row no-margin"><span class="time pull-right"><span title="<?php echo $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getDisplayActivityTime();?>
"><?php echo Vtiger_Util_Helper::formatDateDiffInStrings($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getActivityTime());?>
</span></span><span><strong><?php echo $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getModifiedBy()->getDisplayName();?>
&nbsp;</strong> <?php echo \App\Language::translate('LBL_UPDATED',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</span><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getFieldInstances(), 'FIELDMODEL');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['FIELDMODEL']->value) {
if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value && $_smarty_tpl->tpl_vars['FIELDMODEL']->value->getFieldInstance() && $_smarty_tpl->tpl_vars['FIELDMODEL']->value->getFieldInstance()->isViewable() && $_smarty_tpl->tpl_vars['FIELDMODEL']->value->getFieldInstance()->getDisplayType() != '5') {?><div class='font-x-small updateInfoContainer'><span><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['FIELDMODEL']->value->getName(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</span>:&nbsp;<?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('prevalue') != '' && $_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('postvalue') != '' && !($_smarty_tpl->tpl_vars['FIELDMODEL']->value->getFieldInstance()->getFieldDataType() == 'reference' && ($_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('postvalue') == '0' || $_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('prevalue') == '0'))) {?>&nbsp;<?php echo \App\Language::translate('LBL_FROM');?>
&nbsp;<strong class="moreContent"><span class="teaserContent"><?php echo Vtiger_Util_Helper::toVtiger6SafeHTML($_smarty_tpl->tpl_vars['FIELDMODEL']->value->getOldValue());?>
</span><?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value->has('fullPreValue')) {?><span class="fullContent hide"><?php echo $_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('fullPreValue');?>
</span><button type="button" class="btn btn-info btn-xs moreBtn" data-on="<?php echo \App\Language::translate('LBL_MORE_BTN');?>
" data-off="<?php echo \App\Language::translate('LBL_HIDE_BTN');?>
"><?php echo \App\Language::translate('LBL_MORE_BTN');?>
</button><?php }?></strong><?php } elseif ($_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('postvalue') == '' || ($_smarty_tpl->tpl_vars['FIELDMODEL']->value->getFieldInstance()->getFieldDataType() == 'reference' && $_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('postvalue') == '0')) {?>&nbsp;<strong><?php echo \App\Language::translate('LBL_DELETED');?>
</strong>( <del><?php echo Vtiger_Util_Helper::toVtiger6SafeHTML($_smarty_tpl->tpl_vars['FIELDMODEL']->value->getOldValue());?>
</del> )<?php } else { ?>&nbsp;<?php echo \App\Language::translate('LBL_CHANGED');
}
if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('postvalue') != '' && !($_smarty_tpl->tpl_vars['FIELDMODEL']->value->getFieldInstance()->getFieldDataType() == 'reference' && $_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('postvalue') == '0')) {?>&nbsp;<?php echo \App\Language::translate('LBL_TO');?>
&nbsp;<strong class="moreContent"><span class="teaserContent"><?php echo Vtiger_Util_Helper::toVtiger6SafeHTML($_smarty_tpl->tpl_vars['FIELDMODEL']->value->getNewValue());?>
</span><?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value->has('fullPostValue')) {?><span class="fullContent hide"><?php echo $_smarty_tpl->tpl_vars['FIELDMODEL']->value->get('fullPostValue');?>
</span><button type="button" class="btn btn-info btn-xs moreBtn" data-on="<?php echo \App\Language::translate('LBL_MORE_BTN');?>
" data-off="<?php echo \App\Language::translate('LBL_HIDE_BTN');?>
"><?php echo \App\Language::translate('LBL_MORE_BTN');?>
</button><?php }?></strong><?php }?></div><?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div></div><?php } elseif (($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isRelationLink() || $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isRelationUnLink())) {?><span class="glyphicon glyphicon-link bgOrange"></span><div class="timeline-item<?php if ($_smarty_tpl->tpl_vars['NEW_CHANGE']->value) {?> bgWarning<?php }?>"><div class="pull-left paddingRight15 imageContainer"><img class="userImage img-circle" src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getModifiedBy()->getImagePath()));?>
" ></div><div class="timeline-body row no-margin"><div class="pull-right"><span class="time pull-right"><span title="<?php echo $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getDisplayActivityTime();?>
"><?php echo Vtiger_Util_Helper::formatDateDiffInStrings($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getActivityTime());?>
</span></span></div><span><strong><?php echo $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getModifiedBy()->getName();?>
&nbsp;</strong></span><?php $_smarty_tpl->_assignInScope('RELATION', $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getRelationInstance());
?><span><?php if ($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isRelationLink()) {
echo \App\Language::translate('LBL_ADDED',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);
} else {
echo \App\Language::translate('LBL_REMOVED',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);
}?>&nbsp;</span><span><?php if (Users_Privileges_Model::isPermitted($_smarty_tpl->tpl_vars['RELATION']->value->getLinkedRecord()->getModuleName(),'DetailView',$_smarty_tpl->tpl_vars['RELATION']->value->getLinkedRecord()->getId())) {?><strong class="moreContent"><span class="teaserContent"><?php echo Vtiger_Util_Helper::toVtiger6SafeHTML($_smarty_tpl->tpl_vars['RELATION']->value->getValue());?>
</span><?php if ($_smarty_tpl->tpl_vars['RELATION']->value->has('fullValue')) {?><span class="fullContent hide"><?php echo $_smarty_tpl->tpl_vars['RELATION']->value->get('fullValue');?>
</span><button type="button" class="btn btn-info btn-xs moreBtn" data-on="<?php echo \App\Language::translate('LBL_MORE_BTN');?>
" data-off="<?php echo \App\Language::translate('LBL_HIDE_BTN');?>
"><?php echo \App\Language::translate('LBL_MORE_BTN');?>
</button><?php }?></strong><?php }?></span><span>&nbsp;(<?php echo \App\Language::translate(('SINGLE_').($_smarty_tpl->tpl_vars['RELATION']->value->getLinkedRecord()->getModuleName()),$_smarty_tpl->tpl_vars['RELATION']->value->getLinkedRecord()->getModuleName());?>
)</span></div></div><?php } elseif ($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isRestore()) {
} elseif ($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isConvertToAccount()) {?><span class="glyphicon glyphicon-transfer bgAzure"></span><div class="timeline-item<?php if ($_smarty_tpl->tpl_vars['NEW_CHANGE']->value) {?> bgWarning<?php }?>"><div class="pull-left paddingRight15 imageContainer"><img class="userImage img-circle" src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getModifiedBy()->getImagePath()));?>
" ></div><div class="timeline-body row no-margin"><span class="time pull-right"><span title="<?php echo $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getDisplayActivityTime();?>
"><?php echo Vtiger_Util_Helper::formatDateDiffInStrings($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getActivityTime());?>
</span></span><div class="pull-left"><strong><?php echo \App\Language::translate('LBL_CONVERTED_FROM_LEAD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></div></div></div><?php } elseif ($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->isDisplayed()) {?><span class="glyphicon glyphicon-th-list bgAzure"></span><div class="timeline-item"><div class="pull-left paddingRight15 imageContainer"><img class="userImage img-circle" src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getModifiedBy()->getImagePath()));?>
" ></div><div class="timeline-body row no-margin"><span class="time pull-right"><span title="<?php echo $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getDisplayActivityTime();?>
"><?php echo Vtiger_Util_Helper::formatDateDiffInStrings($_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getActivityTime());?>
</span></span><div class="pull-left"><strong><?php echo $_smarty_tpl->tpl_vars['RECENT_ACTIVITY']->value->getModifiedBy()->getName();?>
</strong>&nbsp;<?php echo \App\Language::translate('LBL_DISPLAYED',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</div></div></div><?php }?></li><?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</ul></div><?php } else { ?><div class="summaryWidgetContainer"><p class="textAlignCenter"><?php echo \App\Language::translate('LBL_NO_RECENT_UPDATES');?>
</p></div><?php }?><input type="hidden" id="newChange" value="<?php echo $_smarty_tpl->tpl_vars['NEW_CHANGE']->value;?>
" /><div id="moreLink"><?php if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value && $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->isNextPageExists()) {?><div class="pull-right"><button type="button" class="btn btn-primary btn-xs moreRecentUpdates"><?php echo \App\Language::translate('LBL_MORE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
..</button></div><?php }?></div></div>
<?php }
}
