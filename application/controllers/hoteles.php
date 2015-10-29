<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Hoteles extends CI_Controller {
		
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
		
		$paisDefault = 13;
		$this->data['paisDefault'] = $paisDefault;
		$provincias = Array();
		$this->data['provincias'] = $provincias;
						
		$this->data['header_title'] = "Hispalia | Hoteles - Nuevo";
		$this->data['h3'] = "HOTELES";
		$this->data['breadcrumb'] = "Nuevo Hotel";
		$this->data['portlet_caption'] = "Completar el formulario del nuevo Hotel";

		//Variables php que se cargaran en clientes.js
		$this->data['autocompleteNombreURL'] = "/hoteles_ajax/checkIfHotelExistsByName";
		$this->data['autocompleteModifcarURL'] = "/hoteles/modificar";
		
		//Variables php que se cargaran en form-validation.js
		$this->data['buttonAddNew'] = "Añadir otro hotel nuevo";
		$this->data['buttonModifyCurrent'] = "Modificar este hotel";
		$this->data['buttonViewAll'] = "Ver tabla con todos los hoteles";
		$this->data['buttonAddNewURL'] ="hoteles/nuevo";
		$this->data['buttonModifyCurrentURL'] ="hoteles/modificar/";
		$this->data['buttonControllerURL'] ="hoteles";
				
		$this->load->view("hoteles/nuevo", $this->data);
	}

	function salvar_hotel() {
		
    		$data_hotel = array(
    			'nombre' 			=> $this->input->post('nombre'),
    			'email' 			=> !empty($this->input->post('email')) ? $this->input->post('email') : NULL,
    			'telefono' 			=> !empty($this->input->post('telefono')) ? $this->input->post('telefono') : NULL,
    			'web' 			=> !empty($this->input->post('web')) ? $this->input->post('web') : NULL,
    			);

			// echo "GENERO: ";
			// print_r($data_hotel); exit;
			
    		$data_direccion = array (
    			'direccion' 		=> !empty($this->input->post('direccion')) ? $this->input->post('direccion') : NULL,
    			'ciudad'			=> !empty($this->input->post('ciudad')) ? $this->input->post('ciudad') : NULL,
    			'cp'				=> !empty($this->input->post('cp')) ? $this->input->post('cp') : NULL,
    			'hotel_id'			=> NULL    			
    			);

    		$rows = $this->hoteles_model->getProvinciaID($this->input->post('provincias'));

    		$data_direccion['provincia_id'] = $this->input->post('provincias');
            
  
    		$data_valoracion = array();
    		
    		// Si se quiere valorar al hotel
			//coger los valores de lista negra y comentarios y meterlos todos juntos en $data
			//registrar datos
			if ($this->input->post('lista_negra') == "Yes") {
				$data_valoracion['lista_negra'] = TRUE;
			}
			else {
				$data_valoracion['lista_negra'] = FALSE;
			}
			
			
			if (empty($this->input->post('comentario'))) {
				$data_valoracion['comentario'] = NULL;
			} else {
				$data_valoracion['comentario'] = $this->input->post('comentario');
			}

			$data_valoracion['hotel_id'] = NULL;
			//NEW hotel
			// if (!empty($this->input->post('action'))) {
			if ($this->input->post('action') != "modify") {
    			$data['hotelID'] = $this->hoteles_model->addHotel($data_hotel, $data_direccion, $data_valoracion);
				$data['dialogInfoResponse'] = "Hotel registrado.";
			// MODIFY and UPDATE Hotel
			}else {
				$data['hotelID'] = $this->input->post('hotel_id');
				$data['dialogInfoResponse'] = "Hotel actualizado correctamente.";
    			$this->hoteles_model->updateTablaHoteles($data['hotelID'], $data_hotel, $data_direccion, $data_valoracion);
			}
			echo json_encode($data);
		}

	
	//TODO
	function index() {
		$config['base_url'] = base_url('clientes');
		$config['total_rows'] = $this ->db->get('clientes')->num_rows();
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

		$this -> table -> set_heading('<input type="checkbox" class="group-checkable" data-set="#general_table .checkboxes"/>', 'Nombre', 'Address', 'City', 'Region', 'Country', 'Tlf', 'e-mail', 'Actions');

		$this -> load -> library('pagination');
		//$this->pagination->initialize($config);

		$tabla = array();
		$i = 0;
		
		$this -> db -> select('hoteles.hotel_id');
		$this -> db -> select('hoteles.nombre AS hotelName');
		$this -> db -> select('hoteles.telefono');
		$this -> db -> select('hoteles.email');

		$this -> db -> select('direcciones.direccion');
		$this -> db -> select('direcciones.ciudad');

		$this -> db -> select('provincias.nombre AS provinciaNombre');

		$this -> db -> select('paises.nombre AS paisNombre');

		$this -> db -> join("direcciones", 'hoteles.hotel_id = direcciones.hotel_id', 'left outer');
		$this -> db -> join("provincias", 'direcciones.provincia_id = provincias.provincia_id', 'left outer');
		$this -> db -> join("paises", 'provincias.pais_id = paises.pais_id', 'left outer');
		$this -> db -> order_by('hoteles.nombre', 'asc');
		$query = $this -> db -> get('hoteles');
		
		foreach ($query->result() as $row) {
			$hID = $row -> hotel_id;
			$row -> hotel_id = anchor('modificar/hotel/' . $row -> hotel_id, $row -> hotel_id);
			$tabla[$i]['checkbox'] = '<input type="checkbox" class="checkboxes" value="1" id="'.$hID.'">';
			$tabla[$i]['nombre'] = $row -> hotelName;
			$tabla[$i]['address'] = $row -> direccion;
			$tabla[$i]['ciudad'] = $row -> ciudad;
			$tabla[$i]['provincia'] = $row -> provinciaNombre;
			$tabla[$i]['pais'] = $row -> paisNombre;
			$tabla[$i]['telefono'] = $row -> telefono;
			$tabla[$i]['email'] = $row -> email;

			$this->db->where('hotel_id', $hID);
			$hoteles = $this->db->get('hoteles')->result_array();
			
			
			$actions = '
            <div id="'.$hID.'">
            	<span class="fa fa-lg fa-pencil modifyButton" title="Modificar"></span>
            	<span class="separator">&nbsp;</span>';
			
			if(empty($hoteles))
            	$actions .= '<span class="fa fa-lg fa-trash-o deleteButton" title="Borrar" id="button-delete-'. $hID .'"></span>';
            
            $actions .= '</div>';
			
			$tabla[$i]['Actions'] = $actions;
			
			$i++;
		}
		
		$this->data['records'] = $tabla;
		
		$this->data['header_title'] = "Hispalia | Hoteles - Tabla";
		$this->data['h3'] = "HOTELES";
		$this->data['breadcrumb'] = "Tabla Hoteles";
		$this->data['tableAddButtonHref'] = "hoteles";
		$this->data['tableAddButton'] = "Añadir nuevo hotel";
		$this->data['tableCreateNewGroup'] = "Crea nuevo grupo";
		
		$this->data['tabla_controller'] = "hoteles";
		
		// Variables included in php view file
		$visibleColumnsToExport = Array(1, 2, 3, 4, 5, 6, 7	);
		$this->data['visibleColumnsToExport'] = json_encode($visibleColumnsToExport);
		$orderableTargets = Array(8);
		$this->data['orderableTargets'] = json_encode($orderableTargets);
		$searchableTargets = Array(0,8);
		$this->data['searchableTargets'] = json_encode($searchableTargets);
		$this->data['confirmDelete'] = "Borrar hotel?";
		$this->data['deleteRowURL'] = 'hoteles_ajax/deleteHotel';
		$this->data['modifyItemURL'] = 'hoteles/modificar/';
		$this->data['deleteSelectedRowsURL'] = 'hoteles_ajax/deleteSelectedHoteles';
		
		$this->load->view("hoteles/general_table", $this->data);
				
		
		
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
			base_url().BOOTSTRAP_DATEPICKER,
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
			base_url().HOTELES,
			base_url().FORM_VALIDATION_HOTELES,
			base_url().TABLE_GENERAL_HOTELES
			
		);	
	}

}