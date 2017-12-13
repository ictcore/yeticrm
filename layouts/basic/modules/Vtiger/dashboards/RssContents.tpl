{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>{\App\Language::translate('LBL_SUBJECT', $MODULE_NAME)}</th>
				<th>{\App\Language::translate('LBL_SOURCE', $MODULE_NAME)}</th>
				<th>{\App\Language::translate('LBL_DATE', $MODULE_NAME)}</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$LIST_SUCJECTS item=SUBJECT}
				<tr>
					<td><a href="{$SUBJECT['link']}"><strong title="{Vtiger_Util_Helper::toSafeHTML($SUBJECT['fullTitle'])}">{$SUBJECT['title']}</strong></a></td>
					<td>{$SUBJECT['source']}</td>
					<td>{$SUBJECT['date']}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
{/strip}
