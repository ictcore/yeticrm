{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<style>
		{foreach item=VALUE key=NAME from=$COLORS}
			.headingColor{$NAME}{
				background-color: {$VALUE} !important;
				border-color: {$VALUE};
				background: linear-gradient(-10deg, #fff, transparent 70%)
			}
		{/foreach}
	</style>
	<div class="remindersContent">
		{foreach item=RECORD from=$RECORDS}
			<div class="panel headingColor{$RECORD->get('notification_type')}" data-record="{$RECORD->getId()}">
				<div class="panel-body padding0">
					<div class="col-xs-2 notificationIcon">
						<span class="glyphicon {if $RECORD->get('notification_type') eq 'PLL_SYSTEM'}glyphicon-hdd{else}glyphicon-user{/if}" aria-hidden="true"></span>
					</div>
					<div class="col-xs-10 paddingLR5 notiContent">
						<div class="col-xs-6 paddingLRZero marginTB3 font-larger">
							<strong class="pull-left">{\App\Language::translate($RECORD->get('notification_type'),$MODULE_NAME)}</strong>
						</div>
						<div class="col-xs-6 paddingLRZero marginTB3 font-larger">
							<strong class="pull-right">{$RECORD->getDisplayValue('createdtime')}</strong>
						</div>
						<div class="col-xs-12 paddingLRZero marginBottom5">
							{$RECORD->getTitle()}
							<div class="moreContent">
								{assign var=FULL_TEXT value=$RECORD->getMessage()}
								<span class="teaserContent">
									{if strip_tags($FULL_TEXT)|strlen <= 200}
										{$FULL_TEXT}
										{assign var=SHOW_BUTTON value=false}
									{else}
										{Vtiger_Util_Helper::toSafeHTML(strip_tags($FULL_TEXT))|substr:0:200}
										{assign var=SHOW_BUTTON value=true}
									{/if}
								</span>
								{if $SHOW_BUTTON}
									<span class="fullContent hide">
										{$FULL_TEXT}
									</span>
									&nbsp;<button type="button" class="btn btn-info btn-xs moreBtn" data-on="{\App\Language::translate('LBL_MORE_BTN')}" data-off="{\App\Language::translate('LBL_HIDE_BTN')}">{\App\Language::translate('LBL_MORE_BTN')}</button>
								{/if}
							</div>
						</div>
						<div class="col-xs-12 paddingLRZero marginBottom5 ">
							<div class="col-xs-10 paddingLRZero textOverflowEllipsis">
								<strong class="">{\App\Language::translate($RECORD->getModule()->getField('smcreatorid')->get('label'),$MODULE_NAME)}: {$RECORD->getCreatorUser()}</strong>
							</div>
							<div class="col-xs-2 paddingLRZero">
								<button type="button" class="btn btn-success btn-xs pull-right setAsMarked" title="{\App\Language::translate('LBL_MARK_AS_READ',$MODULE_NAME)}">
									<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		{foreachelse}
			<div class="alert alert-info">
				{\App\Language::translate('LBL_NO_UNREAD_NOTIFICATIONS',$MODULE_NAME)}
			</div>
		{/foreach}
	</div>
{/strip}
