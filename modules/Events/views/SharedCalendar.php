<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Events_SharedCalendar_View extends Calendar_SharedCalendar_View
{

	public function process(\App\Request $request)
	{
		header("Location: index.php?module=Calendar&view=SharedCalendar");
	}
}
