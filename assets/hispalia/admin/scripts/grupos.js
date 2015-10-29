/**
 Groups script to handle Hispalia groups page
**/
var Grupos = function () {

    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
            
            $("#paises").select2({
                placeholder: "-- Select --",
                allowClear: true,
                escapeMarkup: function (m) {
                    return m;
                }
            });
            
            $("#provincias").select2({
                placeholder: "-- Select --",
                allowClear: true,
                escapeMarkup: function (m) {
                    return m;
                }
            });
            $("#evento").select2({
                placeholder: "-- Select --",
                allowClear: true,
                escapeMarkup: function (m) {
                    return m;
                }
            });
            $("#delegado").select2({
                placeholder: "-- Select --",
                allowClear: true,
                escapeMarkup: function (m) {
                    return m;
                }
            });            

			$('#paises').change(function() {
				rellenarProvincia();
			});

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
                    nombre: {
                        minlength: 5,
                        required: true
                    },
                    provincia: {
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
                    success.show();
                    error.hide();
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
	                $.ajax({
	                	type: "POST",
	                	url: serverURL + '/grupos/salvar_grupo',
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
					                + '<div><button class="btn addNewGroup btn-primary"><i class="icon-user-follow"></i> ' + buttonAddNew + '</button></div>'
					                + '</br>'
					                + '<div><button class="btn modifyGroup btn-primary"><i class="fa fa-edit"></i> ' + buttonModifyCurrent + '</button></div>'
					                + '</br>'
					                + '<div><button class="btn groupsTable btn-primary"><i class="fa fa-table"></i> ' + buttonViewAll + '</button></div>'
					                + '</br>'
					                + '<div><button class="btn goHome btn-alert"><i class="fa fa-home"></i> Home</button></div>');
					                $content.find('button.addNewGroup').click( function(event) {
					                    window.location.replace(serverURL + dialogAddNewLink);
					                });
					                $content.find('button.modifyGroup').click( function(event) {
					                    window.open(serverURL + buttonModifyCurrentURL + obj.clientID);
					                });
					                $content.find('button.groupsTable').click( function(event) {
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
            	
            	
                $('#tab3 .form-control-static', form).each(function(){
                	
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
                alert('Finished! Hope you like it :)');
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




