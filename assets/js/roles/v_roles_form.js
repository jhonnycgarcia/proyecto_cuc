$(document).ready(function() {
	
	$("#form_roles").validate({
		rules : {
			rol : {
				required : true,
				minlength : 3
			}
		}
	});
});