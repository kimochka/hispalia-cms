var FormValidation = function () {

	var handleClientValidation = function() {

        var formClient = $('#formClient');
        var errorClient = $('.alert-danger', formClient);
        var successClient = $('.alert-success', formClient);

        //IMPORTANT: update CKEDITOR textarea with actual content before submit
        // formClient.on('submit', function() {
            // for(var instanceName in CKEDITOR.instances) {
                // CKEDITOR.instances[instanceName].updateElement();
            // }
        // });

        formClient.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                nombre: {
                    minlength: 4,
                    required: true
                },
                apellido: {
                    minlength: 4,
                    required: true
                },
                email: {
					email: true
				},
				telefono: {
					number: true
                },
				movil: {
					number: true
                },
				genero: {
                	required: true
				},
				provincias: {
					required: true
				},
				group_name: {
                	required: true
				}
            },

			messages: { // custom messages for radio buttons and checkboxes
				genero: {
					required: "Please select a Gender type"
				}
			},

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
                successClient.hide();
                errorClient.show();
                Metronic.scrollTo(errorClient, -200);
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
                successClient.show();
                errorClient.hide();
                // Normal Submit
                //form.submit();
                
                $.ajax({
                	type: "POST",
                	url: serverURL + buttonControllerURL+'/salvar_cliente',
                	data: $(form).serialize(),
						success:function(response, textStatus, jqXHR) {
                		var obj = $.parseJSON(response);
			        	// alert(obj.clientID);
				        BootstrapDialog.show({
				        	title: 'Information',
				        	closable: false,
				            message: function(dialog) {
				                var $content = $('<div><span>'+obj.dialogInfoResponse+' Cómo proceder?</span></div>'
				                + '</br>'
				                + '<div><button class="btn addNewClient btn-primary"><i class="icon-user-follow"></i> ' + buttonAddNew + '</button></div>'
				                + '</br>'
				                + '<div><button class="btn modifyClient btn-primary"><i class="fa fa-edit"></i> ' + buttonModifyCurrent + '</button></div>'
				                + '</br>'
				                + '<div><button class="btn clientsTable btn-primary"><i class="fa fa-table"></i> ' + buttonViewAll + '</button></div>'
				                + '</br>'
				                + '<div><button class="btn goHome btn-alert"><i class="fa fa-home"></i> Home</button></div>');
				                $content.find('button.addNewClient').click( function(event) {
				                    window.location.replace(serverURL + buttonAddNewURL);
				                });
				                $content.find('button.modifyClient').click( function(event) {
				                    window.open(serverURL + buttonModifyCurrentURL + obj.clientID);
				                });
				                $content.find('button.clientsTable').click( function(event) {
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
		$('.date-picker').datepicker({
			rtl: Metronic.isRTL(),
			autoclose: true
		});
		$('.date-picker .form-control').change(function() {
			formClient.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
		})
    }	    	
	    	
    return {

        //main function to initiate the module
        init: function () {
			
        	handleClientValidation();
        }

    };

}();