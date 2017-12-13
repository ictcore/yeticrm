{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
<input type="hidden" id="view" value="{$VIEW}" />
<div class="" id="inventoryConfig">
	<div class="widget_header row">
		<div class="col-xs-12">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
			{\App\Language::translate($PAGE_LABELS.description,$QUALIFIED_MODULE)}
		</div>
	</div>
	<div class="contents marginTop20 form-horizontal">
		<div class="form-group">
			{assign var=LABEL_CHECKBOX value='LBL_YES'}
			{if !$CONFIG.active}
				{assign var=LABEL_CHECKBOX value='LBL_NO'}
			{/if}
			<label class="col-md-3 control-label form-control-static">{\App\Language::translate('LBL_ARE_ACTIVE', $QUALIFIED_MODULE)}</label>
			<div class="col-md-6" data-toggle="buttons">
				<label class="btn {if $CONFIG.active}btn-success active{else}btn-default{/if}">
					<input autocomplete="off" type="checkbox" name="active" {if $CONFIG.active}checked{/if}><span class="text">&nbsp;&nbsp;{\App\Language::translate($LABEL_CHECKBOX, $QUALIFIED_MODULE)}</span>
					<span class="glyphicon {if $CONFIG.active}glyphicon-check{else}glyphicon-unchecked{/if} pull-left"></span>
				</label>	
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label form-control-static">{\App\Language::translate('LBL_SUMMATION_TYPE', $QUALIFIED_MODULE)}</label>
			<div class="col-md-6">
				<select class="select2" name="aggregation">
					{foreach  item=LABEL key=KEY from=Settings_Inventory_Module_Model::getPicklistValues('aggregation')}
						<option value="{$KEY}" {if $KEY eq $CONFIG.aggregation} selected {/if}>{\App\Language::translate($LABEL, $QUALIFIED_MODULE)}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<div class="form-group">
			{if $VIEW eq 'DiscountConfiguration'}
				{assign var=FIELD value='discounts'}
			{else}
				{assign var=FIELD value='taxs'}	
			{/if}
			{assign var=FIELD_VALUE value=explode(',',$CONFIG[$FIELD])}
			<label class="col-md-3 control-label form-control-static">{\App\Language::translate('LBL_AVAILABLE_'|cat:strtoupper($FIELD), $QUALIFIED_MODULE)}</label>
			<div class="col-md-6">
				<select class="select2" multiple name="{$FIELD}">
					{foreach  item=LABEL key=KEY from=Settings_Inventory_Module_Model::getPicklistValues($FIELD)}
						<option value="{$KEY}" {if in_array($KEY, $FIELD_VALUE)} selected {/if}>{\App\Language::translate($LABEL, $QUALIFIED_MODULE)}</option>
					{/foreach}
				</select>
			</div>
		</div>
	</div>
</div>
{/strip}
