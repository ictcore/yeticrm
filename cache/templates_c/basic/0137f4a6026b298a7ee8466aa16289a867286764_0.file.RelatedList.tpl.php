<?php
/* Smarty version 3.1.31, created on 2017-12-08 10:58:25
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/RelatedList.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a2a01a9e825_40677870',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0137f4a6026b298a7ee8466aa16289a867286764' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/RelatedList.tpl',
      1 => 1483948814,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a2a01a9e825_40677870 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="relatedContainer"><?php $_smarty_tpl->_assignInScope('RELATED_MODULE_NAME', $_smarty_tpl->tpl_vars['RELATED_MODULE']->value->get('name'));
?><input type="hidden" name="currentPageNum" value="<?php echo $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->getCurrentPage();?>
" /><input type="hidden" name="relatedModuleName" class="relatedModuleName" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_MODULE']->value->get('name');?>
" /><input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['ORDER_BY']->value;?>
" id="orderBy"><input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['SORT_ORDER']->value;?>
" id="sortOrder"><input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_ENTIRES_COUNT']->value;?>
" id="noOfEntries"><input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->getPageLimit();?>
" id='pageLimit'><input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['TOTAL_ENTRIES']->value;?>
" id='totalCount'><input type="hidden" id="autoRefreshListOnChange" value="<?php echo AppConfig::performance('AUTO_REFRESH_RECORD_LIST_ON_SELECT_CHANGE');?>
"/><div class="relatedHeader "><div class="btn-toolbar row"><div class="col-md-6 col-sm-6"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['RELATED_LIST_LINKS']->value['LISTVIEWBASIC'], 'RELATED_LINK');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['RELATED_LINK']->value) {
ob_start();
echo Users_Privileges_Model::isPermitted($_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value,'CreateView');
$_prefixVariable1=ob_get_clean();
if ($_prefixVariable1) {?><div class="btn-group paddingRight10"><?php ob_start();
echo $_smarty_tpl->tpl_vars['RELATED_LINK']->value->get('_selectRelation');
$_prefixVariable2=ob_get_clean();
$_smarty_tpl->_assignInScope('IS_SELECT_BUTTON', $_prefixVariable2);
?><button type="button" class="btn addButton btn-default<?php if ($_smarty_tpl->tpl_vars['IS_SELECT_BUTTON']->value == true) {?> selectRelation <?php }?> moduleColor_<?php echo $_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['RELATED_LINK']->value->linkqcs == true) {?>quickCreateSupported<?php }?>"<?php if ($_smarty_tpl->tpl_vars['IS_SELECT_BUTTON']->value == true) {?> data-moduleName=<?php echo $_smarty_tpl->tpl_vars['RELATED_LINK']->value->get('_module')->get('name');?>
 <?php }
if (($_smarty_tpl->tpl_vars['RELATED_LINK']->value->isPageLoadLink())) {
if ($_smarty_tpl->tpl_vars['RELATION_FIELD']->value) {?> data-name="<?php echo $_smarty_tpl->tpl_vars['RELATION_FIELD']->value->getName();?>
" <?php }?>data-url="<?php echo $_smarty_tpl->tpl_vars['RELATED_LINK']->value->getUrl();?>
"<?php } else { ?>onclick='<?php echo substr($_smarty_tpl->tpl_vars['RELATED_LINK']->value->getUrl(),strlen("javascript:"));?>
;'<?php }
if ($_smarty_tpl->tpl_vars['IS_SELECT_BUTTON']->value != true && stripos($_smarty_tpl->tpl_vars['RELATED_LINK']->value->getUrl(),'javascript:') !== 0) {?>name="addButton"<?php }?>><?php if ($_smarty_tpl->tpl_vars['IS_SELECT_BUTTON']->value == false) {?><span class="glyphicon glyphicon-plus icon-white"></span><?php }?>&nbsp;<strong><?php echo $_smarty_tpl->tpl_vars['RELATED_LINK']->value->getLabel();?>
</strong></button></div><?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
&nbsp;</div><div class="col-xs-12 col-md-6 col-sm-6"><div class="paginationDiv pull-right"><?php $_smarty_tpl->_subTemplateRender(vtemplate_path('Pagination.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('VIEWNAME'=>'related'), 0, true);
?>
</div></div></div></div><div class="contents-topscroll"><div class="topscroll-div">&nbsp;</div></div><div class="relatedContents contents-bottomscroll"><div class="bottomscroll-div"><?php $_smarty_tpl->_assignInScope('FILENAME', "RelatedListContents.tpl");
$_smarty_tpl->_subTemplateRender(vtemplate_path($_smarty_tpl->tpl_vars['FILENAME']->value,$_smarty_tpl->tpl_vars['RELATED_MODULE']->value->get('name')), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
</div></div></div>
<?php }
}
