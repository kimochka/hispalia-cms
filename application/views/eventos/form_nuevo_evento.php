	<?php 
	
		$eventoDefault = 0;
		$hotelDefault = 0;
		$nombre = array(
        	'name'			=> 'nombre',
            'id'			=> 'nombre',
            'class'			=> 'form-control',
            'value'         =>  !empty($evento['nombre']) ? $evento['nombre'] : null,
            'placeholder'	=> 'Nombre Evento',
            'maxlength'		=> '100',
            'data-required' => 1,
            'type'			=> 'text'
         	);

		// $destino = array(
        	// 'name'			=> 'destino',
            // 'id'			=> 'destino',
            // 'class'			=> 'form-control',
            // 'value'         =>  !empty($evento['destino']) ? $evento['destino'] : null,
            // 'placeholder'	=> 'Destino',
            // 'maxlength'		=> '100',
            // 'data-required' => 1,
            // 'type'			=> 'text'
         	// );

		$ciudad = array(
         	'name'   		=> 'ciudad',
            'id'        	=> 'ciudad',
            'class'			=> 'form-control',
            'value'         =>  !empty($evento_direccion['ciudad']) ? $evento_direccion['ciudad'] : null,            
            'placeholder'	=> 'Ciudad/Pueblo',
            'maxlength'		=> '100',		
			);

		$precio_jugador = array(
         	'name'   		=> 'precio_jugador',
            'id'        	=> 'precio_jugador',
            'class'			=> 'form-control',
            'value'         =>  !empty($evento['precio_jugador']) ? $evento['precio_jugador'] : null,            
            'placeholder'	=> 'Precio Jugador',
            'maxlength'		=> '100',		
			);
		$precio_no_jugador = array(
         	'name'   		=> 'precio_no_jugador',
            'id'        	=> 'precio_no_jugadordad',
            'class'			=> 'form-control',
            'value'         =>  !empty($evento['precio_no_jugador']) ? $evento['precio_no_jugador'] : null,            
            'placeholder'	=> 'Precio No jugador',
            'maxlength'		=> '100',		
			);
		$precio_suplemento_individual = array(
         	'name'   		=> 'precio_suplemento_individual',
            'id'        	=> 'precio_suplemento_individual',
            'class'			=> 'form-control',
            'value'         =>  !empty($evento['precio_suplemento_individual']) ? $evento['precio_suplemento_individual'] : null,            
            'placeholder'	=> 'Precio Suplemento_individual',
            'maxlength'		=> '100',
			);			
		$precio_nino = array(
         	'name'   		=> 'precio_nino',
            'id'        	=> 'precio_nino',
            'class'			=> 'form-control',
            'value'         =>  !empty($evento['precio_nino']) ? $evento['precio_nino'] : null,            
            'placeholder'	=> 'Precio Niñ@',
            'maxlength'		=> '100',		
			);
		
	?>								
	
										<form id="formEvento" action="/eventos/salvar_evento" class="form-horizontal" method="post">
											<?php echo form_hidden('action', 'newInsert');?>
											
											<div class="form-body">
												<h3 class="form-section">Introduce datos Evento</h3>
												<div class="alert alert-danger display-hide">
													<button class="close" data-close="alert"></button>
													You have some form errors. Please check below.
												</div>			
												<div class="alert alert-success display-hide">
													<button class="close" data-close="alert"></button>
													Your form validation is successful!
												</div>																		
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Nombre Evento<span class="required">
																* </span></label>
															<div class="col-md-9">
																<?php echo form_input($nombre); ?>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Tipo Evento</label>
															<div class="col-md-9">
																<?php echo form_dropdown('tipo_evento', $tipos, !empty($evento_tipo) ? key($evento_tipo) : $eventoDefault, 'id="tipo_evento" class="select2_category form-control"'); ?>
															</div>
														</div>														
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">

													</div>

													<!--/span-->
												</div>


													<!--/span-->
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Localidad</label>
															<div class="col-md-9">
																<?php echo form_input($ciudad) ?>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group eventDates">
															<label class="control-label col-md-3">Event Dates <span class="required">
																* </span></label>
															<div class="col-md-9">
																<input type="hidden" name="from" id="from" value=""/>
																<input type="hidden" name="to" id="to" value=""/>																												
																<div id="reportrange" class="btn default">
																	<i class="fa fa-calendar"></i>
																	&nbsp; <span>
																	</span>
																	<b class="fa fa-angle-down"></b>
																</div>
															</div>
														</div>	
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">País</label>
															<div class="col-md-9">
																<?php echo form_dropdown('pais', $paises, !empty($evento_pais) ? key($evento_pais) : 0, 'id="paises" class="select2_category form-control"'); ?>

															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Provincia <span class="required">* </span></label>
															<div class="col-md-9">
																<?php echo form_dropdown('provincias', $provincias, !empty($evento_provincia) ? key($evento_provincia) : null,'id="provincias" class="select2_category form-control"'); ?>
															</div>
														</div>
													</div>
													<!--/span-->
																										
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Hotel</label>
															<div class="col-md-9">
																<?php echo form_dropdown('hotel', $hoteles, !empty($evento_hotel) ? key($evento_hotel) : $hotelDefault, 'id="hotel" class="select2_category form-control"'); ?>
															</div>
														</div>	
													</div>											
												</div>

												<h3 class="form-section">Precios</h3>
	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Precio Jugador<span class="required">
																* </span></label>
															<div class="col-md-9">
																<?php echo form_input($precio_jugador); ?>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Precio No Jugador<span class="required">
																* </span></label>
															<div class="col-md-9">
																<?php echo form_input($precio_no_jugador); ?>
															</div>
														</div>
													</div>													
												</div>																							
											</div>
											<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Precio Nino<span class="required">
																* </span></label>
															<div class="col-md-9">
																<?php echo form_input($precio_nino); ?>
															</div>
														</div>
													</div>												
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Precio Suplemento Individual<span class="required">
																* </span></label>
															<div class="col-md-9">
																<?php echo form_input($precio_suplemento_individual); ?>
															</div>
														</div>
													</div>
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-6">
														<div class="row">
															<div class="col-md-offset-3 col-md-9">
																<button type="submit" class="btn green">Confirmar evento</button>
																<button type="button" class="btn default">Cancelar</button>
															</div>
														</div>
													</div>
													<div class="col-md-6">
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
									</div>
								<!--</div>-->
		