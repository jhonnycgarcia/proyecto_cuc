    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Session Expiration Warning</h4>
                </div>
                <div class="modal-body">
                    <p>You've been inactive for a while. For your security, we'll log you out automatically. Click "Stay Online" to continue your session. </p>
                    <p>Su sesion expirara en <span class="bold" id="sessionSecondsRemaining">5</span> segundos</p>
                </div>
                <div class="modal-footer">
                    <button id="extendSession" type="button" class="btn btn-default btn-success" data-dismiss="modal">Permanecer</button>
                    <button id="logoutSession" type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdlLoggedOut" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">You have been logged out</h4>
                </div>
                <div class="modal-body">
                    <p>Your session has expired.</p>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>