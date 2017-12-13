/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */
 
jQuery.Class('Settings_RealizationProcesses_Js', {
}, {
	/**
	 * Saves config to database
	 */
	saveConfig : function() {
		jQuery('.projectStatus').on('change',function() {
			var status = jQuery(this).val();
			var params = {};
			params.data = {
				module: 'RealizationProcesses',
				parent: 'Settings',
				action: 'SaveGeneral',
				status: status,
				moduleId: jQuery(this).data('moduleid'),
				mode: 'save'
			
			};
			params.async = false;
			params.dataType = 'json';
			AppConnector.request(params).done(
				function(data) {
				var response = data['result'];
				if ( response['success']) {
					var params = {
						text: app.vtranslate(response.message),
						animation: 'show',
						type: 'success'
					};
					Vtiger_Helper_Js.showPnotify(params);
				}
				else {
					var params = {
						text: app.vtranslate(response.message),
						animation: 'show',
						type: 'error'
					};
					Vtiger_Helper_Js.showPnotify(params);
				}
				}
			);
		});
	},


});

jQuery(document).ready(function() {
	var instance = new Settings_RealizationProcesses_Js();
	instance.saveConfig();
})
