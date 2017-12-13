{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
<input id="activityReminder" class="hide noprint" type="hidden" value="{$ACTIVITY_REMINDER}"/>
{if AppConfig::module('Users', 'IS_VISIBLE_USER_INFO_FOOTER')}
	<div class="infoUser">
		{$USER_MODEL->getName()}&nbsp;(
		{$USER_MODEL->get('email1')}&nbsp;
		{if !empty({$USER_MODEL->get('phone_crm_extension')})}
			,&nbsp; {$USER_MODEL->get('phone_crm_extension')}
		{/if}
		)
	</div>
{/if}
<footer class="footerContainer navbar-default navbar-fixed-bottom noprint">
	<div class="vtFooter">
		<div class="pull-left">
			<a class="iconsInFooter" href="https://www.linkedin.com/groups/8177576">
				<span class="AdditionalIcon-Linkedin" title="Linkendin"></span>
			</a>
			<a class="iconsInFooter" href="https://twitter.com/YetiForceEN">
				<span class="AdditionalIcon-Twitter" title="Twitter"></span>
			</a>
			<a class="iconsInFooter" href="https://www.facebook.com/YetiForce-CRM-158646854306054/">
				<span class="AdditionalIcon-Facebook" title="Facebook"></span>
			</a>
			<a class="iconsInFooter" href="https://github.com/YetiForceCompany/YetiForceCRM">
				<span class="AdditionalIcon-Github" title="Github"></span>
			</a>
		</div>
		<div class="pull-right">
			<button type="button" class="btn-link" data-toggle="modal" data-target="#yetiforceDetails">
				<img class="logoFooter" src="{App\Layout::getPublicUrl('layouts/resources/Logo/white_logo_yetiforce.png')}" alt="YetiForceCRM"/>
			</button>
		</div>
		{assign var=SCRIPT_TIME value=round(microtime(true) - \App\Config::$startTime, 3)}
		{if $USER_MODEL->is_admin == 'on'}
			{assign var=FOOTVR value= '[ver. '|cat:$YETIFORCE_VERSION|cat:'] ['|cat:\App\Language::translate('WEBLOADTIME')|cat:': '|cat:$SCRIPT_TIME|cat:'s.]'}
			{assign var=FOOTVRM value= '['|cat:$SCRIPT_TIME|cat:'s.]'}
			{assign var=FOOTOSP value= '<u><a href="index.php?module=Home&view=Credits&parent=Settings">open source project</a></u>'}
			<p class="hidden-xs">{sprintf( \App\Language::translate('LBL_FOOTER_CONTENT') , $FOOTVR ,$FOOTOSP)}</p>
			<p class="visible-xs-block">{sprintf( \App\Language::translate('LBL_FOOTER_CONTENT') , $FOOTVRM ,$FOOTOSP)}</p>
		{else}
			<p>{sprintf( \App\Language::translate('LBL_FOOTER_CONTENT') , '['|cat:\App\Language::translate('WEBLOADTIME')|cat:': '|cat:$SCRIPT_TIME|cat:'s.]', 'open source project' )}</p>
		{/if}
	</div>
</footer>
<div class="modal fade" id="yetiforceDetails" tabindex="-1" role="dialog" aria-labelledby="yetiforceDetails">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">YetiForceCRM {if $USER_MODEL->is_admin == 'on'}v{$YETIFORCE_VERSION}{/if} - The best open system in the world</h4>
			</div>
			<div class="modal-body">
				<p class="text-center"><img  src="{App\Layout::getPublicUrl('layouts/resources/Logo/blue_yetiforce_logo.png')}" title="YetiForceCRM" alt="YetiForceCRM" style="height: 120px;"/></p>
				<p>Copyright © YetiForce.com All rights reserved.</p>
				<p>The Program is provided AS IS, without warranty. Licensed under <a href="licenses/LicenseEN.txt" target="_blank"><strong>YetiForce Public License 2.0</strong></a>.</p>
				<p>YetiForce is based on two systems - <strong>VtigerCRM</strong> and <strong>SugarCRM</strong>.<br /><br /></p>
				<p><span class="label label-default">License:</span> <a href="licenses/LicenseEN.txt" target="_blank"><strong>YetiForce Public License 2.0</strong></a></p>
				<p><span class="label label-primary">WWW:</span> <a href="https://yetiforce.com" target="_blank"><strong>https://yetiforce.com</strong></a></p>
				<p><span class="label label-success">Code:</span> <a href="https://github.com/YetiForceCompany/YetiForceCRM" target="_blank"><strong>https://github.com/YetiForceCompany/YetiForceCRM</strong></a></p>
				<p><span class="label label-info">Documentation:</span> <a href="https://yetiforce.com/en/documentation.html" target="_blank"><strong>https://yetiforce.com/en/documentation.html</strong></a></p>
				<p><span class="label label-warning">Issues:</span> <a href="https://github.com/YetiForceCompany/YetiForceCRM/issues" target="_blank"><strong>https://github.com/YetiForceCompany/YetiForceCRM/issues</strong></a></p>
				<p class="text-center">
					<a class="yetiforceDetailsLink" href="https://www.linkedin.com/groups/8177576">
						<span class="fa fa-linkedin-square" title="LinkendIn"></span>
					</a>
					<a class="yetiforceDetailsLink" href="https://twitter.com/YetiForceEN">
						<span class="fa fa-twitter-square" title="Twitter"></span>
					</a>
					<a class="yetiforceDetailsLink" href="https://www.facebook.com/YetiForce-CRM-158646854306054/">
						<span class="fa fa-facebook-square" title="Facebook"></span>
					</a>
					<a class="yetiforceDetailsLink" href="https://github.com/YetiForceCompany/YetiForceCRM">
						<span class="fa fa-github-square" title="Github"></span>
					</a>
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-warning" type="reset" data-dismiss="modal"><strong>{\App\Language::translate('LBL_CANCEL', $MODULE)}</strong></button>
			</div>
		</div>
	</div>
</div>
{* javascript files *}
{include file='JSResources.tpl'|@vtemplate_path}
{if \App\Debuger::isDebugBar()}
	{\App\Debuger::getDebugBar()->getJavascriptRenderer()->render()}
{/if}
</body>
</html>
{/strip}
