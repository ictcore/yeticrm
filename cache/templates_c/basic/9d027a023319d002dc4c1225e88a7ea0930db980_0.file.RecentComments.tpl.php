<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:33:31
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/RecentComments.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279d4b4717c3_82626263',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d027a023319d002dc4c1225e88a7ea0930db980' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/RecentComments.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279d4b4717c3_82626263 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('COMMENT_TEXTAREA_DEFAULT_ROWS', "2");
?><div class="commentContainer recentComments"><div class="commentTitle"><?php if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value && $_smarty_tpl->tpl_vars['COMMENTS_MODULE_MODEL']->value->isPermitted('CreateView')) {?><div class="addCommentBlock"><div class="input-group"><span class="input-group-addon" ><span class="glyphicon glyphicon-comment"></span></span><textarea name="commentcontent" rows="<?php echo $_smarty_tpl->tpl_vars['COMMENT_TEXTAREA_DEFAULT_ROWS']->value;?>
" class="commentcontent form-control" title="<?php echo \App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" placeholder="<?php echo \App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" ></textarea></div><button class="btn btn-success detailViewSaveComment  marginTop10 pull-right" type="button" data-mode="add"><span class="visible-xs-inline-block glyphicon glyphicon-ok"></span><strong class="hidden-xs"><?php echo \App\Language::translate('LBL_POST',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button><div class="clearfix"></div></div><?php }?></div><hr><br /><div class="commentsBody"><?php if (!empty($_smarty_tpl->tpl_vars['COMMENTS']->value)) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['COMMENTS']->value, 'COMMENT', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['COMMENT']->value) {
?><div class="commentDetails"><div class="commentDiv"><div class="singleComment"><div class="commentInfoHeader" data-commentid="<?php echo $_smarty_tpl->tpl_vars['COMMENT']->value->getId();?>
" data-parentcommentid="<?php echo $_smarty_tpl->tpl_vars['COMMENT']->value->get('parent_comments');?>
"><div class="commentTitle"><?php $_smarty_tpl->_assignInScope('PARENT_COMMENT_MODEL', $_smarty_tpl->tpl_vars['COMMENT']->value->getParentCommentModel());
$_smarty_tpl->_assignInScope('CHILD_COMMENTS_MODEL', $_smarty_tpl->tpl_vars['COMMENT']->value->getChildComments());
?><div class="row"><div class="paddingLeftMd"><?php $_smarty_tpl->_assignInScope('IMAGE_PATH', $_smarty_tpl->tpl_vars['COMMENT']->value->getImagePath());
?><img class="alignMiddle pull-left" width="48" alt="" src="<?php if (!empty($_smarty_tpl->tpl_vars['IMAGE_PATH']->value)) {
echo $_smarty_tpl->tpl_vars['IMAGE_PATH']->value;
} else {
echo vimage_path('DefaultUserIcon.png');
}?>"></div><div class="col-xs-8 commentorInfo"><?php $_smarty_tpl->_assignInScope('COMMENTOR', $_smarty_tpl->tpl_vars['COMMENT']->value->getCommentedByModel());
?><span class="commentorName"><strong><?php echo $_smarty_tpl->tpl_vars['COMMENTOR']->value->getName();?>
</strong></span><div class="commentInfoContent"><?php echo nl2br($_smarty_tpl->tpl_vars['COMMENT']->value->get('commentcontent'));?>
</div></div><div class="inner"><span class="pull-right paddingRight15"><p class="muted"><small title="<?php echo Vtiger_Util_Helper::formatDateTimeIntoDayString($_smarty_tpl->tpl_vars['COMMENT']->value->getCommentedTime());?>
"><?php echo Vtiger_Util_Helper::formatDateDiffInStrings($_smarty_tpl->tpl_vars['COMMENT']->value->getCommentedTime());?>
</small></p></span><div class="clearfix"></div></div></div></div></div><div class="commentActionsContainer"><?php $_smarty_tpl->_assignInScope('REASON_TO_EDIT', $_smarty_tpl->tpl_vars['COMMENT']->value->get('reasontoedit'));
?><div class="pull-left <?php if (empty($_smarty_tpl->tpl_vars['REASON_TO_EDIT']->value)) {?>hide <?php }?>editStatus"  name="editStatus"><span class="pull-left paddingRight10 visible-lg-block"><p class="muted"><small>[ <?php echo \App\Language::translate('LBL_EDIT_REASON',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
 ] :<span name="editReason" class="textOverflowEllipsis"><?php echo nl2br($_smarty_tpl->tpl_vars['REASON_TO_EDIT']->value);?>
</span></small></p></span></div><?php if ($_smarty_tpl->tpl_vars['COMMENT']->value->getCommentedTime() != $_smarty_tpl->tpl_vars['COMMENT']->value->getModifiedTime()) {?><div class="clearfix"></div><span class="pull-left visible-lg-block"><p class="muted pull-right"><small><em><?php echo \App\Language::translate('LBL_MODIFIED',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</em></small>&nbsp;<small title="<?php echo Vtiger_Util_Helper::formatDateTimeIntoDayString($_smarty_tpl->tpl_vars['COMMENT']->value->getModifiedTime());?>
" class="commentModifiedTime"><?php echo Vtiger_Util_Helper::formatDateDiffInStrings($_smarty_tpl->tpl_vars['COMMENT']->value->getModifiedTime());?>
</small></p></span><?php }
if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value) {?><div class="pull-right commentActions"><?php if ($_smarty_tpl->tpl_vars['COMMENTS_MODULE_MODEL']->value->isPermitted('CreateView')) {?><span><button type="button" class="btn btn-xs btn-success replyComment feedback"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>&nbsp;<?php echo \App\Language::translate('LBL_REPLY',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</button><?php if (Users_Privileges_Model::isPermitted('ModComments','EditableComments') && $_smarty_tpl->tpl_vars['CURRENTUSER']->value->getId() == $_smarty_tpl->tpl_vars['COMMENT']->value->get('userid')) {?><button type="button" class="btn btn-xs btn-primary editComment feedback marginLeft5"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;<?php echo \App\Language::translate('LBL_EDIT',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</button><?php }?></span><?php }?><span><?php if ($_smarty_tpl->tpl_vars['PARENT_COMMENT_MODEL']->value != false || $_smarty_tpl->tpl_vars['CHILD_COMMENTS_MODEL']->value != null) {?><button type="button" class="btn btn-xs btn-info detailViewThread marginLeft5"><?php echo \App\Language::translate('LBL_VIEW_THREAD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</button><?php }?></span></div><?php }?><div class="clearfix"></div></div></div></div></div><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
} else {
$_smarty_tpl->_subTemplateRender(vtemplate_path("NoComments.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}?></div><?php if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value && $_smarty_tpl->tpl_vars['PAGING_MODEL']->value->isNextPageExists()) {?><div class="row"><div class="pull-right"><a href="javascript:void(0)" class="moreRecentComments btn btn-xs btn-info marginTop5 marginRight15"><?php echo \App\Language::translate('LBL_MORE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
..</a></div></div><?php }
if (!$_smarty_tpl->tpl_vars['IS_READ_ONLY']->value) {?><div class="hide basicAddCommentBlock marginTop10 marginBottom10px"><div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-addon" ><span class="glyphicon glyphicon-comment"></span></span><textarea rows="<?php echo $_smarty_tpl->tpl_vars['COMMENT_TEXTAREA_DEFAULT_ROWS']->value;?>
" class="form-control commentcontenthidden fullWidthAlways" name="commentcontent" title="<?php echo \App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" placeholder="<?php echo \App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"></textarea></div><button class="cursorPointer closeCommentBlock marginTop10 btn btn-warning pull-right cancel" type="reset"><span class="visible-xs-inline-block glyphicon glyphicon-remove"></span><strong class="hidden-xs"><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button><button class="btn btn-success saveComment marginTop10 pull-right" type="button" data-mode="add"><span class="visible-xs-inline-block glyphicon glyphicon-ok"></span><strong class="hidden-xs"><?php echo \App\Language::translate('LBL_POST',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button></div></div><div class="clearfix"></div></div><div class="hide basicEditCommentBlock" ><div class="row"><div class="col-md-12 marginTop10 marginBottom10px"><input type="text" name="reasonToEdit" title="<?php echo \App\Language::translate('LBL_REASON_FOR_CHANGING_COMMENT',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" placeholder="<?php echo \App\Language::translate('LBL_REASON_FOR_CHANGING_COMMENT',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" class="input-block-level form-control"/></div></div><div class="row"><div class="col-md-12 marginBottom10px"><div class="input-group"><span class="input-group-addon" ><span class="glyphicon glyphicon-comment"></span></span><textarea rows="<?php echo $_smarty_tpl->tpl_vars['COMMENT_TEXTAREA_DEFAULT_ROWS']->value;?>
" class="form-control commentcontenthidden fullWidthAlways" name="commentcontent" title="<?php echo \App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" placeholder="<?php echo \App\Language::translate('LBL_ADD_YOUR_COMMENT_HERE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
" ></textarea></div><button class="cursorPointer closeCommentBlock marginTop10 btn btn-warning pull-right cancel" type="reset"><span class="visible-xs-inline-block glyphicon glyphicon-remove"></span><strong class="hidden-xs"><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button><button class="btn btn-success saveComment marginTop10 pull-right" type="button" data-mode="edit"><span class="visible-xs-inline-block glyphicon glyphicon-ok"></span><strong class="hidden-xs"><?php echo \App\Language::translate('LBL_POST',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button></div></div><div class="clearfix"></div></div><?php }?></div>
<?php }
}
