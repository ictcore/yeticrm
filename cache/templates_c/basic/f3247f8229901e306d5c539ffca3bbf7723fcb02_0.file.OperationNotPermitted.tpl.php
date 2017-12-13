<?php
/* Smarty version 3.1.31, created on 2017-12-07 14:56:03
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/OperationNotPermitted.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a291033464eb5_08231677',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f3247f8229901e306d5c539ffca3bbf7723fcb02' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/OperationNotPermitted.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a291033464eb5_08231677 (Smarty_Internal_Template $_smarty_tpl) {
?>

<!DOCTYPE html>
<html><head><title>Yetiforce: <?php echo \App\Language::translate('LBL_ERROR');?>
</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="SHORTCUT ICON" href="<?php echo vimage_path('favicon.ico');?>
"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><link rel="stylesheet" href="<?php echo \App\Layout::getPublicUrl('libraries/bootstrap/css/bootstrap.css');?>
" type="text/css" media="screen"><?php echo '<script'; ?>
 type="text/javascript" src="<?php echo \App\Layout::getPublicUrl('libraries/jquery/jquery.js');?>
"><?php echo '</script'; ?>
></head><body><div style="margin-top: 10px;" class="alert alert-danger shadow"><div style="position: relative;" ><div><h2 class="alert-heading"><?php echo \App\Language::translate('LBL_ERROR');?>
</h2><p><?php echo \App\Language::translate($_smarty_tpl->tpl_vars['MESSAGE']->value);?>
</p><p class="Buttons"><a class="btn btn-warning" href="javascript:window.history.back();"><?php echo \App\Language::translate('LBL_GO_BACK');?>
</a><a class="btn btn-info" href="index.php"><?php echo \App\Language::translate('LBL_MAIN_PAGE');?>
</a></p></div></div></div></body></html>
<?php }
}
