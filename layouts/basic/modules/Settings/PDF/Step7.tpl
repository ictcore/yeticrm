{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="pdfTemplateContents">
		<form name="EditPdfTemplate" action="index.php" method="post" id="pdf_step7" class="form-horizontal">
			<input type="hidden" name="module" value="PDF">
			<input type="hidden" name="view" value="Edit">
			<input type="hidden" name="mode" value="Step8" />
			<input type="hidden" name="parent" value="Settings" />
			<input type="hidden" class="step" value="7" />
			<input type="hidden" name="record" value="{$RECORDID}" />

			<div class="padding1per stepBorder">
				<label>
					<strong>{\App\Language::translate('LBL_STEP_N',$QUALIFIED_MODULE, 7)}: {\App\Language::translate('LBL_PERMISSIONS_DETAILS',$QUALIFIED_MODULE)}</strong>
				</label>
				<br />
				<div class="form-group">
					<div class="col-md-2 control-label">
						{\App\Language::translate('LBL_GROUP_MEMBERS', 'Settings:Groups')}
					</div>
					<div class="col-md-6 controls">
						<div class="row">
							<div class="col-md-6">
								<select class="select2 form-control" multiple="true" name="template_members[]" data-placeholder="{\App\Language::translate('LBL_ADD_USERS_ROLES', 'Settings:Groups')}">
									{assign 'TEMPLATE_MEMBERS' explode(',',$PDF_MODEL->get('template_members'))}
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
				</div>
			</div>
			<br />
			<div class="pull-right">
				<button class="btn btn-danger backStep" type="button"><strong>{\App\Language::translate('LBL_BACK', $QUALIFIED_MODULE)}</strong></button>&nbsp;&nbsp;
				<button class="btn btn-success" type="submit"><strong>{\App\Language::translate('LBL_NEXT', $QUALIFIED_MODULE)}</strong></button>&nbsp;&nbsp;
				<button class="btn btn-warning cancelLink" type="reset">{\App\Language::translate('LBL_CANCEL', $QUALIFIED_MODULE)}</button>
			</div>
		</form>
	</div>
{/strip}
