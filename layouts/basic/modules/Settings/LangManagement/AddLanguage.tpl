{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
<div class="modal fade AddNewLangMondal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel" class="modal-title">{\App\Language::translate('LBL_ADD_LANG',$QUALIFIED_MODULE)}</h3>
			</div>
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-3">{\App\Language::translate('LBL_Lang_label', $QUALIFIED_MODULE)}:</label>
					<div class="col-md-7"><input name="label" class="form-control" type="text" /></div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{\App\Language::translate('LBL_Lang_name', $QUALIFIED_MODULE)}:</label>
					<div class="col-md-7"><input name="name" class="form-control" type="text" /></div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{\App\Language::translate('LBL_Lang_prefix', $QUALIFIED_MODULE)}:</label>
					<div class="col-md-7"><input name="prefix" class="form-control" type="text" /></div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary">{\App\Language::translate('LBL_AddLanguage', $QUALIFIED_MODULE)}</button>
				<button class="btn btn-warning" data-dismiss="modal" type="button" aria-hidden="true">{\App\Language::translate('LBL_Cancel', $QUALIFIED_MODULE)}</button>
			</div>
		</div>
	</div>
</div>
