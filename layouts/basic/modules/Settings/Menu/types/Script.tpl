{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}

<div class="form-group">
	<label class="col-md-4 control-label">{\App\Language::translate('LBL_NAME', $QUALIFIED_MODULE)}:</label>
	<div class="col-md-7">
		<input name="label" class="form-control" type="text" value="{if $RECORD}{$RECORD->get('label')}{/if}" data-validation-engine="validate[required]" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">{\App\Language::translate('LBL_JAVASCRIPT', $QUALIFIED_MODULE)}:</label>
	<div class="col-md-7">
		<textarea name="dataurl" class="form-control">{if $RECORD}{$RECORD->get('dataurl')}{else}javascript:{/if}</textarea>
	</div>
</div>
{include file='fields/Hotkey.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
<div class="form-group">
	<label class="col-md-4 control-label">{\App\Language::translate('LBL_ICON_NAME', $QUALIFIED_MODULE)}:</label>
	<div class="col-md-7">
		<div class="input-group">
			<input name="icon" class="form-control" type="text" value="{if $RECORD}{$RECORD->get('icon')}{/if}"/>
			<span class="input-group-btn">
				<button id="selectIconButton" class="btn btn-default" title="{\App\Language::translate('LBL_SELECT_ICON',$QUALIFIED_MODULE)}" type="button"><span class="glyphicon glyphicon-info-sign"></span></button>
			</span>
		</div>
	</div>
</div>
