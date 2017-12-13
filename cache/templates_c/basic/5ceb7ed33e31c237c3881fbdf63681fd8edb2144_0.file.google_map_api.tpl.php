<?php
/* Smarty version 3.1.31, created on 2017-12-07 14:52:57
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ApiAddress/google_map_api.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a290f79e5c192_66366798',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5ceb7ed33e31c237c3881fbdf63681fd8edb2144' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ApiAddress/google_map_api.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a290f79e5c192_66366798 (Smarty_Internal_Template $_smarty_tpl) {
?>

<hr>
<?php if ($_smarty_tpl->tpl_vars['API_INFO']->value["key"]) {?>
	<div class="col-xs-3 apiAdrress" data-api-name="<?php echo $_smarty_tpl->tpl_vars['API_NAME']->value;?>
">
		<?php echo \App\Language::translate('LBL_USE_GOOGLE_GEOCODER',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
: &nbsp;&nbsp;
		<input type="checkbox" name="nominatim" class="api" <?php if ($_smarty_tpl->tpl_vars['API_INFO']->value['nominatim']) {?> checked <?php }?>/>
	</div>
	<div class="col-xs-9">
		<button type="button" class="btn btn-danger delete" id="delete"><?php echo \App\Language::translate('LBL_REMOVE_CONNECTION',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
</button>
		<button type="button" class="btn btn-success save" id="save" ><?php echo \App\Language::translate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
</button>
	</div>
<?php } else { ?>
	<div class="col-xs-6 apiAdrress paddingLRZero" data-api-name="<?php echo $_smarty_tpl->tpl_vars['API_NAME']->value;?>
">
		<input name="key" type="text" class="api form-control" placeholder="<?php echo \App\Language::translate('LBL_ENTER_KEY_APPLICATION',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
">
	</div>
	<div class="col-xs-6">
		<a class="btn btn-primary" href="https://code.google.com/apis/console/?noredirect" target="_blank"><?php echo \App\Language::translate('Google Geocoder',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
</a>
		<button type="button" class="btn btn-success save" id="save"><?php echo \App\Language::translate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
</button>
	</div>
<?php }
}
}
