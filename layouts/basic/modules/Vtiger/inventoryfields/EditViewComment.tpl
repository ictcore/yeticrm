{*<!-- {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} -->*}
{strip}
	{assign var=VALUE value=$FIELD->getValue($ITEM_VALUE)}
	<textarea name="{$FIELD->getColumnName()}{$ROW_NO}" title="{\App\Language::translate("LBL_ROW_COMMENT",$MODULE)}" id="editView_comment{$FIELD->getColumnName()}{$ROW_NO}" data-fieldinfo="{\App\Json::encode(['mandatory' => false])|escape}"
			  class="comment commentTextarea form-control {if $INVENTORY_FIELD->isWysiwygType($REFERENCE_MODULE)}ckEditorSource ckEditorBasic{/if}" {if $FIELD->get('displaytype') == 10}readonly="readonly"{/if}>
		{$VALUE}
	</textarea>
{/strip}
