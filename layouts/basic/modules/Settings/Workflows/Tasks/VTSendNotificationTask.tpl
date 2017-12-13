{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="" id="VtVTEmailTemplateTaskContainer">
		<div class="">
			<div class="row">
				<label class="control-label col-md-4">{\App\Language::translate('EmailTempleteList', $QUALIFIED_MODULE)}</label>
				<div class="col-md-7">
					<select class="chzn-select form-control" name="template" data-validation-engine='validate[required]'>
						<option value="">{\App\Language::translate('LBL_NONE', $QUALIFIED_MODULE)}</option>
						{foreach from=App\Mail::getTempleteList($SOURCE_MODULE,'PLL_RECORD') key=key item=item}
							<option {if $TASK_OBJECT->template eq $item['id']}selected=""{/if} value="{$item['id']}">{\App\Language::translate($item['name'], $QUALIFIED_MODULE)}</option>
						{/foreach}
					</select>
				</div>
			</div>
		</div>
	</div>	
{/strip}	
