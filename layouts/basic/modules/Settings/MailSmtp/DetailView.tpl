{strip} 
	{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
	<div class="widget_header row">
		<div class="col-md-8">
			{include file='BreadCrumbs.tpl'|@vtemplate_path:$MODULE}
			{App\Language::translate('LBL_MAILSMTP_TO_SEND_DESCRIPTION',$QUALIFIED_MODULE)}
		</div>
		<div class="col-md-4 marginbottomZero">
			<div class="pull-right btn-toolbar"><span class="actionImages">
					<a class="btn btn-info" href="{$RECORD_MODEL->getEditViewUrl()}">
						<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;
						<strong>{App\Language::translate('LBL_EDIT_RECORD', $QUALIFIED_MODULE)}</strong>
					</a>
					<a class="btn btn-danger marginLeft5" href="{$RECORD_MODEL->getDeleteActionUrl()}">
						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;
						<strong>{App\Language::translate('LBL_DELETE_RECORD', $QUALIFIED_MODULE)}</strong>
					</a>
			</div>
		</div>
	</div>
	<div class="detailViewInfo">
		{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}
		<table class="table table-bordered">
			<thead>
				<tr class="blockHeader">
					<th colspan="2" class="{$WIDTHTYPE} col-md-12"><strong>{App\Language::translate('LBL_SMTP_DETAIL',$QUALIFIED_MODULE)}</strong></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_NAME', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('name')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_MAILER_TYPE', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('mailer_type')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_DEFAULT', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('default')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_HOST', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('host')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_PORT', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('port')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_AUTHENTICATION', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('authentication')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_USERNAME', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('username')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_PASSWORD', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('password')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_INDIVIDUAL_DELIVERY', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('individual_delivery')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_SECURE', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('secure')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_INDIVIDUAL_DELIVERY', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('individual_delivery')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_FROM_NAME', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('from_name')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_FROM_EMAIL', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('from_email')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_REPLY_TO', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('reply_to')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_OPTIONS', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('options')}
					</td>
				</tr>
				<tr>
					<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_SAVE_SEND_MAIL', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE} col-md-8">
						{$RECORD_MODEL->getDisplayValue('save_send_mail')}
					</td>
				</tr>
			</tbody>
		</table>
		{if $RECORD_MODEL->get('save_send_mail') eq 1}	
			<table class="table table-bordered">
				<thead>
					<tr class="blockHeader">
						<th colspan="2" class="{$WIDTHTYPE} col-md-12"><strong>{App\Language::translate('LBL_IMAP_SAVE_MAIL',$QUALIFIED_MODULE)}</strong></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_HOST', $QUALIFIED_MODULE)}</label></td>
						<td class="{$WIDTHTYPE} col-md-8">
							{$RECORD_MODEL->getDisplayValue('smtp_host')}
						</td>
					</tr>
					<tr>
						<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_PORT', $QUALIFIED_MODULE)}</label></td>
						<td class="{$WIDTHTYPE} col-md-8">
							{$RECORD_MODEL->getDisplayValue('smtp_port')}
						</td>
					</tr>
					<tr>
						<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_USERNAME', $QUALIFIED_MODULE)}</label></td>
						<td class="{$WIDTHTYPE} col-md-8">
							{$RECORD_MODEL->getDisplayValue('smtp_username')}
						</td>
					</tr>
					<tr>
						<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_PASSWORD', $QUALIFIED_MODULE)}</label></td>
						<td class="{$WIDTHTYPE} col-md-8">
							{$RECORD_MODEL->getDisplayValue('smtp_password')}
						</td>
					</tr>
					<tr>
						<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_SEND_FOLDER', $QUALIFIED_MODULE)}</label></td>
						<td class="{$WIDTHTYPE} col-md-8">
							{$RECORD_MODEL->getDisplayValue('smtp_folder')}
						</td>
					</tr>
					<tr>
						<td class="{$WIDTHTYPE} col-md-3" ><label class="pull-right">{App\Language::translate('LBL_VALIDATE_CERT', $QUALIFIED_MODULE)}</label></td>
						<td class="{$WIDTHTYPE} col-md-8">
							{$RECORD_MODEL->getDisplayValue('smtp_validate_cert')}
						</td>
					</tr>
				</tbody>
			</table>
		{/if}	
	</div>
	{strip}
