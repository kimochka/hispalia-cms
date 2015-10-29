/**
 Reservas script to handle Hispalia bookings page
**/
var Reservas = function () {
  
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
            getEventos();
            // $("#paises").select2({
                // placeholder: "-- Select --",
                // allowClear: true,
                // escapeMarkup: function (m) {
                    // return m;
                // }
            // });
            // $("#provincias").select2({
                // placeholder: "-- Select --",
                // allowClear: true,
                // escapeMarkup: function (m) {
                    // return m;
                // }
            // });
            
            // $("#evento").select2({
                // placeholder: "-- Select --",
                // allowClear: true,
                // escapeMarkup: function (m) {
                    // return m;
                // }
            // });

			function getEventos() {
	            $.ajax({
	            	method: "POST",
	            	dataType: "json",
	            	url: serverURL + 'reservas/getEventos',
					success:function(response, textStatus, jqXHR) {
						eventosTipo(response);
					}
				});
			}
				
			
			function eventosTipo(data) {
					
				var select = $('#evento');
				
				if(select.prop) {
					var options = select.prop('options');
				} else {
					var options = select.attr('options');
				}
				$('option', select).remove();
							
				console.log(data);
					
	            $.each(data, function(value, key) {
	            	console.log("value: "+value);
	            	console.log("key: "+key);
	                if (value == 0) {
	                    options[options.length] = new Option(key, "", false);
	                } else {
	                    options[options.length] = new Option(key, value);
	                }
				});
			}			
//---------


			$('#paises').change(function() {
				rellenarProvincia();
			});
			
 
 
         $( "#dialog:ui-dialog" ).dialog( "destroy" );
        
        var concepto = $( "#concepto" ),
            unidades = $( "#unidades" ),
            precio_unidad = $( "#precio_unidad" ),
            allFields = $( [] ).add( concepto ).add( unidades ).add( precio_unidad ),
            tips = $( ".validateTips" );
            
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
    		
       $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 450,
            width: 450,
            modal: true,
            buttons: {
                "Add product...": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );

                    bValid = bValid && checkLength( concepto, "concepto", 1, 120 );
                    bValid = bValid && checkLength( unidades, "unidades", 1, 10 );
                    bValid = bValid && checkLength( precio_unidad, "precio_unidad", 1, 10 );
                    
                    bValid = bValid && checkRegexp( unidades, /^([0-9])+$/i, "Unidades may consist of whole numbers within the interval 0-9" );
                    bValid = bValid && checkRegexp( precio_unidad, /^([0-9.0])+$/i, "Precio por Unidad may consist of 0-9, ir/racionales." );
                    
                    
                    if ( bValid ) {
                        $( "#productos tbody" ).append( "<tr>" +
                            "<td>" + concepto.val() + "</td>" + 
                            "<td>" + unidades.val() + "</td>" + 
                            "<td>" + precio_unidad.val() + "</td>" +
                            "<td>" + (precio_unidad.val() * unidades.val()) + "</td>" +
                            "<td><a href='#' class='fa fa-lg fa-trash-o' onclick='return deleteProduct(this);' title='Delete Product'></a></td>" +
                        "</tr>" );
                        
                        $( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });  
        // $( "#create-user" )
        // $( ".buttonAddProduct" )
            // .button()
            // .click(function() {
                // $( "#dialog-form" ).dialog( "open" );
            // });  		

		$( ".buttonAddProduct" )
            .button()
            .click(function() {
		        BootstrapDialog.show({
		        	title: 'Fill Product Information: ',
		        	closable: false,
		            message: function(dialog) {
		                var $content = $('<div class="portlet-body form">'
					+'<form class="form-horizontal" role="form">'
						+'<div class="form-body">'
							+'<div class="form-group">'
								+'<label class="col-md-3 control-label">Product Type</label>'
								+'<div class="col-md-8">'
									+'<select id="productType" class="form-control">'
										+ tipo_productos
									+'</select>'
								+'</div>'
							+'</div>'
							+'<div class="form-group">'
								+'<label class="col-md-3 control-label">Concept</label>'
								+'<div class="col-md-9">'
									+'<input type="text" name="productConcept" />'
								+'</div>'
							+'</div>'
							+'<div class="form-group">'
								+'<label class="col-md-3 control-label">Units</label>'
								+'<div class="col-md-8">'
									+'<input type="text" name="productUnits" />'
								+'</div>'
							+'</div>'
							+'<div class="form-group">'
								+'<label class="col-md-3 control-label">Price / Unit (€)</label>'
								+'<div class="col-md-8">'
									+'<input type="text" name="productPrice" />'
								+'</div>'
							+'</div>'																	
						+'</form>'
					+'</div>'
					+'</div>'
					+'<div class="modal-footer">'
						+'<button type="button" class="btn red closeButton">Close</button>'
						+'<button type="button" class="btn blue acceptProductButton">Accept</button>'
					+'</div>');
		
			    	$content.find('button.closeButton').click( function(event) {
		                // action of the button
		                dialog.close();
		            }); 
			    	$content.find('button.acceptProductButton').click( function(event) {
		               	var productConcept = $("input:text[name=productConcept]");
		               	var productUnits = $("input:text[name=productUnits]");
		               	var productPrice = $("input:text[name=productPrice]");

		                
		               	var bValid = true;
		               	productConcept.removeClass('ui-state-error');
		               	productUnits.removeClass('ui-state-error');
		               	productPrice.removeClass('ui-state-error');
		               	
	                    bValid = bValid && checkLength( productConcept, "productConcept", 1, 120 );
	                    bValid = bValid && checkLength( productUnits, "productUnits", 1, 10 );
	                    bValid = bValid && checkLength( productPrice, "productPrice", 1, 10 );
	                    
	                    bValid = bValid && checkRegexp( productUnits, /^([0-9])+$/i, "Unidades may consist of whole numbers within the interval 0-9" );
	                    bValid = bValid && checkRegexp( productPrice, /^([0-9.0])+$/i, "Precio por Unidad may consist of 0-9, ir/racionales." );
                    
		               	
		               	if ( bValid ) {
		                var productTypeVal = $("#productType option:selected").attr("value");
		                var productTypeText = $("#productType option:selected").html();
			
			                // rows = '<tr data-clientId="'+ clientID +'">';
			                row = '<tr>';
			                row += '<td data-product-type="'+productTypeVal+'"">'+ productTypeText +'</td>';
			                row += '<td>'+ productConcept.val() +'</td>';
			                row += '<td>'+ productUnits.val() +'</td>';
			                row += '<td>'+ productPrice.val() +'</td>';
			                row += '<td>'+ (productPrice.val() * productUnits.val()) +'</td>';
			                row += '<td>'+ '<a href="#" class="fa fa-lg fa-trash-o" onclick="return deleteProduct(this);" title="Delete Product"></a>' + '</td>'; 
			                row += '</tr>';
			
			                $('#productos > tbody:last-child').append(row);
			                
			                updateSummaryProducts();
			                
			                dialog.close();
		               	}
		            });
		                                                       
		            return $content;
		     	}    	
		    });
		});      		
    		/*
    		$(".buttonAddProduct").click(function() {
					        BootstrapDialog.show({
					        	title: 'Add Product',
					        	closable: false,
					            message: function(dialog) {
					                var $content = $('<div><span>'+obj.dialogInfoResponse+' Cómo proceder?</span></div>'
					                + '</br>'
					                + '<div><button class="btn addNewReserva btn-primary"><i class="icon-user-follow"></i> ' + buttonAddNew + '</button></div>'
					                + '</br>'
					                + '<div><button class="btn modifyReserva btn-primary"><i class="fa fa-edit"></i> ' + buttonModifyCurrent + '</button></div>'
					                + '</br>'
					                + '<div><button class="btn reservasTable btn-primary"><i class="fa fa-table"></i> ' + buttonViewAll + '</button></div>'
					                + '</br>'
					                + '<div><button class="btn goHome btn-alert"><i class="fa fa-home"></i> Home</button></div>');
					                $content.find('button.addNewReserva').click( function(event) {
					                    window.location.replace(serverURL + dialogAddNewLink);
					                });
					                $content.find('button.modifyReserva').click( function(event) {
					                    window.open(serverURL + buttonModifyCurrentURL + obj.clientID);
					                });
					                $content.find('button.reservasTable').click( function(event) {
					                    window.location.replace(serverURL + buttonControllerURL);
					                });       
					                $content.find('button.goHome').click( function(event) {
					                    window.location.replace(serverURL);
					                });                                              
					                return $content;
					            }
					        });				
			});
			*/

            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
            
            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {            
                    //account
                    evento: {
                        required: true
                    },
                    provincia: {
                    	required: true
                    },
                    nombre: {
                        minlength: 5,
                        required: true
                    }                    
              	},
              	
                 errorPlacement: function (error, element) {  // render error placement for each input type
                        error.insertAfter(element); // for other inputs, just perform default behavior
                 },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    Metronic.scrollTo(error, -200);
                },
                
                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },                          

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                }, 

                success: function (label) {
               		label
                  		.addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                },
                
                submitHandler: function (form) {

                    
                    //Parsar tabla productos
                    products_Type = [];			// Array para Tipo Producto
                    products_Concept = [];		// Array para Concepto
                    products_Units = [];		// Array para Numero de Unidades
                    products_PricePerUnit = [];	// Array para precio por unidad
                    $('#productos tbody tr').each(function (i, row) {
                		products_Type.push($(this).find('td:eq(0)').attr('data-product-type'));
                		products_Concept.push($(this).find('td:eq(1)').html());
                		products_Units.push($(this).find('td:eq(2)').html());
                		products_PricePerUnit.push($(this).find('td:eq(3)').html());
                    });
                    
                    //Parsar tabla pagos
                    pagos_Method = [];			// Array para metodo de pago
                    pagos_Import = [];		// Array para Cantidad 
                    pagos_Concept = [];		// Array para Concepto
                    $('#pagos tbody tr').each(function (i, row) {
                		pagos_Method.push($(this).find('td:eq(0)').attr('data-pay-method'));
                		pagos_Import.push($(this).find('td:eq(1)').html());
                		pagos_Concept.push($(this).find('td:eq(2)').html());
                    });                    
                    
                    //Parsar tabla clientes_pack
                    selectedClients = [];
                    selectedClients_Delegate = [];
                    selectedClients_ClientType = [];
                    selectedClients_RoomType = [];
                    $('#clientes_pack tbody tr').each(function (i, row) {
                    	// console.log($(this).attr('data-clientid'));
                    	selectedClients.push($(this).attr('data-clientid'));
                    	
                    	if($('#evento').val() != 1) {
                    		// Columna Delegado
                    		if($(this).find('td:eq(2)').html() == '') selectedClients_Delegate.push(0);
                    		else selectedClients_Delegate.push(1);
                    		
                    		// Columna Tipo Cliente en el evento
                    		if($(this).find('td:eq(3)').html() == 'No Jugador') selectedClients_ClientType.push(0);
                    		if($(this).find('td:eq(3)').html() == 'Jugador') 	selectedClients_ClientType.push(1);
                    		if($(this).find('td:eq(3)').html() == 'Kid') 		selectedClients_ClientType.push(2);
                    		
                    		if($(this).find('td:eq(4)').html() == 'Individual') selectedClients_RoomType.push(1);
                    		if($(this).find('td:eq(4)').html() == 'Doble') 		selectedClients_RoomType.push(2);
                    		if($(this).find('td:eq(4)').html() == 'Triple') 	selectedClients_RoomType.push(3);
                    	}
                    });
                    // console.log(selectedClients);
                    
                    //if no product 
                    console.log($('#evento').val());
                    console.log(products_Type);
                    if(jQuery.isEmptyObject(products_Type) && $('#evento').val() == '1') {
                    	alert('Neither products or events have been selected');
                    	error.show();
                    	return false;
                    }
                    if(jQuery.isEmptyObject(selectedClients)) {
                    	alert('No client has been selected');
                    	error.show();
                    	return false;                    	
                    }                	
                    success.show();
                    error.hide();
                    	
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
	                $.ajax({
	                	type: "POST",
	                	url: serverURL + 'reservas/salvar_reserva',
	                	data: {
	                		evento_id: $('#evento').val(),
	                		// Tabla clientes
	           				sc_clientsId: selectedClients,
	                		sc_Delegate: selectedClients_Delegate,
	                		sc_ClientType: selectedClients_ClientType,
	                		sc_RoomType: selectedClients_RoomType,
	                		
	                		// Tabla Productos
		                    prod_Type: products_Type,					// Array para Tipo Producto
		                    prod_Concept: products_Concept,				// Array para Concepto
		                    prod_Units: products_Units,				// Array para Numero de Unidades
		                    prod_PricePerUnit: products_PricePerUnit,	// Array para precio por unidad	        
		                    
		                    // Tabla Pagos
		                    pa_Method: pagos_Method,			// Array para Tipo Producto
		                    pa_Import: pagos_Import,			// Array para Concepto
		                    pa_Concept: pagos_Concept,			// Array para precio por unidad	   		                            		
	                	},
						success:function(response, textStatus, jqXHR) {
	                		var obj = $.parseJSON(response);
				        	console.log(obj);
					        BootstrapDialog.show({
					        	title: 'Information',
					        	closable: false,
					            message: function(dialog) {
					                var $content = $('<div><span>'+obj.dialogInfoResponse+' Cómo proceder?</span></div>'
					                + '</br>'
					                + '<div><button class="btn addNewReserva btn-primary"><i class="icon-user-follow"></i> ' + buttonAddNew + '</button></div>'
					                + '</br>'
					                + '<div><button class="btn modifyReserva btn-primary"><i class="fa fa-edit"></i> ' + buttonModifyCurrent + '</button></div>'
					                + '</br>'
					                + '<div><button class="btn reservasTable btn-primary"><i class="fa fa-table"></i> ' + buttonViewAll + '</button></div>'
					                + '</br>'
					                + '<div><button class="btn goHome btn-alert"><i class="fa fa-home"></i> Home</button></div>');
					                $content.find('button.addNewReserva').click( function(event) {
					                    window.location.replace(serverURL + buttonAddNewURL);
					                });
					                $content.find('button.modifyReserva').click( function(event) {
					                    window.open(serverURL + buttonModifyCurrentURL + obj.compraID);
					                });
					                $content.find('button.reservasTable').click( function(event) {
					                    window.location.replace(serverURL + buttonControllerURL);
					                });       
					                $content.find('button.goHome').click( function(event) {
					                    window.location.replace(serverURL);
					                });                                              
					                return $content;
					            }
					        });
	                	},
						error: function(jqXHR, textStatus, errorThrown) {
							//if fails
							BootstrapDialog.alert('Error! El Item no pudo ser salvado.');
						}
	                });
			    	return false; // required to block normal submit since you used ajax
            	}
			});
			
			
			var rellenarProvincia = function() {
		
				$.post("/clientes_ajax/getProvincias_3", {paises:$('#paises').val()},
				
				function(data) {
					
					var select = $('#provincias');
					
					if(select.prop) {
						var options = select.prop('options');
					} else {
						var options = select.attr('options');
					}
					
					$('option', select).remove();
									
		            $.each(data, function(value, key) {
		                if (value == 0) {
		                    options[options.length] = new Option(key, "", false);
		                } else {
		                    options[options.length] = new Option(key, value);
		                }
					});
				}, 'json');
				
			}
				
			//TODO: rellenar
            var displayConfirm = function() {
            	var i = 0;
            	
            	console.log("HIDDEN ELEMENTS : "+$("input:hidden").length); // LOS CUENTA
            	// var clients = [];
                // $('input:hidden', form).each(function(){
	            	// console.log("ELEMENTO ATTRIBUTE: "+$(this).attr("data-display"))
                	// if($(this).attr("data-display") == 'clients')
	            		// console.log( "encontrado");
	            		// clients.push($(this));
            	// });
            	
            	
                $('#tab4 .form-control-static', form).each(function(){
                	
                	// console.log("COUNTER: "+i); // 9 sin clientes
                	// i++;
                	
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                   	// } else if(input.is(":hidden")) {
                   	}
                   	if($(this).attr("data-display") == 'clients_name') {
                   		console.log("ENCONTRADO");
                   		var clients = [];
                   		$('[name="clients_name[]"]').each(function(){
                   		clients.push($(this).val());
                   		});
                   		$(this).html(clients.join("<br>"));
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                        
                    } else if ($(this).attr("data-display") == 'payment') {
                        var payment = [];
                        $('[name="payment[]"]:checked').each(function(){
                            payment.push($(this).attr('data-title'));
                        });
                        $(this).html(payment.join("<br>"));
                    }
                });
            }
            
            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                Metronic.scrollTo($('.page-title'));
           	}
           	
            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });           	  

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
                // alert('Finished! Hope you like it :)');
                form.submit();
            }).hide();
		}
	};
			           
	
	if ($("input[name$='action']").val() == "newInsert") {
		// alert($("input[name$='action']").val());		
		rellenarProvincia();
	}
	// else alert("no enchotrado");
	
	

}();

	function deleteProduct(obj){
		$(obj).closest("tr")[0].remove();
		updateSummaryProducts();
		return false;
	}
	
	function viewPagos(compra_id){
		$.ajax({
        	method: "POST",
        	dataType: "html",
        	url: serverURL + 'reservas/getPagos',
        	data: {compra_id: compra_id},
			success:function(response, textStatus, jqXHR) {
		        BootstrapDialog.show({
		        	title: 'Payments info: ',
		        	closable: false,
		            message: function(dialog) {
		                var $content = $('<div class="portlet grey-cascade box">'
						+'<div class="portlet-title">'
							+'<div class="caption">'
								+'<i class="fa fa-cogs"></i>Pagos'
							+'</div>'
							+'<div class="actions">'
								+'<a href="#" class="btn btn-default btn-sm buttonAddPago">'
								+'<i class="fa fa-plus"></i> Add Pago</a>'															
							+'</div>'
						+'</div>'
						+'<div class="portlet-body">'
							+'<div class="table-responsive">'
								+'<table id="pagos" class="table table-hover table-bordered table-striped">'
								+'<thead>'
								+'<tr>'
									+'<th>'
										+' Método'
									+'</th>'
									+'<th>'
										+'Cantidad'
									+'</th>'
									+'<th>'
										+'Concepto'
									+'</th>'
									+'<th>Action</th>'
								+'</tr>'
								+'</thead>'
								+'<tbody>');

								$content += '</tbody>'
								+'</table>'
							+'</div>'
						+'</div>'
					+'</div>'
					+'<div class="modal-footer">'
						+'<button type="button" class="btn red closeButton">Close</button>'
						+'<button type="button" class="btn blue acceptProductButton">Accept</button>'
					+'</div>';
		
			    	$content.find('button.closeButton').click( function(event) {
		                dialog.close();
		            }); 
			    	$content.find('button.acceptButton').click( function(event) {
			           	dialog.close();
		            });
		                                                       
		            return $content;
		     	}    	
		    });
			}
		});	    
		
	}




