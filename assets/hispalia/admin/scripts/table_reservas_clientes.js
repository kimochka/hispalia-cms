var table;
var delegadoYaExiste = false;
var GeneralTable = function () {

    var initClientsSelection = function () {
		
		// var table = $('#general_table');
		table = $('#general_table');
		
		// var delegadoYaExiste = false;

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
            "pageLength": 5,
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

            "tableTools": {
                "sSwfPath": "assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                
                "aButtons": []
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
        
        table.on('click', '.addCliente', function (e) {
            // e.preventDefault();
	        var itemID = $(this).closest("tr").attr("id");
	        
			var isChecked = $(this).is(':checked');
			console.log("IS CHECKED? "+isChecked);
			if(!isChecked){ //checked to unchecked
				//delete client row in selectedClients Table.
				console.log("CLIENTE CLICKADO: "+itemID);
				$('.clickMe_'+itemID).trigger( "click", [ "this" ] );
				return;
			}
			
			$('#evento').prop('disabled', 'disabled');
			
	        var itemNombre = $(this).closest("td").next().text();
	        var itemApellido = $(this).closest("td").next().next().text();
            
            var nRow = $(this).parents('tr')[0];
            
            // $(this).parents('tr')[0].css("background-color", "black");
			if($('#evento').val() != 1) {
		        BootstrapDialog.show({
		        	title: 'Fill information for: ' + itemNombre + ' ' + itemApellido,
		        	closable: false,
		            message: function(dialog) {
		                var $content = $('<div class="portlet-body form">'
						+'<form class="form-horizontal" role="form">'
							+'<div class="form-body">'
								+'<div class="form-group">'
									+'<label class="col-md-3 control-label">Es Delegado?</label>'
									+'<div class="col-md-9">'
										+'<div class="radio-list">'
											+'<label class="radio-inline">'
											+'<input type="radio" name="delegado_question" id="no_es_delegado" value="0" checked="checked"> NO </label>'
											+'<label class="radio-inline">'
											+'<input type="radio" name="delegado_question" id="es_delegado" value="1"> SI </label>'
										+'</div>'
									+'</div>'
								+'</div>'
								+'<div class="form-group">'
									+'<label class="col-md-3 control-label">Client Type</label>'
									+'<div class="col-md-8">'
										+'<select id="clientType" class="form-control">'
											+'<option value="1">Jugador</option>'
											+'<option value="2">No Jugador</option>'
											+'<option value="3">Niñ@</option>'
										+'</select>'
									+'</div>'
								+'</div>'
								+'<div class="form-group">'
									+'<label class="col-md-3 control-label">Room Type</label>'
									+'<div class="col-md-9">'
										+'<select id="roomType" class="form-control">'
											+'<option value="1">Individual</option>'
											+'<option value="2" selected>Doble</option>'
											+'<option value="3">Triple</option>'
										+'</select>'
									+'</div>'
								+'</div>'
							+'</form>'
						+'</div>'
						+'</div>'
						+'<div class="modal-footer">'
							+'<input type="hidden" name="clientID" value="'+ itemID +'"/>'
							+'<button type="button" class="btn red closeButton">Close</button>'
							+'<button type="button" class="btn blue addClientToListButton">Accept</button>'
						+'</div>');
		
				    	$content.find('button.closeButton').click( function(event) {
		                    // action of the button
		                    $("#checkbox_id_"+itemID).prop("checked", false);
		                    $("#checkbox_id_"+itemID).uniform();
		                    // $(".group-checkable").uniform(); // tal vez haga falta para llevar a cabo el mismo cometido
		                    dialog.close();
		                }); 
				    	$content.find('button.addClientToListButton').click( function(event) {
				    		console.log("test");
				    		// console.log(precios);		    		
		 					var clientID = $('input:hidden[name=clientID]').val()
		                    var esDelegadoVal = $("input:radio[name=delegado_question]:checked").val();
		                    var clienteTypeVal = $("#clientType option:selected").attr("value");
		                    var roomTypeVal = $("#roomType option:selected").attr("value");
		                   
		                   	var esDelegadoText = '';
		 					if(esDelegadoVal == "1") {
		 						if(!delegadoYaExiste) {
			 						esDelegadoText = '<i class="fa fa-lg fa-check-square-o"></i>';
									delegadoYaExiste = true;
								}else {
									alert("Este cliente no puede ser delegado. Ya hay uno existente en el grupo.");
			 						return;	
								}
		 					} 
		 					
		                    var clienteTypeText = $("#clientType option:selected").html();
		                    var roomTypeText = $("#roomType option:selected").text(); 
		
		                    // rows = '<tr data-clientId="'+ clientID +'">';
		                    rows = '<tr data-clientId="'+ clientID +'">';
		                    rows += '<td>'+ itemApellido +'</td>';
		                    rows += '<td>'+ itemNombre +'</td>';
		                    rows += '<td class="clickMe_'+clientID+'" onclick="return deleteSelectedClient(this, 0);" >'+ esDelegadoText +'</td>';
		                    rows += '<td>'+ clienteTypeText +'</td>';
		                    rows += '<td>'+ roomTypeText +'</td>';
		                    rows += '</tr>';
		
		                    $('#clientes_pack > tbody:last-child').append(rows);
		                    
		                    updateSummaryEvents();
		                    
		                    dialog.close();
		                });
		                                                           
		                return $content;
			     	}
		     	// ,
	            // buttons: [{
	                // label: 'Title 1',
	                // action: function(dialog) {
	                    // dialog.setTitle('Title 1');
	                // }
	            // }, {
	                // label: 'Title 2',
	                // action: function(dialog) {
	                    // dialog.setTitle('Title 2');
	                // }
	            // }]	     	
				
				});			
            } // end if
            else { //compra sin eventos asociados
                rows = '<tr data-clientId="'+ itemID +'">';
                rows += '<td>'+ itemApellido +'</td>';
                rows += '<td class="clickMe_'+itemID+'" onclick="return deleteSelectedClient(this, 1);">'+ itemNombre +'</td>';
                // rows += '<td class="clickMe_'+itemID+'" onclick="return deleteSelectedClient(this, 1);" >'+ '<i class="fa fa-lg fa-trash"></i>' +'</td>';
                rows += '</tr>';

                $('#clientes_pack > tbody:last-child').append(rows);
            }

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
		
		// /**
		 // * Delete selected rows
		 // */
		// var iDsToDelete = [];
		// $('.deleteSelected').click(function() {
			// if($('.totalItemsSelected.toDelete').text() == '0') return;
            // if (confirm("Borrar "+ $('.totalItemsSelected.toDelete').text() +" items?") == false) {
                // return;
            // }
			// $('input[type="checkbox"]:checked', table.fnGetNodes()).each(function(){
				// console.log($(this).attr('id'));
				// iDsToDelete.push($(this).attr('id'));
				// table.fnDeleteRow( $(this).parents('tr')[0], false );
			// });
			// table.fnDraw();
			// console.log(iDsToDelete);
			// //ajax
			// $.ajax({
		        // type: "POST",
				// url: serverURL + deleteSelectedRowsURL,    
		        // data: { itemsToDelete: iDsToDelete},
		        // dataType: "html",
		        // success: function(response){
		            // $('.totalItemsSelected').text("0");
		            // alert("Borrado Correcto");
		        // },
		        // error: function(response){
	        	// alert('Something went wrong. Click "OK" and "Refresh" the page.');
		        // }
		    // });
		    // iDsToDelete = [];
		// });

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
		
			$('#evento').change(function() {
				var tableClients = ''; 
				var evento_id = $(this).attr("value");
				if(evento_id == 1) { // no event selected
					tableClients = '<thead><tr><th>Surname</th><th>Name</th></tr></thead><tbody></tbody>';
				} else {
					
	                $.ajax({
	                	method: "POST",
	                	dataType: "json",
	                	data: {evento_id: evento_id},
	                	url: serverURL + 'reservas/getPreciosEvento',
						success:function(response, textStatus, jqXHR) {
							// console.log(response);
							precios = response;
							// precios = jQuery.parseJSON('{ "name": "John" }');
							
							}
					});					
					
					tableClients = '<thead><tr><th>Surname</th><th>Name</th><th>Is Delegate</th><th>Is Player</th><th>Room Type</th></tr></thead><tbody></tbody>';
				}
				$('#clientes_pack').html(tableClients);
			});			           
		
        
    }
    
    var initPagos = function () {
        function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }

        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }  
        
        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        } 
    	
		$( ".buttonAddPago" )
            .button()
            .click(function() {
                // $( "#dialog-form" ).dialog( "open" );

		        BootstrapDialog.show({
		        	title: 'Fill Payment Information: ',
		        	closable: false,
		            message: function(dialog) {
		                var $content = $('<div class="portlet-body form">'
					+'<form class="form-horizontal" role="form">'
						+'<div class="form-body">'
							+'<div class="form-group">'
								+'<label class="col-md-3 control-label">Payment Method</label>'
								+'<div class="col-md-8">' 
									+'<select id="pagoType" class="form-control">' // Si se cambia alguna opcion, asegurarse que viene cambiado en el DDBB, table tipo_pagos
										// +'<option value="1">Check</option>'
										// +'<option value="2">Cash</option>'
										// +'<option value="3">Bank Transfer</option>'
										// +'<option value="4">Credit Card</option>'
										// +'<option value="5">Paypal</option>'
										+tipo_pagos
									+'</select>'
								+'</div>'
							+'</div>'
							+'<div class="form-group">'
								+'<label class="col-md-3 control-label">Amount (€)</label>'
								+'<div class="col-md-9">'
									+'<input type="text" name="pagoCantidad" />'
								+'</div>'
							+'</div>'
							+'<div class="form-group">'
								+'<label class="col-md-3 control-label">Concept</label>'
								+'<div class="col-md-8">'
									+'<input type="text" name="pagoConcepto" />'
								+'</div>'
							+'</div>'										
						+'</form>'
					+'</div>'
					+'</div>'
					+'<div class="modal-footer">'
						+'<button type="button" class="btn red closeButton">Close</button>'
						+'<button type="button" class="btn blue acceptPagoButton">Accept</button>'
					+'</div>');
		
			    	$content.find('button.closeButton').click( function(event) {
		                // action of the button
		                dialog.close();
		            }); 
			    	$content.find('button.acceptPagoButton').click( function(event) {
		                // var esDelegadoVal = $("input:radio[name=delegado_question]:checked").val();
		               
		               	var pagoCantidad = $("input:text[name=pagoCantidad]");
		                var pagoCantidadVal = $("input:text[name=pagoCantidad]").attr("value");
		                
		               	var bValid = true;
		               	$("input:text[name=pagoCantidad]").removeClass('ui-state-error');
		               	bValid = bValid && checkLength( pagoCantidad, "pagoCantidad", 1, 10 );
						bValid = bValid && checkRegexp( pagoCantidad, /^([0-9.0])+$/i, "Payments may consist of 0-9, ir/racionales." );
		               	if ( bValid ) {
			                var pagoTypeVal = $("#pagoType option:selected").attr("value");
			                var pagoConceptoVal = $("input:text[name=pagoConcepto]").attr("value");
			                var pagoTypeText = $("#pagoType option:selected").html();
			
			                // rows = '<tr data-clientId="'+ clientID +'">';
			                row = '<tr>';
			                row += '<td data-pay-method="'+pagoTypeVal+'">'+ pagoTypeText +'</td>';
			                row += '<td>'+ pagoCantidadVal +'</td>';
			                row += '<td>'+ pagoConceptoVal +'</td>';
			                row += '<td>'+ '<a href="#" class="fa fa-lg fa-trash-o" onclick="return deletePago(this);" title="Delete Payment"></a>' + '</td>'; 
			                row += '</tr>';
			
			                $('#pagos > tbody:last-child').append(row);
			                
			                updateSummaryPayments();
			                
			                dialog.close();
		               	}
		            });
		                                                       
		            return $content;
		     	}    	
		    });
		});  
    }

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initClientsSelection();
            
            initPagos();
        }

    };
    

}();

	function deleteSelectedClient(obj, type){
		// var string = '<div class="checker" id="uniform-checkbox_id_115"><span><input type="checkbox" class="checkboxes addCliente" id="checkbox_id_115"></span></div>';
        // table.api().cell('#checkbox_td_id_115').data(string).draw().uniform();
        
        if(type == 0) { //An Event has been linked to this booking
	        isDelegado = $(obj).children().length;
			
			if(isDelegado == "1") {
				delegadoYaExiste = false;
			}
	        $(obj).parent().remove();
			// console.log("DELEGADO EXISTE YA: "+delegadoYaExiste);
			updateSummaryEvents();
		}
		if(type == 1) { //No Events Linked to this booking. Only products.
			$(obj).parent().remove();
			updateSummaryProducts();
		}
		return false;		
	}
	
	function updateSummaryPayments() {
		
		temp = 0;
		pricePaymentsTotal = 0;
		$("#pagos tbody tr").each(function (i, row) {
			temp = Number($(row).find('td:eq(1)').text());
			// console.log(temp);
			pricePaymentsTotal += Number(temp.toFixed(2));
		});
		$("#paymentsTotal").html(Number(temp.toFixed(2)));

		calcularBalance();
	}	
	
	function updateSummaryProducts() {
		
		temp = 0;
		priceProductsTotal = 0;
		$("#productos tbody tr").each(function (i, row) {
			temp = Number($(row).find('td:eq(4)').text());
			console.log(temp);
			priceProductsTotal += Number(temp.toFixed(2));
		});
		$("#priceProductTotal").html(Number(priceProductsTotal.toFixed(2)));
		
		// console.log("PRODUCTO TOTAL: " + priceProductsTotal);
		
		calcularBalance();
	}
	
	function updateSummaryEvents() {
		// $('#clientes_pack > tbody:last-child').append(rows);
		
		var contPlayers = 0;
		var contNoPlayers = 0;
		var contSingleSuppl = 0;
		
		console.log(precios);
		
		$("#pricePlayer").html(precios.jugador);
		$("#priceNoPlayer").html(precios.no_jugador);
		$("#priceSingleSuppl").html(precios.suplemento_individual);
		
		$("#clientes_pack tbody tr").each(function (i, row) {
			//Player
			var temp = $(row).find('td:eq(3)').text();
			if(temp == 'Jugador') contPlayers++;
			if(temp == 'No Jugador') contNoPlayers++;
			
			var temp = $(row).find('td:eq(4)').text();
			if(temp == 'Individual') contSingleSuppl++;
		});
		
		$("#contPlayer").html(contPlayers);
		$("#contNoPlayer").html(contNoPlayers);
		$("#contSingleSuppl").html(contSingleSuppl);	

		$("#pricePlayerTotal").html(Number(precios.jugador) * Number(contPlayers));
		$("#priceNoPlayerTotal").html(Number(precios.no_jugador) * Number(contNoPlayers));
		$("#priceSingleSupplTotal").html(Number(precios.suplemento_individual) * Number(contSingleSuppl));	
		
		priceEventTotal = (Number(precios.jugador) * Number(contPlayers)) + (Number(precios.no_jugador) * Number(contNoPlayers)) + (Number(precios.suplemento_individual) * Number(contSingleSuppl));
		$("#priceEventTotal").html(priceEventTotal.toFixed(2));
		
		calcularBalance();
		
	}
	
	function calcularBalance()
	{
		var priceProductTotal = Number($("#priceProductTotal").html().replace(/[^0-9\.]+/g,""));
		var priceEventTotal = Number($("#priceEventTotal").html().replace(/[^0-9\.]+/g,""));
		var paymentsTotal = Number($("#paymentsTotal").html().replace(/[^0-9\.]+/g,""));
		
		// var balance = priceProductTotal + priceEventTotal - paymentsTotal;
		var balance = paymentsTotal - (priceProductTotal + priceEventTotal);
		$("#balanceTotal").html(balance.toFixed(2));
		
		if(balance < 0) {
			$("#balanceTotal").parent().attr("class", "").addClass("label label-danger");
		} else {
			$("#balanceTotal").parent().attr("class", "").addClass("label label-info");
		}
	}

	//To delete
	function deleteSelectedClient_test(obj){
		//TODO: Search for its value on the big customer table. Unckeck the row checkbox.

		//TODO: look it is a delegate. If its a delegate, reset var delegadoYaExiste to false;
		// $(obj).closest("tr")[0];
		var itemID = $(obj).closest("tr").attr("data-clientId");
		// console.log(itemID);
		
		console.log(table.api().rows('#'+itemID+':first-child').data());
		// console.log($('#'+itemID, table.fnGetNodes() )[0]);
		console.log($('#'+itemID, table.api().rows().nodes()));
		console.log($(table.api().rows().nodes()).filter('#'+itemID)[0]);
		
		var test1 = $(table.api().rows().nodes()).filter('#'+itemID)[0];
		var td = $(test1).children().first();
		var test2 = table.api().cell($(test1).children().first());
		
		table.api().cell($('#checkbox_id_'+itemID)).data("test");
		
		var cell = table.api().cell($('#checkbox_id_'+itemID));
		var string = '<div class="checker" id="uniform-checkbox_id_'+itemID+'"><span><input type="checkbox" class="checkboxes addCliente" checked="false" id="checkbox_id_'+itemID+'"></span></div>';
		cell.data("dddddddddd test").draw();
		// console.log(cell.data(string).draw());
		
		// table//on('click', '#checkbox_id_'+itemID, function (e) {
			// .find('#checkbox_id_'+itemID)
			// .prop("checked", false)
			// .uniform();
			// $(this).prop("checked", false);
			// $(this).uniform();
       // }); 
		
    	// $("#checkbox_id_"+itemID).prop("checked", false);
        // $("#checkbox_id_"+itemID).uniform();
        isDelegado = $(obj).parent().prev().prev().prev().children().length;
		
		if(isDelegado == "1") {
			delegadoYaExiste = false;
		}
        
        $(obj).closest("tr")[0].remove();
        
		// console.log("DELEGADO EXISTE YA: "+delegadoYaExiste);
		return false;
	}
	
	function deletePago(obj){
		$(obj).closest("tr")[0].remove();
		updateSummaryPayments();
		return false;
	}	
