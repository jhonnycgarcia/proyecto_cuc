// (function (e) {
//     // console.log(e);
    
// })(jQuery);

// $(window).load(function() {
//  console.log("cargando vista");
//  alert("cargando vista");
// });

$(document).ready(function() {
    var _config = {
        tema : null,
        timeMaxEsp : 0
    }

    get_config();   // run

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
            _estatus = true;
            // console.log(e);
            _config.tema = e.tema_template;
            // console.log(_config);
            refresh();  // run
        })
        .fail(function(e) {
            console.log("error");
            console.log(e);
        })
        .always(function() {
            // console.log("complete");
            if( _estatus == false ){
                alert('Ocurrio un inconveniente al momento de cargar las librerias necesarias para la ejecucion de este proyecto, favor comuniquese con el WEBMASTER para solventar este inconveniente');
            }
        });
    }


    function refresh(){
        var _item_class = get_class_element();
        _item_class = to_array(_item_class);
        _item_class = capture_class(_item_class);

        // console.log(_config);
        if( _item_class != _config.tema && _config.tema != null ){
            // console.log(_item_class);
            // change_class(_item_class,_config.tema);
        }

    }

    function check_class(clase){
        if( $("body").hasClass(clase)){return true;
        }else{ return false; }
    }

    function change_class(oldc,newc){
        $("body").removeClass(oldc);
        $("body").addClass(newc);
    }

    /**
     * Funcion para obtener la clase del elemento
     * @return {[type]} [description]
     */
    function get_class_element(){
        var _item = $("body").attr('class');
        return _item;
    }

    /**
     * Funcion para convertir en array un string
     * @param  {[string]} _class [description]
     * @return {[array]}        [description]
     */
    function to_array(_class){
        _class = _class.split(" ");
        return _class;
    }

    /**
     * Funcion para capturar la clase existente y retornarla como string
     * @param  {[type]} _class [description]
     * @return {[type]}        [description]
     */
    function capture_class(_class){
        var _ans = false;
        for (var i = _class.length - 1; i >= 0; i--) {
            if( _class[i].indexOf("skin") > -1 ){ return _class[i]; }
        }
        return _ans;
    }

});