<?php
/* Smarty version 3.1.31, created on 2017-12-06 12:30:40
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/BlockHeader.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a279ca0630438_55453872',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '75c0d20f25eb1e0ad315c810ba32bce209e36eaa' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/BlockHeader.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a279ca0630438_55453872 (Smarty_Internal_Template $_smarty_tpl) {
?>
<span class="copyAddressLabel control-label"><?php echo \App\Language::translate('COPY_ADRESS_FROM');?>
</span><button class="btn btn-sm btn-primary copyAddressFromAccount" type="button" data-label="<?php echo $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value;?>
"><strong><?php echo \App\Language::translate('SINGLE_Accounts',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><button class="btn btn-sm btn-primary copyAddressFromLead" type="button" data-label="<?php echo $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value;?>
"><strong><?php echo \App\Language::translate('SINGLE_Leads',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><button class="btn btn-sm btn-primary copyAddressFromVendor" type="button" data-label="<?php echo $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value;?>
"><strong><?php echo \App\Language::translate('SINGLE_Vendors',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><?php ob_start();
echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;
$_prefixVariable3=ob_get_clean();
if ($_prefixVariable3 != 'Contacts') {?><button class="btn btn-sm btn-primary copyAddressFromContact" type="button" data-label="<?php echo $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value;?>
"><strong><?php echo \App\Language::translate('SINGLE_Contacts',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><?php }
if ($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value != 'LBL_ADDRESS_INFORMATION' && array_key_exists('LBL_ADDRESS_INFORMATION',$_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value) && count($_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value['LBL_ADDRESS_INFORMATION'])) {?><button class="btn btn-sm btn-primary copyAddressFromMain" type="button" data-label="LBL_ADDRESS_INFORMATION"><strong><?php echo \App\Language::translate('LBL_ADDRESS_INFORMATION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><?php }
if ($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value != 'LBL_ADDRESS_MAILING_INFORMATION' && array_key_exists('LBL_ADDRESS_MAILING_INFORMATION',$_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value) && count($_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value['LBL_ADDRESS_MAILING_INFORMATION'])) {?><button class="btn btn-sm btn-primary copyAddressFromMailing" type="button" data-label="LBL_ADDRESS_MAILING_INFORMATION"><strong><?php echo \App\Language::translate('LBL_ADDRESS_MAILING_INFORMATION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><?php }
if ($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value != 'LBL_ADDRESS_DELIVERY_INFORMATION' && array_key_exists('LBL_ADDRESS_DELIVERY_INFORMATION',$_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value) && count($_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value['LBL_ADDRESS_DELIVERY_INFORMATION'])) {?><button class="btn btn-sm btn-primary copyAddressFromDelivery" type="button" data-label="LBL_ADDRESS_DELIVERY_INFORMATION"><strong><?php echo \App\Language::translate('LBL_ADDRESS_DELIVERY_INFORMATION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><?php }?>

<?php }
}
