<?php
/* Smarty version 3.1.31, created on 2017-12-07 11:21:15
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Menu/CreateMenuStep2.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28dddba23b23_10973779',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b345fbcc00aed8a517174ea10438b12af7ceca03' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/Menu/CreateMenuStep2.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28dddba23b23_10973779 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="modal fade" tabindex="-1">
	<div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo \App\Language::translate('LBL_CREATING_MENU',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h4>
			</div>
			<div class="modal-body">
				<?php $_smarty_tpl->_assignInScope('MENU_TYPES', $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getMenuTypes());
?>
				<?php $_smarty_tpl->_assignInScope('MENU_TYPE', $_smarty_tpl->tpl_vars['MENU_TYPES']->value[$_smarty_tpl->tpl_vars['TYPE']->value]);
?>
				<form class="form-horizontal">
					<input type="hidden" name="type" id="menuType" value="<?php echo $_smarty_tpl->tpl_vars['MENU_TYPE']->value;?>
" />
					<div class="form-group">
						<label class="col-md-4 control-label"><?php echo \App\Language::translate('LBL_TYPE_OF_MENU',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
:</label>
						<div class="col-md-7 form-control-static"><?php echo \App\Language::translate(('LBL_').(strtoupper($_smarty_tpl->tpl_vars['MENU_TYPE']->value)),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div>
					</div>
					<?php $_smarty_tpl->_subTemplateRender(vtemplate_path((('types/').($_smarty_tpl->tpl_vars['MENU_TYPE']->value)).('.tpl'),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

				</form>
			</div>
			<div class="modal-footer">
				<div class="pull-right cancelLinkContainer" style="margin-top:0px;">
					<button class="btn cancelLink btn-warning" type="reset" data-dismiss="modal"><?php echo \App\Language::translate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button>
					<button class="btn btn-success saveButton"><strong><?php echo \App\Language::translate('LBL_ADD_NEW_MENU',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }
}
