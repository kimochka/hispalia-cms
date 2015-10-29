<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Delegados extends CI_Controller {
		
	public $data;
	
	function __construct(){		
		parent::__construct();

		$this->inzialize_css();		
		$this->inzialize_js();	
		
		$this->data['mainMenu'] =& buildMainMenu();	
		
	}	
	
	function index() {
		
		$config['base_url'] = base_url('delegados');
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

		$this -> table -> set_heading('<input type="checkbox" class="group-checkable" data-set="#general_table .checkboxes"/>', 'Apellido', 'Nombre', 'Address', 'City', 'Region', 'Country', 'Tlf', 'e-mail', 'Talla Camiseta', 'Actions');

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
		$this -> db -> where('clientes.es_delegado', 1);
		$this -> db -> order_by('clientes.apellido', 'asc');
		//$query = $this->db->get('clientes', $config['per_page'], $this->uri->segment(3));
		$query = $this -> db -> get('clientes');
		
		$medidas_camiseta = eval(CAMISETAS);
		
		
		foreach ($query->result() as $row) {
			$cID = $row -> cliente_id;
			$row -> cliente_id = anchor('modificar/cliente/' . $row -> cliente_id, $row -> cliente_id);
			$tabla[$i]['checkbox'] = '<input type="checkbox" class="checkboxes" value="1" cliente="'.$cID.'">';
			//$tabla[$i]['cliente_id'] = $row -> cliente_id;
			$tabla[$i]['apellido'] = $row -> apellido;
			$tabla[$i]['nombre'] = $row -> cliName;
			$tabla[$i]['address'] = $row -> direccion;
			$tabla[$i]['ciudad'] = $row -> ciudad;
			$tabla[$i]['provincia'] = $row -> provinciaNombre;
			$tabla[$i]['pais'] = $row -> paisNombre;
			$tabla[$i]['telefono'] = $row -> telefono;
			$tabla[$i]['email'] = $row -> email;
			$tabla[$i]['camiseta'] = !empty($row -> camiseta) ? $medidas_camiseta[$row -> camiseta] : null;

			$actions = '
            <div cliente="'.$cID.'">
            	<span class="fa fa-lg fa-pencil modifyButton" title="Modificar"></span>
            	<span class="separator">&nbsp;</span>
            	<span class="fa fa-lg fa-trash-o deleteButton" title="Borrar" id="button-delete-'. $cID .'"></span>
            </div>';
			$tabla[$i]['Actions'] = $actions;
			
			$i++;
		}
		
		$this->data['records'] = $tabla;
		
		$this->data['header_title'] = "Hispalia | Delegados - Tabla";
		$this->data['h3'] = "DELEGADOS";
		$this->data['breadcrumb'] = "Tabla Delegados";
		$this->data['tableAddButtonHref'] = "delegados";
		$this->data['tableAddButton'] = "Añadir nuevo delegado";
		
		$this->data['tabla_controller'] = "delegados";
		
		// Variables included in php view file
		$visibleColumnsToExport = Array(1, 2, 3, 4, 5, 6, 7, 8, 9);
		$this->data['visibleColumnsToExport'] = json_encode($visibleColumnsToExport);
		$orderableTargets = Array(10);
		$this->data['orderableTargets'] = json_encode($orderableTargets);		
		$searchableTargets = Array(0,10);
		$this->data['searchableTargets'] = json_encode($searchableTargets);		
		$this->data['confirmDelete'] = "Borrar delegado?";
		$this->data['deleteRowURL'] = 'clientes_ajax/deleteCliente';
		$this->data['modifyItemURL'] = 'clientes/modificar/';
		$this->data['deleteSelectedRowsURL'] = 'clientes_ajax/deleteSelectedClientes';
		
		$this->load->view("general_views/general_table1", $this->data);
	}	

	function nuevo() {
        
 		if($query = $this->clientes_model->getPaises_2()) {
			foreach ($query as $row) {
				$paises[$row->pais_id] = $row->nombre;
			}
			$this->data['paises'] = $paises;
		}   
		$paisDefault = 15;
		$this->data['paisDefault'] = $paisDefault;
		$provincias = Array();
		$this->data['provincias'] = $provincias;
		
				
		$this->data['header_title'] = "Hispalia | Delegados - Nuevo";
		$this->data['h3'] = "DELEGADOS";
		$this->data['breadcrumb'] = "Nuevo Delegado";
		$this->data['portlet_caption'] = "Completar el formulario del nuevo Delegado";
		
		//Variables php que se cargaran en clientes.js
		$this->data['autocompleteNombreURL'] = "/clientes_ajax/checkIfClienteExistsByName";
		$this->data['autocompleteApellidoURL'] = "/clientes_ajax/checkIfClienteExistsBySurname";
		$this->data['autocompleteModifcarURL'] = "/delegados/modificar";
		
		//Variables php que se cargaran en form-validation.js
		$this->data['buttonAddNew'] = "Añadir otro delegado nuevo";
		$this->data['buttonModifyCurrent'] = "Modificar este delegado";
		$this->data['buttonViewAll'] = "Ver tabla con todos los delegados";
		$this->data['buttonAddNewURL'] ="delegados/nuevo";
		$this->data['buttonModifyCurrentURL'] ="delegados/modificar/";
		$this->data['buttonControllerURL'] ="delegados";
		
				
		$this->load->view("clientes/nuevo", $this->data);
	}

	function salvar_cliente() {
    		$data_cliente = array(
    			'nombre' 			=> $this->input->post('nombre'),
    			'apellido' 			=> $this->input->post('apellido'),
    			'email' 			=> !empty($this->input->post('email')) ? $this->input->post('email') : NULL,
    			'telefono' 			=> !empty($this->input->post('telefono')) ? $this->input->post('telefono') : NULL,
    			'movil' 			=> !empty($this->input->post('movil')) ? $this->input->post('movil') : NULL,
                'fecha_nacimiento'  => !empty($this->input->post('datepicker')) ? $this->input->post('datepicker') : NULL,
                'camiseta'          => $this->input->post('medida_camiseta'),
                'genero'			=> !empty($this->input->post('genero')) ? $this->input->post('genero') : NULL,
    			);
    		$data_direccion = array (
    			'direccion' 		=> !empty($this->input->post('direccion')) ? $this->input->post('direccion') : NULL,
    			'ciudad'			=> !empty($this->input->post('ciudad')) ? $this->input->post('ciudad') : NULL,
    			'cp'				=> !empty($this->input->post('cp')) ? $this->input->post('cp') : NULL,
    			'grupo_id'			=> NULL    			
    			);

    		$rows = $this->clientes_model->getProvinciaID($this->input->post('provincias'));

    		$data_direccion['provincia_id'] = $this->input->post('provincias');
            
    		$data_cliente['es_delegado'] = 1;
	
    		$data_valoracion = array();
    		
    		// Si se quiere valorar al cliente
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

			$data_valoracion['grupo_id'] = NULL;
			//NEW client
			if (!empty($this->input->post('action'))) {
    			$data['clientID'] = $this->clientes_model->addCliente($data_cliente, $data_direccion, $data_valoracion);
				$data['dialogInfoResponse'] = "Delegado registrado.";
			// MODIFY and UPDATE Client
			}else {
				$data['clientID'] = $this->input->post('client_id');
				$data['dialogInfoResponse'] = "Delegado actualizado correctamente.";
    			$this->clientes_model->updateTablaCliente($data['clientID'], $data_cliente, $data_direccion, $data_valoracion);
			}
			echo json_encode($data);
	}


	function modificar() {
		if($query = $this->clientes_model->getCliente($this->uri->segment(3))) {
			$this->data['cliente'] = $query;
		}
		if($clienteAddress = $this->clientes_model->getClienteAddress($this->uri->segment(3))) {
			// print_r($clienteAddress[0]);
			$this->data['cliente_direccion'] = $clienteAddress;
			// Recoger la provincia del cliente
			$cliente_provincia = array();
			if($query = $this->clientes_model->getProvincia($clienteAddress[0]['provincia_id'])) {
				foreach ($query as $row) {
					$cliente_provincia[$row->provincia_id] = $row->nombre;
					$temp_pais_id = $row->pais_id;
				}
				$this->data['cliente_provincia'] = $cliente_provincia;
				// recoger el pais del cliente
				$cliente_pais = array();
				if($query = $this->clientes_model->getPais($temp_pais_id)) {
					foreach($query as $row) {
						$cliente_pais[$row->pais_id] = $row->nombre;
					}	
					$this->data['cliente_pais'] = $cliente_pais;
					//$this->data['cliente_pais'] = $query[0]['nombre'];
				}
				// Recoger todas las provincas del pais del cliente
				// creando un array ordenado donde cada posicion corresponde realmente
				// a la posicion en la BBDD.
				$provincias = array();
				if($query = $this->clientes_model->getProvinciasID($temp_pais_id)) {
					foreach ($query as $row) {
						$provincias[$row->provincia_id] = $row->nombre;
					}

					$this->data['provincias'] = $provincias;
				}
			} else // Provincia ID = NULL -> no hace falta desarrollar puesto que hemos 
			// puesto un Validation (is_required|is_natural_non_zero) en la funcion checkFormValidation()
			{
			    
			}
		} else {
			$temp_pais_id = 1;
			$this->data['cliente_direccion'] = NULL;
			$cliente_provincia = array('1' => 'Alsace');
			$cliente_pais = array('1' => 'France');

			$this->data['cliente_provincia'] = $cliente_provincia;
			$this->data['cliente_pais'] = $cliente_pais;
			
			// Recoger todas las provincas del pais del cliente
			// creando un array ordenado donde cada posicion corresponde realmente
			// a la posicion en la BBDD.
			$provincias = array();
			if($query = $this->clientes_model->getProvinciasID($temp_pais_id)) {
				foreach ($query as $row) {
					$provincias[$row->provincia_id] = $row->nombre;
				}
				$this->data['provincias'] = $provincias;
			}
		}
		
		// Recoger todos los países de la BBDD
		$paises = array();
		if($query = $this->clientes_model->getPaises_2()) {
			foreach ($query as $row) {
				$paises[$row->pais_id] = $row->nombre;
			}
			$this->data['paises'] = $paises;
		}

		if($query = $this->clientes_model->getValoraciones($this->uri->segment(3))) {
			// SÍ tiene valoraciones
			foreach ($query as $row) {
				$this->data['cliente_comentario'] = $row->comentario;
				$this->data['lista_negra'] = $row->lista_negra;
			}
		} else {
			// NO se han encontrado valoraciones
			$this->data['cliente_comentario'] = NULL;
			$this->data['lista_negra'] = 0;
		}

		//Coger y todas las paises:
		/*
		if($query3 = $this->clientes_model->getPaises()) {
			if ($query3 != -1) {
				$this->data['paises'] = $query3;
			} else {
				$this->data['paises'] = NULL;
			}
		}*/
        
        
		$this->data['header_title'] = "Hispalia | Delegado - Modificar";

		$this->data['h3'] = "DELEGADOS";
		$this->data['breadcrumb'] = "Modificar Delegado";
		$this->data['portlet_caption'] = "Completar el formulario del Delegado";

		//Variables php que se cargaran en clientes.js
		$this->data['autocompleteNombreURL'] = "/clientes_ajax/checkIfClienteExistsByName";
		$this->data['autocompleteApellidoURL'] = "/clientes_ajax/checkIfClienteExistsBySurname";
		$this->data['autocompleteModifcarURL'] = "/delegados/modificar";
		
		//Variables php que se cargaran en form-validation.js
		$this->data['buttonAddNew'] = "Añadir otro delegado nuevo";
		$this->data['buttonModifyCurrent'] = "Modificar este delegado";
		$this->data['buttonViewAll'] = "Ver tabla con todos los delegados";;
		$this->data['buttonAddNewURL'] ="delegados/nuevo";
		$this->data['buttonModifyCurrentURL'] ="delegados/modificar/";
		$this->data['buttonControllerURL'] ="delegados";	
		
		$this->load->view('clientes/modificar', $this->data);
		
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
			//end view clients table
						
			// THEME STYLES
			base_url().COMPONENTS,
			base_url().PLUGINS,			
			base_url().LAYOUT,
			base_url().LAYOUT_THEMES_DEFAULT,
			base_url().LAYOUT_CUSTOM,
			base_url().HISPALIA_STYLE
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
			base_url().JQUERY_COKIE_MIN,
			base_url().JQUERY_UNIFORM_MIN,
			base_url().BOOTSTRAP_SWITCH,
		// BEGIN PAGE LEVEL PLUGINS
			// begin new user
			base_url().JQUERY_VALIDATE_MIN,
			base_url().VALIDATION_ADDITIONAL_METHODS_MIN,
			base_url().BOOTSTRAP_DATEPICKER_JS,
			base_url().BOOTSTRAP_DIALOG_MIN,
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
			base_url().CLIENTES,
			base_url().FORM_VALIDATION,
			base_url().TABLE_GENERAL
		);	
	}
	
}