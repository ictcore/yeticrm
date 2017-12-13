/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */
jQuery.Class('Settings_Mail_Config_Js', {}, {
	registerChangeConfig: function () {
		var thisInstance = this;
		var container = jQuery('.configContainer');
		container.on('change', '.configCheckbox', function () {
			var name = jQuery(this).attr('name');
			var type = jQuery(this).data('type');
			var val = this.checked;
			var progressIndicator = jQuery.progressIndicator();
			var params = {};
			params['module'] = app.getModuleName();
			params['parent'] = app.getParentModuleName();
			params['action'] = 'SaveAjax';
			params['mode'] = 'updateConfig';
			params['type'] = type;
			params['name'] = name;
			params['val'] = val;

			AppConnector.request(params).then(
				function (data) {
					progressIndicator.progressIndicator({'mode': 'hide'});
					var params = {};
					params['text'] = data.result.message;
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicator.progressIndicator({'mode': 'hide'});
				}
			);
		});
	},
	registerSignature: function () {
		var customConfig = {
			height: '20em',
		};
		var container = jQuery('#signature');
		var ckEditorInstance = new Vtiger_CkEditor_Js();
		ckEditorInstance.loadCkEditor(container.find('.ckEditorSource'), customConfig);
		container.find('button').click(function () {
			var progressIndicator = jQuery.progressIndicator();
			var editor = CKEDITOR.instances.signatureCkEditor; 
			var params = {};
			params['module'] = app.getModuleName();
			params['parent'] = app.getParentModuleName();
			params['action'] = 'SaveAjax';
			params['mode'] = 'updateSignature';
			params['val'] = editor.getData();
			AppConnector.request(params).then(
				function (data) {
					progressIndicator.progressIndicator({'mode': 'hide'});
					var params = {};
					params['text'] = data.result.message;
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicator.progressIndicator({'mode': 'hide'});
				}
			);
		});
	},
	registerEvents: function () {
		var thisInstance = this;
		thisInstance.registerChangeConfig();
		thisInstance.registerSignature();
	},
});