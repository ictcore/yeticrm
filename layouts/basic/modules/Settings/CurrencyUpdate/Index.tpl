{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
<div id="currencyUpdateContainer">
	<div class="widget_header row">
		<div class="col-xs-12">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
			{\App\Language::translate('LBL_CURRENCY_UPDATE_DESCRIPTION', $QUALIFIED_MODULE)}
		</div>
	</div>
	{if $CURRNUM lt 2}
		<div class="alert alert-danger" style="margin:10px 15px;">
			<strong>{\App\Language::translate('LBL_WARNING', $QUALIFIED_MODULE)}</strong> {\App\Language::translate('MSG_ONE_CURRENCY', $QUALIFIED_MODULE)}
		</div>
	{/if}
	<form class="form-horizontal" method="post" action="index.php?module={$MODULENAME}&view=Index&parent=Settings">
		<table class="table table-bordered currencyTable">
			<tr>
				<th class="blockHeader" colspan="4">{\App\Language::translate('LBL_SELECT_BANK', $QUALIFIED_MODULE)}</th>
			</tr>
			<tr>
				<td class="fieldLabel">
					<span class="pull-right"><strong>{\App\Language::translate('LBL_BANK', $QUALIFIED_MODULE)}:</strong></span>
				</td>
				<td class="fieldValue">
					<div class="row">
						<div class="col-md-5">
							<select name="bank" id="bank" class="chzn-select form-control">
								{foreach from=$BANK item=key}
									<option value="{$key.id}" {if $key.active eq '1'}selected{/if} data-name="{$key.bank_name}">{\App\Language::translate($key.bank_name, $QUALIFIED_MODULE)}</option>
								{/foreach}
							</select>
						</div>
						<div class="col-md-7 btn-toolbar">
							{*<button class="btn btn-success pull-right" name="save" type="submit"><strong>{\App\Language::translate('LBL_SET_DEFAULT_BANK', $QUALIFIED_MODULE)}</strong></button>*}
							<button class="btn btn-danger pull-right {if count($UNSUPPORTED_CURRENCIES) eq 0}hide{/if}" id="unsupportedCurrencies" title="{\App\Language::translate('LBL_CURRENCIES_UNSUPPORTED', $QUALIFIED_MODULE)}" type="button"><span class="glyphicon glyphicon-alert"></span></button>
							<button class="btn btn-info pull-right" id="supportedCurrencies" title="{\App\Language::translate('LBL_CURRENCIES_SUPPORTED', $QUALIFIED_MODULE)}" type="button"><span class="glyphicon glyphicon-info-sign"></span></button>
						</div>
					</div>
				</td>
			</tr>
			<tr id="infoBlock" class="hide">
				<td colspan="4">
					<div class="alert alert-info">
						<h4>{\App\Language::translate('LBL_CURRENCIES_SUPPORTED', $QUALIFIED_MODULE)}:</h4>
						<span id='infoSpan'>
							{foreach from=$SUPPORTED_CURRENCIES key=NAME item=CODE}
								<p><strong>{\App\Language::translate($NAME, $QUALIFIED_MODULE)}</strong> - {$CODE}</p>
							{/foreach}
						</span>
					</div>
				</td>
			</tr>
			<tr id="alertBlock" class="hide">
				<td colspan="4">
					<div class="alert alert-danger">
						<h4>{\App\Language::translate('LBL_CURRENCIES_UNSUPPORTED', $QUALIFIED_MODULE)}:</h4>
						<span id='alertSpan'>
							{foreach from=$UNSUPPORTED_CURRENCIES key=NAME item=CODE}
								<p><strong>{\App\Language::translate($NAME, $QUALIFIED_MODULE)}</strong> - {$CODE}</p>
							{/foreach}
						</span>
					</div>
				</td>
			</tr>
			<tr>
				<th class="blockHeader" colspan="4">{\App\Language::translate('LBL_HISTORY', $QUALIFIED_MODULE)}</th>
			</tr>
			<tr>
				<td class="fieldLabel">
					<span class="pull-right"><strong>{\App\Language::translate('LBL_CAL_DATE', $QUALIFIED_MODULE)}:</strong></label>
				</td>
				<td class="fieldValue" >
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
						<input id="datepicker" type="text" class="form-control dateField" name="duedate" data-date-format="{$USER_MODEL->get('date_format')}" value="{$DATE}" />
						<span class="input-group-btn">
							<button class="btn btn-success" name="download" value="download" type="submit">{\App\Language::translate('LBL_SHOW', $QUALIFIED_MODULE)}</button>
						</span>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
		<div class="alert alert-info alert-block">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>{\App\Language::translate('LBL_INFORMATIONS', $QUALIFIED_MODULE)}:</h4>
			<p><strong>{\App\Language::translate('LBL_MAINCURRENCY', $QUALIFIED_MODULE)}:</strong> {\App\Language::translate($MAINCURR['currency_name'], $QUALIFIED_MODULE)}, <strong>{\App\Language::translate('LBL_CODE', $QUALIFIED_MODULE)}:</strong> {$MAINCURR['currency_code']}, <strong>{\App\Language::translate('LBL_SYMBOL', $QUALIFIED_MODULE)}</strong>: {$MAINCURR['currency_symbol']}</p>
		</div>
			<table class="table table-bordered tableRWD">
				<thead>
					<tr>
						<th class="blockHeader">{\App\Language::translate('LBL_CURRENCY_NAME', $QUALIFIED_MODULE)}</td>
						<th class="blockHeader">{\App\Language::translate('LBL_CURRENCY_SYMBOL', $QUALIFIED_MODULE)}</td>
						<th class="blockHeader">{\App\Language::translate('LBL_COURSE', $QUALIFIED_MODULE)}</td>
						<th class="blockHeader">{\App\Language::translate('LBL_DATE', $QUALIFIED_MODULE)}</td>
						<th class="blockHeader">{\App\Language::translate('LBL_ACTUAL_DATE_OF_COURSE', $QUALIFIED_MODULE)}</td>
					</tr>
				</thead>
				{foreach from=$HISTORIA item=key}
					<tr>
						<td>{\App\Language::translate($key.currency_name, 'Settings:Currency')} ({$key.currency_code})</td>
						<td>
							{if $USER_MODEL->get('currency_symbol_placement') eq '$1.0'}
								{$key.currency_symbol} 
							{/if}
							1
							{if $USER_MODEL->get('currency_symbol_placement') eq '1.0$'}
								{$key.currency_symbol}
							{/if}
						</td>
						<td>
							{if $USER_MODEL->get('currency_symbol_placement') eq '$1.0'}
								{$MAINCURR['currency_symbol']} 
							{/if}
							{number_format($key.exchange, 4, $USER_MODEL->get('currency_decimal_separator'), $USER_MODEL->get('currency_grouping_separator'))}
							{if $USER_MODEL->get('currency_symbol_placement') eq '1.0$'}
								{$MAINCURR['currency_symbol']}
							{/if}
						</td>
						<td>{DateTimeField::convertToUserFormat($key.fetch_date)}</td>
						<td>{DateTimeField::convertToUserFormat($key.exchange_date)}</td>
					</tr>
				{/foreach}
			</table>
		
	</form>
</div>
{/strip}
