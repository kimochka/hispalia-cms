	<?php 
		$nombre = array(
        	'name'			=> 'nombre',
            'id'			=> 'nombre',
            'class'			=> 'form-control',
            'value'         =>  !empty($hotel['nombre']) ? $hotel['nombre'] : null,
            'placeholder'	=> 'Nombre',
            'maxlength'		=> '100',
            'data-required' => 1,
            'type'			=> 'text'
         	);


		$email = array(
            'name'      	=> 'email',
            'id'        	=> 'email',
            'class'			=> 'form-control',
            'value'         =>  !empty($hotel['email']) ? $hotel['email'] : null,            
            'placeholder'  	=> 'Email',
            'maxlength' 	=> '100'		
			);

		$telefono = array(
            'name'      	=> 'telefono',
            'id'        	=> 'telefono',
            'class'			=> 'form-control',
            'value'         => !empty($hotel['telefono']) ? $hotel['telefono'] : null,            
            'placeholder'  	=> 'Teléfono',
            'maxlength' 	=> '100'		
			);
		
		$movil = array(
            'name'      	=> 'movil',
            'id'        	=> 'movil',
            'class'			=> 'form-control',
            'value'         =>  !empty($hotel['movil']) ? $hotel['movil'] : null,            
            'placeholder'  	=> 'Móvil',
            'maxlength' 	=> '100'
			);


		$direccion = array(
           	'name'    		=> 'direccion',
            'id'        	=> 'direccion',
            'class'			=> 'form-control',
            'value'         =>  !empty($hotel_direccion['direccion']) ? $hotel_direccion['direccion'] : null,          	
            'placeholder'  	=> 'Dirección',
            'maxlength' 	=> '100'
			);

		$ciudad = array(
         	'name'   		=> 'ciudad',
            'id'        	=> 'ciudad',
            'class'			=> 'form-control',
            'value'         =>  !empty($hotel_direccion['ciudad']) ? $hotel_direccion['ciudad'] : null,            
            'placeholder'	=> 'Ciudad/Pueblo',
            'maxlength'		=> '100',		
			);

		$cp = array(
            'name'      	=> 'cp',
            'id'        	=> 'cp',
            'class'			=> 'form-control',
            'value'         => !empty($hotel_direccion['cp']) ? $hotel_direccion['cp'] : null,            
            'placeholder'	=> 'Código Postal',
            'maxlength'		=> '100'
			);
		
	?>								
	
										<form id="formHotel" action="/hoteles/salvar_hotel" class="form-horizontal" method="post">
											<?php echo form_hidden('action', 'newInsert');?>
											
											<div class="form-body">
												<h3 class="form-section">Datos personales</h3>
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
															<label class="control-label col-md-3">Nombre <span class="required">
																* </span></label>
															<div class="col-md-9">
																<?php echo form_input($nombre); ?>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">E-mail</label>
															<div class="col-md-9">
																<div class="input-group">
																	<span class="input-group-addon">
																		<i class="fa fa-envelope"></i>
																	</span>
																	<?php echo form_input($email); ?>
																</div>
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
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Teléfono</label>
															<div class="col-md-9">
																<?php echo form_input($telefono); ?>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Móvil</label>
															<div class="col-md-9">
																<?php echo form_input($movil); ?>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>


													

													<!--/span-->
												<h3 class="form-section">Datos geográficos</h3>
												<!--/row-->
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-2">Dirección</label>
															<div class="col-md-9">
																<?php echo form_input($direccion) ?>
															</div>
														</div>
													</div>
												</div>
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
														<div class="form-group">
															<label class="control-label col-md-3">Codigo Postal</label>
															<div class="col-md-9">
																<?php echo form_input($cp) ?>
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
																<?php echo form_dropdown('pais', $paises, !empty($hotel_pais) ? key($hotel_pais) : $paisDefault, 'id="paises" class="select2_category form-control"'); ?>

															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Provincia <span class="required">* </span></label>
															<div class="col-md-9">
																<?php echo form_dropdown('provincias', $provincias, !empty($hotel_provincia) ? key($hotel_provincia) : null,'id="provincias" class="select2_category form-control"'); ?>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->

												<h3 class="form-section">Datos Valoración</h3>
												<!--row-->
	<?php	
		$dentro_lista_negra = array(
    		'name'        => 'lista_negra',
    		'value'       => 'Yes',
    		'checked'     => FALSE
    	);
	
    	$fuera_lista_negra = array(
   			'name'        => 'lista_negra',
    		'value'       => 'No',
    		'checked'     => FALSE
    	);
	
		empty($lista_negra) ? $fuera_lista_negra['checked'] = TRUE : $dentro_lista_negra['checked'] = TRUE;
			
    ?>												
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Meter en lista negra?</label>
															<div class="col-md-9">
																<div class="radio-list">
																	<label class="radio-inline">
																	<?php echo form_radio($dentro_lista_negra); ?>
																	 Si
																	</label>
																	<label class="radio-inline">
																	<?php echo form_radio($fuera_lista_negra); ?> No </label>
																</div>	
															</div>
														</div>
													</div>
		<?php 
			$comentario = array(
              'name'        => 'comentario',
              'id'          => 'comentario',
              'class'		=> 'form-control',
              'placeholder' => 'Comentario',
              'maxlength'   => '300',
              'cols'		=> '35',
              'rows'		=> '5',
              'value'		=> !empty($hotel_comentario) ? $hotel_comentario : null
			);
		?>													
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Notas</label>
															<div class="col-md-9">
																<?php echo form_textarea($comentario); ?>
															</div>
														</div>
													</div>
												</div>																							
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-6">
														<div class="row">
															<div class="col-md-offset-3 col-md-9">
																<button type="submit" class="btn green">Confirmar hotel</button>
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
		