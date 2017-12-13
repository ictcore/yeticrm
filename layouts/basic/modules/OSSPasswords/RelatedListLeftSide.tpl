{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	{if $IS_FAVORITES}
		{assign var=RECORD_IS_FAVORITE value=(int)in_array($RELATED_RECORD->getId(),$FAVORITES)}
		<div>
			<a class="favorites" data-state="{$RECORD_IS_FAVORITE}">
				<span title="{\App\Language::translate('LBL_REMOVE_FROM_FAVORITES', $MODULE)}" class="glyphicon glyphicon-star alignMiddle {if !$RECORD_IS_FAVORITE}hide{/if}"></span>
				<span title="{\App\Language::translate('LBL_ADD_TO_FAVORITES', $MODULE)}" class="glyphicon glyphicon-star-empty alignMiddle {if $RECORD_IS_FAVORITE}hide{/if}"></span>
			</a>
		</div>
	{/if}
	<div>
		<a href="#" id="copybtn_{$PASS_ID}" data-id="{$PASS_ID}" class="copy_pass hide" title="{\App\Language::translate('LBL_CopyToClipboardTitle', $RELATED_MODULE_NAME)}"><span class="glyphicon glyphicon-download-alt alignMiddle"></span></a>&nbsp;
	</div>
	<div class="actions">
		<span class="glyphicon glyphicon-wrench toolsAction alignMiddle"></span>
		{* button for copying password to clipboard *}  
		<span class="actionImages hide">
			<a href="#" class="show_pass" id="btn_{$PASS_ID}"><span title="{\App\Language::translate('LBL_ShowPassword', $RELATED_MODULE_NAME)}" data-title-show="{\App\Language::translate('LBL_ShowPassword', $RELATED_MODULE_NAME)}" data-title-hide="{\App\Language::translate('LBL_HidePassword', $RELATED_MODULE_NAME)}" class="glyphicon adminIcon-passwords-encryption alignMiddle"></span></a>&nbsp;
				{if $RELATED_MODULE->isPermitted('WatchingRecords') && $RELATED_RECORD->isViewable()}
					{assign var=WATCHING_STATE value=(!$RELATED_RECORD->isWatchingRecord())|intval}
				<a href="#" onclick="Vtiger_Index_Js.changeWatching(this)" title="{\App\Language::translate('BTN_WATCHING_RECORD', $MODULE)}" data-record="{$RELATED_RECORD->getId()}" data-value="{$WATCHING_STATE}" class="noLinkBtn{if !$WATCHING_STATE} info-color{/if}" data-on="info-color" data-off="" data-icon-on="glyphicon-eye-open" data-icon-off="glyphicon-eye-close" data-module="{$RELATED_MODULE_NAME}">
					<span class="glyphicon {if $WATCHING_STATE}glyphicon-eye-close{else}glyphicon-eye-open{/if} alignMiddle"></span>
				</a>&nbsp;
			{/if}
			{if $RELATED_MODULE_NAME eq 'Calendar'}
				{assign var=CURRENT_ACTIVITY_LABELS value=Calendar_Module_Model::getComponentActivityStateLabel('current')}
				{if $IS_EDITABLE && in_array($RELATED_RECORD->get('activitystatus'),$CURRENT_ACTIVITY_LABELS)}
					<a class="showModal" data-url="{$RELATED_RECORD->getActivityStateModalUrl()}">
						<span title="{\App\Language::translate('LBL_SET_RECORD_STATUS', $MODULE)}" class="glyphicon glyphicon-ok alignMiddle"></span>
					</a>&nbsp;
				{/if}
				{if $RELATED_RECORD->isViewable()}
					<a href="{$RELATED_RECORD->getFullDetailViewUrl()}">
						<span title="{\App\Language::translate('LBL_SHOW_COMPLETE_DETAILS', $MODULE)}" class="glyphicon glyphicon-th-list alignMiddle"></span>
					</a>&nbsp;
				{/if}
			{else}
				{if $RELATED_RECORD->isViewable()}
					<a href="{$RELATED_RECORD->getFullDetailViewUrl()}">
						<span title="{\App\Language::translate('LBL_SHOW_COMPLETE_DETAILS', $MODULE)}" class="glyphicon glyphicon-th-list alignMiddle"></span>
					</a>&nbsp;
				{/if}
			{/if}
			{if $IS_EDITABLE && $RELATED_RECORD->isEditable()}
				{if $RELATED_MODULE_NAME eq 'PriceBooks'}
					<a data-url="index.php?module=PriceBooks&view=ListPriceUpdate&record={$PARENT_RECORD->getId()}&relid={$RELATED_RECORD->getId()}&currentPrice={$LISTPRICE}"
					   class="editListPrice cursorPointer" data-related-recordid='{$RELATED_RECORD->getId()}' data-list-price={$LISTPRICE}>
						<span class="glyphicon glyphicon-pencil alignMiddle" title="{\App\Language::translate('LBL_EDIT', $MODULE)}"></span>
					</a>&nbsp;
				{elseif $RELATED_MODULE_NAME eq 'Calendar'}
					{if $RELATED_RECORD->isEditable()}
						<a href='{$RELATED_RECORD->getEditViewUrl()}'>
							<span title="{\App\Language::translate('LBL_EDIT', $MODULE)}" class="glyphicon glyphicon-pencil alignMiddle"></span>
						</a>&nbsp;
					{/if}
				{else}
					<a href='{$RELATED_RECORD->getEditViewUrl()}'>
						<span title="{\App\Language::translate('LBL_EDIT', $MODULE)}" class="glyphicon glyphicon-pencil alignMiddle"></span>
					</a>&nbsp;
				{/if}
			{/if}
			{if ($IS_EDITABLE && $RELATED_RECORD->isEditable() && $RELATED_RECORD->editFieldByModalPermission()) || $RELATED_RECORD->editFieldByModalPermission(true)}
				{assign var=FIELD_BY_EDIT_DATA value=$RELATED_RECORD->getFieldToEditByModal()}
				<a class="showModal {$FIELD_BY_EDIT_DATA['listViewClass']}" data-url="{$RELATED_RECORD->getEditFieldByModalUrl()}">
					<span title="{\App\Language::translate({$FIELD_BY_EDIT_DATA['titleTag']}, $MODULE)}" class="glyphicon {$FIELD_BY_EDIT_DATA['iconClass']} alignMiddle"></span>
				</a>&nbsp;
			{/if}
			{if $IS_DELETABLE && $RELATED_RECORD->isDeletable()}
				<a class="relationDelete">
					<span title="{\App\Language::translate('LBL_DELETE', $MODULE)}" class="glyphicon glyphicon-trash alignMiddle"></span>
				</a>
			{/if}
		</span>
	</div>
	{if AppConfig::module('ModTracker', 'UNREVIEWED_COUNT') && $RELATED_MODULE->isPermitted('ReviewingUpdates') && $RELATED_MODULE->isTrackingEnabled() && $RELATED_RECORD->isViewable()}
		<div>
			<a href="{$RELATED_RECORD->getUpdatesUrl()}" class="unreviewed alignMiddle">
				<span class="badge bgDanger all" title="{\App\Language::translate('LBL_NUMBER_UNREAD_CHANGES', 'ModTracker')}"></span>
				<span class="badge bgBlue mail noLeftRadius noRightRadius" title="{\App\Language::translate('LBL_NUMBER_UNREAD_MAILS', 'ModTracker')}"></span>
			</a>
		</div>
	{/if}
{/strip}
