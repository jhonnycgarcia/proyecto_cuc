$(document).ready(function() {

    var _table = $('#list').DataTable({
		    	"oLanguage": { 
					"oPaginate": { 
								"sPrevious": "Anterior", 
								"sNext": "Siguiente", 
								"sLast": "Ultima", 
								"sFirst": "Primera" 
					}, 
					"sLengthMenu": 'Mostrar <select class="form-control input-sm" >'+ 
									'<option value="10">10</option>'+ 
									'<option value="20">20</option>'+ 
									'<option value="30">30</option>'+ 
									'<option value="40">40</option>'+ 
									'<option value="50">50</option>'+ 
									'<option value="-1">Todos</option>'+ 
									'</select> registros',

					"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)", 

					"sInfoFiltered": " - filtrados de _MAX_ registros", 

					"sInfoEmpty": "No hay resultados de búsqueda", 

					"sZeroRecords": "No hay registros a mostrar", 

					"sProcessing": "Espere, por favor...", 

					"sSearch": "Buscar: ", 

				} 
		    });

		_table.columns( '.select-filter' ).every( function () {
		    var that = this;
		 	
		    // Create the select list and search operation
		    var select = $('<br><select class="" />')
		        .appendTo(
		            // this.footer()
		            // this.header()
		            this.header()

		        )
		        .on( 'change', function () {
		            that
		                .search( $(this).val() )
		                .draw();
		        } );
		 
		    // Get the search data for the first column and add to the select list
		    this
		        .cache( 'search' )
		        .sort()
		        .unique()
		        .each( function ( d ) {
		            select.append( $('<option value="'+d+'">'+d+'</option>') );
		        } );
		} );

		_table.columns( '.input-filter').every( function(){
			var that = this;

			var input = $('<br><input class="" type="text">')
				.appendTo(
					this.header()
				)
				.on('keyup change', function() {
		            if ( that.search() !== this.value ) {
                		that
	                    .search( this.value )
	                    .draw();
           			}
				} );

		});

} );