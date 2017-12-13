/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */
jQuery(document).ready(function ($) {
    $('#tabs').tab();
    $('#pills').tab();
    
    // modal is greyed out if z-index is low
    $("#myModal").css("z-index", "9999999");
    $("#myRegisterModal").css("z-index", "9999999");
    
    // Hide modal if "Okay" is pressed
    $('#myModal .okay-button').click(function() {
        var disabled = $('#confirm').attr('disabled');
        if(typeof disabled == 'undefined') {
            $('#myModal').modal('hide');
            $('#delete #EditView').submit();
        }
    });
    $('#myRegisterModal .okay-button').click(function() {
		var disabled = $('#confirmRegistration').attr('disabled');
        if(typeof disabled == 'undefined') {
            $('#myRegisterModal').modal('hide');
        }
    });
    
    // enable/disable confirm button
    $('#status').change(function() {
        $('#confirm').attr('disabled', !this.checked);
    });
    $('#confirmRegistration').click(function() {
        $('#register_changes').prop("checked", $('#statusRegistration').prop("checked"));
    });
	$('#register_changes').click(function(){
		app.showModalWindow($('#myRegisterModal'));
	});
});
