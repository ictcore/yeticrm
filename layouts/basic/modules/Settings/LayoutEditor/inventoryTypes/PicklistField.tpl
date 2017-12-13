{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="form-group">
		<label class="col-md-4 control-label">{\App\Language::translate('LBL_LABEL_NAME', $QUALIFIED_MODULE)}:</label>
		<div class="col-md-7">
			{assign var='LABEL' value=$FIELD_INSTANCE->getDefaultLabel()}
			{if $FIELD_INSTANCE->get('label') }
				{assign var='LABEL' value=$FIELD_INSTANCE->get('label')}
			{/if}
			<input name="label" class="form-control" type="text" value="{$LABEL}" data-validation-engine="validate[required]" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">{\App\Language::translate('LBL_DISPLAY_TYPE', $QUALIFIED_MODULE)}:</label>
		<div class="col-md-7">
			<select class='form-control select2' name="displayType" data-validation-engine="validate[required]">
				{foreach from=$FIELD_INSTANCE->displayTypeBase() item=ITEM key=KEY}
					<option value="{$ITEM}" {if $ITEM eq $FIELD_INSTANCE->get('displaytype')} selected {/if}>{\App\Language::translate($KEY, $QUALIFIED_MODULE)}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">{\App\Language::translate('LBL_COLSPAN', $QUALIFIED_MODULE)}:</label>
		<div class="col-md-7">
			<input name="colSpan" class="form-control" type="text" value="{$FIELD_INSTANCE->getColSpan()}" data-validation-engine="validate[required]" />
		</div>
	</div>
	{if $FIELD_INSTANCE->getParams()}
		<div class="paramsJson">
			<input id="params" class="" type="hidden" value='{\App\Json::encode($FIELD_INSTANCE->getParams())}'/>
			{assign var=PARAMS value=\App\Json::decode($FIELD_INSTANCE->get('params'))}
			{foreach from=$FIELD_INSTANCE->getParams() item=MODULE}
				<div class="form-group paramsJson">
					<label class="col-md-4 control-label">{\App\Language::translate($MODULE, $MODULE)}:</label>
					<div class="col-md-7">
						<select class="form-control select2" name="{$MODULE}"  data-validation-engine="validate[required]">
							{foreach from=$FIELD_INSTANCE->getPicklist($MODULE) item=NAME key=VALUE}
								<option value="{$VALUE}" {if $PARAMS[$MODULE] == $VALUE} selected {/if}>{$NAME}</option>
							{/foreach}
						</select>
					</div>
				</div>
			{/foreach}
		</div>
	{/if}
{/strip}
