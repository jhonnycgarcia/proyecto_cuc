        (function ($) {

            var session = {
                inactiveTimeout: 3000,              // tiempo para mostrar el mensaje de alerta
                warningTimeout: 5000,               // tiempo para esperar respuesta de la notificacion
                warningStart: null,                 // fecha del tiempo en que comenzo el conteo
                warningTimer: 5000,                 // el tiempo que transcurre por segundo antes del logout Timer running every second to countdown to logout
                sessionSecondsRemaining: 0,         // tiempo para esperar del segundo conteo
                logout: function () {       //Logout function once warningTimeout has expired
                        //window.location = settings.autologout.logouturl;
                        console.log('cierre de session');
                    },
            }


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

                console.log('Usuario inactivo diff = '+diff+' / warning ='+warning+' / warningStart ='+session.warningStart+' / sessionSecondsRemaining = '+session.sessionSecondsRemaining);

                // realizar cuenta regresiva para el cierre de sesion
                session.warningTimer = setInterval(function () {
                    var remaining = Math.round( (session.warningTimeout / 1000) - ( ( (+new Date() ) - session.warningStart) / 1000) );
                    console.log('cuenta regresiva = '+remaining);
                    if( remaining >= 0){
                        console.log('mostrar ultima ventana');
                    }else{
                        session.logout();
                        clearInterval(session.warningTimer);
                        $( document ).idleTimer("destroy");
                        window.location.replace(_base_url+'/salir');
                    }
                },1000);

            });


            $(document).on("active.idleTimer", function (event, elem, obj) {
                console.log('Usuario Activo');
            });

            //inicializar contador
            $(document).idleTimer(session.inactiveTimeout);
        })(jQuery);