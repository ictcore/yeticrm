{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	<div class="rowRelatedRecord" data-id="{$RELATED['id']}" data-module="{$RELATED['module']}">
		<a href="{$URL}index.php?module={$RELATED['module']}&amp;view=Detail&amp;record={$RELATED['id']}" title="{\App\Language::translate('SINGLE_'|cat:$RELATED['module'],$RELATED['module'])}: {$RELATED['label']}" target="_blank">
			<span class="relatedModuleIcon userIcon-{$RELATED['module']}" aria-hidden="true"></span>
			<span class="relatedName">
				{vtlib\Functions::textLength($RELATED['label'],38)}
			</span>
		</a>
		<div class="pull-right rowActions">
			{if Users_Privileges_Model::isPermitted('Calendar','CreateView')}
				<button class="addRelatedRecord" data-module="Calendar" title="{\App\Language::translate('LBL_ADD_CALENDAR',$MODULE_NAME)}">
					<span class="userIcon-Calendar" aria-hidden="true"></span>
				</button>
			{/if}
			{if Users_Privileges_Model::isPermitted('ModComments','CreateView')}
				<button class="addRelatedRecord" data-module="ModComments" title="{\App\Language::translate('LBL_ADD_MODCOMMENTS',$MODULE_NAME)}">
					<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
				</button>
			{/if}
			{if in_array($RELATED['module'], ['HelpDesk','Project']) &&  Users_Privileges_Model::isPermitted('HelpDesk','CreateView')}
				<button class="addRelatedRecord" data-module="HelpDesk" title="{\App\Language::translate('LBL_ADD_HELPDESK',$MODULE_NAME)}">
					<span class="userIcon-HelpDesk" aria-hidden="true"></span>
				</button>
			{/if}
			{if in_array($RELATED['module'], ['Accounts','Contacts','Leads']) && Users_Privileges_Model::isPermitted('Products','DetailView')}
				<button class="selectRecord" data-type="1" data-module="Products" title="{\App\Language::translate('LBL_ADD_PRODUCTS',$MODULE_NAME)}">
					<span class="userIcon-Products" aria-hidden="true"></span>
				</button>
			{/if}
			{if in_array($RELATED['module'], ['Accounts','Contacts','Leads']) &&  Users_Privileges_Model::isPermitted('Services','DetailView')}
				<button class="selectRecord" data-type="1" data-module="Services" title="{\App\Language::translate('LBL_ADD_SERVICES',$MODULE_NAME)}">
					<span class="userIcon-Services" aria-hidden="true"></span>
				</button>
			{/if}
			<button class="removeRecord " title="{\App\Language::translate('LBL_REMOVE_RELATION',$MODULE_NAME)} {$RELATED['label']}">
				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			</button>
		</div>
	</div>
{/strip}
