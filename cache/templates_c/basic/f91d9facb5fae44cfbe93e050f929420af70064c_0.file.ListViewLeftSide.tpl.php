<?php
/* Smarty version 3.1.31, created on 2017-12-08 15:22:50
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Documents/ListViewLeftSide.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a67fa268e89_21858387',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f91d9facb5fae44cfbe93e050f929420af70064c' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Documents/ListViewLeftSide.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a67fa268e89_21858387 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->getId();?>
" class="listViewEntriesCheckBox" title="<?php echo \App\Language::translate('LBL_SELECT_SINGLE_ROW');?>
" /></div>&nbsp;<?php $_smarty_tpl->_assignInScope('IMAGE_CLASS', Documents_Record_Model::getFileIconByFileType($_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->get('filetype')));
?><span class="<?php echo $_smarty_tpl->tpl_vars['IMAGE_CLASS']->value;?>
 fa-lg middle <?php if ($_smarty_tpl->tpl_vars['IMAGE_CLASS']->value == 'userIcon-Documents') {?>back4RightMargin<?php }?>"></span><?php $_smarty_tpl->_assignInScope('LINKS', $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->getRecordListViewLinksLeftSide());
if (count($_smarty_tpl->tpl_vars['LINKS']->value) > 0) {
$_smarty_tpl->_assignInScope('ONLY_ONE', count($_smarty_tpl->tpl_vars['LINKS']->value) == 1);
?><div class="actions"><div class="<?php if (!$_smarty_tpl->tpl_vars['ONLY_ONE']->value) {?>actionImages hide<?php }?>"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LINKS']->value, 'LINK');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['LINK']->value) {
$_smarty_tpl->_subTemplateRender(vtemplate_path('ButtonLink.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('BUTTON_VIEW'=>'listViewBasic'), 0, true);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</div><?php if (!$_smarty_tpl->tpl_vars['ONLY_ONE']->value) {?><button type="button" class="btn btn-sm btn-default toolsAction"><span class="glyphicon glyphicon-wrench"></span></button><?php }?></div><?php }?><div><?php if (in_array($_smarty_tpl->tpl_vars['MODULE']->value,AppConfig::module('ModTracker','SHOW_TIMELINE_IN_LISTVIEW')) && $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isPermitted('TimeLineList')) {?><a type="button" data-url="<?php echo $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->getTimeLineUrl();?>
" class="timeLineIconList hide"><span class="glyphicon" aria-hidden="true"></span></a><?php }
if (AppConfig::module('ModTracker','UNREVIEWED_COUNT') && $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isPermitted('ReviewingUpdates') && $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isTrackingEnabled() && $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->isViewable()) {?><a href="<?php echo $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->getUpdatesUrl();?>
" class="unreviewed"><span class="badge bgDanger all" title="<?php echo \App\Language::translate('LBL_NUMBER_UNREAD_CHANGES','ModTracker');?>
"></span><span class="badge bgBlue mail noLeftRadius noRightRadius" title="<?php echo \App\Language::translate('LBL_NUMBER_UNREAD_MAILS','ModTracker');?>
"></span></a><?php }?></div>

<?php }
}
