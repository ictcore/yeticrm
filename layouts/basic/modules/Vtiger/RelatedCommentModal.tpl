{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="massEditHeader" class="modal-title">{\App\Language::translate('LBL_EDIT_RELATED_COMMENT', $MODULE)}</h3>
	</div>
	<div class="modal-body">
		<input type="hidden" class="relatedRecord" value="{$RELATED_RECORD}" />
		<input type="hidden" class="relatedModuleName" value="{$RELATED_MODULE}" />
		<textarea class="form-control comment" rows="4">{$COMMENT}</textarea>
	</div>
	<div class="modal-footer">
		<div class="pull-right">
			<button class="btn btn-success" type="submit" name="saveButton"><strong>{\App\Language::translate('LBL_SAVE', $MODULE)}</strong></button>
			<button class="btn btn-warning" type="reset" data-dismiss="modal"><strong>{\App\Language::translate('LBL_CANCEL', $MODULE)}</strong></button>
		</div>
	</div>
{/strip}
