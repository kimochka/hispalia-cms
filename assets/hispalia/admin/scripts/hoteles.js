/**
Hoteles script to handle Hispalia hoteles page
**/
var Hoteles = function () {

  	
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

}();




