	<?php 
		$nombre = array(
        	'name'			=> 'nombre',
            'id'			=> 'nombre',
            'class'			=> 'form-control',
            'value'         =>  !empty($grupo['nombre']) ? $grupo['nombre'] : null,
            'placeholder'	=> 'Nombre',
            'maxlength'		=> '100',
            'data-required' => 1,
            'type'			=> 'text'
         	);

		$telefono = array(
            'name'      	=> 'telefono',
            'id'        	=> 'telefono',
            'class'			=> 'form-control',
            'value'         => !empty($grupo['telefono']) ? $grupo['telefono'] : null,            
            'placeholder'  	=> 'Teléfono',
            'maxlength' 	=> '100'		
			);

		$ciudad = array(
         	'name'   		=> 'ciudad',
            'id'        	=> 'ciudad',
            'class'			=> 'form-control',
            'value'         =>  !empty($grupo_direccion['ciudad']) ? $grupo_direccion['ciudad'] : null,            
            'placeholder'	=> 'Ciudad/Pueblo',
            'maxlength'		=> '100',		
			);

		$cp = array(
            'name'      	=> 'cp',
            'id'        	=> 'cp',
            'class'			=> 'form-control',
            'value'         => !empty($grupo_direccion['cp']) ? $grupo_direccion['cp'] : null,            
            'placeholder'	=> 'Código Postal',
            'maxlength'		=> '100'
			);
		
	?>								
	
										<form id="formGrupo" action="/grupos/salvar_grupo" class="form-horizontal" method="post">
											<?php echo form_hidden('action', 'newInsert');?>
											
											<div class="form-body">
												<h3 class="form-section">Datos Generales</h3>
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
															<label class="control-label col-md-3">Teléfono</label>
															<div class="col-md-9">
																<?php echo form_input($telefono); ?>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Evento</label>
															<div class="col-md-9">
																<?
        echo form_dropdown('evento', $eventos, !empty($evento['id']) ? $evento['id'] : 4, 'class="select2_category form-control" data-placeholder="Evento" id="evento" name="evento" tabindex="1"');																
																?>
				
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Delegado</label>
															<div class="col-md-9">
																<?
        echo form_dropdown('delegado', $delegados, !empty($delegado['id']) ? $delegado['id'] : 4, 'class="select2_category form-control" data-placeholder="Tiene Delegado?" id="delegado" name="delegado" tabindex="1"');																
																?>
				
															</div>
														</div>
													</div>


													
													<!--/span-->
													<div class="col-md-6">
													</div>
													<!--/span-->
												</div>												
												<h3 class="form-section">Datos geográficos</h3>
												<!--/row-->
												<div class="row">
													<div class="col-md-12">
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
																<?php echo form_dropdown('pais', $paises, !empty($cliente_pais) ? key($cliente_pais) : $paisDefault, 'id="paises" class="select2_category form-control"'); ?>

															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Provincia <span class="required">* </span></label>
															<div class="col-md-9">
																<?php echo form_dropdown('provincias', $provincias, !empty($cliente_provincia) ? key($cliente_provincia) : null,'id="provincias" class="select2_category form-control"'); ?>
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
              'value'		=> !empty($cliente_comentario) ? $cliente_comentario : null
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
																<button type="submit" class="btn green">Confirmar Grupo</button>
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
		