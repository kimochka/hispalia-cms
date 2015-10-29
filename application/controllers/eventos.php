<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Eventos extends CI_Controller {
		
	public $data;
		
	function __construct(){		
		parent::__construct();

		$this->inzialize_css();
		$this->inzialize_js();
		
		$this->data['mainMenu'] =& buildMainMenu();	
		$this->data['footer'] = eval(FOOTER);
		
	}
	
	//TODO
	function nuevo() {
		
 		if($query = $this->clientes_model->getPaises_2()) {
			foreach ($query as $row) {
				$paises[$row->pais_id] = $row->nombre;
			}
			$this->data['paises'] = $paises;
		}   

        $tipos = array();
        if($query = $this->eventos_model->getTiposEventos()) {
            foreach ($query as $row) {
                $tipos[$row->tipo_id] = $row->nombre;
            }
            // $tipos[0] = 'Escoge Tipo de Evento';
        }
        $this->data['tipos'] = $tipos;

        $hoteles = array();
		// $deFaultPais = 13;
        // if($hoteles = $this->hoteles_model->getHoteles($deFaultPais, null)) {
            // // foreach ($query as $row) {
                // // $tipos[$row->tipo_id] = $row->nombre;
            // // }
            // $hoteles[0] = 'Escoge Hotel';
        // }
        $this->data['hoteles'] = $hoteles;
		
		$paisDefault = 13;
		$this->data['paisDefault'] = $paisDefault;
		$provincias = Array();
		$this->data['provincias'] = $provincias;
						
		$this->data['header_title'] = "Hispalia | Eventos - Nuevo";
		$this->data['h3'] = "EVENTOS";
		$this->data['breadcrumb'] = "Nuevo Evento";
		$this->data['portlet_caption'] = "Completar el formulario del nuevo Evento";

		//Variables php que se cargaran en clientes.js
		$this->data['autocompleteNombreURL'] = "/eventos_ajax/checkIfEventoExistsByName";
		$this->data['autocompleteModifcarURL'] = "/eventos/modificar";
		
		//Variables php que se cargaran en form-validation.js
		$this->data['buttonAddNew'] = "Añadir otro evento nuevo";
		$this->data['buttonModifyCurrent'] = "Modificar este evento";
		$this->data['buttonViewAll'] = "Ver tabla con todos los eventos";
		$this->data['buttonAddNewURL'] ="eventos/nuevo";
		$this->data['buttonModifyCurrentURL'] ="eventos/modificar/";
		$this->data['buttonControllerURL'] ="eventos";
				
		$this->load->view("eventos/nuevo", $this->data);
	}

	function salvar_evento() {
			
		// echo "hola:"; print_r($_POST);exit;
		
		$data_evento = array(
			'nombre' 			=> $this->input->post('nombre'),
			'tipo_id' 			=> !empty($this->input->post('tipo_evento')) ? $this->input->post('tipo_evento') : NULL,
			'hotel_id' 			=> !empty($this->input->post('hotel')) ? $this->input->post('hotel') : NULL,
			'fecha_in' 			=> !empty($this->input->post('web')) ? $this->input->post('web') : NULL,
			'fecha_out' 		=> !empty($this->input->post('web')) ? $this->input->post('web') : NULL,
		);

		$data_precios = array(
			'jugador' 	=> !empty($this->input->post('precio_jugador')) ? $this->input->post('precio_jugador') : NULL,
			'no_jugador' 	=> !empty($this->input->post('precio_no_jugador')) ? $this->input->post('precio_no_jugador') : NULL,
			'niño' 	=> !empty($this->input->post('precio_nino')) ? $this->input->post('precio_nino') : NULL,
			'suplemento_individual' 	=> !empty($this->input->post('precio_suplemento_individual')) ? $this->input->post('precio_suplemento_individual') : NULL,
		);

		//NEW hotel
		// if (!empty($this->input->post('action'))) {
		if ($this->input->post('action') != "modify") {
			$data['eventoID'] = $this->eventos_model->addEvento($data_evento, $data_precios);
			$data['dialogInfoResponse'] = "Evento registrado.";
		// MODIFY and UPDATE Hotel
		}else {
			$data['eventoID'] = $this->input->post('evento_id');
			$data['dialogInfoResponse'] = "Evento actualizado correctamente.";
			$this->eventos_model->updateTablaEventos($data['eventoID'], $data_evento, $data_precios);
		}
		echo json_encode($data);
	}

	
	//TODO
	function index() {
		$config['base_url'] = base_url('eventos');
		$config['total_rows'] = $this ->db->get('eventos')->num_rows();
		$config['per_page'] = 1;
		$config['num_links'] = 1;

		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';

		$tmpl = array(
			'table_open'		  => '<table class="table table-striped table-bordered table-hover" id="general_table">',
           // 'heading_cell_start'  => '<th class="table-checkbox">', //TODO modificar para que solo sea aplicable a la primera celda del header (primer <th>)
			'row_start'           => '<tr class="odd gradeX">'
		);
		/*
		 * Para añadir una primera fila de filtros
		$tmpl = array(
			'table_open' 		=> '<table class="table table-striped table-bordered table-hover" id="datatable_ajax">',
			'heading_row_start' => '<tr role="row" class="heading">'
		);
		 * */
		
		$this -> table -> set_template($tmpl);

		$this -> table -> set_heading('<input type="checkbox" class="group-checkable" data-set="#general_table .checkboxes"/>', 'Nombre', 'Tipo', 'City', 'Region', 'Country', 'From', 'To', 'Precio Jugador', 'Precio No jugador', 'Precio Niño', 'Precio Suplemento Individual', 'Actions');

		$this -> load -> library('pagination');
		//$this->pagination->initialize($config);

		$tabla = array();
		$i = 0;
		
		$this -> db -> select('eventos.evento_id');
		$this -> db -> select('eventos.nombre AS eventoName');
		$this -> db -> select('eventos.fecha_in');
		$this -> db -> select('eventos.fecha_out');
		$this -> db -> select('eventos.hotel_id');
		$this -> db -> select('eventos.tipo_id');

		$this -> db -> select('precios.jugador');
		$this -> db -> select('precios.no_jugador');
		$this -> db -> select('precios.suplemento_individual');
		$this -> db -> select('precios.niño');

		$this -> db -> select('tipos.nombre AS tipoNombre');

		$this -> db -> select('provincias.nombre AS provinciaNombre');

		$this -> db -> select('paises.nombre AS paisNombre');

		$this -> db -> join("direcciones", 'eventos.hotel_id = direcciones.hotel_id', 'left outer');
		$this -> db -> join("provincias", 'direcciones.provincia_id = provincias.provincia_id', 'left outer');
		$this -> db -> join("paises", 'provincias.pais_id = paises.pais_id', 'left outer');
		$this -> db -> join("tipos", 'tipos.tipo_id = eventos.tipo_id', 'left outer');
		$this -> db -> join("precios", 'eventos.evento_id = precios.evento_id', 'left outer');
		$this -> db -> join("hoteles", 'eventos.hotel_id = hoteles.hotel_id', 'left outer');
		$this -> db -> order_by('eventos.nombre', 'asc');
		$query = $this -> db -> get('eventos');
		
		foreach ($query->result() as $row) {
			$eID = $row -> evento_id;
			$row -> hotel_id = anchor('modificar/evento/' . $eID, $eID);
			$tabla[$i]['checkbox'] = '<input type="checkbox" class="checkboxes" value="1" id="'.$eID.'">';
			$tabla[$i]['nombre'] = $row -> eventoName;
			$tabla[$i]['tipo'] = $row -> tipoNombre;
			$tabla[$i]['ciudad'] = $row -> ciudad;
			$tabla[$i]['provincia'] = $row -> provinciaNombre;
			$tabla[$i]['pais'] = $row -> paisNombre;
			$tabla[$i]['fecha_in'] = $row -> fecha_in;
			$tabla[$i]['fecha_out'] = $row -> fecha_out;

			$tabla[$i]['jugador'] = $row -> jugador;
			$tabla[$i]['no_jugador'] = $row -> no_jugador;
			$tabla[$i]['niño'] = $row -> niño;
			$tabla[$i]['suplemento_individual'] = $row -> suplemento_individual;
			


			$this->db->where('evento_id', $eID);
			$hoteles = $this->db->get('compras')->result_array();
			
			
			$actions = '
            <div id="'.$eID.'">
            	<span class="fa fa-lg fa-pencil modifyButton" title="Modificar"></span>
            	<span class="separator">&nbsp;</span>';
			
			if(empty($hoteles))
            	$actions .= '<span class="fa fa-lg fa-trash-o deleteButton" title="Borrar" id="button-delete-'. $eID .'"></span>';
            
            $actions .= '</div>';
			
			$tabla[$i]['Actions'] = $actions;
			
			$i++;
		}
		
		$this->data['records'] = $tabla;
		
		$this->data['header_title'] = "Hispalia | Eventos - Tabla";
		$this->data['h3'] = "EVENTOS";
		$this->data['breadcrumb'] = "Tabla Eventos";
		$this->data['tableAddButtonHref'] = "eventos";
		$this->data['tableAddButton'] = "Añadir nuevo evento";
		//$this->data['tableCreateNewGroup'] = "Crea nuevo grupo";
		
		$this->data['tabla_controller'] = "hoteles";
		
		// Variables included in php view file
		$visibleColumnsToExport = Array(1, 2, 3, 4, 5, 6, 7	);
		$this->data['visibleColumnsToExport'] = json_encode($visibleColumnsToExport);
		$orderableTargets = Array(8);
		$this->data['orderableTargets'] = json_encode($orderableTargets);
		$searchableTargets = Array(0,8);
		$this->data['searchableTargets'] = json_encode($searchableTargets);
		$this->data['confirmDelete'] = "Borrar evento?";
		$this->data['deleteRowURL'] = 'eventos_ajax/deleteEvento';
		$this->data['modifyItemURL'] = 'eventos/modificar/';
		//$this->data['deleteSelectedRowsURL'] = 'eventos_ajax/deleteSelectedEventos';
		
		$this->load->view("eventos/general_table", $this->data);
				
		
		
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
			//start insert new hotel
			base_url().JQUERY_UI,
			base_url().JQUERY_UI_MIN,
			base_url().BOOTSTRAP_DIALOG,
			// base_url().BOOTSTRAP_DATEPICKER,
			base_url().BOOTSTRAP_DATERANGEPICKER,
			//end insert new user
			//start view hotels table
			base_url().SELECT2,
			// base_url().DATATABLES_SCROLLER_MIN,
			// base_url().DATATABLES_COL_REORDER,
			base_url().DATATABLES_BOOTSTRAP,
			base_url().DATATABLES_JQUERY_CSS,
			//end view hotels table
						
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
			// base_url().BOOTSTRAP_DATEPICKER_JS,
			base_url().MOMENT_DATERANGEPICKER,
			base_url().BOOTSTRAP_DATERANGEPICKER_JS,
			base_url().BOOTSTRAP_DIALOG_MIN,
			// base_url().BOOTSTRAP_WIZARD_JS,
			// begin view all users
			base_url().SELECT2_MIN,
			base_url().JQUERY_DATATABLES_MIN,
			base_url().DATATABLES_TABLETOOLS_MIN,
			base_url().DATATABLES_BOOTSTRAP_JS,
			
		// BEGIN PAGE LEVEL SCRIPTS	
			base_url().METRONIC,
			base_url().LAYOUT_JS,
			base_url().DEMO,
			base_url().QUICK_SIDEBAR,
			base_url().EVENTOS,
			base_url().FORM_VALIDATION_EVENTOS,
			base_url().TABLE_GENERAL_EVENTOS
			
		);	
	}

}