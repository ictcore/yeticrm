/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 *************************************************************************************/

var Vtiger_Index_Js = {
	showLocation: function (text) {
		app.showModalWindow(null, 'index.php?module=OpenStreetMap&view=MapModal', function (container) {
			var mapView = new OpenStreetMap_Map_Js();
			mapView.registerModalView(container);
			container.find('.searchValue').val(text);
			container.find('.searchBtn').trigger('click');
		});
	},
	massAddDocuments: function (url) {
		app.showModalWindow(null, url, function (container) {
			var uploadButton = container.find('#filesToUpload');
			var template = container.find('.fileContainer');
			var uploadContainer = container.find('.uploadFileContainer');
			var form = container.find('form');
			uploadButton.change(function () {
				uploadContainer.find('.fileItem').remove();
				var files = uploadButton[0].files;
				for (var i = 0; i < files.length; i++) {
					uploadContainer.append(template.html());
					uploadContainer.find('[name="nameFile[]"]:last').val(files[i].name);
				}
			});
			form.submit(function (e) {
				e.preventDefault();
				var formData = new FormData(form[0]);
				if (formData) {
					url = 'index.php';
					if (app.getViewName() === 'Detail') {
						formData.append('createmode', 'link');
						formData.append('return_module', app.getModuleName());
						formData.append('return_id', app.getRecordId());
					}
					var params = {
						url: url,
						type: "POST",
						data: formData,
						processData: false,
						contentType: false
					};
					var progressIndicatorElement = jQuery.progressIndicator({
						blockInfo: {'enabled': true}
					});
					AppConnector.request(params).then(function (data) {
						progressIndicatorElement.progressIndicator({'mode': 'hide'});
						app.hideModalWindow();
						if (app.getViewName() === 'Detail') {
							var detailView = Vtiger_Detail_Js.getInstance();
							if (detailView.getSelectedTab().data('reference') === 'Documents') {
								detailView.reloadTabContent();
							} else {
								var updatesWidget = detailView.getContentHolder().find("[data-type='RelatedModule'][data-name='Documents']");
								if (updatesWidget.length > 0) {
									var params = detailView.getFiltersData(updatesWidget);
									detailView.loadWidget(updatesWidget, params['params']);
								}
							}
						} else {
							Vtiger_List_Js.getInstance().getListViewRecords();
						}
					});
				}
			});
		});
	},
	getEmailFromRecord: function (record, module, maxEmails) {
		var aDeferred = jQuery.Deferred();
		AppConnector.request({
			dataType: 'html',
			data: {
				module: 'OSSMail',
				action: 'GetMail',
				sourceModule: module,
				sourceRecord: record,
				maxEmails: maxEmails,
			}
		}).then(function (data) {
			if (data.substring(0, 1) == '{') {
				data = $.parseJSON(data);
				data = data['result'];
				aDeferred.resolve(data);
			} else {
				app.showModalWindow(data, function (data) {
					data.find('.selectButton').click(function (e) {
						var email = data.find('input:checked').val();
						app.hideModalWindow(data);
						aDeferred.resolve(email);
					});
				});
			}
		}, function (error, err) {
			aDeferred.reject(error);
		})
		return aDeferred.promise();
	},
	registerMailButtons: function (container) {
		var thisInstance = this;
		container.find('.sendMailBtn:not(.mailBtnActive)').each(function (e) {
			var sendButton = jQuery(this);
			sendButton.addClass('mailBtnActive');
			sendButton.click(function (e) {
				e.stopPropagation();
				var url = sendButton.data("url");
				var module = sendButton.data("module");
				var record = sendButton.data("record");
				var popup = sendButton.data("popup");
				var toMail = sendButton.data("to");
				if (toMail) {
					url += '&to=' + toMail;
				}
				thisInstance.sendMailWindow(url, popup);
			});
		});
	},
	sendMailWindow: function (url, popup, postData) {
		if (popup) {
			var width = screen.width - 15;
			var height = screen.height - 150;
			var left = 0;
			var top = 30;
			var popupParams = 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top;
			if (postData == undefined) {
				window.open(url, '_blank', popupParams + ',resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,status=nomenubar=no');
				return;
			}
			var form = $("<form/>", {action: 'index.php'});
			var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
				form.append($("<input>", {name: key, value: value}));
			});
			for (var i in postData) {
				form.append($("<input>", {name: i, value: JSON.stringify(postData[i])}));
			}
			$('body').append(form);
			form.submit();
		} else {
			window.location.href = url;
		}
	},
	registerWidgetsEvents: function () {
		var widgets = jQuery('div.widgetContainer');
		widgets.on('shown.bs.collapse', function (e) {
			var widgetContainer = jQuery(e.currentTarget);
			Vtiger_Index_Js.loadWidgets(widgetContainer);
			var key = widgetContainer.attr('id');
			app.cacheSet(key, 1);
		});
		widgets.on('hidden.bs.collapse', function (e) {
			var widgetContainer = jQuery(e.currentTarget);
			var imageEle = widgetContainer.parent().find('.imageElement');
			var imagePath = imageEle.data('rightimage');
			imageEle.attr('src', imagePath);
			var key = widgetContainer.attr('id');
			app.cacheSet(key, 0);
		});
	},
	/**
	 * Function is used to load the sidebar widgets
	 * @param widgetContainer - widget container
	 * @param open - widget should be open or closed
	 */
	loadWidgets: function (widgetContainer, open) {
		var message = jQuery('.loadingWidgetMsg').html();
		if (widgetContainer.find('.panel-body').html().trim()) {
			var imageEle = widgetContainer.parent().find('.imageElement');
			var imagePath = imageEle.data('downimage');
			imageEle.attr('src', imagePath);
			widgetContainer.css('height', 'auto');
			return;
		}

		widgetContainer.progressIndicator({'message': message});
		var url = widgetContainer.data('url');
		var listViewWidgetParams = {
			"type": "GET", "url": "index.php",
			"dataType": "html", "data": url
		}
		AppConnector.request(listViewWidgetParams).then(
				function (data) {

					if (typeof open == 'undefined')
						open = true;
					if (open) {
						widgetContainer.progressIndicator({'mode': 'hide'});
						var imageEle = widgetContainer.parent().find('.imageElement');
						var imagePath = imageEle.data('downimage');
						imageEle.attr('src', imagePath);
						widgetContainer.css('height', 'auto');
					}
					widgetContainer.html(data);
					if (data == '') {
						widgetContainer.closest('.quickWidget').addClass('hide');
					} else {
						var label = widgetContainer.closest('.quickWidget').find('.quickWidgetHeader').data('label');
					}
					jQuery('.bodyContents').trigger('Vtiger.Widget.Load.' + label, jQuery(widgetContainer));
				}
		);
	},
	loadWidgetsOnLoad: function () {
		var widgets = jQuery('div.widgetContainer');
		widgets.each(function (index, element) {
			Vtiger_Index_Js.loadWidgets(jQuery(element));
		});
	},
	/**
	 * Function to change user theme(colour)
	 * @params : colour name
	 */
	changeSkin: function () {
		jQuery('.themeElement').on('click', function (e) {
			e.stopPropagation();
			var currentElement = jQuery(e.currentTarget);
			currentElement.closest('#themeContainer').hide();
			var progressElement = jQuery('#progressDiv');
			progressElement.progressIndicator();
			var params = {
				'module': 'Users',
				'action': 'SaveAjax',
				'record': jQuery('#current_user_id').val(),
				'field': 'theme',
				'value': currentElement.data('skinName')
			}
			AppConnector.request(params).then(function (data) {
				if (data.success && data.result) {
					progressElement.progressIndicator({'mode': 'hide'});
					jQuery('.settingIcons').removeClass('open');
					window.location.reload();
				}
			},
					function (error, err) {
					});
		})
	},
	markNotifications: function (id) {
		var aDeferred = jQuery.Deferred();
		var thisInstance = this;
		var params = {
			module: 'Notification',
			action: 'Notification',
			mode: 'setMark',
			ids: id
		}
		AppConnector.request(params).then(
				function (data) {
					var row = $('.notificationEntries .noticeRow[data-id="' + id + '"]');
					Vtiger_Helper_Js.showPnotify({
						title: app.vtranslate('JS_MESSAGE'),
						text: app.vtranslate('JS_MARKED_AS_READ'),
						type: 'info'
					});
					if (row.length) {
						row.fadeOut(300, function () {
							var entries = row.closest('.notificationEntries')
							row.remove();
							entries.each(function (index) {
								var block = $(this);
								if (block.find(".noticeRow").length == 0) {
									block.closest('.panel').hide();
								}
							});
						});
						thisInstance.getNotificationsForReminder();
					}
					aDeferred.resolve(data);
				},
				function (textStatus, errorThrown) {
					app.errorLog(textStatus, errorThrown);
					aDeferred.reject(textStatus, errorThrown);
				});
		return aDeferred.promise();
	},
	markAllNotifications: function (element) {
		var ids = [];
		var li = $(element).closest('.notificationContainer');
		li.find('.notificationEntries .noticeRow').each(function (index) {
			ids.push($(this).data('id'));
		});
		if (ids.length == 0) {
			element.remove();
			return false;
		}
		var params = {
			module: 'Notification',
			action: 'Notification',
			mode: 'setMark',
			ids: ids
		}
		li.progressIndicator({'position': 'html'});
		AppConnector.request(params).then(function (data) {
			li.progressIndicator({'mode': 'hide'});
			Vtiger_Helper_Js.showPnotify({
				title: app.vtranslate('JS_MESSAGE'),
				text: app.vtranslate('JS_MARKED_AS_READ'),
				type: 'info'
			});
			Vtiger_Index_Js.getNotificationsForReminder();
		});
	},
	/**
	 * Function registers event for Reminder popups
	 */
	registerReminders: function () {
		var activityReminder = (parseInt(app.getMainParams('activityReminder')) || 0) * 1000;
		if (activityReminder != 0 && jQuery('.remindersNotice.autoRefreshing').length) {
			Vtiger_Index_Js.requestReminder();
			window.reminder = setInterval(function () {
				Vtiger_Index_Js.requestReminder();
			}, activityReminder);
		}
		var reminder = (parseInt(app.getMainParams('intervalForNotificationNumberCheck')) || 0) * 1000;
		if (reminder != 0 && jQuery('.notificationsNotice.autoRefreshing').length) {
			Vtiger_Index_Js.getNotificationsForReminder();
			window.reminderNotifications = setInterval(function () {
				Vtiger_Index_Js.getNotificationsForReminder();
			}, reminder);
		}
	},
	getNotificationsForReminder: function () {
		var thisInstance = this;
		var content = $('.remindersNotificationContainer');
		var element = $(".notificationsNotice");
		var url = 'index.php?module=Notification&view=Reminders';
		AppConnector.request(url).then(function (data) {
			content.html(data);
			app.registerMoreContent(content.find('button.moreBtn'));
			thisInstance.refreshReminderCount(content, element, 'countNotificationsReminder');
			content.find('.setAsMarked').on('click', function (e) {
				var currentElement = jQuery(e.currentTarget);
				var recordID = currentElement.closest('.panel').data('record');
				thisInstance.markNotifications(recordID).then(function (data) {
					currentElement.closest('.panel').fadeOut(300, function () {
						$(this).remove();
						thisInstance.refreshReminderCount(content, element, 'countNotificationsReminder');
					});
				});
			});
		}, function (data, err) {
			clearInterval(window.reminderNotifications);
		});
	},
	/**
	 * Function request for reminder popups
	 */
	requestReminder: function () {
		var thisInstance = this;
		var content = $('.remindersNoticeContainer');
		var element = $('.remindersNotice');
		var url = 'index.php?module=Calendar&view=Reminders&type_remainder=true';
		AppConnector.request(url).then(function (data) {
			content.html(data);
			thisInstance.refreshReminderCount(content, element, 'countRemindersNotice');
			app.registerModal(content);
			content.find('.reminderPostpone').on('click', function (e) {
				var currentElement = jQuery(e.currentTarget);
				var recordID = currentElement.closest('.panel').data('record');
				var url = 'index.php?module=Calendar&action=ActivityReminder&mode=postpone&record=' + recordID + '&time=' + currentElement.data('time');
				AppConnector.request(url).then(function (data) {
					currentElement.closest('.panel').fadeOut(300, function () {
						$(this).remove();
						thisInstance.refreshReminderCount(content, element, 'countRemindersNotice');
					});
				});
			});
		}, function (data, err) {
			clearInterval(window.reminder);
		});
	},
	refreshReminderCount: function (content, element, tag) {
		var badge = element.find('.badge');
		var count = content.find('.panel:visible').length;
		badge.text(count);
		badge.removeClass('hide');
		if (count > 0 && element.hasClass('autoRefreshing')) {
			element.effect("pulsate", 1500);
			if (app.cacheGet(tag) != count) {
				app.playSound('REMINDERS');
				app.cacheSet(tag, count);
			}
		} else {
			badge.addClass('hide');
		}
	},
	registerResizeEvent: function () {
		$(window).resize(function () {
			if (this.resizeTO)
				clearTimeout(this.resizeTO);
			this.resizeTO = setTimeout(function () {
				$(this).trigger('resizeEnd');
			}, 600);
		});
		$(window).bind('resizeEnd', function () {
			Vtiger_Index_Js.adjustTopMenuBarItems();
		});
	},
	registerChat: function () {
		var modal = $('.chatModal');
		if (modal.length === 0) {
			return;
		}
		modal.on('shown.bs.modal', function (e) {
			var modalBody = modal.find('.modal-body');
			var modalFooter = modal.find('.modal-footer');
			var modalHeader = modal.find('.modal-header');
			var height = app.getScreenHeight() - modalFooter.outerHeight(true) - modalHeader.outerHeight(true);
			modalBody.css('max-height', height + 'px');
			modalBody.css('overflow', 'auto');
			modalBody.perfectScrollbar();
		});
		$('.headerLinkChat').on('click', function (e) {
			e.stopPropagation();
			var remindersNoticeContainer = $('.remindersNoticeContainer,.remindersNotificationContainer');
			if (remindersNoticeContainer.hasClass('toggled')) {
				remindersNoticeContainer.removeClass('toggled');
			}
			$('.chatModal').modal({backdrop: false});
		});
		this.registerChatLoadItems(modal.data('timer'));
		modal.find('.addMsg').on('click', function (e) {
			var message = modal.find('.message').val();
			clearTimeout(Vtiger_Index_Js.chatTimer);
			AppConnector.request({
				dataType: 'html',
				data: {
					module: 'Chat',
					action: 'Entries',
					mode: 'add',
					message: message,
					cid: $('.chatModal .chatItem').last().data('cid')
				}
			}).then(function (html) {
				$('.chatModal .modal-body').append(html);
				Vtiger_Index_Js.registerChatLoadItems(modal.data('timer'));
			});
			modal.find('.message').val('');
		});
	},
	registerChatLoadItems: function (timer) {
		var icon = $('.chatModal .modal-title .glyphicon-comment');
		this.chatTimer = setTimeout(function () {
			icon.css('color', '#00e413');
			Vtiger_Index_Js.getChatItems();
			Vtiger_Index_Js.registerChatLoadItems(timer);
			icon.css('color', '#000');
		}, timer);
	},
	getChatItems: function () {
		AppConnector.request({
			module: 'Chat',
			view: 'Entries',
			mode: 'get',
			cid: $('.chatModal .chatItem').last().data('cid')
		}).then(function (html) {
			if (html) {
				$('.chatModal .modal-body').append(html);
			}
		}, function (error, err) {
			clearTimeout(Vtiger_Index_Js.chatTimer);
		});
	},
	/**
	 * Function to make top-bar menu responsive.
	 */
	adjustTopMenuBarItems: function () {
		// Dedicated space for all dropdown text
		var TOLERANT_MAX_GAP = 125; // px
		var menuBarWrapper = ($(window).outerWidth() < 1161) ? jQuery('#mediumNav') : jQuery('#largeNav');
		var topMenuBarWidth = menuBarWrapper.parent().outerWidth();
		var optionalBarItems = jQuery('.opttabs', menuBarWrapper), optionalBarItemsCount = optionalBarItems.length;
		var optionalBarItemIndex = optionalBarItemsCount;
		function enableOptionalTopMenuItem() {
			var opttab = (optionalBarItemIndex > 0) ? optionalBarItems[optionalBarItemIndex - 1] : null;
			if (opttab) {
				opttab = jQuery(opttab);
				opttab.hide();
				optionalBarItemIndex--;
			}
			return opttab;
		}
		// Loop and enable hidden menu item until the tolerant width is reached.
		var stopLoop = false;
		do {
			if ((topMenuBarWidth - menuBarWrapper.outerWidth()) < TOLERANT_MAX_GAP) {
				var lastOptTab = enableOptionalTopMenuItem();
				if (lastOptTab == null || (topMenuBarWidth - menuBarWrapper.outerWidth()) > TOLERANT_MAX_GAP) {
					if (lastOptTab)
						lastOptTab.hide();
					stopLoop = true;
					break;
				}
			} else {
				stopLoop = true;
				break;
			}
		} while (!stopLoop);
		// Required to get the functionality of All drop-down working.
		$(window).on("load", function (e) {
			$("#topMenus").css({'overflow': 'visible'});
		});
	},
	/**
	 * Function to trigger tooltip feature.
	 */
	registerTooltipEvents: function () {
		var references = jQuery.merge(jQuery('[data-field-type="reference"] > a'), jQuery('[data-field-type="multireference"] > a'));
		var lastPopovers = [];
		// Fetching reference fields often is not a good idea on a given page.
		// The caching is done based on the URL so we can reuse.
		var CACHE_ENABLED = true;

		function prepareAndShowTooltipView() {
			hideAllTooltipViews();
			var el = jQuery(this);
			var url = el.attr('href') ? el.attr('href') : '';
			if (url == '') {
				return;
			}

			// Rewrite URL to retrieve Tooltip view.
			url = url.replace('view=', 'xview=') + '&view=TooltipAjax';
			var cachedView = CACHE_ENABLED ? jQuery('[data-url-cached="' + url + '"]') : null;
			if (cachedView && cachedView.length) {
				showTooltip(el, cachedView.html());
			} else {
				AppConnector.request(url).then(function (data) {
					cachedView = jQuery('<div>').css({display: 'none'}).attr('data-url-cached', url);
					cachedView.html(data);
					jQuery('body').append(cachedView);
					showTooltip(el, data);
				});
			}
		}

		function get_popover_placement(el) {
			var width = window.innerWidth;
			var left_pos = jQuery(el).offset().left;
			if (width - left_pos < 400 || checkLastElement(el))
				return 'left';
			return 'right';
		}

		//The function checks if the selected element is the last element of the table in list view.
		function checkLastElement(el) {
			var parent = el.closest('tr');
			var lastElementTd = parent.find('td.listViewEntryValue:last a');
			if (el.attr('href') == lastElementTd.attr('href')) {
				return true;
			}
			return false;
		}

		function showTooltip(el, data) {
			var the_placement = get_popover_placement(el);
			el.popover({
				//title: '', - Is derived from the Anchor Element (el).
				trigger: 'manual',
				content: data,
				animation: false,
				html: true,
				placement: the_placement,
				template: '<div class="popover popover-tooltip"><div class="arrow"></div><div class="popover-inner"><button name="vtTooltipClose" class="close" style="color:white;opacity:1;font-weight:lighter;position:relative;top:3px;right:3px;">x</button><h3 class="popover-title"></h3><div class="popover-content"><div></div></div></div></div>'
			});
			lastPopovers.push(el.popover('show'));
			registerToolTipDestroy();
		}

		function hideAllTooltipViews() {
			// Hide all previous popover
			var lastPopover = null;
			while (lastPopover = lastPopovers.pop()) {
				lastPopover.popover('hide');
			}
		}

		references.each(function (index, el) {
			jQuery(el).hoverIntent({
				interval: 100,
				sensitivity: 7,
				timeout: 10,
				over: prepareAndShowTooltipView,
				out: hideAllTooltipViews
			});
		});
		function registerToolTipDestroy() {
			jQuery('button[name="vtTooltipClose"]').on('click', function (e) {
				var lastPopover = lastPopovers.pop();
				lastPopover.popover('hide');
				jQuery('.popover').css("display", "none", "important");
			});
		}
	},
	changeWatching: function (instance) {
		var value, module, state, className, user, record;
		if (instance != undefined) {
			instance = $(instance);
			value = instance.data('value');
			if (instance.data('module') != undefined) {
				module = instance.data('module');
			} else {
				module = app.getModuleName();
			}
			if (instance.data('user') != undefined) {
				user = instance.data('user');
			}
			if (instance.data('record') != undefined) {
				record = instance.data('record');
			}
		}
		bootbox.dialog({
			message: app.vtranslate('JS_WATCHING_MESSAGE' + value),
			title: app.vtranslate('JS_WATCHING_TITLE'),
			buttons: {
				success: {
					label: app.vtranslate('LBL_YES'),
					className: "btn-success",
					callback: function () {
						Vtiger_Index_Js.updateWatching(module, value, user, record).then(function (data) {
							if (instance != undefined) {
								state = data.result == 1 ? 0 : 1;
								instance.data('value', state);
								if (state == 1) {
									instance.toggleClass(instance.data('off') + ' ' + instance.data('on'));
									instance.children().toggleClass(instance.data('iconOff') + ' ' + instance.data('iconOn'));
								} else {
									instance.toggleClass(instance.data('on') + ' ' + instance.data('off'));
									instance.children().toggleClass(instance.data('iconOn') + ' ' + instance.data('iconOff'));
								}
							}
						});
					}
				},
				danger: {
					label: app.vtranslate('LBL_NO'),
					className: "btn-warning",
					callback: function () {
					}
				}
			}
		});
	},
	updateWatching: function (module, value, user, record) {
		var aDeferred = jQuery.Deferred();
		var params = {
			module: module,
			action: 'Watchdog',
			state: value
		};
		if (user != undefined) {
			params['user'] = user;
		}
		if (record != undefined && record != 0) {
			params['record'] = record;
		}
		AppConnector.request(params).then(function (data) {
			aDeferred.resolve(data);
		}, function (textStatus, errorThrown) {
			aDeferred.reject(textStatus, errorThrown);
			app.errorLog(textStatus, errorThrown);
		});
		return aDeferred.promise();
	},
	assignToOwner: function (element, userId) {
		var aDeferred = jQuery.Deferred();
		element = jQuery(element);
		if (userId == undefined) {
			userId = app.getMainParams('current_user_id');
		}
		var params = {
			module: element.data('module'),
			record: element.data('record'),
			field: 'assigned_user_id',
			value: userId
		};
		app.saveAjax('', null, params).then(function (e) {
			app.hideModalWindow();
			if (app.getViewName() === 'List') {
				var listinstance = new Vtiger_List_Js();
				listinstance.getListViewRecords();
			}
		})
	},
	sendNotification: function () {
		Vtiger_Header_Js.getInstance().quickCreateModule('Notification');
	},
	loadPreSaveRecord: function (form) {
		SaveResult = new SaveResult()
		return SaveResult.checkData(form);
	},
	performPhoneCall: function (phoneNumber, record) {
		AppConnector.request({
			module: app.getModuleName(),
			view: 'BasicAjax',
			mode: 'performPhoneCall',
			phoneNumber: phoneNumber,
			record: record
		}).then(function (response) {
			response = jQuery.parseJSON(response);
			Vtiger_Helper_Js.showMessage({text: response.result});
		});
	},
	registerEvents: function () {
		Vtiger_Index_Js.registerWidgetsEvents();
		Vtiger_Index_Js.loadWidgetsOnLoad();
		Vtiger_Index_Js.registerReminders();
		Vtiger_Index_Js.adjustTopMenuBarItems();
		Vtiger_Index_Js.registerPostAjaxEvents();
		Vtiger_Index_Js.changeSkin();
		Vtiger_Index_Js.registerResizeEvent();
		Vtiger_Index_Js.registerChat();
	},
	registerPostAjaxEvents: function () {
		Vtiger_Index_Js.registerTooltipEvents();
	}
}
//On Page Load
jQuery(document).ready(function () {
	Vtiger_Index_Js.registerEvents();
	app.listenPostAjaxReady(function () {
		Vtiger_Index_Js.registerPostAjaxEvents();
	});
});
