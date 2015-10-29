var GeneralTable = function () {

	var format = function ( d ) {
		console.log(d);
		console.log(d[0]);
		return d[9];
		// '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
			// '<tr>'+
				// '<td>Full name:</td>'+
				// '<td>'+d.name+'</td>'+
			// '</tr>'+
			// '<tr>'+
				// '<td>Extension number:</td>'+
				// '<td>'+d.extn+'</td>'+
			// '</tr>'+
			// '<tr>'+
				// '<td>Extra info:</td>'+
				// '<td>And any further details here (images etc)...</td>'+
			// '</tr>'+
		// '</table>';
	}

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
        	// "ajax": serverURL+"grupos/getGroups",
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
            "columnDefs": [
            // { set default column settings
            	// 'className': 'details-control',
            	// 'targets': [0]
            // },
            {  
                'orderable': false,
                'targets': orderableTargets
            }, {
        		"sSortDataType": "dom-checkbox", //Used for making checkbox orderable
                'targets': [1]
            } , {
                "searchable": false,
                "targets": searchableTargets
            } ,
            // {
                // "visible": false,
            	// "targets": [ 9 ]
            // }
            ],
            
            "order": [
                [1, "asc"]
            ], // set first column as a default sort by asc
            
            "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            "tableTools": {
                "sSwfPath": "assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                
                "aButtons": [{
                    "sExtends":    "collection",
                    "sButtonText": "Save As...",
                    "aButtons":    [{
	                    "sExtends": "pdf",
	                    "sButtonText": "PDF",
	                    "mColumns": visibleColumnsToExport,
	                    "oSelectorOpts": {
			                page: 'current'
			            }
	                }, {
	                    "sExtends": "csv",
	                    "sButtonText": "CSV",
	                    "mColumns": visibleColumnsToExport,
	                    "oSelectorOpts": {
			                page: 'current'
			            }
	                }, {
	                    "sExtends": "xls",
	                    "sButtonText": "Excel",
	                    "mColumns": visibleColumnsToExport,
	                    "oSelectorOpts": {
			                page: 'current'
			            }
	                }]                	
                } , {
                    "sExtends": "print",
                    "sButtonText": "Print",
                    "sInfo": 'Please press "CTR+P" to print or "ESC" to quit',
                    "oSelectorOpts": {
		                page: 'current'
		            }
                },]
            }
        });

        var tableWrapper = jQuery('#general_table_wrapper');

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

	    // Add event listener for opening and closing details
	    // $('#general_table tbody')
	    table.on('click', 'td.details-control', function () {
	    	// alert('ddd');
	        var tr = $(this).closest('tr');
	        var row = table.api().row( tr );
	 
	        if ( row.child.isShown() ) {
	            // This row is already open - close it
	            row.child.hide();
	            tr.removeClass('shown');
	        }
	        else {
	            // Open this row
	            row.child( format(row.data()) ).show();
	            tr.addClass('shown');
	        }
	    } );
            
        table.on('click', '.deleteButton', function (e) { 
            e.preventDefault();

            if (confirm(deleteConfirm) == false) {
                return;
            }
	        // var itemID = $(this).parent().attr(attributeID);
	        var itemID = $(this).parent().attr("id");
            
            var nRow = $(this).parents('tr')[0];
            table.fnDeleteRow(nRow);
            table.fnDraw();
			$.ajax({
	            type: "POST",
				url: serverURL + deleteRowURL,    
	            data: { id: itemID},
	            dataType: "html",
	            success: function(response){
	                alert("Borrado Correcto");
	            },
	            error: function(response){
	            	alert('Something went wrong. Click "OK" and "Refresh" the page.');
	            }
	        });
        });        

       	table.on('click', '.modifyButton', function (e) {
            e.preventDefault();
			window.location.href = serverURL + modifyItemURL +  $(this).parent().attr('id');
        });
        
        // table.on('click', '.viewGroupClients', function (e) { 
// 
	        // // var itemID = $(this).parent().attr(attributeID);
	        // console.log($(this).attr("group"));
    		// var itemID = $(this).attr("group");
//             
            // var nRow = $(this).parents('tr')[0];
            // table.fnDeleteRow(nRow);
            // table.fnDraw();
			// $.ajax({
	            // type: "POST",
				// url: serverURL + viewGroupClientsRowURL,    
	            // data: { group_id: itemID},
	            // dataType: "html",
	            // success: function(response){
	                // // alert("estoy dentro kim");
	                // // $("#dialog_content").html(response);
	                // $('#ajax').modal('show'); 
	            // },
	            // error: function(response){
	            	// alert('Something went wrong. Click "OK" and "Refresh" the page.');
	            // }
	        // });
            // e.preventDefault();
        // }); 
        
        $('body').on('hidden.bs.modal', '.modal', function () {
		  $(this).removeData('bs.modal');
		});

		/** Cuenta el numero de Checboxes seleccionados a cada click de un checkbox 
		 * y añade al badge del boton ".totalItemsSelected"
		 */ 
		var contadorSeleccionados = 0;
       	table.on('click', '.checkboxes', function (e) {
			$('input[type="checkbox"]:checked', table.fnGetNodes()).each(function(){
				contadorSeleccionados++;
			});
			$('.totalItemsSelected').text(contadorSeleccionados);
			contadorSeleccionados = 0;
		});
       	table.on('click', '.group-checkable', function (e) {
			$('input[type="checkbox"]:checked', table.fnGetNodes()).each(function(){
				contadorSeleccionados++;
			});
			$('.totalItemsSelected').text(contadorSeleccionados);
			contadorSeleccionados = 0;
		});
		
		/**
		 * Delete selected rows
		 */
		var iDsToDelete = [];
		$('.deleteSelected').click(function() {
			if($('.totalItemsSelected.toDelete').text() == '0') return;
            if (confirm("Borrar "+ $('.totalItemsSelected.toDelete').text() +" items?") == false) {
                return;
            }
			$('input[type="checkbox"]:checked', table.fnGetNodes()).each(function(){
				console.log($(this).attr('id'));
				iDsToDelete.push($(this).attr('id'));
				table.fnDeleteRow( $(this).parents('tr')[0], false );
			});
			table.fnDraw();
			console.log(iDsToDelete);
			//ajax
			$.ajax({
		        type: "POST",
				url: serverURL + deleteSelectedRowsURL,    
		        data: { itemsToDelete: iDsToDelete},
		        dataType: "html",
		        success: function(response){
		            $('.totalItemsSelected').text("0");
		            alert("Borrado Correcto");
		        },
		        error: function(response){
		        	alert('Something went wrong. Click "OK" and "Refresh" the page.');
		        }
		    });
		    iDsToDelete = [];
		});

		/**
		 * Read information from a column of checkboxes (input elements with type
		 * checkbox) and return an array to use as a basis for sorting.
		 *
		 *  @summary Sort based on the checked state of checkboxes in a column
		 *  @name Checkbox data source
		 *  @author [Allan Jardine](http://sprymedia.co.uk)
		 *  @URL1: https://datatables.net/plug-ins/sorting/custom-data-source/dom-checkbox
		 *  @URL2: http://datatables.net/beta/1.7/examples/plug-ins/dom_sort.html
		 */
		$.fn.dataTable.ext.order['dom-checkbox'] = function  ( settings, col )
		{
			return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
				return $('input', td).prop('checked') ? '0' : '1';
			} );
		};
        
    }

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable();
        }

    };

}();