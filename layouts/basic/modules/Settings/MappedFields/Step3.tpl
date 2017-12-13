{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="mfTemplateContents">
		<form name="editMFTemplate" action="index.php" method="post" id="mf_step3" class="form-horizontal">
			<input type="hidden" name="module" value="{$MAPPEDFIELDS_MODULE_MODEL->getName()}">
			<input type="hidden" name="view" value="Edit">
			<input type="hidden" name="mode" value="Step4" />
			<input type="hidden" name="parent" value="{$MAPPEDFIELDS_MODULE_MODEL->getParentName()}" />
			<input type="hidden" class="step" value="3" />
			<input type="hidden" name="record" value="{$RECORDID}" />
			<input type="hidden" name="conditions" id="advanced_filter" value='' />
			<div class="col-md-12 paddingLRZero">
				<div class="panel panel-default">
					<div class="panel-body padding0">
						{include file='AdvanceFilterExpressions.tpl'|@vtemplate_path}
					</div>
					<div class="panel-footer clearfix">
						<div class="btn-toolbar pull-right">
							<button class="btn btn-danger backStep" type="button">{\App\Language::translate('LBL_BACK', $QUALIFIED_MODULE)}</button>
							<button class="btn btn-success" type="submit">{\App\Language::translate('LBL_NEXT', $QUALIFIED_MODULE)}</button>
							<button class="btn btn-warning cancelLink" type="reset">{\App\Language::translate('LBL_CANCEL', $QUALIFIED_MODULE)}</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
{/strip}
