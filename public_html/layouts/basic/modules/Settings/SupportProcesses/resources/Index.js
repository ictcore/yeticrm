/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */
 
jQuery.Class('Settings_SupportProcesses_Index_Js', {
}, {
		registerChangeVal: function (content) {
		var thisInstance = this;
		content.find('.configField').change(function (e) {
			var target = $(e.currentTarget);
			var params = {};
			params['type'] = target.data('type');
			params['param'] = target.attr('name');
			if (target.attr('type') == 'checkbox') {
				params['val'] = this.checked;
			} else {
				params['val'] = target.val() != null ? target.val() : '';
			}
			app.saveAjax('updateConfig', params).then(function (data) {
				Settings_Vtiger_Index_Js.showMessage({type: 'success', text: data.result.message});
			});
		});
	},
	registerEvents: function() {
		var content = $('.supportProcessesContainer');
		this.registerChangeVal(content);
	}


});
