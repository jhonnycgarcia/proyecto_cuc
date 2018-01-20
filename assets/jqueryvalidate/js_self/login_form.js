$(document).ready(function(){
    var _submit = false;

      $("#form_login").validate({
        onsubmit: _submit,

        rules:{
          username:{
            required : true,
            minlength : 3
          },
          password:{
            required : true,
            minlength : 3,
            maxlength : 6
          }
        },

        success: function(label) {
          var _username = $("#username").val();

          if( _username == 'jgarciac' ) {
            _submit = true;
          }else{
            alert('Usuario no administrador.');
          }
        }


      });
} );