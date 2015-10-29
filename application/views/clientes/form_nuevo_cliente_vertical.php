				<div class="portlet light bg-inverse">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-equalizer font-red-sunglo"></i>
							<span class="caption-subject font-red-sunglo bold uppercase">NUEVO CLIENTE</span>
							<span class="caption-helper">Rellena datos del nuevo cliente</span>
						</div>
						<div class="tools">
							<a href="" class="collapse">
							</a>
							<a href="#portlet-config" data-toggle="modal" class="config">
							</a>
							<a href="" class="reload">
							</a>
							<a href="" class="remove">
							</a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- BEGIN FORM-->
						<form action="#" class="horizontal-form">
							<div class="form-body">
								<h3 class="form-section">Info Cliente</h3>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Nombre</label>
											<input type="text" id="nombre" class="form-control">

										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group has-error">
											<label class="control-label">Apellido</label>
											<input type="text" id="apellido" class="form-control">
										</div>
									</div>
									<!--/span-->
								</div>
								<!--/row-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group has-error">
											<label class="control-label">e-mail</label>
											<input type="text" id="email" class="form-control">
										</div>
									</div>													
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Fecha nacimiento</label>
											<input type="text" id="datepicker" name="datepicker" class="form-control hasDatepicker" placeholder="dd/mm/yyyy">
										</div>
									</div>
									<!--/span-->
								</div>
								<!--/row-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Teléfono</label>
											<input type="text" id="telefono" class="form-control">
										</div>
									</div>													
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Móvil</label>
											<input type="text" id="movil" class="form-control">
										</div>
									</div>
									<!--/span-->
								</div>												
								<!--/row-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Talla Camiseta</label>
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
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Genero</label>
											<div class="radio-list">
												<label class="radio-inline">
												<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Hombre </label>
												<label class="radio-inline">
												<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Mujer </label>
											</div>
										</div>
									</div>
									<!--/span-->
								</div>
								<!--/row-->
								<h3 class="form-section">Dirección</h3>
								<div class="row">
									<div class="col-md-12 ">
										<div class="form-group">
											<label>Direccion</label>
											<input type="text" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Ciudad/Pueblo</label>
											<input type="text" class="form-control">
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label>Codigo Postal</label>
											<input type="number" class="form-control">
										</div>
									</div>
									<!--/span-->
								</div>
								<!--/row-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Pais</label>
											<select class="select2_category form-control" data-placeholder="Medida Camiseta" id="paises" name="paises" tabindex="1">
												<option value="1">S</option>
												<option value="2">M</option>
												<option value="3">L</option>
												<option value="4" selected="selected">XL</option>
												<option value="5">XXL</option>
												<option value="6">XXXL</option>
											</select>
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label>Provincia</label>
											<select class="select2_category form-control" data-placeholder="Medida Camiseta" id="provincias" name="provincias" tabindex="1">
												<option value="1">S</option>
												<option value="2">M</option>
												<option value="3">L</option>
												<option value="4" selected="selected">XL</option>
												<option value="5">XXL</option>
												<option value="6">XXXL</option>
											</select>
										</div>
									</div>
									<!--/span-->
								</div>
								<!--/row-->
								
								<h3 class="form-section">Info Extra</h3>
								<div class="row">
									<div class="col-md-6 ">
										<div class="form-group">
											<label class="control-label">Tiene Delegado?</label>
											<div class="radio-list">
												<label class="radio-inline">
												<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Si </label>
												<label class="radio-inline">
												<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> No </label>
											</div>														
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Elige Delegado</label>
											<select class="select2_category form-control" data-placeholder="Medida Camiseta" id="delegado" name="delegado" tabindex="1">
												<option value="1">BLA BLA</option>
												<option value="2">BLO BLO</option>
											</select>
										</div>
									</div>
								</div>
								<!--/row-->
								<h3 class="form-section">Valoración</h3>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">Meter en lista negra?</label>
											<div class="radio-list">
												<label class="radio-inline">
												<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Si </label>
												<label class="radio-inline">
												<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> No </label>
											</div>														
										</div>														
									</div>
										
									<!--/span-->
									<div class="col-md-9">
										<div class="form-group">
											<label>Notas:</label>
											<input type="text" class="form-control">
										</div>
									</div>
									<!--/span-->
								
								</div>																						
							</div>
							
							<div class="form-actions left">
								<button type="button" class="btn default">Cancelar</button>
								<button type="submit" class="btn blue"><i class="fa fa-check"></i> Salvar</button>
							</div>
						</form>
						<!-- END FORM-->
					</div>
				</div>