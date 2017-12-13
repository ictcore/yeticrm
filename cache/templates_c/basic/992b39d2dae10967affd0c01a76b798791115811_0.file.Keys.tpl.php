<?php
/* Smarty version 3.1.31, created on 2017-12-07 12:32:46
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Dav/Keys.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28ee9e986b42_49051739',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '992b39d2dae10967affd0c01a76b798791115811' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Dav/Keys.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28ee9e986b42_49051739 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="" id="DavKeysContainer"><div class="widget_header row"><div class="col-md-8"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
echo \App\Language::translate('LBL_DAV_KEYS_DESCRIPTION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div><div class="col-md-4"><button class="btn btn-primary addKey pull-right marginTop20"><?php echo \App\Language::translate('LBL_ADD_KEY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></div></div><div class="contents"><?php if ($_smarty_tpl->tpl_vars['ENABLEDAV']->value) {?><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><?php echo \App\Language::translate('LBL_ALERT_DAV_NO_ACTIVE_TITLE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h4><p><?php echo \App\Language::translate('LBL_ALERT_DAV_NO_ACTIVE_DESC',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</p></div><?php }?><div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button><h4 class="alert-heading"><?php echo \App\Language::translate('LBL_ALERT_DAV_CONFIG_TITLE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h4><p><?php echo \App\Language::translate('LBL_ALERT_DAV_CONFIG_DESC',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value,AppConfig::main('site_URL'));?>
</p></div><div><div class="contents tabbable"><table class="table table-bordered  tableRWD table-condensed listViewEntriesTable"><thead><tr class="blockHeader"><th><strong><?php echo \App\Language::translate('LBL_LOGIN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('LBL_KEY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('LBL_DISPLAY_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('LBL_EMAIL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('LBL_ACTIVE_USER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('CardDAV',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('CalDAV',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('WebDAV',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('LBL_COUNT_CARD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('LBL_COUNT_CAL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th><th><strong><?php echo \App\Language::translate('LBL_TOOLS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></th></tr></thead><tbody><?php $_smarty_tpl->_assignInScope('AMOUNT_DATA', $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getAmountData());
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getAllKeys(), 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->_assignInScope('ADDRESSBOOK', $_smarty_tpl->tpl_vars['AMOUNT_DATA']->value['addressbook'][$_smarty_tpl->tpl_vars['item']->value['addressbooksid']]);
$_smarty_tpl->_assignInScope('CALENDAR', $_smarty_tpl->tpl_vars['AMOUNT_DATA']->value['calendar'][$_smarty_tpl->tpl_vars['item']->value['calendarsid']]);
?><tr data-user="<?php echo $_smarty_tpl->tpl_vars['item']->value['userid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['item']->value['user_name'];?>
"><td><?php echo $_smarty_tpl->tpl_vars['item']->value['user_name'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['item']->value['key'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['item']->value['displayname'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['item']->value['email'];?>
</td><td><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['item']->value['status'],'Users');?>
</td><td><?php if ($_smarty_tpl->tpl_vars['item']->value['addressbooksid']) {
echo \App\Language::translate('LBL_YES');
} else {
echo \App\Language::translate('LBL_NO');
}?></td><td><?php if ($_smarty_tpl->tpl_vars['item']->value['calendarsid']) {
echo \App\Language::translate('LBL_YES');
} else {
echo \App\Language::translate('LBL_NO');
}?></td><td><?php echo \App\Language::translate('LBL_YES');?>
</td><td><?php if ($_smarty_tpl->tpl_vars['ADDRESSBOOK']->value) {
echo $_smarty_tpl->tpl_vars['ADDRESSBOOK']->value;
} else { ?>0<?php }?></td><td><?php if ($_smarty_tpl->tpl_vars['CALENDAR']->value) {
echo $_smarty_tpl->tpl_vars['CALENDAR']->value;
} else { ?>0<?php }?></td><td><button class="btn btn-danger deleteKey"><?php echo \App\Language::translate('LBL_DELETE_KEY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></td></tr><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</tbody></table></div></div><div class="modal addKeyContainer fade" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header contentsBackground"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-title"><?php echo \App\Language::translate('LBL_ADD_KEY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><div class="modal-body"><form class="form-horizontal"><div class="form-group"><label class="col-sm-3 control-label"><?php echo \App\Language::translate('LBL_SELECT_USER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="col-sm-6 controls"><select class="select user form-control" name="user" data-validation-engine="validate[required]"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['USERS']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value->getDisplayName();?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div><div class="form-group"><label class="col-sm-3 control-label"><?php echo \App\Language::translate('LBL_SELECT_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="col-sm-6 controls"><select multiple="" class="select type form-control" name="type"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getTypes(), 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?><option selected="" value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</select></div></div></form></div><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('ModalFooter.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div></div></div></div>
<?php }
}
