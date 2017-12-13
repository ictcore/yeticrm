<?php
/* Smarty version 3.1.31, created on 2017-12-07 14:52:57
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ApiAddress/Configuration.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a290f79e37275_87129402',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'de4853912ca384281923164864d7901e442917e7' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/ApiAddress/Configuration.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a290f79e37275_87129402 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="menuEditorContainer">
    <div class="widget_header row">
        <div class="col-md-12">
			<?php $_smarty_tpl->_subTemplateRender(vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

			<?php echo \App\Language::translate('LBL_API_ADDRESS_DESCRIPTION',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>

		</div>
    </div>
    <hr>
	<div class="main_content">
		<form>
			<div class="col-xs-12 row">
				<div class="col-xs-12 row">
					<h4><?php echo \App\Language::translate('LBL_GLOBAL_CONFIG',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
 </h4>
				</div>
				<div class="col-xs-12 row marginBottom5px">
					<div class="col-sm-6 col-md-4 row">
						<div >
							<?php echo \App\Language::translate('LBL_MIN_LOOKUP_LENGTH',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
: 
						</div>
					</div>
					<div class="col-sm-6 col-md-4">
						<div style="text-align:center" >
							<input name="min_length" type="text" class="api form-control" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['global']['min_length'];?>
" style="margin:0 auto;">
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-xs-12 row  marginBottom5px">
					<div class='col-sm-6 col-md-4 row'>
						<div>
							<?php echo \App\Language::translate('LBL_NUMBER_SEARCH_RESULTS',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
: 
						</div>
					</div>
					<div class="col-sm-6 col-md-4">
						<div style="text-align:center" >
							<input name="result_num" type="text" class="api form-control" value="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['global']['result_num'];?>
" style="margin:0 auto;">
						</div>
					</div>
				</div>
				<div class="col-xs-12 row marginBottom5px">
					<div>
						<button type="button" class="btn btn-success saveGlobal"><?php echo \App\Language::translate('LBL_SAVE_GLOBAL_SETTINGS',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
</button>
					</div>
				</div>
				<div class="col-xs-12 row marginBottom5px">
					<hr>
				</div>
				<div class="col-xs-12 row marginBottom5px">
					<div class=' row col-md-4 col-sm-6'>
						<?php echo \App\Language::translate('LBL_CHOOSE_API',$_smarty_tpl->tpl_vars['MODULENAME']->value);?>

					</div>
					<div class='col-sm-6 col-md-4'>
						<select class="select2" id="change_api" class="form-control" style="width: 200px;">
							<option><?php echo \App\Language::translate('LBL_SELECT_OPTION');?>
</option>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['CONFIG']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
								<?php if ($_smarty_tpl->tpl_vars['key']->value != 'global') {?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['key']->value,$_smarty_tpl->tpl_vars['MODULENAME']->value);?>
</option>
								<?php }?>

							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

						</select>
					</div>
				</div>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['CONFIG']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
					<?php if ($_smarty_tpl->tpl_vars['key']->value != 'global') {?>
						<div class="apiContainer col-xs-12 paddingLRZero <?php if (!$_smarty_tpl->tpl_vars['item']->value["key"]) {?>hide<?php }?> api_row <?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
							<?php $_smarty_tpl->_subTemplateRender(vtemplate_path(($_smarty_tpl->tpl_vars['key']->value).('.tpl'),$_smarty_tpl->tpl_vars['MODULENAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('API_INFO'=>$_smarty_tpl->tpl_vars['item']->value,'API_NAME'=>$_smarty_tpl->tpl_vars['key']->value), 0, true);
?>

						<?php }?>
					</div>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


			</div> 
		</form>	
	</div>
</div>
<?php }
}
