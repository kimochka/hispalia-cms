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
?>

			<!-- BEGIN PAGE CONTENT-->
			<div clas="row">
				<div class="col-md-12 col-sm-12">
					<div class="well">
						<div class="form-group">
							<!--
															 <label class="control-label col-md-3">Nombre <span class="required">
																* </span></label>
															<div class="col-md-9">
																<?php // echo form_input($nombre); ?>
															</div>
														</div> -->
														
						<?php echo form_dropdown('evento', $eventos, !empty($evento) ? key($evento) : null, 'id="evento" class="select2_category form-control"'); ?>
					</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12 col-sm-12">
					
					<!-- BEGIN DATATABLE CHECKBOX -->
					<!-- <div class="portlet box purple">
						<div class="portlet-title">				
							<div class="caption">
								<i class="fa fa-cogs"></i>
							</div> -->
							
							<!-- <div class="actions">
								<a href="#" class="btn btn-default btn-sm createSelectedGroup" title="Crear nuevo grupo usando clientes seleccionados">
								<i class="fa fa-plus"></i>&nbsp<i class="fa fa-users"></i>  &nbsp<span class="badge badge-default totalItemsSelected">0</span></a>								
								<a href="/<?php echo $tableAddButtonHref;?>/nuevo" title="Crear nuevo cliente a la Base de Datos" class="btn btn-default btn-sm">
								<i class="icon-user-follow"></i> <?php echo $tableAddButton;?></a>
								<a href="#" class="btn btn-default btn-sm deleteSelected" title="Delete Selected Clients">
								<i class="fa fa-trash-o"></i> &nbsp<span class="badge badge-default totalItemsSelected toDelete">0</span></a>
							</div> -->
							<!-- <div class="tools">
							</div> -->
						<!-- </div> -->
								
								
												<div class="portlet grey-cascade box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Lista productos
														</div>
														<div class="actions">
															<a href="#" class="btn btn-default btn-sm buttonAddProduct">
															<i class="fa fa-plus"></i> Add Producto</a>
														</div>
													</div>
													<div class="portlet-body">
														<div class="table-responsive">
															<table id="productos" class="table table-hover table-bordered table-striped">
															<thead>
															<tr>
																<th>
																	Tipo
																</th>
																<th>
																	Concepto
																</th>																
																<th>
																	Unidades
																</th>
																<th>
																	 Coste x unidad (€)
																</th>
																<th>
																	 Coste (€)
																</th>
																<th></th>
															</tr>
															</thead>
															<tbody>
																
															</tbody>
															</table>
														</div>
													</div>
												</div>
								
								
								
								
								
								
								
								
					<!-- </div>											 -->
					<!-- END DATATABLE CHECKBOX -->
					

				</div>
			</div>
			<!-- END PAGE CONTENT-->
			


        <!-- <div id="dialog-form" title="Introducir productos extras..."> -->
        
            <!-- <form>
            <fieldset>
                <label for="concepto">Concepto</label>
                <input type="text" name="concepto" id="concepto" class="text ui-widget-content ui-corner-all" />
                <p></p>
                <label for="unidades">Unidades</label>
                <input type="text" name="unidades" id="unidades" value="" class="text ui-widget-content ui-corner-all" />
                <p></p>
                <label for="precio_unidad">Precio Unidad</label>
                <input type="text" name="precio_unidad" id="precio_unidad" value="" class="text ui-widget-content ui-corner-all" />           
            </fieldset>
            </form>
        </div> -->
        
        
        <!--<div id="users-contain" class="ui-widget">
            <table id="users" class="ui-widget ui-widget-content">
                <thead>
                    <tr class="ui-widget-header ">
                        <th>Concepto</th>
                        <th>Unidades</th>
                        <th>Precio Unidad</th>
                        <th>Precio Producto</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
        <button id="create-user">Añadir producto...</button> -->
   