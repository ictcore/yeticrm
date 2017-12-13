<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:30:26
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/ButtonLink.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279c92c69fd3_96311871',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '64391212b35ff9c8856e69f30783afb0e7644201' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/ButtonLink.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279c92c69fd3_96311871 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="btn-group <?php if (strrpos($_smarty_tpl->tpl_vars['BUTTON_VIEW']->value,'listView') !== false && $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('rowheight') == 'narrow') {?>btn-group-sm<?php }?>"><?php $_smarty_tpl->_assignInScope('LABEL', $_smarty_tpl->tpl_vars['LINK']->value->getLabel());
$_smarty_tpl->_assignInScope('ACTION_NAME', $_smarty_tpl->tpl_vars['LABEL']->value);
if ($_smarty_tpl->tpl_vars['LINK']->value->get('linkhint') != '') {
$_smarty_tpl->_assignInScope('ACTION_NAME', $_smarty_tpl->tpl_vars['LINK']->value->get('linkhint'));
$_smarty_tpl->_assignInScope('LABEL', $_smarty_tpl->tpl_vars['LINK']->value->get('linkhint'));
}
$_smarty_tpl->_assignInScope('LINK_URL', $_smarty_tpl->tpl_vars['LINK']->value->getUrl());
$_smarty_tpl->_assignInScope('BTN_MODULE', $_smarty_tpl->tpl_vars['LINK']->value->getRelatedModuleName($_smarty_tpl->tpl_vars['MODULE']->value));
if ($_smarty_tpl->tpl_vars['LINK']->value->get('linkhref')) {?><a<?php } else { ?><button type="button"<?php }?> <?php if (!$_smarty_tpl->tpl_vars['LINK']->value->isActive()) {?> disabled <?php }?>id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['BUTTON_VIEW']->value;?>
_action_<?php echo Vtiger_Util_Helper::replaceSpaceWithUnderScores($_smarty_tpl->tpl_vars['ACTION_NAME']->value);?>
" class="btn <?php if ($_smarty_tpl->tpl_vars['LINK']->value->getClassName() != '') {
if (strrpos($_smarty_tpl->tpl_vars['LINK']->value->getClassName(),"btn-") === false) {?>btn-default <?php }
echo $_smarty_tpl->tpl_vars['LINK']->value->getClassName();
} else { ?>btn-default<?php }?> <?php if ($_smarty_tpl->tpl_vars['LABEL']->value != '' && $_smarty_tpl->tpl_vars['LINK']->value->get('showLabel') != '1') {?> popoverTooltip<?php }?> <?php if ($_smarty_tpl->tpl_vars['LINK']->value->get('modalView')) {?>showModal<?php }?>"<?php if ($_smarty_tpl->tpl_vars['LINK']->value->get('linkdata') != '' && is_array($_smarty_tpl->tpl_vars['LINK']->value->get('linkdata'))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LINK']->value->get('linkdata'), 'DATA', false, 'NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['NAME']->value => $_smarty_tpl->tpl_vars['DATA']->value) {
?> data-<?php echo $_smarty_tpl->tpl_vars['NAME']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['DATA']->value;?>
"<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?> <?php if ($_smarty_tpl->tpl_vars['LABEL']->value != '' && $_smarty_tpl->tpl_vars['LINK']->value->get('showLabel') != 1) {?>data-placement="bottom" data-content="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['LABEL']->value,$_smarty_tpl->tpl_vars['BTN_MODULE']->value);?>
"<?php }?> <?php if ($_smarty_tpl->tpl_vars['LINK']->value->get('linkhref')) {?>href="<?php echo $_smarty_tpl->tpl_vars['LINK_URL']->value;?>
"<?php }?> <?php if ($_smarty_tpl->tpl_vars['LINK']->value->get('linktarget')) {?>target="<?php echo $_smarty_tpl->tpl_vars['LINK']->value->get('linktarget');?>
"<?php }?> <?php if ($_smarty_tpl->tpl_vars['LINK']->value->get('modalView')) {?>data-url="<?php echo $_smarty_tpl->tpl_vars['LINK_URL']->value;?>
"<?php } else {
if ($_smarty_tpl->tpl_vars['LINK']->value->get('linkPopup')) {?>onclick="window.open('<?php echo $_smarty_tpl->tpl_vars['LINK_URL']->value;?>
', '<?php if ($_smarty_tpl->tpl_vars['LINK']->value->get('linktarget')) {
echo $_smarty_tpl->tpl_vars['LINK']->value->get('linktarget');
} else { ?>_self<?php }?>'<?php if ($_smarty_tpl->tpl_vars['LINK']->value->get('linkPopup')) {?>, 'resizable=yes,location=no,scrollbars=yes,toolbar=no,menubar=no,status=no'<?php }?>)"<?php } else {
if ($_smarty_tpl->tpl_vars['LINK_URL']->value != '' && !$_smarty_tpl->tpl_vars['LINK']->value->get('linkhref')) {
if (stripos($_smarty_tpl->tpl_vars['LINK_URL']->value,'javascript:') === 0) {?>onclick='<?php echo substr($_smarty_tpl->tpl_vars['LINK_URL']->value,strlen("javascript:"));?>
;'<?php } else { ?>onclick='window.location.href = "<?php echo $_smarty_tpl->tpl_vars['LINK_URL']->value;?>
"'<?php }
}
}
}?>><?php if ($_smarty_tpl->tpl_vars['LINK']->value->get('linkimg') != '') {?><img class="image-in-button" src="<?php echo $_smarty_tpl->tpl_vars['LINK']->value->get('linkimg');?>
" title="<?php echo \App\Language::translate($_smarty_tpl->tpl_vars['LABEL']->value,$_smarty_tpl->tpl_vars['BTN_MODULE']->value);?>
"><?php } elseif ($_smarty_tpl->tpl_vars['LINK']->value->get('linkicon') != '') {?><span class="<?php echo $_smarty_tpl->tpl_vars['LINK']->value->get('linkicon');?>
"></span><?php }
if ($_smarty_tpl->tpl_vars['LABEL']->value != '' && $_smarty_tpl->tpl_vars['LINK']->value->get('showLabel') == 1) {
if ($_smarty_tpl->tpl_vars['LINK']->value->get('linkimg') != '' || $_smarty_tpl->tpl_vars['LINK']->value->get('linkicon') != '') {?>&nbsp;&nbsp;<?php }?><strong><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['LABEL']->value,$_smarty_tpl->tpl_vars['BTN_MODULE']->value);?>
</strong><?php }
if ($_smarty_tpl->tpl_vars['LINK']->value->get('linkhref')) {?></a><?php } else { ?></button><?php }?></div>
<?php }
}
