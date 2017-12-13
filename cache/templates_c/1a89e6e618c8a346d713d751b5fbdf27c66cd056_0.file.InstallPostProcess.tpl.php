<?php
/* Smarty version 3.1.31, created on 2017-12-06 07:08:54
  from "/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/InstallPostProcess.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2797861631c1_26381876',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a89e6e618c8a346d713d751b5fbdf27c66cd056' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/install/tpl/InstallPostProcess.tpl',
      1 => 1502282096,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:JSResources.tpl' => 1,
  ),
),false)) {
function content_5a2797861631c1_26381876 (Smarty_Internal_Template $_smarty_tpl) {
?>

<br /><center><footer class="noprint"><div class="vtFooter"><p><?php echo \App\Language::translate('POWEREDBY');?>
 <?php echo $_smarty_tpl->tpl_vars['YETIFORCE_VERSION']->value;?>
 &nbsp;&copy; 2004 - <?php echo date('Y');?>
&nbsp;&nbsp;<a href="http://yetiforce.com" target="_blank">yetiforce.com</a>&nbsp;|&nbsp;<a href="#" onclick="window.open('../licenses/License.html', 'License', 'height=615,width=875').moveTo(110, 120)"><?php echo \App\Language::translate('LBL_READ_LICENSE');?>
</a></p></div></footer></center><?php $_smarty_tpl->_subTemplateRender('file:JSResources.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div></div></body></html>
<?php }
}
