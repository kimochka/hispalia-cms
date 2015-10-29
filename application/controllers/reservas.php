<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Reservas extends CI_Controller {
		
	public $data;
		
	function __construct(){		
		parent::__construct();

		$this->inzialize_css();
		$this->inzialize_js();
		
		$this->data['mainMenu'] =& buildMainMenu();	
		$this->data['footer'] = eval(FOOTER);
		
		$this->load->model('reservas_model');

		$temp_tipoPagos = $this->reservas_model->getTipoPagos();
		$tipo_pagos = '';
		foreach($temp_tipoPagos as $value) {
			$tipo_pagos .= '<option value="'.$value->tipo_pago_id.'">'.$value->nombre.'</option>';
		}
		$temp_tipoProductos = $this->reservas_model->getTipoProductos();
		$tipo_productos = '';
		foreach($temp_tipoProductos as $value) {
			$tipo_productos .= '<option value="'.$value->tipo_producto_id.'">'.$value->nombre.'</option>';
		}	

		$this->data['tipo_pagos'] = $tipo_pagos;
		$this->data['tipo_productos'] = $tipo_productos;		
	}
	
	function index() {
		
		// $this->data['records'] = $tabla;
		
		$this->db->order_by('apellido ASC');
		$clientes_temp = $this->db->get('clientes')->result();
		// $clientes[0] = "All";
		foreach($clientes_temp as $cl) {
			$clientes[$cl->cliente_id] = $cl->apellido . ', '. $cl->nombre;
		}
		$this->data['clientes'] = $clientes;
		// print_r($clientes);
		
		$eventos_temp = $this->db->get('eventos')->result();
		$eventos[0] = "All Events";
		foreach($eventos_temp as $ev) {
			$eventos[$ev->evento_id] = $ev->nombre;
		}
		$this->data['eventos'] = $eventos;
		
		$eventos_tipos_temp = $this->db->get('tipos')->result();
		$eventos_tipos[0] = "All Events";
		foreach($eventos_tipos_temp as $ev_ti) {
			$eventos_tipos[$ev_ti->tipo_id] = $ev_ti->nombre;
		}
		$this->data['eventos_tipos'] = $eventos_tipos;
		
		$this->data['header_title'] = "Hispalia | Reservas - Tabla";
		$this->data['h3'] = "RESERVAS";
		$this->data['breadcrumb'] = "Tabla Reservas";
		$this->data['tableAddButtonHref'] = "reservas";
		$this->data['tableAddButton'] = "Añadir nueva reserva";
		$this->data['tableCreateNewGroup'] = "Crea nueva reserva";
		
		$this->data['tabla_controller'] = "reservas";
		
		// Variables included in php view file
		$visibleColumnsToExport = Array(1, 2, 3, 4, 5, 6, 7	);
		$this->data['visibleColumnsToExport'] = json_encode($visibleColumnsToExport);
		$orderableTargets = Array(8);
		$this->data['orderableTargets'] = json_encode($orderableTargets);
		$searchableTargets = Array(0,8);
		$this->data['searchableTargets'] = json_encode($searchableTargets);
		$this->data['confirmDelete'] = "Borrar Reerva?";
		$this->data['deleteRowURL'] = 'reservas_ajax/deleteReserva';
		$this->data['modifyItemURL'] = 'reservas/modificar/';
		$this->data['deleteSelectedRowsURL'] = 'reservas_ajax/deleteSelectedReserva';
		
		$this->load->view("reservas/general_table", $this->data);
						
	}

	function nuevo() {

	//-------------------------------- 1/4 -> Add Customers
        // Mandamos los tipos de eventos
        $eventos = array();
        // $eventos[0] = '-- Incluir evento --';
        // $eventos[] = '-- Incluir evento --';
        if($query = $this->general_model->getEventos()) {
            foreach ($query as $row) {
                $eventos[$row->evento_id] = $row->nombre;
            }
        }
       	$this->data['eventos'] = $eventos;

	//-------------------------------- 2/4 -> Add Customers
		$config['base_url'] = base_url('clientes');
		$config['total_rows'] = $this ->db->get('clientes')->num_rows();
		$config['per_page'] = 1;
		$config['num_links'] = 1;

		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';

		$tmpl = array(
			'table_open'		  => '<table class="table table-striped table-bordered table-hover" id="general_table">',
           // 'heading_cell_start'  => '<th class="table-checkbox">', //TODO modificar para que solo sea aplicable a la primera celda del header (primer <th>)
			'row_start'           => '<tr class="odd">'
		);
		/*
		 * Para añadir una primera fila de filtros
		$tmpl = array(
			'table_open' 		=> '<table class="table table-striped table-bordered table-hover" id="datatable_ajax">',
			'heading_row_start' => '<tr role="row" class="heading">'
		);
		 * */
		
		$this -> table -> set_template($tmpl);

		$this -> table -> set_heading('<input type="checkbox" class="group-checkable" data-set="#datatable_clientes .checkboxes"/>', 'Apellido', 'Nombre', 'Address', 'City', 'Region', 'Country', 'Notification');

		$this -> load -> library('pagination');
		//$this->pagination->initialize($config);

		$tabla = array();
		$i = 0;
		
		/*
		//Add Filter to Table First Row
		
		$i = 1; //comentar la asignacion de la variable $i anterior por esta.
		
		$filterButtons = '
        <div>
        	<span class="fa fa-lg fa-filter filterButton" title="Filtrar"></span>
        	<span class="separator">&nbsp;</span>
        	<span class="fa fa-eraser resetButton" title="Reset Filter"></span>
        </div>';
					
		$row = array(
			null,
			'<input type="text" class="form-control form-filter input-sm" name="order_id">', 
			'<input type="text" class="form-control form-filter input-sm" name="order_id">', 
			'<input type="text" class="form-control form-filter input-sm" name="order_id">', 
			'<input type="text" class="form-control form-filter input-sm" name="order_id">', 
			'<input type="text" class="form-control form-filter input-sm" name="order_id">', 
			'<input type="text" class="form-control form-filter input-sm" name="order_id">', 
			'<input type="text" class="form-control form-filter input-sm" name="order_id">', 
			'<input type="text" class="form-control form-filter input-sm" name="order_id">', 
			'<input type="text" class="form-control form-filter input-sm" name="order_id">', 
			'<input type="text" class="form-control form-filter input-sm" name="order_id">',
			$filterButtons
		);
		$tabla[0] = array('data'=>$row, 'class'=>'filter', 'role'=>'row');
		*/
		
		$this -> db -> select('clientes.cliente_id');
		$this -> db -> select('clientes.nombre AS cliName');
		$this -> db -> select('clientes.apellido');
		$this -> db -> select('clientes.telefono');
		$this -> db -> select('clientes.email');
		$this -> db -> select('clientes.camiseta');

		$this -> db -> select('direcciones.direccion');
		$this -> db -> select('direcciones.ciudad');

		$this -> db -> select('provincias.nombre AS provinciaNombre');

		$this -> db -> select('paises.nombre AS paisNombre');

		$this -> db -> join("direcciones", 'clientes.cliente_id = direcciones.cliente_id', 'left outer');
		$this -> db -> join("provincias", 'direcciones.provincia_id = provincias.provincia_id', 'left outer');
		$this -> db -> join("paises", 'provincias.pais_id = paises.pais_id', 'left outer');
		$this -> db -> where('clientes.es_delegado', 0);
		$this -> db -> where('clientes.cliente_id <>', 1); //cliente joker usado en compras que carecen de clientes.		
		$this -> db -> order_by('clientes.apellido', 'asc');
		//$query = $this->db->get('clientes', $config['per_page'], $this->uri->segment(3));
		$query = $this -> db -> get('clientes');
		
		foreach ($query->result() as $row) {
			$cID = $row -> cliente_id;
			$row -> cliente_id = anchor('modificar/cliente/' . $row -> cliente_id, $row -> cliente_id);
			// $tabla[$i]['checkbox'] = '<input type="checkbox" class="checkboxes addCliente" onchange="controlClient(this, \''.$cID.'\')" value="1" id="'.$cID.'">';
			$tabla[$i]['checkbox'] = '<input type="checkbox" class="checkboxes addCliente" id="checkbox_id_'.$cID.'">';
			$tabla[$i]['apellido'] = $row -> apellido;
			$tabla[$i]['nombre'] = $row -> cliName;
			$tabla[$i]['address'] = $row -> direccion;
			$tabla[$i]['ciudad'] = $row -> ciudad;
			$tabla[$i]['provincia'] = $row -> provinciaNombre;
			$tabla[$i]['pais'] = $row -> paisNombre;

			$actions = '
            <div class="'.$cID.'">
            	
            	TODO: Notification XXX: User presente ya en este evento en otro grupo o compra solo
            	
            </div>';
			$tabla[$i]['Actions'] = $actions;
			
			
			// $cell = array('data' => $tabla[$i]['checkbox'], 'id' => 'checkbox_td_id_'.$cID);
			// $row = Array(
				// $cell, 
				// $tabla[$i]['apellido'], 
				// $tabla[$i]['nombre'], 
				// $tabla[$i]['address'], 
				// $tabla[$i]['ciudad'], 
				// $tabla[$i]['provincia'], 
				// $tabla[$i]['pais'], 
				// $tabla[$i]['Actions']
			// );
			// $this->table->add_row(array('data' => $row, 'id'=>$cID));	
			
			
			// Esta modificacion permite añadir atributos a la fila.
			// Añadido el fichero MY_Table.php en application/libraries
			// https://github.com/dalehurley/codeigniter-table-rows
		    $rows[]=array('data'=>$tabla[$i], 'id'=>$cID);
			//or
			// $this->table->add_row(array('data'=>$row, 'class'=>'warning'));
			
			$i++;
		}
		
		$this->data['records'] = $rows;
		
		$this->data['header_title'] = "Hispalia | Reservas - Nueva";
		$this->data['h3'] = "RESERVAS";
		$this->data['breadcrumb'] = "Nueva Reserva";
		$this->data['portlet_caption'] = "Completar el formulario para realizar nueva reserva";

		// Variables included in php view file
		$visibleColumnsToExport = Array(1, 2, 3, 4, 5, 6);
		$this->data['visibleColumnsToExport'] = json_encode($visibleColumnsToExport);
		$orderableTargets = Array(6);
		$this->data['orderableTargets'] = json_encode($orderableTargets);
		$searchableTargets = Array(0,6);
		$this->data['searchableTargets'] = json_encode($searchableTargets);	
		// $this->data['confirmDelete'] = "Borrar cliente?";
		// $this->data['deleteRowURL'] = 'clientes_ajax/deleteCliente';
		// $this->data['modifyItemURL'] = 'clientes/modificar/';
		$this->data['deleteSelectedRowsURL'] = 'grupos_ajax/deleteSelectedGrupos';

		//Variables php que se cargaran en grupos.js
		$this->data['autocompleteModifcarURL'] = "/reservas/modificar";
		//Variables php que se cargaran en grupos.js
		$this->data['buttonAddNew'] = "Añadir otra reserva nueva";
		$this->data['buttonModifyCurrent'] = "Modificar esta reserva";
		$this->data['buttonViewAll'] = "Ver tabla con todas las rervas";
		$this->data['buttonAddNewURL'] ="reservas/nuevo";
		$this->data['buttonModifyCurrentURL'] ="reservas/modificar/";
		$this->data['buttonControllerURL'] ="reservas";	
		

	
		$this->load->view('reservas/nuevo', $this->data);
	}

	public function salvar_reserva()
	{
		$fecha_compra = date("Y-m-d H:i:s");  
		$evento_id = !empty($_POST['evento_id'] ) ? $_POST['evento_id'] : null;
		
		$data_compra = Array();
		$data_compra['fecha_compra'] = $fecha_compra;
		$data_compra['evento_id'] = $evento_id;
		$this->db->insert('compras', $data_compra);
		
		$compra_id = $this->db->insert_id();
		
		//PRODUCTOS
		if(!empty($_POST['prod_Type'])) {
			$data_producto = Array();
			$prod_type_array = $_POST['prod_Type'];
			$prod_concept_array = $_POST['prod_Concept'];
			$prod_units_array = $_POST['prod_Units'];
			$prod_price_units_array = $_POST['prod_PricePerUnit'];
			for($i = 0; $i < sizeof($prod_type_array); $i++) {
				$data_producto['tipo_producto_id'] = $prod_array[$i];
				$data_producto['concepto'] = $prod_concept_array[$i];
				$data_producto['unidades'] = $prod_units_array[$i];
				$data_producto['precio_unidad'] = $prod_price_units_array[$i];
				$data_producto['compra_id'] = $compra_id;
				$this->db->insert('productos', $data_producto);
			}
		}
		//PAGOS
		if(!empty($_POST['pa_Method'])){
			$data_pago = Array();
			$pago_method_array = $_POST['pa_Method'];
			$pago_import_array = $_POST['pa_Import'];
			$pago_concept_array = $_POST['pa_Concept'];
			for($i = 0; $i < sizeof($pago_method_array); $i++) {
				$data_pago['tipo_pago_id'] = $pago_method_array[$i];
				$data_pago['cantidad'] = $pago_import_array[$i];
				$data_pago['description'] = $pago_concept_array[$i];
				$data_pago['fecha_creacion'] = $fecha_compra;
				$data_pago['compra_id'] = $compra_id;
				$this->db->insert('pagos', $data_pago);
			}
		}
		//CLIENTES & EVENTO
		if(!empty($_POST['sc_clientsId'])) {
			$clientes_array = $_POST['sc_clientsId'];
			for($i = 0; $i < sizeof($clientes_array); $i++) {
			// foreach($clientes_array as $cl) {
				$data['cliente_id'] = $clientes_array[$i];
				$data['compra_id'] = $compra_id;
				if($evento_id != 1) {// no hay evento asociado
					$clientes_delegado_array = $_POST['sc_Delegate'];
					$clientes_tipos_array = $_POST['sc_ClientType'];
					$clientes_room_type_array = $_POST['sc_RoomType'];
					$data['es_delegado'] = $clientes_delegado_array[$i];
					$data['es_jugador'] = $clientes_tipos_array[$i];
					$data['tipo_habitacion'] = $clientes_room_type_array[$i];
				}
				$this->db->insert('clientes_compran', $data);
			}

		}
		
		//RESTO DE DATOS A RELLENAR PARA LA COMPRA
		$import_pagos_total = 0;
		$import_productos_total = 0;
		$import_eventos_total = 0;
		$balance = 0;
		
		$this->db->select('SUM(cantidad) as import_total');
		$this->db->where('compra_id', $compra_id);
		$import_pagos_total = $this->db->get('pagos')->row('import_total');
		
		$this->db->select('SUM(precio_total) as import_total');
		$this->db->where('compra_id', $compra_id);
		$import_productos_total = $this->db->get('productos')->row('import_total');
		
		if($evento_id != 1) {
			$this->db->select('jugador');
			$this->db->select('no_jugador');
			$this->db->select('niño');
			$this->db->where('evento_id', $evento_id);
			$precios = $this->db->get('precios')->row();
			
			$cont_jugador = 0;
			$cont_no_jugador = 0;
			$cont_suplemento_individual = 0;
			if(!empty($_POST['sc_clientsId'])) {
				for($i = 0; $i < sizeof($clientes_array); $i++) {
					if($clientes_tipos_array[$i] == 1) //jugador 
						$cont_jugador++;
					if($clientes_tipos_array[$i] == 0) //no jugador 
						$cont_no_jugador++;
					if($clientes_room_type_array[$i] == 1) //suplemento_individual
						$cont_suplemento_individual++;
				}
				
				$import_eventos_total =+ $precios->jugador * $cont_jugador;
				$import_eventos_total =+ $precios->no_jugador * $cont_no_jugador;
				$import_eventos_total =+ $precios->niño * $cont_suplemento_individual;
			}
		}
		
		$import_compras_total = $import_productos_total + $import_eventos_total;
		
		$balance = $import_pagos_total - $import_compras_total;
		
		$this->db->set('precio_total', $import_compras_total);
		$this->db->set('pagos_total', $import_pagos_total);
		$this->db->set('balance', $balance);
		$this->db->where('compra_id', $compra_id);
		$this->db->update('compras');
		
		

		// if ($this->input->post('action') != "modify") {
			// $data['compraID'] = $this->clientes_model->addCliente($data_cliente, $data_direccion, $data_valoracion);
		$return['compraID'] = $compra_id;
		$return['dialogInfoResponse'] = "Reserva salvada.";
		// MODIFY and UPDATE Client
		// }else {
			// $data['clientID'] = $this->input->post('client_id');
			// $data['dialogInfoResponse'] = "Cliente actualizado correctamente.";
			// $this->clientes_model->updateTablaCliente($data['clientID'], $data_cliente, $data_direccion, $data_valoracion);
		// }		

		echo json_encode($return);
	}
	
	private function inzialize_css()
	{
		
		$this->data['frontend_css'] = array(
			// BEGIN GENERAL STYLES
			//base_url().GENERAL_STYLES,
		
			// GLOBAL MANDATORY STYLES
			FONTS_GOOGLE_OPEN_SANS,
			base_url().FONT_AWESOME,
			base_url().FONT_SIMPLE_LINE_ICONS,
			base_url().BOOTSTRAP_MIN,
			base_url().UNIFORM_DEFAULT,
			base_url().BOOTSTRAP_SWITCH_MIN,
			
			// PAGE LEVEL STYLES
			//start insert new client
			base_url().JQUERY_UI,
			base_url().JQUERY_UI_MIN,
			base_url().BOOTSTRAP_DIALOG,
			base_url().BOOTSTRAP_DATEPICKER,
			//end insert new user
			//start view clients table
			base_url().SELECT2,
			// base_url().DATATABLES_SCROLLER_MIN,
			// base_url().DATATABLES_COL_REORDER,
			base_url().DATATABLES_BOOTSTRAP,
			base_url().DATATABLES_JQUERY_CSS,
			//end view clients table
			base_url().MUTISELECT_CSS,
						
			// THEME STYLES
			base_url().COMPONENTS,
			base_url().PLUGINS,			
			base_url().LAYOUT,
			base_url().LAYOUT_THEMES_DEFAULT,
			base_url().LAYOUT_CUSTOM,
			// base_url().HISPALIA_STYLE
		);		
		
	}

	private function inzialize_js()
	{
		$this->data['frontend_js'] = array(
		// BEGIN CORE PLUGINS
			base_url().JQUERY_1_11_0_MIN,
			base_url().JQUERY_MIGRATE_1_2_1_MIN,
			//IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip			
			base_url().JQUERY_UI_1_10_3_MIN,
			base_url().BOOTSTRAP_MIN_JS,
			base_url().BOOTSTRAP_HOVER_DROPDOWN_MIN,
			base_url().JQUERY_SLIMSCROLL_MIN,
			base_url().JQUERY_BLOCKUI_MIN,
			// base_url().JQUERY_COKIE_MIN,
			base_url().JQUERY_UNIFORM_MIN,
			base_url().BOOTSTRAP_SWITCH,
		// BEGIN PAGE LEVEL PLUGINS
			// begin new user
			base_url().JQUERY_VALIDATE_MIN,
			base_url().VALIDATION_ADDITIONAL_METHODS_MIN,
			base_url().BOOTSTRAP_DATEPICKER_JS,
			// base_url().BOOTSTRAP_DATEPICKER_JS,
			base_url().BOOTSTRAP_DIALOG_MIN,
			base_url().BOOTSTRAP_WIZARD_JS,
			// begin view all users
			base_url().SELECT2_MIN,
			base_url().JQUERY_DATATABLES_MIN,
			base_url().DATATABLES_TABLETOOLS_MIN,
			base_url().DATATABLES_BOOTSTRAP_JS,
			base_url().MUTISELECT_JS,
			base_url().MUTISELECT_FILTER_JS,
			
		// BEGIN PAGE LEVEL SCRIPTS	
			base_url().METRONIC,
			base_url().LAYOUT_JS,
			base_url().DEMO,
			base_url().QUICK_SIDEBAR,
			base_url().DATATABLE,
			base_url().RESERVAS,
			base_url().TABLE_RESERVAS_CLIENTES,
			base_url().TABLE_GENERAL_RESERVAS			
		);
	}	

	function getEventos(){
		$eventos = array();
		$eventos[0] = "- Select Event -";
		$this -> db -> select('eventos.evento_id');
		$this -> db -> select('eventos.nombre');
		$this -> db -> order_by('eventos.nombre', 'asc');
		$query = $this -> db -> get('eventos')->result_array();
		
		// print_r($query);
		
		foreach($query as $row){
			$eventos[$row['evento_id']] = $row['nombre'];
		}
		echo json_encode($eventos);
	}
	
	function getPreciosEvento(){
		$precios = array();
		$this -> db -> select('precios.jugador');
		$this -> db -> select('precios.no_jugador');
		$this -> db -> select('precios.niño AS nino');
		$this -> db -> select('precios.suplemento_individual');
		$this -> db -> join("precios", 'precios.evento_id = eventos.evento_id', 'left outer');
		$this->db->where('eventos.evento_id', $_POST['evento_id']);
		$precios = $this -> db -> get('eventos')->row_array();
		
		// print_r($precios);
		
		echo json_encode($precios);
	}	
	
	function getCompras(){
		
		// var_dump($_POST);
		
		$status_list = array(
			array("success" => "Master"),
		    array("info" => "Veterans"),
		    array("danger" => "Europeen"),
		    array("default" => "Lyonnaise")
		);
		
		$this->db->select('evento_id, nombre');
		$eventos_array_temp = $this->db->get('eventos')->result_array();
		$eventos = Array();
		foreach($eventos_array_temp as $key => $value) {
			$eventos[$value['evento_id']] = $value['nombre'];
		}
		
		$this->db->select('tipo_id, nombre');
		$eventos_tipos_array_temp = $this->db->get('tipos')->result_array();
		$eventos_tipos = Array();
		foreach($eventos_tipos_array_temp as $key => $value) {
			$eventos_tipos[$value['tipo_id']] = $value['nombre'];
		}
		
		// print_r($eventos_tipos);
		// exit;
	
		$this->db->select('compra_id');
		$this->db->order_by('compra_id', 'ASC');
		$num_rows = $this->db->get("compras")->num_rows();

		// print_r($_POST);
		// print_r($_POST['reserva_created_to']);
		
		$this->db->select('eventos.tipo_id');
		$this->db->select('compras.evento_id');
		$this->db->select('compras.compra_id');
		$this->db->select('(compras.precio_total - compras.pagos_total) AS balance');
		
		$this->db->join('eventos', 'eventos.evento_id = compras.evento_id', 'LEFT'); //para filtrar por tipo de evento
		$this->db->join('clientes_compran', 'clientes_compran.compra_id = compras.compra_id', 'LEFT'); //para filtrar por tipo de evento
						/* 
		 * FILTROS
		 */
		 	if(!empty($_POST['reserva_clientes'])) {
		 		// print_r($_POST['reserva_clientes']);
		 		$this->db->where_in('clientes_compran.cliente_id', $_POST['reserva_clientes']);
		 	}
		 	
		 	if(!empty($_POST['reserva_event_type'])) {
		 		$this->db->where('tipo_id', $_POST['reserva_event_type']);
		 	}
			if(!empty($_POST['reserva_id'])) $this->db->where('compra_id', $_POST['reserva_id']);
			if(!empty($_POST['reserva_created_from'])) $this->db->where('DATE(fecha_compra) >= \''.$_POST['reserva_created_from'].'\'');
			if(!empty($_POST['reserva_created_to'])) $this->db->where('DATE(fecha_compra) <  \''.$_POST['reserva_created_to'].'\'');
			
			if(!empty($_POST['reserva_event'])) $this->db->where('compras.evento_id', $_POST['reserva_event']);
			
			// if(!empty($_POST['reserva_balance'])) {$this->db->where('balance', $_POST['reserva_balance']);
			
			// $this->db->where('compras.evento_id', $_POST['reserva_event']);
			
			if(!empty($_POST['reserva_balance'])) {
				if($_POST['reserva_balance'] == 1)
					$this->db->where('balance >= 0');
					// $this->db->where('(precio_total - pagos_total) >= 0');
				if($_POST['reserva_balance'] == 2)
					// $this->db->where('(precio_total - pagos_total) < 0');
					$this->db->where('balance < 0');
			}


		/*
		 * FIN FILTROS
		 */		
		
		$this->db->order_by('fecha_compra', 'DESC');
		$this->db->group_by('compras.compra_id');
		$compras_ids_array = $this->db->get("compras", intval($_REQUEST['length']), intval($_REQUEST['start']))->result();

		// print_r($this->db->last_query()); echo "<br>";


		$records = array();
		$records["data"] = array();
				
		foreach($compras_ids_array as $com) {
			
			$contPlayers = 0;
			$contNoPlayers = 0;
			$contSingleSuppl = 0;
			$evento_cost = 0;
			
			//getPrecios Evento
			$this->db->select('evento_id');
			$this->db->where('compra_id', $com->compra_id);
			// $this->db->where('evento_id IS NOT NULL');
			$evento = $this->db->get('compras')->row();
			
			// print_r($evento); echo "<br>";
			// print_r($this->db->last_query()); echo "<br>";
			
			if(!empty($evento)) {
				
				$this->db->select('tipo_id');
				$this->db->where('evento_id', $evento->evento_id);
				$evento_tipo = $this->db->get('eventos')->row();
				
				$this->db->where('evento_id', $evento->evento_id);
				$precios_evento = $this->db->get('precios')->row();
				
				// print_r($precios_evento); echo "<br>";
				
				$this->db->distinct();
				$this->db->select('cliente_id');
				$this->db->select('es_jugador, tipo_habitacion');
				// $this->db->where('evento_id', $evento_id_compra[0]->evento_id);
				$this->db->where('compra_id', $com->compra_id);
				$clientes_compra = $this->db->get('clientes_compran')->result();
				
				foreach($clientes_compra as $cliente) {
					// print_r($cliente); echo "<br>";
					
					if($cliente->es_jugador) $contPlayers++;
					else $contNoPlayers++;
					if($cliente->tipo_habitacion == 1) $contSingleSuppl++;
					
					$temp_1 = $precios_evento->jugador * $contPlayers;
					$temp_2 = $precios_evento->no_jugador * $contNoPlayers;
					$temp_3 = $precios_evento->suplemento_individual * $contSingleSuppl;
					
					$evento_cost = $temp_1 + $temp_2 + $temp_3;
					
				}
			}

			//PRODUCTOS
			$this->db->select('SUM(precio_total) as importe');
			$this->db->where('compra_id', $com->compra_id);
			$productos = $this->db->get('productos')->row();
			
			//PAGOS
			$this->db->select('SUM(cantidad) as importe');
			$this->db->where('compra_id', $com->compra_id);
			$pagos = $this->db->get('pagos')->row();
			
			//CANTIDAD CLIENTES
			$this->db->select('COUNT(cliente_id) as qty');
			$this->db->where('compra_id', $com->compra_id);
			$clientes = $this->db->get('clientes_compran')->row();			
			
			//DATOS COMPRA
			$this->db->select('fecha_compra');
			$this->db->where('compras.compra_id', $com->compra_id);
			$compra = $this->db->get('compras')->row();
			
			// print_r($this->db->last_query()); exit;
			// print_r($evento_cost);
			$pagos_import = !empty($pagos->import) ? $pagos->import : 0;
			
			$balance_amount = $pagos->importe - ($productos->importe + $evento_cost);
			if($balance_amount > 0) $balance_span = '<span class="label label-success">'.$balance_amount.'</span>';
			if($balance_amount == 0) $balance_span = '<span class="label label-default">'.$balance_amount.'</span>';
			if($balance_amount < 0) $balance_span = '<span class="label label-danger">'.$balance_amount.'</span>';
			// print_r($this->db->last_query());
			// print_r($compra);
			// exit;
			//---------------------------
			// $status = $status_list[rand(0, 2)];
			$records["data"][] = array(
			'<input type="checkbox" name="id[]" value="'.$com->compra_id.'">',
			$com->compra_id,
			$compra->fecha_compra,
			'<a href="#" class="btn btn-xs btn-default" onclick="return alert(\'TODO\')">'.$clientes->qty.'</a>',
			!empty($productos->importe) ? $productos->importe : '',
			// '<span class="label label-sm label-'.(key($status)).'">'.(current($status)).'</span>',
			// $eventos[$compra->compra_evento_id],
			// 'XX',
			// print_r($evento_tipo),
			!empty($evento_tipo) ? $eventos_tipos[$evento_tipo->tipo_id] : '',//$event_type $eventos_tipos
			!empty($evento->evento_id) ? $eventos[$evento->evento_id] : '',
			$evento_cost,
			'<a href="#" class="btn btn-xs default btn-editable" onclick="return viewPagos('.$com->compra_id.')">'. $pagos_import .'</a>',
			$balance_span,
			'XX',
			''
			// '<a href="#" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i> Edit</a>',
			);			
		}
		
		// $compras = $this->db->get("compras", intval($_REQUEST['length']), intval($_REQUEST['start']))->result();
		
		// print_r($compras); exit;
				
		$iTotalRecords = $num_rows;
		// $iDisplayLength = intval($_REQUEST['length']); // rows by query (pagination)
		// $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		// $iDisplayStart = intval($_REQUEST['start']); // Could be OFFSET
		$sEcho = intval($_REQUEST['draw']);

		
		// $end = $iDisplayStart + $iDisplayLength;
		// $end = $end > $iTotalRecords ? $iTotalRecords : $end;


		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;
		
		echo json_encode($records);
	}
	
	function getCompras_metronic(){

		  $iTotalRecords = 2430;
  $iDisplayLength = intval($_REQUEST['length']);
  $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
  $iDisplayStart = intval($_REQUEST['start']);
  $sEcho = intval($_REQUEST['draw']);
  
  $records = array();
  $records["data"] = array(); 

  $end = $iDisplayStart + $iDisplayLength;
  $end = $end > $iTotalRecords ? $iTotalRecords : $end;

  $status_list = array(
    array("success" => "Publushed"),
    array("info" => "Not Published"),
    array("danger" => "Deleted")
  );

  for($i = $iDisplayStart; $i < $end; $i++) {
    $status = $status_list[rand(0, 2)];
    $id = ($i + 1);
    $records["data"][] = array(
      '<input type="checkbox" name="id[]" value="'.$id.'">',
      $id,
      'Test Product',
      'Mens/FootWear',
      '185.50$',      
      rand(5,4000),
      '05/01/2011',
      '<span class="label label-sm label-'.(key($status)).'">'.(current($status)).'</span>',
      '<a href="ecommerce_products_edit.html" class="btn btn-xs default btn-editable"><i class="fa fa-pencil"></i> Edit</a>',
    );
  }

	  if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
	    $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
	    $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
	  }
	
	  $records["draw"] = $sEcho;
	  $records["recordsTotal"] = $iTotalRecords;
	  $records["recordsFiltered"] = $iTotalRecords;
	  
	  echo json_encode($records);		
		
		
	}

	public function getPagos() 
	{
		$this->db->select('pagos.pago_id, tipo_pagos.nombre as metodo,  pagos.tipo_pago_id as metodo_id, pagos.cantidad, pagos.descripcion');
		$this->db->join('tipo_pagos', 'tipo_pagos.tipo_pago_id = pagos.tipo_pago_id', 'left');
		$this->db->where('compra_id', $_POST['compra_id']);
		$pagos = $this->db->get('pagos')->result_array();
		
		$html = '';
		if(!empty($pagos)) {
			foreach($pagos as $pago){
				$html .= '<tr data-pay_id="'.$pago['pago_id'].'">';
					$html .= '<td data-pay-method="'.$pago['metodo_id'].'">'.$pago['metodo'].'</td>';
					$html .= '<td>'.$pago['cantidad'].'</td>';
					$html .= '<td>'.$pago['descripcion'].'</td>';
					$html .= '<td><a href="#" class="fa fa-lg fa-trash-o" onclick="return deletePago(this);" title="Delete Payment"></a></td>';
				$html .= '</tr>';
			}
		}

		echo $html;
		
	}
	
	public function updatePagos()
	{	//delete all pagos from this compra
		// $this->db->where('compra_id', $_POST['compra_id']);
		// $this->db->delete('pagos');
		
		//PAGOS
		if(!empty($_POST['pa_Ids'])){
			$data_pago = Array();
			$pago_id_array = $_POST['pa_Ids'];
			$pago_method_array = $_POST['pa_Method'];
			$pago_import_array = $_POST['pa_Import'];
			$pago_concept_array = $_POST['pa_Concept'];
			$fecha_creacion = date("Y-m-d H:i:s");
			for($i = 0; $i < sizeof($pago_method_array); $i++) {
				if(empty($pago_id_array[$i])) { //new value
					$data_pago['tipo_pago_id'] = $pago_method_array[$i];
					$data_pago['cantidad'] = $pago_import_array[$i];
					$data_pago['description'] = $pago_concept_array[$i];
					$data_pago['fecha_creacion'] = $fecha_creacion;
					$data_pago['compra_id'] = $compra_id;
					$this->db->insert('pagos', $data_pago);
				}else{
					// $data_pago['pago_id'] = $pago_id_array[$i];
					// $data_pago['tipo_pago_id'] = $pago_method_array[$i];
					// $data_pago['cantidad'] = $pago_import_array[$i];
					// $data_pago['description'] = $pago_concept_array[$i];
					// $data_pago['fecha_creacion'] = $fecha_creacion;
					// $data_pago['compra_id'] = $compra_id;
					// $this->db->update('pagos');
				}
			}
		}		
	}

	public function deletePago()
	{
		$this->db->where('pago_id', $_POST['pago_id']);
		$this->db->delete('pagos');
		
		$this->db->select('SUM(cantidad) as total');
		$this->db->where('compra_id', $_POST['compra_id']);
		$pagos_total = $this->db->get('pagos')->row();
		
		$this->db->select('precio_total as total');
		$this->db->where('compra_id', $_POST['compra_id']);
		$precio_total = $this->db->get('compras')->row();
		
		$data['balance'] = $precio_total->total - $pagos_total;
		$data['pagos_total'] = $pagos_total->total;
		$this->db->where('compras_id', $_POST['compra_id']);
		$this->db->update('compras', $data);

	}

}