	<?php 
		$nombre = array(
        	'name'			=> 'nombre',
            'id'			=> 'nombre',
            'class'			=> 'form-control',
            'value'         =>  set_value('nombre'),
            'placeholder'	=> 'Nombre',
            'maxlength'		=> '100',
            'data-required' => 1,
            'type'			=> 'text'
         	);
		
		$apellido = array(
            'name'   		=> 'apellido',
            'id'        	=> 'apellido',
            'class'			=> 'form-control',
            'value'         =>  set_value('apellido'),            
            'placeholder'  	=> 'Apellido',
            'maxlength' 	=> '100'		
			);

		$email = array(
            'name'      	=> 'email',
            'id'        	=> 'email',
            'class'			=> 'form-control',
            'value'         =>  set_value('email'),            
            'placeholder'  	=> 'Email',
            'maxlength' 	=> '100'		
			);

		$telefono = array(
            'name'      	=> 'telefono',
            'id'        	=> 'telefono',
            'class'			=> 'form-control',
            'value'         =>  set_value('telefono'),            
            'placeholder'  	=> 'Teléfono',
            'maxlength' 	=> '100'		
			);
		
		$movil = array(
            'name'      	=> 'movil',
            'id'        	=> 'movil',
            'class'			=> 'form-control',
            'value'         =>  set_value('movil'),            
            'placeholder'  	=> 'Móvil',
            'maxlength' 	=> '100'
			);

		$datepicker = array(
           	'name'      	=> 'datepicker',
          	'id'        	=> 'datepicker',
            'class'			=> 'form-control',
            'value'         =>  set_value('datepicker') ? set_value('datepicker') : null,          	
          	'placeholder' 	=> 'Fecha de Nacimiento',
          	'readonly'		=> null
			);

		$direccion = array(
           	'name'    		=> 'direccion',
            'id'        	=> 'direccion',
            'class'			=> 'form-control',
            'value'         =>  set_value('direccion'),            
            'placeholder'  	=> 'Dirección',
            'maxlength' 	=> '100'
			);

		$ciudad = array(
         	'name'   		=> 'ciudad',
            'id'        	=> 'ciudad',
            'class'			=> 'form-control',
            'value'         =>  set_value('ciudad'),            
            'placeholder'	=> 'Ciudad/Pueblo',
            'maxlength'		=> '100',		
			);

		$cp = array(
            'name'      	=> 'cp',
            'id'        	=> 'cp',
            'class'			=> 'form-control',
            'value'         =>  set_value('cp'),            
            'placeholder'	=> 'Código Postal',
            'maxlength'		=> '100'
			);
		
		$provincias = array();
	?>								
	
										<form id="formClient" action="/clientes/salvar_cliente" class="form-horizontal" method="post">
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
															<label class="control-label col-md-3">Apellido <span class="required">
																* </span></label>
															<div class="col-md-9">
																<?php echo form_input($apellido); ?>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
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
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Fecha Nacimiento</label>
															<div class="col-md-9">
																<!--
																	<input id="dob" data-type="combodate" data-format="YYYY-MM-DD" data-viewformat="DD/MM/YYYY" type="text" class="form-control" placeholder="dd/mm/yyyy">
															  -->
																<div class="input-group date date-picker" data-date-format="yyyy/mm/dd">
																	<?php echo form_input($datepicker); ?>
																	<span class="input-group-btn">
																	<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
																	</span>
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
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Talla Camiseta</label>
															<div class="col-md-9">
																<select class="select2_category form-control" data-placeholder="Medida Camiseta" id="medida_camiseta" name="medida_camiseta" tabindex="1">
																	<option value="1">S</option>
																	<option value="2">M</option>
																	<option value="3">L</option>
																	<option value="4" selected="selected">XL</option>
																	<option value="5">XXL</option>
																	<option value="6">XXXL</option>
																</select>
															</div>
														</div>
													</div>
	<?php
	
		$male = array(
    		'name'        => 'genero',
    		'value'       => 'M',
    		'checked'     => FALSE
    	);
	
    	$female = array(
   			'name'        => 'genero',
    		'value'       => 'F',
    		'checked'     => FALSE
    	);
	?>
													
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Género <span class="required">
																* </span></label>
															<div class="col-md-9">
																<div class="radio-list" data-error-container="#formClient_genero_error">
																	<label class="radio-inline">
																	<?php echo form_radio($male); ?> Hombre </label>
																	<label class="radio-inline">
																	<?php echo form_radio($female); ?> Mujer </label>
																</div>
																<div id="formClient_genero_error"></div>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>												
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
																<?php echo form_dropdown('pais', $paises, (set_value('pais') != null) ? set_value('pais') : 15, 'id="paises" class="select2_category form-control"'); ?>

															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Provincia <span class="required">* </span></label>
															<div class="col-md-9">
																<?php echo form_dropdown('provincias', $provincias, set_value('provincias'),'id="provincias" class="select2_category form-control"'); ?>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												
												
	<?php
	
		$tiene_delegado = array(
    		'name'        => 'group_name',
    		'value'       => 'Yes',
    		'checked'     => FALSE
    	);
	
    	$no_tiene_delegado = array(
   			'name'        => 'group_name',
    		'value'       => 'No',
    		'checked'     => FALSE
    	);
	
    ?>												
    <!--
												<h3 class="form-section">Datos Delegado</h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Tiene Delegado?<span class="required">*</span></label>
															<div class="col-md-9">
																<div class="radio-list" data-error-container="#formClient_tiene_delegado_error">
																	<label class="radio-inline">
																	<?php echo form_radio($tiene_delegado); ?> Si </label>
																	<label class="radio-inline">
																	<?php echo form_radio($no_tiene_delegado); ?> No </label>
																</div>
																<div id="formClient_tiene_delegado_error"></div>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div id="delegados_box" class="form-group">
															<label class="control-label col-md-3">Elige Delegado</label>
															<div class="col-md-9">
																	<?php 
																		if(isset($delegados)) {
																			echo form_dropdown('lista_delegados', $delegados, '','class="select2_category form-control"');
																		} else {
																			echo "Introduce delegados primeramente...";
																			echo form_hidden($delegados);
																		}
																	?>
															</div>
														</div>
													</div>
												</div>	
												/row-->
												<h3 class="form-section">Datos Valoración</h3>
												<!--row-->
	<?php	
		$dentro_lista_negra = array(
    		'name'        => 'lista_negra',
    		// 'id'          => 'dentro_lista',
    		'value'       => 'Yes',
    		'checked'     => FALSE
    	);
	
    	$fuera_lista_negra = array(
   			'name'        => 'lista_negra',
    		// 'id'          => 'fuera_lista',
    		'value'       => 'No',
    		'checked'     => FALSE
    	);
	
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
              'rows'		=> '5'
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
																<button type="submit" class="btn green">Añadir Cliente</button>
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
		