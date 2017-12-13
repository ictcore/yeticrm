/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */
jQuery.Class("Settings_HideBlocks_Conditions_Js",{},{
	advanceFilterInstance : false,
	registerSaveConditions : function(){
		var thisInstance = this;
		$( ".saveLink" ).click(function() {
			var form = $('.targetFieldsTableContainer form')
			var advfilterlist = thisInstance.advanceFilterInstance.getValues();
			$('.advanced_filter').val(JSON.stringify(advfilterlist));
			var formData = form.serializeFormData();
			form.submit();
		});
	},
	registerEvents : function(container) {
		this.advanceFilterInstance = Vtiger_AdvanceFilter_Js.getInstance(jQuery('.filterContainer'));
		this.registerSaveConditions();
	}
});