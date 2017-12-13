/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */

jQuery.Class('Settings_PublicHoliday_Js', {
}, {

	/**
	 * Function that deletes holiday from list
	 */
	registerDeleteHoliday: function (element) {
		var thisInstance = this;
		element.find('.deleteHoliday').each(function () {
			jQuery(this).on('click', function () {
				thisInstance.deleteHoliday(jQuery(this).data('holiday-id'));
			});
		});
	},

	/**
	 * Delete chosen holiday date
	 */
	deleteHoliday: function (holidayId) {
		var thisInstance = this;
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});

		var params = {};
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'Holiday';
		params['mode'] = 'delete';
		params['id'] = holidayId;

		AppConnector.request(params).then(
				function (data) {
					var params = {};
					params['module'] = app.getModuleName();
					params['view'] = 'Configuration';
					params['parent'] = app.getParentModuleName();
					params['async'] = false;
					AppConnector.request(params).done(function (data) {
						jQuery('.contentsDiv').html(data);
						thisInstance.registerEvents();
						progressIndicatorElement.progressIndicator({'mode': 'hide'});
					});

					params = {};
					params['text'] = data.result.message;
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
				}
		);
	},
	/**
	 * Function to register click event for add custom block button
	 */
	registerAddDate: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutDashBoards');
		contents.find('.addDateWindow').click(function (e) {
			var addBlockContainer = contents.find('.addDateWindowModal').clone(true, true);
			var translate = app.vtranslate('JS_ADD_NEW_HOLIDAY')
			addBlockContainer.find('.modal-title').text(translate);
			var callBackFunction = function (data) {
				data.find('.addDateWindowModal').removeClass('hide').show();

				var form = data.find('.addDateWindowForm');
				jQuery('[name="holidayId"]').val('');
				jQuery('[name="saveButton"]').on('click', function () {
					var progressIndicatorElement = jQuery.progressIndicator({
						'position': 'html',
						'blockInfo': {
							'enabled': true
						}
					});

					thisInstance.saveNewDate(form).then(
							function (data) {
								var params = {};
								if (data['success']) {
									var result = data['result'];

									params['text'] = result['message'];
									Settings_Vtiger_Index_Js.showMessage(params);
									var params = {};
									params['module'] = app.getModuleName();
									params['view'] = 'Configuration';
									params['parent'] = app.getParentModuleName();
									AppConnector.request(params).then(function (data) {
										jQuery('.contentsDiv').html(data);
										thisInstance.registerEvents();
										progressIndicatorElement.progressIndicator({'mode': 'hide'});
									});
								} else {
									progressIndicatorElement.progressIndicator({'mode': 'hide'});
									params['text'] = data['result']['message'];
									params['type'] = 'error';
									Settings_Vtiger_Index_Js.showMessage(params);
								}
							}
					);
					app.hideModalWindow();
					return true;
				});

				jQuery(document).find('div.blockOverlay').on('click', function () {
					var progressIndicatorElement = jQuery.progressIndicator({
						'position': 'html',
						'blockInfo': {
							'enabled': true
						}
					});
					var params = {};
					params['module'] = app.getModuleName();
					params['view'] = 'Configuration';
					params['parent'] = app.getParentModuleName();
					AppConnector.request(params).then(function (data) {
						jQuery('.contentsDiv').html(data);
						thisInstance.registerEvents();
						progressIndicatorElement.progressIndicator({'mode': 'hide'});
					});
				});

				jQuery('.cancelLink').on('click', function () {
					var progressIndicatorElement = jQuery.progressIndicator({
						'position': 'html',
						'blockInfo': {
							'enabled': true
						}
					});
					var params = {};
					params['module'] = app.getModuleName();
					params['view'] = 'Configuration';
					params['parent'] = app.getParentModuleName();
					AppConnector.request(params).then(function (data) {
						jQuery('.contentsDiv').html(data);
						thisInstance.registerEvents();
						progressIndicatorElement.progressIndicator({'mode': 'hide'});
					});
				});

				form.submit(function (e) {
					e.preventDefault();
				})
			}
			app.showModalWindow(addBlockContainer, function (data) {
				if (typeof callBackFunction == 'function') {
					callBackFunction(data);
				}
			}, {'width': '1000px'});
		});
	},

	/**
	 * Function to register click event for add custom block button
	 */
	registerEditDate: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutDashBoards');
		contents.find('.editHoliday').click(function (e) {
			var addBlockContainer = contents.find('.addDateWindowModal').clone(true, true);
			var dateElement = jQuery(this).closest('.holidayElement');
			addBlockContainer.find('[name="holidayId"]').val(dateElement.data('holiday-id'));
			addBlockContainer.find('[name="holidayDate"]').val(dateElement.data('holiday-date'));
			addBlockContainer.find('[name="holidayName"]').val(dateElement.data('holiday-name'));
			addBlockContainer.find('[name="holidayType"]').val(dateElement.data('holiday-type'));
			var translate = app.vtranslate('JS_EDIT_HOLIDAY')
			addBlockContainer.find('.modal-title').text(translate);

			var callBackFunction = function (data) {
				data.find('.addDateWindowModal').removeClass('hide').show();

				var form = data.find('.addDateWindowForm');

				jQuery('[name="saveButton"]').on('click', function () {
					var progressIndicatorElement = jQuery.progressIndicator({
						'position': 'html',
						'blockInfo': {
							'enabled': true
						}
					});
					thisInstance.saveNewDate(form).then(
							function (data) {
								var params = {};
								if (data['success']) {
									var result = data['result'];

									params['text'] = result['message'];
									Settings_Vtiger_Index_Js.showMessage(params);
									var params = {};
									params['module'] = app.getModuleName();
									params['view'] = 'Configuration';
									params['parent'] = app.getParentModuleName();
									AppConnector.request(params).then(function (data) {
										jQuery('.contentsDiv').html(data);
										thisInstance.registerEvents();
										progressIndicatorElement.progressIndicator({'mode': 'hide'});
									});
								} else {
									progressIndicatorElement.progressIndicator({'mode': 'hide'});
									params['text'] = data['result']['message'];
									params['type'] = 'error';
									Settings_Vtiger_Index_Js.showMessage(params);
								}
							}
					);
					app.hideModalWindow();
					return true;
				});


				jQuery(document).find('div.blockOverlay').on('click', function () {
					var progressIndicatorElement = jQuery.progressIndicator({
						'position': 'html',
						'blockInfo': {
							'enabled': true
						}
					});
					var params = {};
					params['module'] = app.getModuleName();
					params['view'] = 'Configuration';
					params['parent'] = app.getParentModuleName();
					AppConnector.request(params).then(function (data) {
						jQuery('.contentsDiv').html(data);
						thisInstance.registerEvents();
						progressIndicatorElement.progressIndicator({'mode': 'hide'});
					});
				});

				jQuery('.cancelLink').on('click', function () {
					var progressIndicatorElement = jQuery.progressIndicator({
						'position': 'html',
						'blockInfo': {
							'enabled': true
						}
					});
					var params = {};
					params['module'] = app.getModuleName();
					params['view'] = 'Configuration';
					params['parent'] = app.getParentModuleName();
					AppConnector.request(params).then(function (data) {
						jQuery('.contentsDiv').html(data);
						thisInstance.registerEvents();
						progressIndicatorElement.progressIndicator({'mode': 'hide'});
					});
				});

				form.submit(function (e) {
					e.preventDefault();
				});
			}
			app.showModalWindow(addBlockContainer, function (data) {
				if (typeof callBackFunction == 'function') {
					callBackFunction(data);
				}
			}, {'width': '1000px'});
		});
	},

	/**
	 * Function to save the new custom block details
	 */
	saveNewDate: function (form) {
		var thisInstance = this;
		var params = form.serializeFormData();
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'Holiday';
		params['mode'] = 'save';

		if (params['holidayName'] == '' || params['holidayDate'] == '') {
			var params = [];
			params['text'] = app.vtranslate('JS_FILL_FORM_ERROR');
			params['type'] = 'error';
			Settings_Vtiger_Index_Js.showMessage(params);
			var progressIndicatorElement = jQuery.progressIndicator({
				'position': 'html',
				'blockInfo': {
					'enabled': true
				}
			});
			var params = {};
			params['module'] = app.getModuleName();
			params['view'] = 'Configuration';
			params['parent'] = app.getParentModuleName();
			AppConnector.request(params).then(function (data) {
				jQuery('.contentsDiv').html(data);
				thisInstance.registerEvents();
				progressIndicatorElement.progressIndicator({'mode': 'hide'});
			});
		} else {
			var aDeferred = jQuery.Deferred();
			AppConnector.request(params).then(
					function (data) {
						aDeferred.resolve(data);
					},
					function (error) {
						aDeferred.reject(error);
					}
			);
			return aDeferred.promise();
		}

		return true;
	},

	registerChangeDate: function () {
		var thisInstance = this;
		var dateFilter = jQuery('.dateFilter');
		app.registerDateRangePickerFields(dateFilter, {ranges: false});
		dateFilter.on('apply.daterangepicker', function (ev, picker) {
			var format = jQuery(ev.currentTarget).data('dateFormat').toUpperCase();
			$(this).val(picker.startDate.format(format) + ',' + picker.endDate.format(format));
			var progressIndicatorElement = jQuery.progressIndicator({
				position: 'html',
				blockInfo: {
					enabled: true
				}
			});
			AppConnector.request({
				module:app.getModuleName(),
				view:'Configuration',
				parent: app.getParentModuleName(),
				date: '["'+picker.startDate.format(format) + '","' + picker.endDate.format(format)+'"]'
			}).then(function (data) {
				jQuery('.contentsDiv').html(data);
				thisInstance.registerEvents();
				progressIndicatorElement.progressIndicator({mode: 'hide'});
			});
		});
	},

	/**
	 * register events for layout editor
	 */
	registerEvents: function () {
		var thisInstance = this;
		var container = jQuery('#moduleBlocks');

		thisInstance.registerDeleteHoliday(container);
		thisInstance.registerAddDate();
		thisInstance.registerEditDate();
		thisInstance.registerChangeDate();
	}
});

jQuery(document).ready(function () {
	var instance = new Settings_PublicHoliday_Js();
	instance.registerEvents();
})
