			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					
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
						<div class="portlet-body">	
								<?php echo $this->table->generate($records); ?>
								<?php //echo $this->table->generate(); ?>
						</div>
					<!-- </div>											 -->
					<!-- END DATATABLE CHECKBOX -->
					

				</div>
			</div>
			<!-- END PAGE CONTENT-->
			
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
															<i class="fa fa-cogs"></i>Lista Clientes Confirmados
														</div>
														<div class="actions">
														</div>
													</div>
													<div class="portlet-body">
														<div class="table-responsive">
															<table id="clientes_pack" class="table table-hover table-bordered table-striped">
															<thead>
															<tr>
																<th>
																	Apellido
																</th>
																<th>
																	Nombre
																</th>
																<th>
																	 Es Delegado
																</th>
																<th>
																	 Es Jugador?
																</th>
																<th>
																	Room Type
																</th>
																<!-- <th>Action</th> -->
															</tr>
															</thead>
															<tbody>

															</tbody>
															</table>
														</div>
													</div>
												</div>


				</div>
			</div>