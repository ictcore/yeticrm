/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Settings_Vtiger_List_Js("Settings_IctBroadcast_List_Js",{
	
	/**
	 * Function to trigger IctBroadcast new configuration for IctBroadcast server
	 */
	triggerBroadcast : function(massActionUrl, module){
		alert("hello");

	},
	/**
	 * Function to trigger delete SMS provider Configuration
	 */
	registerMassActionSubmitEvent : function(){
        var thisInstance = this;
		jQuery('body').on('submit','#massSave1',function(e){

			var form = jQuery(e.currentTarget);
			var commentContent = form.find('#commentcontent')
			var commentContentValue = commentContent.val();

			if(commentContentValue == "") {
				var errorMsg = app.vtranslate('JS_LBL_COMMENT_VALUE_CANT_BE_EMPTY')
				commentContent.validationEngine('showPrompt', errorMsg , 'error','bottomLeft',true);
				e.preventDefault();
				return;
			}
			commentContent.validationEngine('hide');
			//alert(JSON.stringify(thisInstance.massActionSave(form)));
			thisInstance.massActionSave(form).then(function(data){
			//	alert(data['group_id']);
				//alert(data['campaign_type']);
				//alert('hello');
			//	url = "http://www.mydomain.com/new-page.html";
               //$( location ).attr("href", url);

               
				var g_id = JSON.stringify(data.result.group_id);
				var c_name = JSON.stringify(data.result.campaign_type);

				 var  element= c_name.replace (/"/g,'');
				//alert(JSON.stringify(data.result.group_id));
					//alert(g_id);
					//alert(c_name);
					 var win=window.open("http://202.142.186.26/campaign.php?action=add&type="+element+"&contact_group_id="+g_id, '_blank');
                      win.focus();
					 // window.location = 'new.php';//window.location.href = 'new.php';
					// window.location('http://stackoverflow.com', '_blank');
					Vtiger_List_Js.clearList();
			});
			e.preventDefault();
		});
	},
	
},{
	/**
	 * Function to show the SMS Provider configuration details for edit and add new
	 */
	/*EditRecord : function(url) {
		var thisInstance = this;
		AppConnector.request(url).then(
			function(data) {
				
				var callBackFunction = function(data) {
					var form = jQuery('#smsConfig');
					
					thisInstance.registerProviderTypeChangeEvent(form);
					
					var params = app.getvalidationEngineOptions(true);
					params.onValidationComplete = function(form, valid){
						if(valid) {
							thisInstance.saveConfiguration(form).then(
								function(data) {
									if(data['success']) {
										var params = {};
										params['text'] = app.vtranslate('JS_CONFIGURATION_SAVED');
										Settings_Vtiger_Index_Js.showMessage(params);
										thisInstance.getListViewRecords();
									}
								},
								function(error, err) {

								}
							);
						}
						//To prevent form submit
						return false;
					}
					form.validationEngine(params);
					
				}
				
				app.showModalWindow(data,function(data) {
					if(typeof callBackFunction == 'function') {
						callBackFunction(data);
					}
				});
			},
			function(error,err){
			}
		);
	},*/
	
	/**
	 * Function to register change event for SMS server Provider Type
	 */
	/*registerProviderTypeChangeEvent : function(form) {
		var thisInstance = this;
		var contents = form.find('.configContent');
		form.find('.providerType').change(function(e) {
			var currentTarget = jQuery(e.currentTarget);
			var selectedProvider = currentTarget.find('option:selected');
			var fieldDetails = selectedProvider.data('providerFields');
			jQuery.each(fieldDetails, function(index, field) {
				var newFieldEle = jQuery('<div class="control-group"><span class="control-label"><strong>'+field+'</strong></span><div class="controls">\n\
					<input type="text" name="'+field+'" class="span3" value="" /></div></div>');
				contents.append(newFieldEle);
			})
		})
	},*/
	
	/**
	 * Function to save the SMS Server Configuration Details from edit and Add new configuration 
	 */
	/*saveConfiguration : function(form) {
		var thisInstance = this;
		var aDeferred = jQuery.Deferred();
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
				'enabled' : true
			}
		});
		
		var params = form.serializeFormData();
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'SaveAjax';
		
		AppConnector.request(params).then(
			function(data) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				aDeferred.resolve(data);
			},
			function(error) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				aDeferred.reject(error);
			}
		);
		return aDeferred.promise();
	},*/
	
	/**
	 * Function to delete Configuration for SMS Provider
	 */
	/*DeleteRecord : function(url) {
		var thisInstance = this;
		var message = app.vtranslate('LBL_DELETE_CONFIRMATION');
		Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(
			function(e) {
				AppConnector.request(url).then(
					function() {
						var params = {
							text: app.vtranslate('JS_RECORD_DELETED_SUCCESSFULLY')
						};
						Settings_Vtiger_Index_Js.showMessage(params);
						thisInstance.getListViewRecords();
					},
					function(error,err){
					}
				);
			},
			function(error, err){
			}
		);
	},*/
	
	/**
	 * Function to register all the events
	 */
	registerEvents : function() {
		this.triggerDisplayTypeEvent();
		this.registerPageNavigationEvents();
	}
});