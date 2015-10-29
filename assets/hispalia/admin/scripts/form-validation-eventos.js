var FormValidation = function () {

	var handleEventoValidation = function() {

        var formEvento = $('#formEvento');
        var errorEvento = $('.alert-danger', formEvento);
        var successEvento = $('.alert-success', formEvento);

        //IMPORTANT: update CKEDITOR textarea with actual content before submit
        // formEvento.on('submit', function() {
            // for(var instanceName in CKEDITOR.instances) {
                // CKEDITOR.instances[instanceName].updateElement();
            // }
        // });
		
		
        formEvento.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                nombre: {
                    minlength: 4,
                    required: true
                },
				provincias: {
					required: true
				},
				hotel: {
					required: true
				},				
				precio_jugador: {
					required: true
				},
				precio_no_jugador: {
					required: true
				},
				precio_nino: {
					required: true
				},
				precio_suplemento_individual: {
					required: true
				},
				tipo_evento: {
					required: true
				}
            },

			// messages: { // custom messages for radio buttons and checkboxes
			// },

			errorPlacement: function (error, element) { // render error placement for each input type
            	if (element.parent(".input-group").size() > 0) {
                	error.insertAfter(element.parent(".input-group"));
                } else if (element.attr("data-error-container")) { 
                    error.appendTo(element.attr("data-error-container"));
                } else if (element.parents('.radio-list').size() > 0) { 
                    error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                } else if (element.parents('.radio-inline').size() > 0) { 
                    error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                // } else if (element.parents('.checkbox-list').size() > 0) {
                    // error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                // } else if (element.parents('.checkbox-inline').size() > 0) { 
                    // error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                successEvento.hide();
                errorEvento.show();
                Metronic.scrollTo(errorEvento, -200);
            },

			highlight: function (element) { // hightlight error inputs
            	$(element)
					.closest('.form-group').addClass('has-error'); // set error class to the control group
			},

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                successEvento.show();
                errorEvento.hide();
                // Normal Submit
                //form.submit();
                
                $.ajax({
                	type: "POST",
                	url: serverURL + buttonControllerURL+'/salvar_evento',
                	data: $(form).serialize(),
						success:function(response, textStatus, jqXHR) {
                		var obj = $.parseJSON(response);
			        	// alert(obj.eventoID);
				        BootstrapDialog.show({
				        	title: 'Information',
				        	closable: false,
				            message: function(dialog) {
				                var $content = $('<div><span>'+obj.dialogInfoResponse+' Cómo proceder?</span></div>'
				                + '</br>'
				                + '<div><button class="btn addNewEvento btn-primary"><i class="icon-user-follow"></i> ' + buttonAddNew + '</button></div>'
				                + '</br>'
				                + '<div><button class="btn modifyEvento btn-primary"><i class="fa fa-edit"></i> ' + buttonModifyCurrent + '</button></div>'
				                + '</br>'
				                + '<div><button class="btn eventoTable btn-primary"><i class="fa fa-table"></i> ' + buttonViewAll + '</button></div>'
				                + '</br>'
				                + '<div><button class="btn goHome btn-alert"><i class="fa fa-home"></i> Home</button></div>');
				                $content.find('button.addNewEvento').click( function(event) {
				                    window.location.replace(serverURL + buttonAddNewURL);
				                });
				                $content.find('button.modifyEvento').click( function(event) {
				                    window.open(serverURL + buttonModifyCurrentURL + obj.eventoID);
				                });
				                $content.find('button.eventoTable').click( function(event) {
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
        }); // form.validate END
		
		//initialize datepicker
		// $('.date-picker').datepicker({
			// rtl: Metronic.isRTL(),
			// autoclose: true
		// });
		// $('.date-picker .form-control').change(function() {
			// formEvento.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
		// })
    }	    	
	    	
    return {

        //main function to initiate the module
        init: function () {
			
        	handleEventoValidation();
        	
        }

    };

}();