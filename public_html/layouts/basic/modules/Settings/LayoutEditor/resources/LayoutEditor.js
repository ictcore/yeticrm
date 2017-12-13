/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 *************************************************************************************/
jQuery.Class('Settings_LayoutEditor_Js', {
}, {
	updatedBlockSequence: {},
	reactiveFieldsList: [],
	inActiveFieldsList: false,
	updatedBlockFieldsList: [],
	updatedBlocksList: [],
	blockNamesList: [],
	/**
	 * Function to set the inactive fields list used to show the inactive fields
	 */
	setInactiveFieldsList: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var json = contents.find('.inActiveFieldsArray');
		if (0 < json.length) {
			thisInstance.inActiveFieldsList = JSON.parse(json.val());
		}
	},
	/**
	 * Function to regiser the event to make the blocks sortable
	 */
	makeBlocksListSortable: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var table = contents.find('.blockSortable');
		contents.sortable({
			'containment': contents,
			'items': table,
			'revert': true,
			'tolerance': 'pointer',
			'cursor': 'move',
			'update': function (e, ui) {
				thisInstance.updateBlockSequence();
			}
		});
	},
	/**
	 * Function which will update block sequence
	 */
	updateBlockSequence: function () {
		var thisInstance = this;
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});

		var sequence = JSON.stringify(thisInstance.updateBlocksListByOrder());
		var params = {};
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'Block';
		params['mode'] = 'updateSequenceNumber';
		params['sequence'] = sequence;

		AppConnector.request(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					var params = {};
					params['text'] = app.vtranslate('JS_BLOCK_SEQUENCE_UPDATED');
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
				}
		);
	},
	/**
	 * Function which will arrange the sequence number of blocks
	 */
	updateBlocksListByOrder: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		contents.find('.editFieldsTable.blockSortable').each(function (index, domElement) {
			var blockTable = jQuery(domElement);
			var blockId = blockTable.data('blockId');
			var actualBlockSequence = blockTable.data('sequence');
			var expectedBlockSequence = (index + 1);

			if (expectedBlockSequence != actualBlockSequence) {
				blockTable.data('sequence', expectedBlockSequence);
			}
			thisInstance.updatedBlockSequence[blockId] = expectedBlockSequence;
		});
		return thisInstance.updatedBlockSequence;
	},
	/**
	 * Function to register all the relatedList Events
	 */
	registerRelatedListEvents: function () {
		var thisInstance = this;
		var relatedList = jQuery('#relatedTabOrder');
		var container = relatedList.find('.relatedTabModulesList');
		var ulEle = container.find('ul.relatedModulesList');
		var select2Element = app.showSelectizeElementView(container.find('.select2_container'), {plugins: ['drag_drop', 'remove_button'],
			onInitialize: function () {
				var s = this, children = this.revertSettings.$children;
				if (children.first().is('optgroup')) {
					children = children.find('option');
				}
				children.each(function () {
					var data = $(this).data();
					$.extend(s.options[this.value], data);
				});
			}
		});

		relatedList.on('click', '.inActiveRelationModule', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var relatedModule = currentTarget.closest('.relatedModule');
			relatedModule.find('.activeRelationModule').removeClass('hide').show();
			currentTarget.hide();
			thisInstance.changeStatusRelatedModule(relatedModule.data('relation-id'), 0);
		})
		relatedList.on('click', '.activeRelationModule', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var relatedModule = currentTarget.closest('.relatedModule');
			relatedModule.find('.inActiveRelationModule').removeClass('hide').show();
			currentTarget.hide();
			thisInstance.changeStatusRelatedModule(relatedModule.data('relation-id'), 1);
		})
		relatedList.on('click', '.removeRelation', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var relatedModule = currentTarget.closest('.relatedModule');
			thisInstance.removeRelation(relatedModule);
		})
		var relatedColumnsList = container.find('.relatedColumnsList');
		relatedColumnsList.on('change', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var relatedModule = currentTarget.closest('.relatedModule');
			var selectedFields = thisInstance.updateSelectedFields(currentTarget);
		})
		relatedList.on('click', '.addToFavorites', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			thisInstance.changeStateFavorites(currentTarget);
		})
		relatedList.on('click', '.addRelation', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var container = currentTarget.closest('#relatedTabOrder');
			var contentsDiv = container.closest('.contentsDiv');
			var addRelationContainer = relatedList.find('.addRelationContainer').clone(true, true);
			var callBackFunction = function (data) {
				app.showSelect2ElementView(data.find('select'));
				data.find('.relLabel').val(data.find('.target option:selected').val());
				data.on('change', '.target', function (e) {
					var currentTarget = jQuery(e.currentTarget);
					data.find('.relLabel').val(currentTarget.find('option:selected').val());
				})
				data.on('click', '.addButton', function (e) {
					var form = data.find('form').serializeFormData();
					var params = {};
					params['module'] = app.getModuleName();
					params['parent'] = app.getParentModuleName();
					params['action'] = 'Relation';
					params['mode'] = 'addRelation';
					$.extend(params, form);
					AppConnector.request(params).then(
							function (data) {
								thisInstance.getRelModuleLayoutEditor(container.find('[name="layoutEditorRelModules"]').val()).then(
										function (data) {
											contentsDiv.html(data);
											thisInstance.registerEvents();
										}
								);
							}
					);
				});
			}
			app.showModalWindow(addRelationContainer, function (data) {
				if (typeof callBackFunction == 'function') {
					callBackFunction(data);
				}
			});
		})
	},
	getSelectedFields: function (target) {
		var selectedFields = [];
		target.find(':selected').each(function (e) {
			selectedFields.push({
				id: jQuery(this).val(),
				name: target[0].selectize.options[jQuery(this).val()].fieldName
			});
		})
		return selectedFields;
	},
	/**
	 * Function to regiser the event to make the related modules sortable
	 */
	makeRelatedModuleSortable: function () {
		var thisInstance = this;
		var relatedModulesContainer = jQuery('.relatedModulesList');
		var modulesList = relatedModulesContainer.find('.relatedModule');
		relatedModulesContainer.sortable({
			'containment': relatedModulesContainer,
			'items': modulesList,
			'handle': ".mainBlockTableLabel",
			'revert': true,
			'tolerance': 'pointer',
			'cursor': 'move',
			'update': function (e, ui) {
				thisInstance.updateSequenceRelatedModule();
			}
		});
	},
	changeStateFavorites: function (currentTarget) {
		var thisInstance = this;
		var relatedModule = currentTarget.closest('.relatedModule');
		var status = currentTarget.data('state') == 1 ? 0 : 1;
		var params = {};
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'Relation';
		params['mode'] = 'updateStateFavorites';
		params['relationId'] = relatedModule.data('relation-id');
		params['status'] = status;

		AppConnector.request(params).then(
				function (data) {
					currentTarget.data('state', status);
					currentTarget.find('.glyphicon').each(function () {
						if (jQuery(this).hasClass('hide')) {
							jQuery(this).removeClass('hide');
						} else {
							jQuery(this).addClass('hide');
						}
					})
					Settings_Vtiger_Index_Js.showMessage({text: app.vtranslate('JS_SAVE_NOTIFY_OK')});
				},
				function (error) {
					var params = {};
					params['text'] = error;
					Settings_Vtiger_Index_Js.showMessage(params);
				}
		);
	},
	changeStatusRelatedModule: function (relationId, status) {
		var thisInstance = this;

		var params = {};
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'Relation';
		params['mode'] = 'changeStatusRelation';
		params['relationId'] = relationId;
		params['status'] = status;

		AppConnector.request(params).then(
				function (data) {
					var params = {};
					if (status == 1) {
						params['text'] = app.vtranslate('JS_SAVED_CHANGE_STATUS_1');
					} else {
						params['text'] = app.vtranslate('JS_SAVED_CHANGE_STATUS_0');
					}
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					var params = {};
					params['text'] = error;
					Settings_Vtiger_Index_Js.showMessage(params);
				}
		);
	},
	removeRelation: function (relatedModule) {
		var thisInstance = this;
		var message = app.vtranslate('JS_DELETE_RELATION_CONFIRMATION');
		Vtiger_Helper_Js.showConfirmationBox({'message': message}).then(
				function (e) {
					var params = {};
					params['module'] = app.getModuleName();
					params['parent'] = app.getParentModuleName();
					params['action'] = 'Relation';
					params['mode'] = 'removeRelation';
					params['relationId'] = relatedModule.data('relation-id');

					AppConnector.request(params).then(
							function (data) {
								var params = {};
								params['text'] = app.vtranslate('JS_REMOVE_RELATION_OK');
								relatedModule.remove();
								Settings_Vtiger_Index_Js.showMessage(params);
							},
							function (error) {
								var params = {
									text: message,
									type: 'error'
								};
								Settings_Vtiger_Index_Js.showMessage(params);
							}
					);
				},
				function (error, err) {
				}
		)
	},
	updateSequenceRelatedModule: function () {
		var thisInstance = this;
		var modules = [];
		var relatedModulesContainer = jQuery('.relatedModulesList');
		var params = {};
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});
		relatedModulesContainer.find('.relatedModule').each(function (index, domElement) {
			var relationId = jQuery(domElement).data('relationId');
			modules.push({relationId: relationId, index: index});
		});

		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'Relation';
		params['mode'] = 'updateSequenceRelatedModule';
		params['modules'] = modules;

		AppConnector.request(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					var params = {};
					params['text'] = app.vtranslate('JS_UPDATE_SEQUENCE');
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					var params = {};
					params['text'] = error;
					Settings_Vtiger_Index_Js.showMessage(params);
				}
		);
	},
	updateSelectedFields: function (target) {
		var thisInstance = this;
		var params = {};
		var relatedModule = jQuery(target).closest('.relatedModule');
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});
		if (jQuery(target).data('type') == 'inventory') {
			params['inventory'] = true;
			var selectedFields = jQuery(target).val();
		} else {
			var selectedFields = thisInstance.getSelectedFields(jQuery(target));
		}
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'Relation';
		params['mode'] = 'updateSelectedFields';
		params['relationId'] = relatedModule.data('relation-id');
		params['fields'] = selectedFields;
		AppConnector.request(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					var params = {};
					params['text'] = app.vtranslate('JS_UPDATED_FIELD_LIST_MODULE_RELATED');
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					var params = {};
					params['text'] = error;
					Settings_Vtiger_Index_Js.showMessage(params);
				}
		);
	},
	/**
	 * Function to regiser the event to make the fields sortable
	 */
	makeFieldsListSortable: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var table = contents.find('.editFieldsTable');
		table.each(function () {
			var containment = jQuery(this).closest('.moduleBlocks');
			jQuery(this).find('ul[name=sortable1], ul[name=sortable2]').sortable({
				'containment': containment,
				'revert': true,
				'tolerance': 'pointer',
				'cursor': 'move',
				'connectWith': containment.find('.connectedSortable'),
				'update': function (e, ui) {
					var currentField = ui['item'];
					if (currentField.closest('.moduleBlocks').hasClass('inventoryBlock')) {
						thisInstance.showSaveFieldSequenceButton(currentField.closest('.editFieldsTable'));
					} else {
						thisInstance.showSaveFieldSequenceButton(thisInstance.getDetailViewLayout());
						thisInstance.createUpdatedBlocksList(currentField);
						// rearrange the older block fields
						if (ui.sender) {
							var olderBlock = ui.sender.closest('.editFieldsTable');
							thisInstance.reArrangeBlockFields(olderBlock);
						}
					}

				}
			});
		})

	},
	getDetailViewLayout: function () {
		return jQuery('#detailViewLayout');
	},
	getInventoryViewLayout: function () {
		return jQuery('#inventoryViewLayout');
	},
	/**
	 * Function to show the save button of fieldSequence
	 */
	showSaveFieldSequenceButton: function (layout) {
		var thisInstance = this;
		var saveButton = layout.find('.saveFieldSequence');
		if (app.isHidden(saveButton) || app.isInvisible(saveButton)) {
			if (!saveButton.hasClass('inventorySequence')) {
				thisInstance.updatedBlocksList = [];
				thisInstance.updatedBlockFieldsList = [];
			}
			saveButton.removeClass('hide');
			saveButton.removeClass('invisible');
			var params = {};
			params['text'] = app.vtranslate('JS_SAVE_THE_CHANGES_TO_UPDATE_FIELD_SEQUENCE');
			Settings_Vtiger_Index_Js.showMessage(params);
		}
	},
	/**
	 * Function which will hide the saveFieldSequence button
	 */
	hideSaveFieldSequenceButton: function () {
		var layout = jQuery('#detailViewLayout');
		var saveButton = layout.find('.saveFieldSequence');
		saveButton.addClass('hide');
	},
	/**
	 * Function to create the blocks list which are updated while sorting
	 */
	createUpdatedBlocksList: function (currentField) {
		var thisInstance = this;
		var block = currentField.closest('.editFieldsTable');
		var updatedBlockId = block.data('blockId');
		if (jQuery.inArray(updatedBlockId, thisInstance.updatedBlocksList) == -1) {
			thisInstance.updatedBlocksList.push(updatedBlockId);
		}
		thisInstance.reArrangeBlockFields(block);
	},
	/**
	 * Function that rearranges fields in the block when the fields are moved
	 * @param <jQuery object> block
	 */
	reArrangeBlockFields: function (block) {
		// 1.get the containers, 2.compare the length, 3.if uneven then move the last element
		var leftSideContainer = block.find('ul[name=sortable1]');
		var rightSideContainer = block.find('ul[name=sortable2]');
		if (leftSideContainer.children().length < rightSideContainer.children().length) {
			var lastElementInRightContainer = rightSideContainer.children(':last');
			leftSideContainer.append(lastElementInRightContainer);
		} else if (leftSideContainer.children().length > rightSideContainer.children().length + 1) {	//greater than 1
			var lastElementInLeftContainer = leftSideContainer.children(':last');
			rightSideContainer.append(lastElementInLeftContainer);
		}
	},
	/**
	 * Function to create the list of updated blocks with all the fields and their sequences
	 */
	createUpdatedBlockFieldsList: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');

		for (var index in  thisInstance.updatedBlocksList) {
			var updatedBlockId = thisInstance.updatedBlocksList[index];
			var updatedBlock = contents.find('.block_' + updatedBlockId);
			var firstBlockSortFields = updatedBlock.find('ul[name=sortable1]');
			var editFields = firstBlockSortFields.find('.editFields');
			var expectedFieldSequence = 1;
			editFields.each(function (i, domElement) {
				var fieldEle = jQuery(domElement);
				var fieldId = fieldEle.data('fieldId');
				thisInstance.updatedBlockFieldsList.push({'fieldid': fieldId, 'sequence': expectedFieldSequence, 'block': updatedBlockId});
				expectedFieldSequence = expectedFieldSequence + 2;
			});
			var secondBlockSortFields = updatedBlock.find('ul[name=sortable2]');
			var secondEditFields = secondBlockSortFields.find('.editFields');
			var sequenceValue = 2;
			secondEditFields.each(function (i, domElement) {
				var fieldEle = jQuery(domElement);
				var fieldId = fieldEle.data('fieldId');
				thisInstance.updatedBlockFieldsList.push({'fieldid': fieldId, 'sequence': sequenceValue, 'block': updatedBlockId});
				sequenceValue = sequenceValue + 2;
			});
		}
	},
	/**
	 * Function to register click event for save button of fields sequence
	 */
	registerFieldSequenceSaveClick: function () {
		var thisInstance = this;
		var layout = jQuery('#detailViewLayout');
		layout.on('click', '.saveFieldSequence', function () {
			thisInstance.hideSaveFieldSequenceButton();
			thisInstance.createUpdatedBlockFieldsList();
			thisInstance.updateFieldSequence();
		});
	},
	/**
	 * Function will save the field sequences
	 */
	updateFieldSequence: function () {
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
		params['action'] = 'Field';
		params['mode'] = 'move';
		params['updatedFields'] = thisInstance.updatedBlockFieldsList;

		AppConnector.request(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					window.location.reload();
					var params = {};
					params['text'] = app.vtranslate('JS_FIELD_SEQUENCE_UPDATED');
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
				}
		);
	},
	/**
	 * Function to register click evnet add custom field button
	 */
	registerAddCustomFieldEvent: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		contents.find('.addCustomField').click(function (e) {
			var blockId = jQuery(e.currentTarget).closest('.editFieldsTable').data('blockId');
			var addFieldContainer = contents.find('.createFieldModal').clone(true, true);
			addFieldContainer.removeClass('hide').show();

			var callBackFunction = function (data) {
				//register all select2 Elements
				app.showSelect2ElementView(data.find('select'), {width: '100%'});

				var form = data.find('.createCustomFieldForm');
				form.attr('id', 'createFieldForm');
				var select2params = {tags: [], tokenSeparators: [","]}
				app.showSelect2ElementView(form.find('[name="pickListValues"]'), select2params);

				thisInstance.registerFieldTypeChangeEvent(form);
				thisInstance.registerTableTypeChangeEvent(form);
				thisInstance.registerMultiReferenceFieldsChangeEvent(form);
				thisInstance.registerMultiReferenceFilterFieldChangeEvent(form);

				var params = app.getvalidationEngineOptions(true);
				params.onValidationComplete = function (form, valid) {
					if (valid) {
						var fieldTypeValue = jQuery('[name="fieldType"]', form).val();
						var fieldNameValue = jQuery('[name="fieldName"]', form).val();

						if (fieldTypeValue == 'Picklist' || fieldTypeValue == 'MultiSelectCombo') {
							var pickListValueElement = jQuery('#picklistUi', form);
							var pickListValuesArray = pickListValueElement.val();
							var pickListValuesArraySize = pickListValuesArray.length;
							var specialChars = /["]/;
							if (fieldNameValue.toLowerCase() === 'status' || 'picklist' === fieldNameValue.toLowerCase()) {
								var message = app.vtranslate('JS_RESERVED_PICKLIST_NAME');
								jQuery('[name="fieldName"]', form).validationEngine('showPrompt', message, 'error', 'bottomLeft', true);
								return false;
							}
							for (var i = 0; i < pickListValuesArray.length; i++) {
								if (specialChars.test(pickListValuesArray[i])) {
									var select2Element = app.getSelect2ElementFromSelect(pickListValueElement);
									var message = app.vtranslate('JS_SPECIAL_CHARACTERS') + ' " ' + app.vtranslate('JS_NOT_ALLOWED');
									select2Element.validationEngine('showPrompt', message, 'error', 'bottomLeft', true);
									return false;
								}
							}
							var lowerCasedpickListValuesArray = jQuery.map(pickListValuesArray, function (item, index) {
								return item.toLowerCase();
							});
							var uniqueLowerCasedpickListValuesArray = jQuery.unique(lowerCasedpickListValuesArray);
							var uniqueLowerCasedpickListValuesArraySize = uniqueLowerCasedpickListValuesArray.length;
							var arrayDiffSize = pickListValuesArraySize - uniqueLowerCasedpickListValuesArraySize;
							if (arrayDiffSize > 0) {
								var select2Element = app.getSelect2ElementFromSelect(pickListValueElement);
								var message = app.vtranslate('JS_DUPLICATES_VALUES_FOUND');
								select2Element.validationEngine('showPrompt', message, 'error', 'bottomLeft', true);
								return false;
							}

						}
						if (fieldTypeValue == 'Tree' || fieldTypeValue == 'CategoryMultipicklist') {
							var treeListElement = form.find('select.TreeList');
							if (treeListElement.val() == '-') {
								var message = app.vtranslate('JS_FIELD_CAN_NOT_BE_EMPTY');
								form.find('.TreeList').validationEngine('showPrompt', message, 'error', 'bottomLeft', true);
								return false;
							}

						}
						var saveButton = form.find(':submit');
						saveButton.attr('disabled', 'disabled');
						thisInstance.addCustomField(blockId, form).then(
								function (data) {
									var result = data['result'];
									var params = {};
									if (data['success']) {
										app.hideModalWindow();
										params['text'] = app.vtranslate('JS_CUSTOM_FIELD_ADDED');
										Settings_Vtiger_Index_Js.showMessage(params);
										thisInstance.showCustomField(result);
									} else {
										var message = data['error']['message'];
										if (data['error']['code'] != 513) {
											var errorField = form.find('[name="fieldName"]');
										} else {
											var errorField = form.find('[name="fieldLabel"]');
										}
										errorField.validationEngine('showPrompt', message, 'error', 'topLeft', true);
										saveButton.removeAttr('disabled');
									}
								}
						);
					}
					//To prevent form submit
					return false;
				}
				form.validationEngine(params);
			}

			app.showModalWindow(addFieldContainer, function (data) {
				if (typeof callBackFunction == 'function') {
					callBackFunction(data);
				}
			}, {'width': '1000px'});
		});
	},
	/**
	 * Function to create the array of block names list
	 */
	setBlocksListArray: function (form) {
		var thisInstance = this;
		thisInstance.blockNamesList = [];
		var blocksListSelect = form.find('[name="beforeBlockId"]');
		blocksListSelect.find('option').each(function (index, ele) {
			var option = jQuery(ele);
			var label = option.data('label');
			thisInstance.blockNamesList.push(label);
		})
	},
	/**
	 * Function to save the custom field details
	 */
	addCustomField: function (blockId, form) {
		var thisInstance = this;
		var modalHeader = form.closest('#globalmodal').find('.modal-header h3');
		var aDeferred = jQuery.Deferred();

		modalHeader.progressIndicator({smallLoadingImage: true, imageContainerCss: {display: 'inline', 'margin-left': '18%', position: 'absolute'}});

		var params = form.serializeFormData();
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'Field';
		params['mode'] = 'add';
		params['blockid'] = blockId;
		params['sourceModule'] = jQuery('#selectedModuleName').val();

		AppConnector.request(params).then(
				function (data) {
					modalHeader.progressIndicator({'mode': 'hide'});
					aDeferred.resolve(data);
				},
				function (error) {
					modalHeader.progressIndicator({'mode': 'hide'});
					aDeferred.reject(error);
				}
		);
		return aDeferred.promise();
	},
	registerTableTypeChangeEvent: function (form) {
		form.find('[name="fieldTypeList"]').on('change', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			form.find('[name="fieldName"]').closest('.form-group').toggleClass('hide');
		})
	},
	/**
	 * Function to register change event for fieldType while adding custom field
	 */
	registerFieldTypeChangeEvent: function (form) {
		var thisInstance = this;
		var lengthInput = form.find('[name="fieldLength"]');

		//special validators while adding new field
		var lengthValidator = [{'name': 'DecimalMaxLength'}];
		var maxLengthValidator = [{'name': 'MaxLength'}];
		var decimalValidator = [{'name': 'FloatingDigits'}];

		//By default add the max length validator
		lengthInput.data('validator', maxLengthValidator);

		//register the change event for field types
		form.find('[name="fieldType"]').on('change', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var lengthInput = form.find('[name="fieldLength"]');
			var selectedOption = currentTarget.find('option:selected');

			//hide all the elements like length, decimal,picklist
			form.find('.supportedType').addClass('hide');

			if (selectedOption.data('lengthsupported')) {
				form.find('.lengthsupported').removeClass('hide');
				lengthInput.data('validator', maxLengthValidator);
			}

			if (selectedOption.data('decimalsupported')) {
				var decimalFieldUi = form.find('.decimalsupported');
				decimalFieldUi.removeClass('hide');

				var decimalInput = decimalFieldUi.find('[name="decimal"]');
				var maxFloatingDigits = selectedOption.data('maxfloatingdigits');

				if (typeof maxFloatingDigits != "undefined") {
					decimalInput.data('validator', decimalValidator);
					lengthInput.data('validator', lengthValidator);
				}

				if (selectedOption.data('decimalreadonly')) {
					decimalInput.val(maxFloatingDigits).attr('readonly', true);
				} else {
					decimalInput.removeAttr('readonly').val('');
				}
			}

			if (selectedOption.data('predefinedvalueexists')) {
				var pickListUi = form.find('.preDefinedValueExists');
				pickListUi.removeClass('hide');
			}
			if (selectedOption.data('picklistoption')) {
				var pickListOption = form.find('.picklistOption');
				pickListOption.removeClass('hide');
			}
			if (selectedOption.val() == 'Related1M') {
				form.find('.preDefinedModuleList').removeClass('hide');
			}
			if (selectedOption.val() == 'Tree' || selectedOption.val() == 'CategoryMultipicklist') {
				form.find('.preDefinedTreeList').removeClass('hide');
			}
			if (selectedOption.val() == 'MultiReferenceValue') {
				form.find('.preMultiReferenceValue').removeClass('hide');
				thisInstance.loadMultiReferenceFields(form);
			}
		})
	},
	/**
	 * Function to add new custom field ui to the list
	 */
	showCustomField: function (result) {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var relatedBlock = contents.find('.block_' + result['blockid']);
		var fieldCopy = contents.find('.newCustomFieldCopy').clone(true, true);
		var fieldContainer = fieldCopy.find('div.marginLeftZero.border1px');
		fieldContainer.addClass('opacity editFields').attr('data-field-id', result['id']).attr('data-block-id', result['blockid']);
		fieldContainer.find('.deleteCustomField, .saveFieldDetails').attr('data-field-id', result['id']);
		fieldContainer.find('.fieldLabel').html(result['label'] + ' [' + result['name'] + ']');
		fieldContainer.find('#relatedFieldValue').val(result['name']).prop('id', 'relatedFieldValue' + result['id']);
		fieldContainer.find('.copyFieldLabel').attr('data-target', 'relatedFieldValue' + result['id']);
		thisInstance.registerCopyClipboard(fieldContainer);
		if (!result['customField']) {
			fieldContainer.find('.deleteCustomField').remove();
		}
		if (jQuery.inArray(result['type'], ['string', 'phone', 'currency', 'url', 'integer', 'double']) == -1) {
			fieldContainer.find('.maskField').remove();
		}
		var block = relatedBlock.find('.blockFieldsList');
		var sortable1 = block.find('ul[name=sortable1]');
		var length1 = sortable1.children().length;
		var sortable2 = block.find('ul[name=sortable2]');
		var length2 = sortable2.children().length;
		// Deciding where to add the new field
		if (length1 > length2) {
			sortable2.append(fieldCopy.removeClass('hide newCustomFieldCopy'));
		} else {
			sortable1.append(fieldCopy.removeClass('hide newCustomFieldCopy'));
		}
		thisInstance.makeFieldsListSortable();
	},
	/**
	 * Function to register click event for add custom block button
	 */
	registerAddCustomBlockEvent: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		contents.find('.addCustomBlock').click(function (e) {
			var addBlockContainer = contents.find('.addBlockModal').clone(true, true);

			var callBackFunction = function (data) {
				data.find('.addBlockModal').removeClass('hide').show();
				//register all select2 Elements
				app.showSelect2ElementView(data.find('select'));

				var form = data.find('.addCustomBlockForm');
				thisInstance.setBlocksListArray(form);
				var fieldLabel = form.find('[name="label"]');
				var params = app.validationEngineOptions;
				params.onValidationComplete = function (form, valid) {
					if (valid) {
						var formData = form.serializeFormData();
						if (jQuery.inArray(formData['label'], thisInstance.blockNamesList) == -1) {
							thisInstance.saveBlockDetails(form).then(
									function (data) {
										var params = {};
										if (data['success']) {
											var result = data['result'];
											thisInstance.displayNewCustomBlock(result);
											thisInstance.updateNewSequenceForBlocks(result['sequenceList']);
											thisInstance.appendNewBlockToBlocksList(result, form);
											thisInstance.makeFieldsListSortable();

											params['text'] = app.vtranslate('JS_CUSTOM_BLOCK_ADDED');
										} else {
											params['text'] = data['error']['message'];
											params['type'] = 'error';
										}
										Settings_Vtiger_Index_Js.showMessage(params);
									}
							);
							app.hideModalWindow();
							return valid;
						} else {
							var result = app.vtranslate('JS_BLOCK_NAME_EXISTS');
							fieldLabel.validationEngine('showPrompt', result, 'error', 'topLeft', true);
							e.preventDefault();
							return;
						}
					}
				}
				form.validationEngine(params);

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
	 * Function to save the new custom block details
	 */
	saveBlockDetails: function (form) {
		var thisInstance = this;
		var aDeferred = jQuery.Deferred();
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});
		var params = form.serializeFormData();
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['sourceModule'] = jQuery('#selectedModuleName').val();
		params['action'] = 'Block';
		params['mode'] = 'save';

		AppConnector.request(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					aDeferred.resolve(data);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					aDeferred.reject(error);
				}
		);
		return aDeferred.promise();
	},
	/**
	 * Function used to display the new custom block ui after save
	 */
	displayNewCustomBlock: function (result) {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var beforeBlockId = result['beforeBlockId'];
		var beforeBlock = contents.find('.block_' + beforeBlockId);

		var newBlockCloneCopy = contents.find('.newCustomBlockCopy').clone(true, true);
		newBlockCloneCopy.data('blockId', result['id']).find('.blockLabel').append(jQuery('<strong>' + result['label'] + '</strong>'));
		newBlockCloneCopy.find('.blockVisibility').data('blockId', result['id']);
		if (result['isAddCustomFieldEnabled']) {
			newBlockCloneCopy.find('.addCustomField').removeClass('hide');
		}
		beforeBlock.after(newBlockCloneCopy.removeClass('hide newCustomBlockCopy').addClass('editFieldsTable block_' + result['id']));

		newBlockCloneCopy.find('.blockFieldsList').sortable({'connectWith': '.blockFieldsList'});
	},
	/**
	 * Function to update the sequence for all blocks after adding new Block
	 */
	updateNewSequenceForBlocks: function (sequenceList) {
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		jQuery.each(sequenceList, function (blockId, sequence) {
			contents.find('.block_' + blockId).data('sequence', sequence);
		});
	},
	/**
	 * Function to update the block list with the new block label in the clone container
	 */
	appendNewBlockToBlocksList: function (result, form) {
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var hiddenAddBlockModel = contents.find('.addBlockModal');
		var blocksListSelect = hiddenAddBlockModel.find('[name="beforeBlockId"]');
		var option = jQuery("<option>", {
			value: result['id'],
			text: result['label']
		})
		blocksListSelect.append(option.attr('data-label', result['label']));
	},
	/**
	 * Function to update the block list to remove the deleted custom block label in the clone container
	 */
	removeBlockFromBlocksList: function (blockId) {
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var hiddenAddBlockModel = contents.find('.addBlockModal');
		var blocksListSelect = hiddenAddBlockModel.find('[name="beforeBlockId"]');
		blocksListSelect.find('option[value="' + blockId + '"]').remove();
	},
	/**
	 * Function to register the change event for block visibility
	 */
	registerBlockVisibilityEvent: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		contents.on('click', 'li.blockVisibility', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var oldDisplayStatus = currentTarget.data('visible');
			if (oldDisplayStatus == '0') {
				currentTarget.find('.glyphicon-ok').removeClass('hide');
				currentTarget.data('visible', '1');
			} else {
				currentTarget.find('.glyphicon-ok').addClass('hide');
				currentTarget.data('visible', '0');
			}
			thisInstance.updateBlockStatus(currentTarget);
		})
	},
	/**
	 * Function to save the changed visibility for the block
	 */
	updateBlockStatus: function (currentTarget) {
		var thisInstance = this;
		var blockStatus = currentTarget.data('visible');
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});
		var params = {};
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['sourceModule'] = jQuery('#selectedModuleName').val();
		params['action'] = 'Block';
		params['mode'] = 'save';
		params['blockid'] = currentTarget.data('blockId');
		params['display_status'] = blockStatus;

		AppConnector.request(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					var params = {};
					if (blockStatus == '1') {
						params['text'] = app.vtranslate('JS_BLOCK_VISIBILITY_SHOW');
					} else {
						params['text'] = app.vtranslate('JS_BLOCK_VISIBILITY_HIDE');
					}
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
				}
		);
	},
	/**
	 * Function to register the click event for inactive fields list
	 */
	registerInactiveFieldsEvent: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		contents.on('click', 'li.inActiveFields', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var currentBlock = currentTarget.closest('.editFieldsTable');
			var blockId = currentBlock.data('blockId');
			//If there are no hidden fields, show pnotify
			if (jQuery.isEmptyObject(thisInstance.inActiveFieldsList[blockId])) {
				var params = {};
				params['text'] = app.vtranslate('JS_NO_HIDDEN_FIELDS_EXISTS');
				params['type'] = 'error';
				Settings_Vtiger_Index_Js.showMessage(params);
			} else {
				var inActiveFieldsContainer = contents.find('.inactiveFieldsModal').clone(true, true);

				var callBackFunction = function (data) {
					data.find('.inactiveFieldsModal').removeClass('hide').show();
					thisInstance.reactiveFieldsList = [];
					var form = data.find('.inactiveFieldsForm');
					thisInstance.showHiddenFields(blockId, form);
					//register click event for reactivate button in the inactive fields modal
					form.submit(function (e) {
						thisInstance.createReactivateFieldslist(blockId, form);
						thisInstance.reActivateHiddenFields(currentBlock);
						app.hideModalWindow();
						e.preventDefault();
					});
				}

				app.showModalWindow(inActiveFieldsContainer, function (data) {
					if (typeof callBackFunction == 'function') {
						callBackFunction(data);
					}
				}, {'width': '1000px'});
			}
		});

	},
	/**
	 * Function to show the list of inactive fields in the modal
	 */
	showHiddenFields: function (blockId, form) {
		var thisInstance = this;
		jQuery.each(thisInstance.inActiveFieldsList[blockId], function (key, value) {
			var inActiveField = jQuery('<div class="col-md-4 marginLeftZero padding-bottom1per checkbox"><label class="">\n\
									<input type="checkbox" class="inActiveField" value="' + key + '" />&nbsp;' + value + '</label></div>');
			form.find('.inActiveList').append(inActiveField);
		});
	},
	/**
	 * Function to create the list of reactivate fields list
	 */
	createReactivateFieldslist: function (blockId, form) {
		var thisInstance = this;
		form.find('.inActiveField').each(function (index, domElement) {
			var element = jQuery(domElement);
			var fieldId = element.val();
			if (element.is(':checked')) {
				delete thisInstance.inActiveFieldsList[blockId][fieldId];
				thisInstance.reactiveFieldsList.push(fieldId);
			}
		});
	},
	/**
	 * Function to unHide the selected fields in the inactive fields modal
	 */
	reActivateHiddenFields: function (currentBlock) {
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
		params['action'] = 'Field';
		params['mode'] = 'unHide';
		params['blockId'] = currentBlock.data('blockId');
		params['fieldIdList'] = JSON.stringify(thisInstance.reactiveFieldsList);

		AppConnector.request(params).then(
				function (data) {
					for (var index in data.result) {
						thisInstance.showCustomField(data.result[index]);
					}
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					var params = {};
					params['text'] = app.vtranslate('JS_SELECTED_FIELDS_REACTIVATED');
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
				}
		);
	},
	/**
	 * Function to register the click event for delete custom block
	 */
	registerDeleteCustomBlockEvent: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var table = contents.find('.editFieldsTable');
		contents.on('click', 'li.deleteCustomBlock', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var table = currentTarget.closest('div.editFieldsTable');
			var blockId = table.data('blockId');

			var message = app.vtranslate('JS_LBL_ARE_YOU_SURE_YOU_WANT_TO_DELETE');
			Vtiger_Helper_Js.showConfirmationBox({'message': message}).then(
					function (e) {
						thisInstance.deleteCustomBlock(blockId);
					},
					function (error, err) {

					}
			);
		});
	},
	/**
	 * Function to delete the custom block
	 */
	deleteCustomBlock: function (blockId) {
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
		params['action'] = 'Block';
		params['mode'] = 'delete';
		params['blockid'] = blockId;

		AppConnector.request(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					var params = {};
					if (data['success']) {
						thisInstance.removeDeletedBlock(blockId);
						thisInstance.removeBlockFromBlocksList(blockId);
						params['text'] = app.vtranslate('JS_CUSTOM_BLOCK_DELETED');
					} else {
						params['text'] = data['error']['message'];
						params['type'] = 'error';
					}
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
				}
		);
	},
	/**
	 * Function to remove the deleted custom block from the ui
	 */
	removeDeletedBlock: function (blockId) {
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var deletedTable = contents.find('.block_' + blockId);
		deletedTable.fadeOut('slow').remove();
	},
	/**
	 * Function to register the click event for delete custom field
	 */
	registerDeleteCustomFieldEvent: function (contents) {
		var thisInstance = this;
		if (typeof contents == 'undefined') {
			contents = jQuery('#layoutEditorContainer').find('.contents');
		}
		contents.find('.deleteCustomField').click(function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var fieldId = currentTarget.data('fieldId');
			var message = app.vtranslate('JS_LBL_ARE_YOU_SURE_YOU_WANT_TO_DELETE');
			Vtiger_Helper_Js.showConfirmationBox({'message': message}).then(
					function (e) {
						thisInstance.deleteCustomField(fieldId).then(
								function (data) {
									var field = currentTarget.closest('div.editFields');
									var blockId = field.data('blockId');
									field.parent().fadeOut('slow').remove();
									var block = jQuery('#block_' + blockId);
									thisInstance.reArrangeBlockFields(block);
									var params = {};
									params['text'] = app.vtranslate('JS_CUSTOM_FIELD_DELETED');
									Settings_Vtiger_Index_Js.showMessage(params);
								}, function (error, err) {

						}
						);
					},
					function (error, err) {

					}
			);
		});
	},
	/**
	 * Function to delete the custom field
	 */
	deleteCustomField: function (fieldId) {
		var thisInstance = this;
		var aDeferred = jQuery.Deferred();
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});

		var params = {};
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['action'] = 'Field';
		params['mode'] = 'delete';
		params['fieldid'] = fieldId;

		AppConnector.request(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					aDeferred.resolve(data);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					aDeferred.reject();
				}
		);
		return aDeferred.promise();
	},
	/**
	 * Function to register the cahnge event for mandatory & default checkboxes in edit field details
	 */
	registerFieldDetailsChange: function (contents) {
		contents.find('[name="mandatory"]').on('change', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			if (currentTarget.attr('readonly') !== 'readonly') {
				var form = currentTarget.closest('.fieldDetailsForm');
				var quickcreateEle = form.find('[name="quickcreate"]').filter(':checkbox').not('.optionDisabled');
				var presenceEle = form.find('[name="presence"]').filter(':checkbox').not('.optionDisabled');
				if (currentTarget.is(':checked')) {
					quickcreateEle.attr('checked', true).attr('readonly', 'readonly');
					presenceEle.attr('checked', true).attr('readonly', 'readonly');
				} else {
					quickcreateEle.removeAttr('readonly');
					presenceEle.removeAttr('readonly');
				}
			}
		});
		contents.find('[name="defaultvalue"]').on('change', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var defaultValueUi = currentTarget.closest('.checkbox').find('.defaultValueUi');
			var defaultField = defaultValueUi.find('[name="fieldDefaultValue"]');
			if (currentTarget.is(':checked')) {
				defaultValueUi.removeClass('zeroOpacity');
				defaultField.removeAttr('disabled');
				if (defaultField.is('select')) {
					defaultField.trigger("chosen:updated");
				}
			} else {
				defaultField.attr('disabled', 'disabled');
				defaultValueUi.addClass('zeroOpacity');
			}
		});
	},
	/**
	 * Function to register the click event for related modules list tab
	 */
	relatedModulesTabClickEvent: function () {
		var thisInstance = this;
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		var relatedContainer = contents.find('#relatedTabOrder');
		var relatedTab = contents.find('.relatedListTab');
		relatedTab.click(function () {
			if (relatedContainer.find('.relatedTabModulesList').length > 0) {

			} else {
				thisInstance.showRelatedTabModulesList(relatedContainer);
			}
		});
	},
	/**
	 * Function to show the related tab modules list in the tab
	 */
	showRelatedTabModulesList: function (relatedContainer) {
		var thisInstance = this;
		var params = {};
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['sourceModule'] = jQuery('#selectedModuleName').val();
		params['view'] = 'Index';
		params['mode'] = 'showRelatedListLayout';

		AppConnector.request(params).then(
				function (data) {
					relatedContainer.html(data);
					if (jQuery(data).find('.relatedListContainer').length > 0) {
						thisInstance.makeRelatedModuleSortable();
						thisInstance.registerRelatedListEvents();
					}
				},
				function (error) {
				}
		);
	},
	/**
	 * Function to get the respective module layout editor through pjax
	 */
	getModuleLayoutEditor: function (selectedModule) {
		var thisInstance = this;
		var aDeferred = jQuery.Deferred();
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});

		var params = {};
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['view'] = 'Index';
		params['sourceModule'] = selectedModule;

		AppConnector.requestPjax(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					aDeferred.resolve(data);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					aDeferred.reject();
				}
		);
		return aDeferred.promise();
	},
	getRelModuleLayoutEditor: function (selectedModule) {
		var thisInstance = this;
		var aDeferred = jQuery.Deferred();
		var progressIndicatorElement = jQuery.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});

		var params = {};
		params['module'] = app.getModuleName();
		params['parent'] = app.getParentModuleName();
		params['view'] = 'Index';
		params['mode'] = 'showRelatedListLayout';
		params['sourceModule'] = selectedModule;

		AppConnector.requestPjax(params).then(
				function (data) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					aDeferred.resolve(data);
				},
				function (error) {
					progressIndicatorElement.progressIndicator({'mode': 'hide'});
					aDeferred.reject();
				}
		);
		return aDeferred.promise();
	},
	/**
	 * Function to register the change event for layout editor modules list
	 */
	registerModulesChangeEvent: function () {
		var thisInstance = this;
		var container = jQuery('#layoutEditorContainer');
		var contentsDiv = container.closest('.contentsDiv');

		app.showSelect2ElementView(container.find('[name="layoutEditorModules"]'));

		container.on('change', '[name="layoutEditorModules"]', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var selectedModule = currentTarget.val();
			thisInstance.getModuleLayoutEditor(selectedModule).then(
					function (data) {
						contentsDiv.html(data);
						thisInstance.registerEvents();
					}
			);
		});

	},
	registerRelModulesChangeEvent: function () {
		var thisInstance = this;
		var container = jQuery('#layoutEditorContainer');
		var contentsDiv = container.closest('.contentsDiv');

		app.showSelect2ElementView(container.find('[name="layoutEditorRelModules"]'));

		container.on('change', '[name="layoutEditorRelModules"]', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var selectedModule = currentTarget.val();
			thisInstance.getRelModuleLayoutEditor(selectedModule).then(
					function (data) {
						contentsDiv.html(data);
						thisInstance.registerEvents();
					}
			);
		});

	},
	lockCheckbox: function (contents) {
		contents.on('change', ':checkbox', function (e) {
			var currentTarget = $(e.currentTarget);
			if (currentTarget.attr('readonly') === 'readonly') {
				var status = $(e.currentTarget).is(':checked');
				if (!status) {
					$(e.currentTarget).prop('checked', true);
				} else {
					$(e.currentTarget).prop('checked', false);
				}
				e.preventDefault();
			}
		});
	},
	registerEditFieldDetailsClick: function (contents) {
		var thisInstance = this;
		if (typeof contents === 'undefined') {
			contents = jQuery('#layoutEditorContainer').find('.contents');
		}
		contents.find('.editFieldDetails').click(function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var fieldRow = currentTarget.closest('div.editFields');
			var fieldId = fieldRow.data('fieldId');
			var block = fieldRow.closest('.editFieldsTable');
			var blockId = block.data('blockId');
			app.showModalWindow({
				url: 'index.php?parent=Settings&module=LayoutEditor&view=EditField&fieldId=' + fieldRow.data('fieldId'),
				cb: function (modalContainer) {
					thisInstance.registerFieldDetailsChange(modalContainer);
					thisInstance.lockCheckbox(modalContainer);
					app.registerEventForClockPicker(modalContainer.find('.clockPicker'));
				},
				sendByAjaxCb: function (formData, response) {
					Settings_Vtiger_Index_Js.showMessage({
						text: app.vtranslate('JS_FIELD_DETAILS_SAVED')
					});
					var result = response['result'];
					var fieldLabel = fieldRow.find('.fieldLabel');
					if (result['presence'] === '1') {
						fieldRow.parent().fadeOut('slow').remove();
						if (jQuery.isEmptyObject(thisInstance.inActiveFieldsList[blockId])) {
							if (thisInstance.inActiveFieldsList.length === 0) {
								thisInstance.inActiveFieldsList = {};
							}
							thisInstance.inActiveFieldsList[blockId] = {};
							thisInstance.inActiveFieldsList[blockId][fieldId] = result['label'];
						} else {
							thisInstance.inActiveFieldsList[blockId][fieldId] = result['label'];
						}
						thisInstance.reArrangeBlockFields(block);
					}
					if (result['mandatory']) {
						if (fieldLabel.find('.redColor').length === 0) {
							fieldRow.find('.fieldLabel').append(jQuery('<span class="redColor">*</span>'));
						}
					} else {
						fieldRow.find('.fieldLabel').find('.redColor').remove();
					}
				}
			});
		});
	},
	/**
	 * Function to register all the events for blocks
	 */
	registerBlockEvents: function () {
		var thisInstance = this;
		thisInstance.makeBlocksListSortable();
		thisInstance.registerAddCustomFieldEvent();
		thisInstance.registerBlockVisibilityEvent();
		thisInstance.registerInactiveFieldsEvent();
		thisInstance.registerDeleteCustomBlockEvent();
	},
	/**
	 * Function to register all the events for fields
	 */
	registerFieldEvents: function (contents) {
		var thisInstance = this;
		if (typeof contents == 'undefined') {
			contents = jQuery('#layoutEditorContainer').find('.contents');
		}
		app.registerEventForDatePickerFields(contents);
		app.registerEventForClockPicker(contents);
		app.changeSelectElementView(contents);

		thisInstance.makeFieldsListSortable();
		thisInstance.registerDeleteCustomFieldEvent(contents);
		thisInstance.registerEditFieldDetailsClick(contents);

		contents.find(':checkbox').change(function (e) {
			var currentTarget = jQuery(e.currentTarget);
			if (currentTarget.attr('readonly') == 'readonly') {
				var status = jQuery(e.currentTarget).is(':checked');
				if (!status) {
					jQuery(e.currentTarget).prop('checked', true)
				} else {
					jQuery(e.currentTarget).prop('checked', false);
				}
				e.preventDefault();
			}
		});
	},
	/**
	 * Function to register switch
	 */
	registerSwitch: function () {
		var container = jQuery('#layoutEditorContainer');
		app.showBtnSwitch(container.find('.switchBtn'))
		var inventoryNav = container.find('.inventoryNav');
		container.find('#inventorySwitch').on('switchChange.bootstrapSwitch', function (event, state) {
			var switchBtn = jQuery(event.currentTarget);
			var message = app.vtranslate('JS_EXTENDED_MODULE');
			Vtiger_Helper_Js.showConfirmationBox({'message': '<span class="message-medium">' + message + '</span>', className: "test"}).then(
					function (e) {
						var progressIndicatorElement = jQuery.progressIndicator({
							'message': app.vtranslate('JS_SAVE_LOADER_INFO'),
							'position': 'html',
							'blockInfo': {
								'enabled': true
							}
						});
						var params = {};
						params['module'] = container.find('[name="layoutEditorModules"]').val();
						params['status'] = state ? 0 : 1;
						app.saveAjax('setInventory', params).then(function (data) {
							if (data.result) {
								//Settings_Vtiger_Index_Js.showMessage({type: 'success', text: data.result.message});
								window.location.reload();
							}
						});
						//window.location.reload();
					},
					function (error, err) {
						switchBtn.bootstrapSwitch('toggleState', true);
					}
			);

		});
	},
	/**
	 * Function to adding inventory field
	 */
	registerAddInventoryField: function () {
		var thisInstance = this;
		var container = thisInstance.getInventoryViewLayout();
		container.find('.addInventoryField').click(function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var selectedModule = jQuery('#layoutEditorContainer').find('[name="layoutEditorModules"]').val();
			var blockId = currentTarget.closest('.inventoryBlock').data('block-id');
			var progress = jQuery.progressIndicator();
			app.showModalWindow(null, "index.php?module=LayoutEditor&parent=Settings&view=CreateInventoryFields&mode=step1&type=" + selectedModule + "&block=" + blockId, function (modalContainer) {
				app.showScrollBar(modalContainer.find('.well'), {
					height: '300px'
				});
				thisInstance.registerStep1(modalContainer, blockId);
				progress.progressIndicator({'mode': 'hide'});
			});
		});
	},
	/**
	 * Function to editing inventory field
	 */
	registerEditInventoryField: function () {
		var thisInstance = this;
		var container = thisInstance.getInventoryViewLayout();
		container.find('.editInventoryField').on('click', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var selectedModule = jQuery('#layoutEditorContainer').find('[name="layoutEditorModules"]').val();
			var blockId = currentTarget.closest('.inventoryBlock').data('block-id');
			var editField = currentTarget.closest('.editFields');
			var mType = editField.data('name');
			var id = editField.data('id');
			var progress = jQuery.progressIndicator();
			app.showModalWindow(null, "index.php?module=LayoutEditor&parent=Settings&view=CreateInventoryFields&mode=step2&type=" + selectedModule + "&mtype=" + mType + "&id=" + id, function (container) {
				app.showPopoverElementView(container.find('.HelpInfoPopover'));
				thisInstance.registerStep2(container, blockId);
				progress.progressIndicator({'mode': 'hide'});
			});
		});
	},
	/**
	 * Function to adding inventory field first step
	 */
	registerStep1: function (container, blockId) {
		var thisInstance = this;
		container.find('.nextButton').click(function (e) {
			var selectedModule = jQuery('#layoutEditorContainer').find('[name="layoutEditorModules"]').val();
			var type = container.find('select.type').val();
			app.hideModalWindow();
			var progress = jQuery.progressIndicator({
				'position': 'html',
				'blockInfo': {
					'enabled': true
				}
			});
			app.showModalWindow(null, "index.php?module=LayoutEditor&parent=Settings&view=CreateInventoryFields&mode=step2&type=" + selectedModule + "&mtype=" + type, function (modalContainer) {
				thisInstance.registerStep2(modalContainer, blockId);
				progress.progressIndicator({'mode': 'hide'});
			});
		});
	},
	/**
	 * Function to save inventory field
	 */
	registerStep2: function (container, blockId) {
		var thisInstance = this;
		var containerInventory = thisInstance.getInventoryViewLayout();
		var form = container.find('form');
		var selectedModule = jQuery('#layoutEditorContainer').find('[name="layoutEditorModules"]').val();
		form.validationEngine(app.validationEngineOptions);
		form.on('submit', function (e) {
			var formData = form.serializeFormData();
			var paramsName = thisInstance.getParamsInventory();
			if (paramsName) {
				var params = {};
				for (var i in formData) {
					if (jQuery.inArray(i, paramsName) != -1) {
						var value = formData[i];
						if (i === 'modules' && typeof value === 'string') {
							value = [value];
						}
						params[i] = value;
						delete formData[i];
					}
				}
				formData.params = JSON.stringify(params);
			}
			var errorExists = form.validationEngine('validate');
			if (errorExists != false) {
				formData.block = blockId;
				formData.module = selectedModule;
				app.saveAjax('saveInventoryField', formData).then(function (data) {
					var result = data.result;
					if (result && result.edit) {
						app.hideModalWindow();
						var liElement = containerInventory.find('[data-id="' + result.data.id + '"]');
						liElement.find('.fieldLabel').text(result.data.translate);
					} else if (result) {
						app.hideModalWindow();
						var newLiElement = containerInventory.find('.newLiElement').clone(true, true);
						newLiElement.removeClass('hide newLiElement').find('.editFields').attr('data-id', result.data.id).attr('data-sequence', result.data.sequence).attr('data-name', result.data.invtype).attr('data-column', result.data.columnname).find('.fieldLabel').text(result.data.translate);
						containerInventory.find('[data-block-id="' + result.data.block + '"] .connectedSortable').append(newLiElement);

					}
				});
			}
		});
		container.find('form').submit(function (event) {
			event.preventDefault();
		});
	},
	/**
	 * Function to register click event for save button of fields sequence
	 */
	registerInventoryFieldSequenceSaveClick: function () {
		var thisInstance = this;
		var containerInventory = thisInstance.getInventoryViewLayout();
		var selectedModule = jQuery('#layoutEditorContainer').find('[name="layoutEditorModules"]').val();
		containerInventory.on('click', '.saveFieldSequence', function (e) {
			var button = jQuery(e.currentTarget);
			var target = button.closest('.inventoryBlock');
			var params = {};
			var fieldId = [];
			target.find('.editFields').each(function () {
				fieldId.push(jQuery(this).data('id'));
			})
			params.module = selectedModule;
			params.ids = fieldId;
			app.saveAjax('saveSequence', params).then(function (data) {
				button.addClass('invisible');
			});
		});
	},
	/**
	 * removing elements in advanced blocks
	 */
	registerDeleteInventoryField: function () {
		var thisInstance = this;
		var container = thisInstance.getInventoryViewLayout();
		var selectedModule = jQuery('#layoutEditorContainer').find('[name="layoutEditorModules"]').val();
		container.find('.deleteInventoryField').on('click', function (e) {
			var currentTarget = jQuery(e.currentTarget);
			var liElement = currentTarget.closest('li');
			var message = app.vtranslate('JS_DELETE_INVENTORY_CONFIRMATION');
			Vtiger_Helper_Js.showConfirmationBox({'message': message}).then(
					function (e) {
						var progressIndicatorElement = jQuery.progressIndicator({
							'message': app.vtranslate('JS_SAVE_LOADER_INFO'),
							'position': 'html',
							'blockInfo': {
								'enabled': true
							}
						});
						var editFields = liElement.find('.editFields');
						var params = {};
						params.id = editFields.data('id');
						params.module = selectedModule;
						params.name = editFields.data('name');
						params.column = editFields.data('column');
						app.saveAjax('delete', params).then(function (data) {
							liElement.remove();
							Settings_Vtiger_Index_Js.showMessage({type: 'success', text: app.vtranslate('JS_SAVE_CHANGES')});
							progressIndicatorElement.progressIndicator({'mode': 'hide'});

						});
					},
					function (error, err) {
					}
			);
		});
	},
	/**
	 * get inventory params
	 */
	getParamsInventory: function () {
		if (typeof app.getMainParams('params') != 'undefined') {
			return JSON.parse(app.getMainParams('params'));
		}
	},
	/**
	 * Loading list of fields for a related module
	 */
	loadMultiReferenceFields: function (form) {
		var thisInstance = this;
		var module = form.find('[name="MRVModule"]').val();
		form.find('[name="MRVField"],[name="MRVFilterField"]').select2('destroy');
		form.find('[name="MRVField"]').html(thisInstance.cacheMRVField.html());
		form.find('[name="MRVField"] optgroup').each(function (index) {
			if ($(this).data('module') != module) {
				$(this).remove();
			}
		});

		form.find('[name="MRVFilterField"]').html(thisInstance.cacheMRVFilter.html());
		form.find('[name="MRVFilterField"] option').each(function (index) {
			if ($(this).data('module') != module) {
				$(this).remove();
			}
		});

		app.showSelect2ElementView(form.find('[name="MRVField"],[name="MRVFilterField"]'), {width: '100%'});
	},
	cacheMRVField: false,
	cacheMRVFilter: false,
	/**
	 * Loading list of fields for a related module
	 */
	registerMultiReferenceFieldsChangeEvent: function (form) {
		var thisInstance = this;
		thisInstance.cacheMRVField = form.find('[name="MRVField"]').clone(true, true);
		thisInstance.cacheMRVFilter = form.find('[name="MRVFilterField"]').clone(true, true);

		form.find('[name="MRVModule"]').on('change', function (e) {
			thisInstance.loadMultiReferenceFields(form);
		});
	},
	/**
	 * Loading list of fields for a related module
	 */
	registerMultiReferenceFilterFieldChangeEvent: function (form) {
		var thisInstance = this;
		form.find('[name="MRVFilterField"]').on('change', function (e) {
			var params = {};
			params['module'] = app.getModuleName();
			params['parent'] = app.getParentModuleName();
			params['action'] = 'Field';
			params['mode'] = 'getPicklist';
			params['rfield'] = form.find('[name="MRVFilterField"]').val();
			params['rmodule'] = form.find('[name="MRVModule"]').val();

			form.find('[name="MRVFilterValue"]').select2('destroy');
			form.find('[name="MRVFilterValue"] option').remove();
			AppConnector.request(params).then(
					function (data) {
						$.each(data.result, function (index, value) {
							form.find('[name="MRVFilterValue"]').append(
									$('<option>').val(index).html(value)
									);
						});
						app.showSelect2ElementView(form.find('[name="MRVFilterValue"]'), {width: '100%'});
					}
			);
		});
	},
	/**
	 * Register label copy
	 */
	registerCopyClipboard: function (form) {
		new Clipboard('.copyFieldLabel', {
			text: function (trigger) {
				Vtiger_Helper_Js.showPnotify({
					text: app.vtranslate('JS_NOTIFY_COPY_TEXT'),
					type: 'success'
				});
				return form.find('#' + trigger.getAttribute('data-target')).val();
			}
		});
	},
	/**
	 * register events for layout editor
	 */
	registerEvents: function () {
		var thisInstance = this;
		var container = $('#layoutEditorContainer');

		thisInstance.registerBlockEvents();
		thisInstance.registerFieldEvents();
		thisInstance.setInactiveFieldsList();
		thisInstance.registerAddCustomBlockEvent();
		thisInstance.registerFieldSequenceSaveClick();

		thisInstance.relatedModulesTabClickEvent();
		thisInstance.registerModulesChangeEvent();
		thisInstance.registerRelModulesChangeEvent();

		if (1 === jQuery('#relatedTabOrder').length) {
			thisInstance.registerRelatedListEvents();
			thisInstance.makeRelatedModuleSortable();
		}

		thisInstance.registerSwitch();
		thisInstance.registerAddInventoryField();
		thisInstance.registerEditInventoryField();
		thisInstance.registerInventoryFieldSequenceSaveClick();
		thisInstance.registerDeleteInventoryField();
		thisInstance.registerCopyClipboard(container);
	}

});

jQuery(document).ready(function () {
	var instance = new Settings_LayoutEditor_Js();
	instance.registerEvents();
})

Vtiger_WholeNumberGreaterThanZero_Validator_Js("Vtiger_FloatingDigits_Validator_Js", {
	/**
	 *Function which invokes field validation
	 *@param accepts field element as parameter
	 * @return error if validation fails true on success
	 */
	invokeValidation: function (field, rules, i, options) {
		var rangeInstance = new Vtiger_FloatingDigits_Validator_Js();
		rangeInstance.setElement(field);
		var response = rangeInstance.validate();
		if (response != true) {
			return rangeInstance.getError();
		}

	}

}, {
	/**
	 * Function to validate the decimals length
	 * @return true if validation is successfull
	 * @return false if validation error occurs
	 */
	validate: function () {
		var response = this._super();
		if (response != true) {
			return response;
		} else {
			var fieldValue = this.getFieldValue();
			if (fieldValue < 2 || fieldValue > 5) {
				var errorInfo = app.vtranslate('JS_PLEASE_ENTER_NUMBER_IN_RANGE_2TO5');
				this.setError(errorInfo);
				return false;
			}

			var specialChars = /^[+]/;
			if (specialChars.test(fieldValue)) {
				var error = app.vtranslate('JS_CONTAINS_ILLEGAL_CHARACTERS');
				this.setError(error);
				return false;
			}
			return true;
		}
	}
});

Vtiger_WholeNumberGreaterThanZero_Validator_Js("Vtiger_DecimalMaxLength_Validator_Js", {
	/**
	 *Function which invokes field validation
	 *@param accepts field element as parameter
	 * @return error if validation fails true on success
	 */
	invokeValidation: function (field, rules, i, options) {
		var rangeInstance = new Vtiger_DecimalMaxLength_Validator_Js();
		rangeInstance.setElement(field);
		var response = rangeInstance.validate();
		if (response != true) {
			return rangeInstance.getError();
		}
	}

}, {
	/**
	 * Function to validate the fieldLength
	 * @return true if validation is successfull
	 * @return false if validation error occurs
	 */
	validate: function () {
		var response = this._super();
		if (response != true) {
			return response;
		} else {
			var fieldValue = this.getFieldValue();
			var decimalFieldValue = jQuery('#createFieldForm').find('[name="decimal"]').val();
			var fieldLength = parseInt(64) - parseInt(decimalFieldValue);
			if (fieldValue > fieldLength && !(fieldLength < 0) && fieldLength >= 59) {
				var errorInfo = app.vtranslate('JS_LENGTH_SHOULD_BE_LESS_THAN_EQUAL_TO') + ' ' + fieldLength;
				this.setError(errorInfo);
				return false;
			}

			var specialChars = /^[+]/;
			if (specialChars.test(fieldValue)) {
				var error = app.vtranslate('JS_CONTAINS_ILLEGAL_CHARACTERS');
				this.setError(error);
				return false;
			}
			return true;
		}
	}
});

Vtiger_WholeNumberGreaterThanZero_Validator_Js("Vtiger_MaxLength_Validator_Js", {
	/**
	 *Function which invokes field validation
	 *@param accepts field element as parameter
	 * @return error if validation fails true on success
	 */
	invokeValidation: function (field, rules, i, options) {
		var rangeInstance = new Vtiger_DecimalMaxLength_Validator_Js();
		rangeInstance.setElement(field);
		var response = rangeInstance.validate();
		if (response != true) {
			return rangeInstance.getError();
		}
	}

}, {
	/**
	 * Function to validate the fieldLength
	 * @return true if validation is successfull
	 * @return false if validation error occurs
	 */
	validate: function () {
		var response = this._super();
		if (response != true) {
			return response;
		} else {
			var fieldValue = this.getFieldValue();
			if (fieldValue > 255) {
				var errorInfo = app.vtranslate('JS_LENGTH_SHOULD_BE_LESS_THAN_EQUAL_TO') + ' 255';
				this.setError(errorInfo);
				return false;
			}

			var specialChars = /^[+]/;
			if (specialChars.test(fieldValue)) {
				var error = app.vtranslate('JS_CONTAINS_ILLEGAL_CHARACTERS');
				this.setError(error);
				return false;
			}
			return true;
		}
	}
});

Vtiger_Base_Validator_Js("Vtiger_FieldLabel_Validator_Js", {
	/**
	 *Function which invokes field validation
	 *@param accepts field element as parameter
	 * @return error if validation fails true on success
	 */
	invokeValidation: function (field, rules, i, options) {
		var instance = new Vtiger_FieldLabel_Validator_Js();
		instance.setElement(field);
		var response = instance.validate();
		if (response != true) {
			return instance.getError();
		}
	}

}, {
	/**
	 * Function to validate the field label
	 * @return true if validation is successfull
	 * @return false if validation error occurs
	 */
	validate: function () {
		var fieldValue = this.getFieldValue();
		return this.validateValue(fieldValue);
	},
	validateValue: function (fieldValue) {
		var specialChars = /[&\<\>\:\'\"\,\_]/;

		if (specialChars.test(fieldValue)) {
			var errorInfo = app.vtranslate('JS_SPECIAL_CHARACTERS') + " & < > ' \" : , _ " + app.vtranslate('JS_NOT_ALLOWED');
			this.setError(errorInfo);
			return false;
		}
		return true;
	}
});

Vtiger_Base_Validator_Js("Vtiger_PicklistFieldValues_Validator_Js", {
	/**
	 *Function which invokes field validation
	 *@param accepts field element as parameter
	 * @return error if validation fails true on success
	 */
	invokeValidation: function (field, rules, i, options) {
		var instance = new Vtiger_PicklistFieldValues_Validator_Js();
		instance.setElement(field);
		var response = instance.validate();
		if (response != true) {
			return instance.getError();
		}
	}

}, {
	/**
	 * Function to validate the field label
	 * @return true if validation is successfull
	 * @return false if validation error occurs
	 */
	validate: function () {
		var fieldValue = this.getFieldValue();
		return this.validateValue(fieldValue);
	},
	validateValue: function (fieldValue) {
		var specialChars = /(\<|\>)/gi;
		if (specialChars.test(fieldValue)) {
			var errorInfo = app.vtranslate('JS_SPECIAL_CHARACTERS') + " < >" + app.vtranslate('JS_NOT_ALLOWED');
			this.setError(errorInfo);
			return false;
		}
		return true;
	}
});
