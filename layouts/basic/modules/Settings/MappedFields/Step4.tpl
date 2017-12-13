{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="mfTemplateContents">
		<form name="editMFTemplate" action="index.php" method="post" id="mf_step4" class="form-horizontal">
			<input type="hidden" name="module" value="{$MAPPEDFIELDS_MODULE_MODEL->getName()}">
			<input type="hidden" name="view" value="Edit">
			<input type="hidden" name="mode" value="Step8" />
			<input type="hidden" name="parent" value="{$MAPPEDFIELDS_MODULE_MODEL->getParentName()}" />
			<input type="hidden" class="step" value="4" />
			<input type="hidden" name="record" value="{$RECORDID}" />
			<div class="col-md-12 paddingLRZero">
				<div class="panel panel-default">
					<div class="panel-heading">
						<label>
							<strong>{\App\Language::translate('LBL_STEP_N',$QUALIFIED_MODULE, 4)}: {\App\Language::translate('LBL_PERMISSIONS_DETAILS',$QUALIFIED_MODULE)}</strong>
						</label>
					</div>
					<div class="panel-body">
						<div class="form-group">
								<label class="col-md-3 control-label">
									{\App\Language::translate('LBL_GROUP_MEMBERS', 'Settings:Groups')}
								</label>
							<div class="col-md-8">
								<select class="selectize form-control" multiple="true" id="permissions" name="permissions[]" data-placeholder="{\App\Language::translate('LBL_ADD_USERS_ROLES', 'Settings:Groups')}">
									{assign 'TEMPLATE_MEMBERS' explode(',',$MAPPEDFIELDS_MODULE_MODEL->get('permissions'))}
									{foreach from=Settings_Groups_Member_Model::getAll(false) key=GROUP_LABEL item=ALL_GROUP_MEMBERS}
										<optgroup label="{\App\Language::translate($GROUP_LABEL, $QUALIFIED_MODULE)}">
											{foreach from=$ALL_GROUP_MEMBERS item=MEMBER}
												<option value="{$MEMBER->get('id')}"  data-member-type="{$GROUP_LABEL}" {if in_array($MEMBER->get('id'), $TEMPLATE_MEMBERS)}selected="true"{/if}>{\App\Language::translate($MEMBER->get('name'), $QUALIFIED_MODULE)}</option>
											{/foreach}
										</optgroup>
									{/foreach}
								</select>
							</div>
						</div>
					</div>
					<div class="panel-footer clearfix">
						<div class="btn-toolbar pull-right">
							<button class="btn btn-danger backStep" type="button"><strong>{\App\Language::translate('LBL_BACK', $QUALIFIED_MODULE)}</strong></button>
							<button class="btn btn-success" type="submit"><strong>{\App\Language::translate('LBL_FINISH', $QUALIFIED_MODULE)}</strong></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
{/strip}
