{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
<div class="menuConfigContainer">
	<div class="widget_header row">
		<div class="col-md-7">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
			{\App\Language::translate('LBL_MENU_BUILDER_DESCRIPTION', $QUALIFIED_MODULE)}
		</div>
		<div class="col-md-5 row">
			<div class="col-xs-6 paddingLRZero">
				<button class="btn btn-default addMenu pull-right"><strong>{\App\Language::translate('LBL_ADD_MENU', $QUALIFIED_MODULE)}</strong></button>
			</div>
			<div class="col-xs-6 pull-right ">
				<select class="select2 form-control" name="roleMenu">
					<option value="0" {if $ROLEID eq 0} selected="" {/if}>{\App\Language::translate('LBL_DEFAULT_MENU', $QUALIFIED_MODULE)}</option>
					{foreach item=ROLE key=KEY from=Settings_Roles_Record_Model::getAll()}
						<option value="{$KEY}" {if $ROLEID === $KEY} selected="" {/if}>{\App\Language::translate($ROLE->getName())}</option>
					{/foreach}
				</select>
			</div>
		</div>
	</div>
	<hr>
	{if !$DATA}
		<button class="btn btn-success copyMenu"><strong>{\App\Language::translate('LBL_COPY_MENU', $QUALIFIED_MODULE)}</strong></button>
	{/if}
	<div class="treeMenuContainer">
		<input type="hidden" id="treeLastID" value="{$LASTID}" />
		<input type="hidden" name="tree" id="treeValues" value='{Vtiger_Util_Helper::toSafeHTML(\App\Json::encode($DATA))}' />
		<div id="treeContent"></div>
	</div>
	<div class="modal fade copyMenuModal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">{\App\Language::translate('LBL_COPY_MENU', $QUALIFIED_MODULE)}</h4>
					</div>
					<div class="modal-body">
						<select id="roleList" class="form-control" name="roles" data-validation-engine="validate[required]">
							<option value="0">{\App\Language::translate('LBL_DEFAULT_MENU', $QUALIFIED_MODULE)}</option>
							{foreach item=ROLE key=KEY from=$ROLES_CONTAIN_MENU}
								<option value="{$ROLE['roleId']}"  >{\App\Language::translate($ROLE['roleName'])}</option>
							{/foreach}
						</select>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success saveButton">{\App\Language::translate('LBL_SAVE', $QUALIFIED_MODULE)}</button>
						<button type="button" class="btn btn-warning dismiss" data-dismiss="modal">{\App\Language::translate('LBL_CLOSE', $QUALIFIED_MODULE)}</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>
<div class="modal deleteAlert fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">{\App\Language::translate('LBL_REMOVE_TITLE', $QUALIFIED_MODULE)}</h3>
			</div>
			<div class="modal-body">
				<p>{\App\Language::translate('LBL_REMOVE_DESC', $QUALIFIED_MODULE)}</p>
			</div>
			<div class="modal-footer">
				<div class="pull-right">
					<button class="btn btn-warning cancelLink" type="reset" data-dismiss="modal">{\App\Language::translate('LBL_CANCEL', $QUALIFIED_MODULE)}</button>
				</div>
				<div class="pull-right">
					<button class="btn btn-danger" data-dismiss="modal">{\App\Language::translate('LBL_REMOVE', $QUALIFIED_MODULE)}</button>
				</div>
			</div>
		</div>
	</div>
</div>
