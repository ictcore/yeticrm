{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
<div class="modal fade" tabindex="-1">
	<div class="modal-dialog">
        <div class="modal-content">
			<form class="form-modalAddWidget">
				<input type="hidden" name="wid" value="{$WID}">
				<input type="hidden" name="type" value="{$TYPE}">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" class="close" title="{\App\Language::translate('LBL_CLOSE', $QUALIFIED_MODULE)}">×</button>
					<h3 id="massEditHeader" class="modal-title">{\App\Language::translate('Add widget', $QUALIFIED_MODULE)}</h3>
				</div>
				<div class="modal-body">
					<div class="modal-Fields">
						<div class="row">
							<div class="col-md-5 marginLeftZero"><strong>{\App\Language::translate('Type widget', $QUALIFIED_MODULE)}</strong>:</div>
							<div class="col-md-7">
								{\App\Language::translate($TYPE, $QUALIFIED_MODULE)}
							</div>
						</div>
					</div>
				</div>
				{include file='ModalFooter.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
			</form>
		</div>
	</div>
</div>
{/strip}
