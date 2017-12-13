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

<button type="submit" name="import" id="importButton" class="crmButton big edit btn btn-success"
		><strong>{\App\Language::translate('LBL_IMPORT_BUTTON_LABEL', $MODULE)}</strong></button>
<button type="button" name="cancel" value="{\App\Language::translate('LBL_CANCEL', $MODULE)}" class="cursorPointer cancelLink btn btn-warning" onclick="window.history.back()">
	{\App\Language::translate('LBL_CANCEL', $MODULE)}
</button>
