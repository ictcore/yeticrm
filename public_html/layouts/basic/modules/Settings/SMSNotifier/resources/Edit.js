/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */
Vtiger_Edit_Js('Settings_SMSNotifier_Edit_Js', {}, {
	getForm: function () {
		if (this.formElement == false) {
			this.setForm(jQuery('#modalEdit'));
		}
		return this.formElement;
	},
	registerProviderTypeChangeEvent : function(form) {
		var contents = this.getForm();
		contents.find('[name="providertype"]').on('change',function(e) {
			var currentTarget = jQuery(e.currentTarget);
			var selectedProviderName = currentTarget.val(); 
			contents.find('form [data-provider]').remove();
			var providerFields = contents.find('.providersFields [data-provider="'+selectedProviderName+'"]').clone(true, true);
			contents.find('.fieldsContainer').append(providerFields);
			app.showSelect2ElementView(providerFields.find('select').removeClass('chzn-select'));
		})
	},
	registerEvents: function () {
		var thisInstance = this;
		var container = this.getForm();
		app.destroyChosenElement(container);
		container.find('select').removeClass('chzn-select');
		app.showSelect2ElementView(container.find('form select'));
		this.registerBasicEvents(container);
		var form = container.find('form');
		form.on('submit', function (e) {
			e.preventDefault();
			if (form.validationEngine('validate')) {
				var formData = form.serializeFormData();
				app.saveAjax('', [], formData).then(function (data) {
					if (data.result) {
						Settings_Vtiger_Index_Js.showMessage({text: app.vtranslate('JS_SAVE_SUCCESS')});
						var listInstance = Settings_Vtiger_List_Js.getInstance();
						listInstance.getListViewRecords();
					} else {
						Vtiger_Helper_Js.showPnotify(app.vtranslate('JS_ERROR'));
					}
					app.hideModalWindow();
				});
			}
		});
		thisInstance.registerProviderTypeChangeEvent();
	}
})
jQuery(document).ready(function (e) {
	var instance = new Settings_SMSNotifier_Edit_Js();
	instance.registerEvents();
})
