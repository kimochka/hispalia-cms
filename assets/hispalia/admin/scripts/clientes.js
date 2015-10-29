/**
Clientes script to handle Hispalia clientes page
**/
var Clientes = function () {
	
	// $( "#datepicker" ).datepicker({
		// update: '01-01-1950'
		// changeYear: true,
		// yearRange: 'c-100:cc',
	// });
  	
	$(function() {
		$("input#nombre").autocomplete({
			source: function(request, response) {
				$.ajax({
					url: autocompleteNombreURL,
					data: { nombre: $("#nombre").val()},
					dataType: "json",
					type: "POST",
					success: function(data){
						response(data);
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
			    var str = ui.item.label;
			    var desired = str.split('.');
			    window.location = autocompleteModifcarURL + desired[0];
			}
		});
	});
	
	$(function() {
		$("input#apellido").autocomplete({
			source: function(request, response) {
				$.ajax({
					url: autocompleteApellidoURL,
					data: { apellido: $("#apellido").val()},
					dataType: "json",
					type: "POST",
					success: function(data){
						response(data);
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
			    var str = ui.item.label;
			    var desired = str.split('.');
			    window.location = autocompleteModifcarURL + desired[0];
			}
		});
	});

	function rellenarProvincia() {

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
	
	if ($("input[name$='action']").val() == "newInsert") {
		// alert($("input[name$='action']").val());		
		rellenarProvincia();
	}
	// else alert("no enchotrado");
	
	$('#paises').change(function() {
		rellenarProvincia();
	});

	/*
	$("input[name$='group_name']").click(function(){
			
			var radio_value = $(this).val();
 
 			if(radio_value=='Yes') {
			$("#delegados_box").show("slow");
		}
		else if(radio_value=='No') {
			$("#delegados_box").hide();
		}
	});

	$("#delegados_box").hide();
	*/
}();




