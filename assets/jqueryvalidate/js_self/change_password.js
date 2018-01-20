$(document).ready(function(){

      $("#change_password").validate({

        rules:{
          old_password:{
            required : true,
            minlength : 3,
            maxlength : 6
          },
          new_password:{
            required : true,
            minlength : 3,
            maxlength : 6
          },
          confirm_password:{
            required : true,
            minlength : 3,
            maxlength : 6,
            equalTo: "#new_password"
          }
        },

        messages:{
          old_password:{
            required:'El campo es requerido',
            minlength:'El campo debe tener un minimo de 3 caracteres'
          },
          new_password:{
            required:'El campo es requerido',
            minlength:'El campo debe tener un minimo de 3 caracteres',
            maxlength:'El campo debe tener un maximo de 6 caracteres'
          },
          confirm_password:{
            required:'El campo es requerido',
            minlength:'El campo debe tener un minimo de 3 caracteres',
            maxlength:'El campo debe tener un maximo de 6 caracteres',
            equalTo: 'Ingrese la misma contraseña'
          }
        }

      }); 

} );