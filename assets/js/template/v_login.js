        (function ($) {

            var _config = {
                inactiveTimeout : 0
                ,warningTimeout : 0
                ,warningTimer :0
                ,sessionSecondsRemaining : 0
            }

            var session = {
                inactiveTimeout: 3000,              // tiempo para mostrar el mensaje de alerta por inactividad
                warningTimeout: 5000,               // tiempo para esperar respuesta de la notificacion
                warningStart: null,                 // fecha del tiempo en que comenzo el conteo
                warningTimer: 5000,                 // el tiempo que transcurre por segundo antes del logout Timer running every second to countdown to logout
                sessionSecondsRemaining: 0,         // tiempo para esperar del segundo conteo
                logout: function () {       //Logout function once warningTimeout has expired
                        // console.log('cierre de session');
                        window.location.replace(_base_url+'/salir');
                    }
            }


        /**
         * Funcion para obtener la configuracion del sistema
         * @return {[type]} [description]
         */
        function get_config(){
            var _estatus = false;
            $.ajax({
                url: _base_url+'Template/config_template',
                dataType: 'JSON'
            })
            .done(function(e) {
                // console.log("success");
                // console.log(e);
                session.inactiveTimeout = e.tiempo_max_inactividad;
                session.warningTimeout = e.tiempo_max_alerta;
                session.warningTimer = e.tiempo_max_espera;
                // console.log(session);
                clearTimeout(session.warningTimer);
                // console.log(_config);
            })
            .fail(function(e) {
                console.log("error");
                // console.log(e);
            })
            .always(function() {
                // console.log("complete");
            });
        }

            get_config();




            // Al detectar la inactividad
            $(document).on("idle.idleTimer", function (event, elem, obj) {
                // Obtener el tiempo de inactividad del usuario
                var
                    diff = (+new Date()) - obj.lastActive - obj.timeout,
                    warning = (+new Date()) - diff
                ;
                // capturar fecha de inicio del monitoreo
                session.warningStart = (+new Date()) - diff;                                                           
                // capturar el numero de segundos de espera requeridos para el segundo mensaje de alerta
                session.sessionSecondsRemaining = Math.round( (session.warningTimeout / 1000) - ( ( (+new Date() ) - session.warningStart) / 1000) );

                // console.log('Usuario inactivo diff = '+diff+' / warning ='+warning+' / warningStart ='+session.warningStart+' / sessionSecondsRemaining = '+session.sessionSecondsRemaining);

                // realizar cuenta regresiva para el cierre de sesion
                session.warningTimer = setInterval(function () {
                    var remaining = Math.round( (session.warningTimeout / 1000) - ( ( (+new Date() ) - session.warningStart) / 1000) );
                    // console.log('cuenta regresiva = '+remaining);
                    if( remaining >= 0){
                        // console.log('mostrar ultima ventana');
                    }else{
                        session.logout();
                        clearInterval(session.warningTimer);
                        $( document ).idleTimer("destroy");
                    }
                },1000);

            });


            $(document).on("active.idleTimer", function (event, elem, obj) {
                // console.log('Usuario Activo');
                clearTimeout(session.warningTimer);
            });

            //inicializar contador
            $(document).idleTimer(session.inactiveTimeout);
        })(jQuery);