/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/


jQuery.Class('Vtiger_BasicSearch_Js', {}, {
	//stores the module that need to be searched
	searchModule: false,
	//stores the module that need to be searched which is selected by the user
	currentSearchModule: false,
	// reduce the number of results
	reduceNumberResults: false,
	// Should the result be in html
	returnHtml: true,
	// Main conatiner with modules, value and buttons
	mainConatiner: false,
	/**
	 * Function to get the search module
	 */
	getSearchModule: function () {
		if (this.searchModule === false) {
			//default gives current module
			var module = app.getModuleName();
			if (typeof this.getCurrentSearchModule() != 'undefined') {
				module = this.getCurrentSearchModule();
			}

			this.setSearchModule(module);
		}
		return this.searchModule;
	},
	/**
	 * Function to set the search module
	 */
	setSearchModule: function (moduleName) {
		this.searchModule = moduleName;
		return this;
	},
	/**
	 * Function to set main conatainer 
	 */
	setMainContainer: function (container) {
		this.mainConatiner = container;
		return this;
	},
	/**
	 * Function to get the user selected search module
	 */
	getCurrentSearchModule: function () {
		if (this.currentSearchModule === false && this.mainConatiner) {
			this.currentSearchModule = this.mainConatiner.find('.basicSearchModulesList').val();
		}
		return this.currentSearchModule;
	},
	/**
	 * Function which will perform the search
	 */
	_search: function (params) {
		var aDeferred = jQuery.Deferred();

		if (typeof params == 'undefined') {
			params = {};
		}

		params.view = 'BasicAjax';
		params.mode = 'showSearchResults';
		params.limit = this.reduceNumberResults;
		params.html = this.returnHtml;
		if(this.mainConatiner.find('input[data-operator]').length && this.mainConatiner.find('input[data-operator]').data('operator') != ''){
			params.operator = this.mainConatiner.find('input[data-operator]').data('operator');
		}
		if (typeof params.module == 'undefined') {
			params.module = app.getModuleName();
			//if you are in Settings then module should be Vtiger for normal text search
			if (app.getParentModuleName().length > 0) {
				params.module = 'Vtiger';
			}
		}
		AppConnector.request(params).then(
				function (data) {
					aDeferred.resolve(data);
				},
				function (error, err) {
					aDeferred.reject(error);
				}
		);
		return aDeferred.promise();
	},
	/**
	 * Helper function whicn invokes search
	 */
	search: function (value) {
		var searchModule = this.getCurrentSearchModule();
		var params = {};
		params.value = value;
		if (typeof searchModule != 'undefined') {
			params.searchModule = searchModule;
		}
		params.curentModule = app.getModuleName();
		return this._search(params);
	},
	/**
	 * Function which shows the search results
	 */
	showSearchResults: function (data) {
		var aDeferred = jQuery.Deferred();
		var postLoad = function (data) {
			var body = jQuery(data).find('.contents');
			//app.showScrollBar(body,{'height':'600px','railVisible':'true'});
			aDeferred.resolve(data);
		};
		var params = {};
		params.data = data;
		params.cb = postLoad;
		app.showModalWindow(params);
		return aDeferred.promise();
	}

});

