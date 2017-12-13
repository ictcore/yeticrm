/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */
jQuery.Class("Settings_TimeControlProcesses_Index_Js", {}, {
	registerChangeVal: function (content) {
		var thisInstance = this;
		content.find('input[type="checkbox"]').on('change', function (e) {
			var target = $(e.currentTarget);
			var tab = target.closest('.editViewContainer');
			var value = target.is(':checked');
			var params = {};
			params['value'] = value;
			params['type'] = tab.data('type');
			params['param'] = target.attr('name');
			app.saveAjax('', params).then(function (data) {
				Settings_Vtiger_Index_Js.showMessage({type: 'success', text: data.result.message});
				if (value) {
					target.parent().removeClass('btn-default').addClass('btn-success').find('.glyphicon').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
				} else {
					target.parent().removeClass('btn-success').addClass('btn-default').find('.glyphicon').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
				}
			});
		});
	},
	registerEvents: function () {
		var content = jQuery('.processesContainer');
		this.registerChangeVal(content);
	}
});
