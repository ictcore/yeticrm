/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
Settings_Workflows_Edit_Js("Settings_Workflows_Edit1_Js", {}, {

	init: function () {
		this.initialize();
	},
	/**
	 * Function to get the container which holds all the reports step1 elements
	 * @return jQuery object
	 */
	getContainer: function () {
		return this.step1Container;
	},

	/**
	 * Function to set the reports step1 container
	 * @params : element - which represents the reports step1 container
	 * @return : current instance
	 */
	setContainer: function (element) {
		this.step1Container = element;
		return this;
	},

	/**
	 * Function  to intialize the reports step1
	 */
	initialize: function (container) {
		if (typeof container == 'undefined') {
			container = jQuery('#workflow_step1');
		}
		if (container.is('#workflow_step1')) {
			this.setContainer(container);
		} else {
			this.setContainer(jQuery('#workflow_step1'));
		}
	},

	submit: function () {
		var aDeferred = jQuery.Deferred();
		var form = this.getContainer();
		var formData = form.serializeFormData();
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});
		AppConnector.request(formData).then(
				function (data) {
					form.hide();
					progressIndicatorElement.progressIndicator({
						'mode': 'hide'
					})
					aDeferred.resolve(data);
				},
				function (error, err) {

				}
		);
		return aDeferred.promise();
	},

	/**
	 * Function to register event for scheduled workflows UI
	 */
	registerEventForScheduledWorkflow: function () {
		var thisInstance = this;
		jQuery('input[name="execution_condition"]').on('click', function (e) {
			var element = jQuery(e.currentTarget);
			var scheduleBoxContainer = jQuery('#scheduleBox');
			if (element.is(':checked') && element.val() == '6') {	//for scheduled workflows
				scheduleBoxContainer.removeClass('hide');
			} else {
				scheduleBoxContainer.addClass('hide');
			}
		});
		app.registerEventForClockPicker($('.clockPicker'));
		app.registerEventForDatePickerFields('#scheduleByDate', true);

		jQuery('#annualDates').chosen();
		jQuery('#schdayofweek').chosen();
		jQuery('#schdayofmonth').chosen();

		var currentYear = new Date().getFullYear();
		var weekStartId = jQuery('#weekStartDay').data('value');

		$('#annualDatePicker').datepicker({
			weekStart: weekStartId,
			startDate: '01/01/' + currentYear,
			endDate: '12/31/' + currentYear,
			format: "mm/dd/yyyy",
			maxViewMode: 1,
			todayBtn: "linked",
			language: jQuery('body').data('language'),
			multidate: true,
			todayHighlight: true
		}).on('changeDate', function (e) {
			var datesInfo = [];
			var values = [];
			var html = '';
			// reset the annual dates
			var annualDatesEle = jQuery('#annualDates');
			thisInstance.updateAnnualDates(annualDatesEle);
			for (var index in e.dates) {
				var date = e.dates[index];
				var formated = moment(date).format('YYYY-MM-DD')
				datesInfo.push({
					id: formated,
					text: formated
				});
				values.push(formated);
				html += '<option selected value=' + formated + '>' + formated + '</option>';
			}
			annualDatesEle.append(html);
			annualDatesEle.trigger("chosen:updated");
		});
		var annualDatesEle = jQuery('#annualDates');
		thisInstance.updateAnnualDates(annualDatesEle);
		annualDatesEle.trigger("chosen:updated");
	},
	updateAnnualDates: function (annualDatesEle) {
		annualDatesEle.html('');
		var annualDatesJSON = jQuery('#hiddenAnnualDates').val();
		if (annualDatesJSON) {
			var hiddenDates = '';
			var annualDates = JSON.parse(annualDatesJSON);
			for (var j in annualDates) {
				hiddenDates += '<option selected value=' + annualDates[j] + '>' + annualDates[j] + '</option>';
			}
			annualDatesEle.html(hiddenDates);
		}
	},
	registerEventForChangeInScheduledType: function () {
		var thisInstance = this;
		jQuery('#schtypeid').on('change', function (e) {
			var element = jQuery(e.currentTarget);
			var value = element.val();

			thisInstance.showScheduledTime();
			thisInstance.hideScheduledWeekList();
			thisInstance.hideScheduledMonthByDateList();
			thisInstance.hideScheduledSpecificDate();
			thisInstance.hideScheduledAnually();

			if (value == '1') {	//hourly
				thisInstance.hideScheduledTime();
			} else if (value == '3') {	//weekly
				thisInstance.showScheduledWeekList();
			} else if (value == '4') {	//specific date
				thisInstance.showScheduledSpecificDate();
			} else if (value == '5') {	//monthly by day
				thisInstance.showScheduledMonthByDateList();
			} else if (value == '7') {
				thisInstance.showScheduledAnually();
			}
		});
	},

	hideScheduledTime: function () {
		jQuery('#scheduledTime').addClass('hide');
	},

	showScheduledTime: function () {
		jQuery('#scheduledTime').removeClass('hide');
	},

	hideScheduledWeekList: function () {
		jQuery('#scheduledWeekDay').addClass('hide');
	},

	showScheduledWeekList: function () {
		jQuery('#scheduledWeekDay').removeClass('hide');
	},

	hideScheduledMonthByDateList: function () {
		jQuery('#scheduleMonthByDates').addClass('hide');
	},

	showScheduledMonthByDateList: function () {
		jQuery('#scheduleMonthByDates').removeClass('hide');
	},

	hideScheduledSpecificDate: function () {
		jQuery('#scheduleByDate').addClass('hide');
	},

	showScheduledSpecificDate: function () {
		jQuery('#scheduleByDate').removeClass('hide');
	},

	hideScheduledAnually: function () {
		jQuery('#scheduleAnually').addClass('hide');
	},

	showScheduledAnually: function () {
		jQuery('#scheduleAnually').removeClass('hide');
	},

	registerEvents: function () {
		var container = this.getContainer();

		//After loading 1st step only, we will enable the Next button
		container.find('[type="submit"]').removeAttr('disabled');

		var opts = app.validationEngineOptions;
		// to prevent the page reload after the validation has completed
		opts['onValidationComplete'] = function (form, valid) {
			//returns the valid status
			return valid;
		};
		opts['promptPosition'] = "bottomRight";
		container.validationEngine(opts);

		this.registerEventForScheduledWorkflow();
		this.registerEventForChangeInScheduledType();


	}
});
