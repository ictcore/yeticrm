/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */
jQuery.Class('Vtiger_FileUpload_Js', {}, {
	formElement: false,
	save: function (form) {
		var aDeferred = jQuery.Deferred();
		var formData = new FormData(form[0]);
		var params = {
			url: "file.php",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false
		};
		AppConnector.request(params).then(
				function (data) {
					aDeferred.resolve(data);
				},
				function (textStatus, errorThrown) {
					aDeferred.reject(textStatus, errorThrown);
				}
		);
		return aDeferred.promise();
	},
	getForm: function () {
		if (this.formElement == false) {
			this.formElement = jQuery('form#fileUploadForm');
		}
		return this.formElement;
	},
	updateForm: function (data) {
		var input = $('#' + app.getModuleName() + "_editView_fieldName_" + data.result['field']);
		var ids = [];
		$.each(data.result['attach'], function (index, value) {
			ids.push(value.id);
			var html = value.name + '&nbsp;<span class="btn btn-danger btn-xs multiImageDelete glyphicon glyphicon-trash" data-id="' + value.id + '"></span>';
			$('<div class="multiImageContenDiv row col-xs-12 marginTop2">').html(html).appendTo("#fileResult" + data.result['field']);
		});
		var newValues = ids.concat(JSON.parse("[" + input.val().replace(/(^,)|(,$)/g, "") + ']'));
		input.val(',' + newValues.toString() + ',');
	},
	registerUploadFiles: function () {
		var thisInstance = this;
		var container = jQuery('#modalFileUpload');
		var fileElement = container.find('input#fileupload');
		var maxFileSize = parseInt(container.find('.maxUploadFileSize').val());
		var submitBtn = container.find('button[type="submit"]');
		var template = container.find('.fileContainer');
		var uploadContainer = container.find('.uploadFileContainer');
		fileElement.change(function () {
			uploadContainer.find('.fileItem').remove();
			var files = fileElement[0].files;
			for (var i = 0; i < files.length; i++) {
				if (files[i].size > maxFileSize) {
					alert(app.vtranslate('JS_FILE_EXCEEDS_MAX_UPLOAD_SIZE'));
					fileElement.val('');
					submitBtn.prop('disabled', true);
					break;
				}
				uploadContainer.append(template.html());
				uploadContainer.find('[name="nameFile[]"]:last').val(files[i].name);
			}
			if (files.length) {
				submitBtn.prop('disabled', false);
			} else {
				submitBtn.prop('disabled', true);
			}
		});
		this.getForm().on('submit', function (e) {
			var form = jQuery(e.currentTarget);
			var progressIndicatorElement = jQuery.progressIndicator({
				position: 'html',
				blockInfo: {
					enabled: true
				}
			});
			app.hideModalWindow();
			thisInstance.save(form).then(function (data) {
				thisInstance.updateForm(data);
				progressIndicatorElement.progressIndicator({'mode': 'hide'})
			});
			e.preventDefault();
		});
		fileElement.trigger('click');
	},
	registerEvents: function () {
		this.registerUploadFiles();
	}
});

jQuery(document).ready(function (e) {
	var instance = new Vtiger_FileUpload_Js();
	instance.registerEvents();
})
