var TableNewGrupo = function () {

    var initTable = function () {

		var table = $('#general_table');

        $.extend(true, $.fn.DataTable.TableTools.classes, {
            "container": "btn-group tabletools-btn-group pull-right",
            "buttons": {
                "normal": "btn btn-sm default",
                "disabled": "btn btn-sm default disabled"
            }
        });

        // begin: third table
        table.dataTable({
            	/*
            "columns": [{
        		// "orderable": false,
        		"sSortDataType": "dom-checkbox"
    			}, {
        			"orderable": true
	            }, {
	                "orderable": true
	            }, {
	                "orderable": true
	            }, {
	                "orderable": true
	            }, {
	                "orderable": true
	            }, {
	                "orderable": true
	            }, {
	                "orderable": true
	            }, {
	                "orderable": true
	            }, {
	                "orderable": true
	            }, {
	                "orderable": false                                                                                
	            }],
                  */  	
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,
            "language": {
                "lengthMenu": " _MENU_ records"
            },
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': orderableTargets
            }, {
        		"sSortDataType": "dom-checkbox", //Used for making checkbox orderable
                'targets': [0]
            } , {
                "searchable": false,
                "targets": searchableTargets
            }],
            
            "order": [
                [1, "asc"]
            ], // set first column as a default sort by asc
            
            "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
			// "dom": "<'toolbar'>frtip",
			"sDom": 'T<"clear">lfrtip',
        	"oTableTools": {
            	"sRowSelect": "multi"
        	},
            "tableTools": {
                "sSwfPath": "assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": []
            }
        });

        var tableWrapper = jQuery('#general_table_wrapper');

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

		// Mark/unmark clicked rows
	    $('#general_table tbody').on( 'click', 'tr', function () {
	    	// console.log(table.rows('.selected').data());
	        $(this).toggleClass('selected');
			var cId = $(this).attr('id');
			var cSurname = $('td:first-child', $(this)).text();
			var cName = $('td:nth-child(2)', $(this)).text();
			console.log(cId);
			console.log(cSurname);
			console.log(cName);
	        
	        if($(this).hasClass('selected')) {
	        	// console.log("ID selected: "+cId);
				//Input Usado para visualizar lista clientes en tabulacion 3
				$('<input>').attr({
				    type: 'hidden',
				    id: 'client_name_'+cId,
				    name: 'clients_name[]',
				    value: cSurname+', '+cName,
				}).appendTo('#submit_form');
				
				// Input usado para relevar la lista id de los clientes cuando se envia el form
				$('<input>').attr({
				    type: 'hidden',
				    id: 'client_id_'+cId,
				    name: 'clients_id[]',
				    value: cId,
				}).appendTo('#submit_form');				
	        }
	        else {
	        	// console.log("ID deselected: "+cId);
					$("#client_name_"+cId).detach();
					$("#client_id_"+cId).detach();
	       	}
	       
			// $('table.dataTable tbody tr.selected').each(function(){
			// });
	        
	    } );
		
    }

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().DataTable) {
                return;
            }
            initTable();
        }

    };

}();