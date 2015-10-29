var Eventos = function () {
	
	function fillHotelsSelect(id, type) {
		// if(type == 0) { // pais
			console.log("cambio pais: "+ id);
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "/hoteles_ajax/getHoteles",
				data:{
					id: id,
					type: type
				},
				success: function(data, textStatus) {
					//TODO: add to hotel select, received options
					var select = $('#hotel');
					
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
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("Error loading Hotels Select Input");
				}
			});
		// } else { // provincia
			// console.log("cambio provincia: "+ id);			
		// }
	}

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
	
	$('#paises').change(function() {
		rellenarProvincia();
		fillHotelsSelect($(this).val(), 0);
	});	

	$('#provincias').change(function() {
		fillHotelsSelect($(this).val(), 1);
	});
	
    $("#tipo_evento").select2({
		placeholder: "-",
		allowClear: true
	});	
    $("#paises").select2({
		placeholder: "-",
		allowClear: true
	});
    $("#provincias").select2({
		placeholder: "-",
		allowClear: true
	});	
    $("#hotel").select2({
		placeholder: "-",
		allowClear: true
	});			
	
    var handleDateRangePickers = function () {
        if (!jQuery().daterangepicker) {
            return;
        }

        $('#defaultrange').daterangepicker({
                opens: (Metronic.isRTL() ? 'left' : 'right'),
                format: 'MM/DD/YYYY',
                separator: ' to ',
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2018',
            },
            function (start, end) {
                $('#defaultrange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );        

        $('#defaultrange_modal').daterangepicker({
                opens: (Metronic.isRTL() ? 'left' : 'right'),
                format: 'MM/DD/YYYY',
                separator: ' to ',
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2018',
            },
            function (start, end) {
                $('#defaultrange_modal input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );  

        // this is very important fix when daterangepicker is used in modal. in modal when daterange picker is opened and mouse clicked anywhere bootstrap modal removes the modal-open class from the body element.
        // so the below code will fix this issue.
        $('#defaultrange_modal').on('click', function(){
            if ($('#daterangepicker_modal').is(":visible") && $('body').hasClass("modal-open") == false) {
                $('body').addClass("modal-open");
            }
        });

        $('#reportrange').daterangepicker({
                opens: (Metronic.isRTL() ? 'left' : 'right'),
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                minDate: '01/01/2015',
                maxDate: '12/31/2030',
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                buttonClasses: ['btn'],
                applyClass: 'green',
                cancelClass: 'default',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Apply',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom Range',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );
        //Set the initial state of the picker label
        $('#reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    }


    return {
        //main function to initiate the module
        init: function () {
            handleDateRangePickers();
            
        }
    };

}();