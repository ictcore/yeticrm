<?php
/* Smarty version 3.1.31, created on 2017-12-08 09:33:59
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/EditViewInventorySummary.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a2a1637083202_65379351',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '506a9f568a52452568120470557095ec91458d10' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Vtiger/EditViewInventorySummary.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a2a1637083202_65379351 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="row"><?php if (in_array("discount",$_smarty_tpl->tpl_vars['COLUMNS']->value) && in_array("discountmode",$_smarty_tpl->tpl_vars['COLUMNS']->value)) {?><div class="col-md-4"><div class="panel panel-default inventorySummaryContainer inventorySummaryDiscounts"><div class="panel-heading"><img src="<?php echo vimage_path('Discount24.png');?>
" alt="<?php echo \App\Language::translate('LBL_DISCOUNT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" />&nbsp;&nbsp;<strong><?php echo \App\Language::translate('LBL_DISCOUNTS_SUMMARY',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong><span class="pull-right groupDiscount changeDiscount <?php if (isset($_smarty_tpl->tpl_vars['INVENTORY_ROWS']->value[0]) && $_smarty_tpl->tpl_vars['INVENTORY_ROWS']->value[0]['discountmode'] == '1') {?>hide<?php }?>"><button type="button" class="btn btn-primary btn-xs"><?php echo \App\Language::translate('LBL_SET_GLOBAL_TAX',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button></span></div><div class="panel-body"><div class="form-group"><div class="input-group"><input type="text" class="form-control textAlignRight" readonly="readonly"><?php if (in_array("currency",$_smarty_tpl->tpl_vars['COLUMNS']->value)) {?><div class="input-group-addon currencySymbol"><?php echo $_smarty_tpl->tpl_vars['CURRENCY_SYMBOLAND']->value['symbol'];?>
</div><?php }?></div></div></div></div></div><?php }
if (in_array("tax",$_smarty_tpl->tpl_vars['COLUMNS']->value) && in_array("taxmode",$_smarty_tpl->tpl_vars['COLUMNS']->value)) {?><div class="col-md-4"><div class="panel panel-default inventorySummaryContainer inventorySummaryTaxes"><div class="panel-heading"><img src="<?php echo vimage_path('Tax24.png');?>
" alt="<?php echo \App\Language::translate('LBL_TAX',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" />&nbsp;&nbsp;<strong><?php echo \App\Language::translate('LBL_TAX_SUMMARY',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong><span class="pull-right groupTax changeTax <?php if (isset($_smarty_tpl->tpl_vars['INVENTORY_ROWS']->value[0]) && $_smarty_tpl->tpl_vars['INVENTORY_ROWS']->value[0]['taxmode'] == '1') {?>hide<?php }?>"><button type="button" class="btn btn-primary btn-xs"><?php echo \App\Language::translate('LBL_SET_GLOBAL_DISCOUNT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button></span></div><div class="panel-body"></div><div class="panel-footer"><div class="form-group"><div class="input-group"><div class="input-group-addon percent"><?php echo \App\Language::translate('LBL_AMOUNT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</div><input type="text" class="form-control textAlignRight" readonly="readonly"><?php if (in_array("currency",$_smarty_tpl->tpl_vars['COLUMNS']->value)) {?><div class="input-group-addon currencySymbol"><?php echo $_smarty_tpl->tpl_vars['CURRENCY_SYMBOLAND']->value['symbol'];?>
</div><?php }?></div></div></div><div class="hide"><div class="form-group"><div class="input-group"><div class="input-group-addon percent"></div><input type="text" class="form-control textAlignRight" readonly="readonly"><?php if (in_array("currency",$_smarty_tpl->tpl_vars['COLUMNS']->value)) {?><div class="input-group-addon currencySymbol"><?php echo $_smarty_tpl->tpl_vars['CURRENCY_SYMBOLAND']->value['symbol'];?>
</div><?php }?></div></div></div></div></div><div class="col-md-4"><div class="panel panel-default inventorySummaryContainer inventorySummaryCurrencies"><div class="panel-heading"><strong><?php echo \App\Language::translate('LBL_CURRENCIES_SUMMARY',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></div><div class="panel-body"></div><div class="panel-footer"><div class="form-group"><div class="input-group"><div class="input-group-addon percent"><?php echo \App\Language::translate('LBL_AMOUNT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</div><input type="text" class="form-control textAlignRight" readonly="readonly"><?php if (in_array("currency",$_smarty_tpl->tpl_vars['COLUMNS']->value)) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['BASE_CURRENCY']->value['currency_symbol'];?>
</div><?php }?></div></div></div><div class="hide"><div class="form-group"><div class="input-group"><div class="input-group-addon percent"></div><input type="text" class="form-control textAlignRight" readonly="readonly"><?php if (in_array("currency",$_smarty_tpl->tpl_vars['COLUMNS']->value)) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['BASE_CURRENCY']->value['currency_symbol'];?>
</div><?php }?></div></div></div></div></div><?php }?></div>
<?php }
}
