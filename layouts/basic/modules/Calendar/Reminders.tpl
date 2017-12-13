{strip}
	<style>
	{if empty($COLOR_LIST)}	
		{foreach item=ITEM from=Settings_Calendar_Module_Model::getCalendarConfig('colors')}
			.borderColor{$ITEM['name']}{
				border-color: {$ITEM['value']};
			}
			.headingColor{$ITEM['name']}{
				background-color: {$ITEM['value']} !important;
				border-color: {$ITEM['value']};
			}
		{/foreach}
	{/if}
	</style>
	<div class="remindersContent">
		{foreach item=RECORD from=$RECORDS}
			{assign var=START_DATE value=$RECORD->get('date_start')}
			{assign var=START_TIME value=$RECORD->get('time_start')}
			{assign var=END_DATE value=$RECORD->get('due_date')}
			{assign var=END_TIME value=$RECORD->get('time_end')}
			{assign var=RECORD_ID value=$RECORD->getId()}
			<div class="panel borderColor{$RECORD->get('activitytype')}" data-record="{$RECORD_ID}">
				<div class="panel-heading headingColor{$RECORD->get('activitytype')}" 
					 {if !empty($COLOR_LIST[$RECORD_ID])}
					 style="background: {$COLOR_LIST[$RECORD_ID]['background']}; color: {$COLOR_LIST[$RECORD_ID]['text']};"
					 {/if}>
					<button class="btn btn-success btn-xs pull-right showModal" data-url="index.php?module=Calendar&view=ActivityStateModal&trigger=Reminders&record={$RECORD->getId()}">
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
					</button>
					<img class="activityTypeIcon" src="{vimage_path($RECORD->getActivityTypeIcon())}" />&nbsp;
					<a target="_blank" href="index.php?module=Calendar&view=Detail&record={$RECORD_ID}">
						{$RECORD->get('subject')}
					</a>
				</div>
				<div class="panel-body">
					<div>
						{\App\Language::translate('Start Date & Time',$MODULE_NAME)}: <strong>{Vtiger_Util_Helper::formatDateTimeIntoDayString("$START_DATE $START_TIME",$RECORD->get('allday'))}</strong>
					</div>
					<div>
						{\App\Language::translate('Due Date',$MODULE_NAME)}: <strong>{Vtiger_Util_Helper::formatDateTimeIntoDayString("$END_DATE $END_TIME",$RECORD->get('allday'))}</strong>
					</div>
					{if $RECORD->get('activitystatus') neq '' }
						<div>
							{\App\Language::translate('Status',$MODULE_NAME)}: <strong>{$RECORD->getDisplayValue('activitystatus')}</strong>
						</div>
					{/if}
					{if $RECORD->get('link') neq ''}
						<div>
							{\App\Language::translate('FL_RELATION',$MODULE_NAME)}: <strong>{$RECORD->getDisplayValue('link')}</strong>
							{if $PERMISSION_TO_SENDE_MAIL}
								{if $USER_MODEL->get('internal_mailer') == 1}
									{assign var=COMPOSE_URL value=OSSMail_Module_Model::getComposeUrl(vtlib\Functions::getCRMRecordType($RECORD->get('link')), $RECORD->get('link'), 'Detail', 'new')}
									<a target="_blank" class="pull-right btn btn-default btn-xs actionIcon" href="{$COMPOSE_URL}" title="{\App\Language::translate('LBL_SEND_EMAIL')}">
										<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
									</a>
								{else}
									{assign var=URLDATA value=OSSMail_Module_Model::getExternalUrl(vtlib\Functions::getCRMRecordType($RECORD->get('link')), $RECORD->get('link'), 'Detail', 'new')}
									{if $URLDATA && $URLDATA != 'mailto:?'}
										<a class="pull-right btn btn-default btn-xs actionIcon" href="{$URLDATA}" title="{\App\Language::translate('LBL_CREATEMAIL', 'OSSMailView')}">
											<span class="glyphicon glyphicon-envelope" title="{\App\Language::translate('LBL_CREATEMAIL', 'OSSMailView')}"></span>
										</a>
									{/if}
								{/if}
							{/if}
						</div>
					{/if}
					{if $RECORD->get('process') neq '' }
						<div>
							{\App\Language::translate('FL_PROCESS',$MODULE_NAME)}: <strong>{$RECORD->getDisplayValue('process')}</strong>
						</div>
					{/if}
					{if $RECORD->get('subprocess') neq '' }
						<div>
							{\App\Language::translate('FL_SUB_PROCESS',$MODULE_NAME)}: <strong>{$RECORD->getDisplayValue('subprocess')}</strong>
						</div>
					{/if}
					{if $RECORD->get('location') neq '' }
						<div>
							{\App\Language::translate('Location',$MODULE_NAME)}:&nbsp;
							<strong>
								{$RECORD->get('location')}
							</strong>
							{if App\Privilege::isPermitted('OpenStreetMap')}
								<a class="pull-right btn btn-default btn-xs actionIcon" onclick="Vtiger_Index_Js.showLocation('{$RECORD->get('location')}')">
									<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
								</a>
							{/if}
						</div>
					{/if}
					<hr />
					<div class="actionRow text-center">
						<a class="btn btn-default btn-sm btn-success showModal" data-url="index.php?module=Calendar&view=ActivityStateModal&trigger=Reminders&record={$RECORD->getId()}"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
						<a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="15m">15{\App\Language::translate('LBL_M',$MODULE_NAME)}</a>
						<a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="30m">30{\App\Language::translate('LBL_M',$MODULE_NAME)}</a>
						<a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="1h">1{\App\Language::translate('LBL_H',$MODULE_NAME)}</a>
						<a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="2h">2{\App\Language::translate('LBL_H',$MODULE_NAME)}</a>
						<a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="6h">6{\App\Language::translate('LBL_H',$MODULE_NAME)}</a>
						<a class="btn btn-default btn-sm btn-primary reminderPostpone" data-time="1d">1{\App\Language::translate('LBL_D',$MODULE_NAME)}</a>
					</div>
				</div>
			</div>
		{foreachelse}
			<div class="alert alert-info">
				{\App\Language::translate('LBL_NO_CURRENT_ACTIVITIES',$MODULE_NAME)}
			</div>
		{/foreach}
	</div>
{/strip}
