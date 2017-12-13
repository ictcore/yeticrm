{strip}
{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
<div class="widget_header row">
	<div class="col-md-6">
		{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
	</div>
	<div class="col-md-6">
		<div class="col-md-6">
			<button class="btn btn-success pull-right createNotification">{\App\Language::translate('LBL_ADD',$QUALIFIED_MODULE)}</button>
		</div>
		<div class="col-md-6">
			<select class="select2 form-control" name="roleMenu">
				<option value="0" {if $ROLEID eq 0} selected="" {/if}>{\App\Language::translate('LBL_DEFAULT_MENU', $QUALIFIED_MODULE)}</option>
				{foreach item=ROLE key=KEY from=$LIST_ROLES}
					<option value="{$KEY|replace:'H':''}" {if $ROLEID === $KEY} selected="" {/if}>{\App\Language::translate($ROLE->getName())}</option>
				{/foreach}
			</select>
		</div>
	</div>
</div>
<div class="col-xs-12 listWithNotifications">
</div>
{/strip}
