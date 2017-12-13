<?php
/* Smarty version 3.1.31, created on 2017-12-07 09:37:51
  from "/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/LayoutEditor/Inventory.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a28c59fa904d9_18815839',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '19699e163b206b344a1972a6a560d18051578b09' => 
    array (
      0 => '/usr/ictcore/wwwroot/YetiForceCRM/layouts/basic/modules/Settings/LayoutEditor/Inventory.tpl',
      1 => 1502273894,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a28c59fa904d9_18815839 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('INVENTORY_BLOKS', $_smarty_tpl->tpl_vars['INVENTORY_MODEL']->value->getFields(1,array(),'Settings'));
?>
<div class="moduleBlocks inventoryBlock" data-block-id="0">
	<div class="editFieldsTable block panel panel-default">
		<div class="panel-heading">
			<div class="btn-toolbar btn-group-xs pull-right">
				<button class="btn btn-success saveFieldSequence invisible inventorySequence"  type="button">
					<strong><?php echo App\Language::translate('LBL_SAVE_FIELD_SEQUENCE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
				</button>
				<button class="btn btn-default addInventoryField" type="button">
					<strong><?php echo App\Language::translate('LBL_ADD_CUSTOM_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
				</button>
			</div>
			<div class="panel-title" >
				<?php echo App\Language::translate('LBL_HEADLINE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

			</div>
		</div>
		<div class="blockFieldsList panel-body">
			<ul name="sortable1" class="connectedSortable list-unstyled">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['INVENTORY_BLOKS']->value[0], 'FIELD_MODEL', false, 'NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['NAME']->value => $_smarty_tpl->tpl_vars['FIELD_MODEL']->value) {
?>
					<li>
						<div class="opacity editFields border1px"  data-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('id');?>
" data-column="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('columnname');?>
" data-sequence="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('sequence');?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName();?>
">
							<a>
								<img src="<?php echo vimage_path('drag.png');?>
" border="0" title="<?php echo App\Language::translate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/>
							</a>&nbsp;&nbsp;
							<span class="fieldLabel"><?php echo App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</span>
							<span class="btn-group pull-right actions">
								<a href="#" class="editInventoryField">
									<span class="glyphicon glyphicon-pencil alignMiddle" title="<?php echo App\Language::translate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></span>
								</a>
								<a class="deleteInventoryField"><span title="<?php echo App\Language::translate('LBL_DELETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" class="glyphicon glyphicon-trash alignMiddle"></span></a>
							</span>
						</div>
					</li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			</ul>
		</div>
	</div>
</div>
<div class="moduleBlocks inventoryBlock" data-block-id="1">
	<div class="editFieldsTable block panel panel-default">
		<div class="panel-heading">
			<div class="btn-toolbar btn-group-xs pull-right">
				<button class="btn btn-success saveFieldSequence invisible inventorySequence"  type="button">
					<strong><?php echo App\Language::translate('LBL_SAVE_FIELD_SEQUENCE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
				</button>
				<button class="btn btn-default addInventoryField" type="button">
					<strong><?php echo App\Language::translate('LBL_ADD_CUSTOM_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
				</button>
			</div>
			<div class="panel-title" >
				<?php echo App\Language::translate('LBL_BASIC_VERSE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

			</div>
		</div>
		<div class="blockFieldsList panel-body">
			<ul name="sortable1" class="connectedSortable list-unstyled">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['INVENTORY_BLOKS']->value[1], 'FIELD_MODEL', false, 'NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['NAME']->value => $_smarty_tpl->tpl_vars['FIELD_MODEL']->value) {
?>
					<li>
						<div class="opacity editFields border1px"  data-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('id');?>
" data-column="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('columnname');?>
" data-sequence="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('sequence');?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName();?>
">
							<a>
								<img src="<?php echo vimage_path('drag.png');?>
" border="0" title="<?php echo App\Language::translate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/>
							</a>&nbsp;&nbsp;
							<span class="fieldLabel"><?php echo App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</span>
							<span class="btn-group pull-right actions">
								<a href="#" class="editInventoryField">
									<span class="glyphicon glyphicon-pencil alignMiddle" title="<?php echo App\Language::translate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></span>
								</a>
								<a class="deleteInventoryField"><span title="<?php echo App\Language::translate('LBL_DELETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" class="glyphicon glyphicon-trash alignMiddle"></span></a>
							</span>
						</div>
					</li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			</ul>
		</div>
	</div>
</div>
<div class="moduleBlocks inventoryBlock" data-block-id="2">
	<div class="editFieldsTable block panel panel-default">
		<div class="panel-heading">
			<div class="btn-toolbar btn-group-xs pull-right">
				<button class="btn btn-success saveFieldSequence invisible inventorySequence"  type="button">
					<strong><?php echo App\Language::translate('LBL_SAVE_FIELD_SEQUENCE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
				</button>
				<button class="btn btn-default addInventoryField" type="button">
					<strong><?php echo App\Language::translate('LBL_ADD_CUSTOM_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
				</button>
			</div>
			<div class="panel-title" >
				<?php echo App\Language::translate('LBL_ADDITIONAL_VERSE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

			</div>
		</div>
		<div class="blockFieldsList panel-body">
			<ul name="sortable1" class="connectedSortable list-unstyled">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['INVENTORY_BLOKS']->value[2], 'FIELD_MODEL', false, 'NAME');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['NAME']->value => $_smarty_tpl->tpl_vars['FIELD_MODEL']->value) {
?>
					<li>
						<div class="opacity editFields border1px"  data-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('id');?>
" data-column="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('columnname');?>
" data-sequence="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('sequence');?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName();?>
">
							<a>
								<img src="<?php echo vimage_path('drag.png');?>
" border="0" title="<?php echo App\Language::translate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/>
							</a>&nbsp;&nbsp;
							<span class="fieldLabel"><?php echo App\Language::translate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</span>
							<span class="btn-group pull-right actions">
								<a href="#" class="editInventoryField">
									<span class="glyphicon glyphicon-pencil alignMiddle" title="<?php echo App\Language::translate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></span>
								</a>
								<a class="deleteInventoryField"><span title="<?php echo App\Language::translate('LBL_DELETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" class="glyphicon glyphicon-trash alignMiddle"></span></a>
							</span>
						</div>
					</li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			</ul>
		</div>
	</div>
</div>
<li class="hide newLiElement">
	<div class="opacity editFields border1px" data-column="" data-id="" data-sequence="" data-name="">
		<a>
			<img src="<?php echo vimage_path('drag.png');?>
" border="0" title="<?php echo App\Language::translate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/>
		</a>&nbsp;&nbsp;
		<span class="fieldLabel"></span>
		<span class="btn-group pull-right actions">
			<a href="#" class="editInventoryField">
				<span class="glyphicon glyphicon-pencil alignMiddle" title="<?php echo App\Language::translate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></span>
			</a>
			<a class="deleteInventoryField"><span title="<?php echo App\Language::translate('LBL_DELETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" class="glyphicon glyphicon-trash alignMiddle"></span></a>
		</span>
	</div>
</li>
<?php }
}
