(function ($) {
            var
                session = {
                    //Logout Settings
                    inactiveTimeout: 10000,     //(ms) The time until we display a warning message
                    warningTimeout: 10000,      //(ms) The time until we log them out
                    minWarning: 5000,           //(ms) If they come back to page (on mobile), The minumum amount, before we just log them out
                    warningStart: null,         //Date time the warning was started
                    warningTimer: 5000,         //Timer running every second to countdown to logout
                    logout: function () {       //Logout function once warningTimeout has expired
                        //window.location = settings.autologout.logouturl;
                        $("#mdlLoggedOut").modal("show");
                    },

                    //Keepalive Settings
                    keepaliveTimer: null,
                    keepaliveUrl: "",
                    keepaliveInterval: 5000,     //(ms) the interval to call said url
                    keepAlive: function () {
                        $.ajax({ url: session.keepaliveUrl });
                    }
                }
            ;


            $(document).on("idle.idleTimer", function (event, elem, obj) {
                //Get time when user was last active
                var
                    diff = (+new Date()) - obj.lastActive - obj.timeout,
                    warning = (+new Date()) - diff
                ;
                
                //On mobile js is paused, so see if this was triggered while we were sleeping
                if (diff >= session.warningTimeout || warning <= session.minWarning) {
                    $("#mdlLoggedOut").modal("show");
                } else {
                    //Show dialog, and note the time
                    $('#sessionSecondsRemaining').html(Math.round((session.warningTimeout - diff) / 1000));
                    $("#myModal").modal("show");
                    session.warningStart = (+new Date()) - diff;

                    //Update counter downer every second
                    session.warningTimer = setInterval(function () {
                        var remaining = Math.round((session.warningTimeout / 1000) - (((+new Date()) - session.warningStart) / 1000));
                        if (remaining >= 0) {
                            $('#sessionSecondsRemaining').html(remaining);
                        } else {
                            session.logout();
                            clearInterval(session.warningTimer);
                        }
                    }, 1000)
                }
            });

            // create a timer to keep server session alive, independent of idle timer
            session.keepaliveTimer = setInterval(function () {
                session.keepAlive();
            }, session.keepaliveInterval);

            //User clicked ok to extend session
            $("#extendSession").click(function () {
                clearTimeout(session.warningTimer);
            });
            //User clicked logout
            $("#logoutSession").click(function () {
                session.logout();
            });

            //Set up the timer, if inactive for 10 seconds log them out
            $(document).idleTimer(session.inactiveTimeout);
        })(jQuery);