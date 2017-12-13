{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
    {assign var="FIELD_INFO" value=$FIELD_MODEL->getFieldInfo()}
    {assign var=ALL_VALUES value=$FIELD_INFO['picklistvalues']}
	{if isset($SEARCH_INFO['searchValue'])}
		{assign var=SEARCH_VALUES value=explode(',',$SEARCH_INFO['searchValue'])}
	{else}
		{assign var=SEARCH_VALUES value=[]}
	{/if}
    <div class="picklistSearchField">
        <select id="{$FIELD_MODEL->get('name')}" class="select2noactive listSearchContributor tree form-control" title="{\App\Language::translate($FIELD_MODEL->get('label'), $MODULE)}" multiple name="{$FIELD_MODEL->get('name')}"  data-fieldinfo='{\App\Json::encode($FIELD_INFO)|escape}'>
        {foreach item=LABEL key=KEY from=$ALL_VALUES}
                <option value="{$KEY}"  data-parent="{$LABEL}" {if in_array($KEY,$SEARCH_VALUES) && ($KEY neq "") } selected{/if}>{$LABEL}</option>
        {/foreach}
    </select>
    </div>
{/strip}
