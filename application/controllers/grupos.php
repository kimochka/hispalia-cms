<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Grupos extends CI_Controller {
		
	public $data;
		
	function __construct(){		
		parent::__construct();

		$this->inzialize_css();		
		$this->inzialize_js();	
		
		$this->data['mainMenu'] =& buildMainMenu();	
		$this->data['footer'] = eval(FOOTER);
		
	}	

	function index() {
		$config['base_url'] = base_url('grupos');
		$config['total_rows'] = $this ->db->get('grupos')->num_rows();
		$config['per_page'] = 1;
		$config['num_links'] = 1;

		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';

		$tmpl = array(
			'table_open'		  => '<table class="table table-striped table-bordered table-hover" id="general_table">',
           // 'heading_cell_start'  => '<th class="table-checkbox">', //TODO modificar para que solo sea aplicable a la primera celda del header (primer <th>)
			'row_start'           => '<tr class="odd gradeX">'
		);		
		
		$this -> table -> set_template($tmpl);

		$this -> table -> set_heading('<input type="checkbox" class="group-checkable" data-set="#general_table .checkboxes"/>', 'Nombre', 'Delegado', 'Tlf', 'City', 'Region', 'Country', 'Actions', 'Clientes');

		$this -> load -> library('pagination');
		//$this->pagination->initialize($config);

		$tabla = array();
		$i = 0;
		
		$this -> db -> select('grupos.grupo_id');
		$this -> db -> select('grupos.delegado_id');
		$this -> db -> select('grupos.nombre AS gruName');
		$this -> db -> select('grupos.telefono');

		$this -> db -> select('direcciones.ciudad');

		$this -> db -> select('provincias.nombre AS provinciaNombre');

		$this -> db -> select('paises.nombre AS paisNombre');

		$this -> db -> join("direcciones", 'grupos.grupo_id = direcciones.grupo_id', 'left outer');
		$this -> db -> join("provincias", 'direcciones.provincia_id = provincias.provincia_id', 'left outer');
		$this -> db -> join("paises", 'provincias.pais_id = paises.pais_id', 'left outer');
		// $this -> db -> join("compras", 'compras.grupo_id = grupos.grupo_id', 'left outer');
		// $this -> db -> where('clientes.es_delegado', 0);
		$this -> db -> order_by('grupos.nombre', 'asc');
		//$query = $this->db->get('clientes', $config['per_page'], $this->uri->segment(3));
		$query = $this -> db -> get('grupos');				
		
		// print_r($this->db->last_query());exit;
		
		foreach ($query->result() as $row) {

			$gID = $row -> grupo_id;
			// $tabla[$i][''] = '';
			
			$this->db->select('grupos_contienen_clientes.grupo_id, grupos_contienen_clientes.cliente_id, grupos_contienen_clientes.fecha_incorporacion, grupos_contienen_clientes.es_delegado');
			$this->db->select('clientes.nombre, clientes.apellido');
			// $this->db->join('grupos', 'grupos.grupo_id = grupos_contienen_clientes.grupo_id', 'LEFT');
			$this->db->join('clientes', 'clientes.cliente_id = grupos_contienen_clientes.cliente_id', 'LEFT');
			$this->db->where('grupos_contienen_clientes.grupo_id', $gID);
			$this -> db -> where('clientes.cliente_id <>', 1); //cliente joker usado en compras que carecen de clientes.
			$clientesGrupo = $this->db->get('grupos_contienen_clientes')->result_array();
			// print_r($this->db->last_query()); exit;
			
			$html = '';
			if(!empty($clientesGrupo)) {
				$html = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
							<thead>
								<tr>
									<td>Nombre</td>
									<td>Apellido</td>
								</tr>
							</thead>
							<tbody>';
				
				// $tabla[$i]['dataClients'] = '';
				
				foreach($clientesGrupo as $cliente) {
					// print_r($cliente);
					// echo "<br>";
					$html .= '<tr>';
					$html .= '<td>'.$cliente['nombre'].'<td>';
					$html .= '<td>'.$cliente['apellido'].'<td>';
					$html .= '<tr>';
				}
					$html .= '</tbody></table>';
			}
			
			$this->db->where('grupo_id', $gID);
			$grupoHaComprado = $this->db->get('compras')->result_array();
			if(!empty($grupoHaComprado)) {
				$haComprado = TRUE;
			}
			else $haComprado = FALSE;
			
			if(!$haComprado) {
				$row -> grupo_id = anchor('modificar/grupo/' . $row -> grupo_id, $row -> grupo_id);
				$tabla[$i]['checkbox'] = '<input type="checkbox" class="checkboxes" value="1" id="'.$gID.'">';
			} else {
				$tabla[$i]['checkbox'] = '';
			}
			//$tabla[$i]['cliente_id'] = $row -> cliente_id;
			$tabla[$i]['nombre'] = $row -> gruName;
			
			$delegadoString = '';
			if(!empty($row -> delegado_id)) {
				$this->db->where('cliente_id', $row -> delegado_id);
				$delegado= $this->db->get('clientes')->row();
				// print_r($delegado);exit;
				$delegadoString = $delegado -> nombre.', '.$delegado->apellido;
			}
			$tabla[$i]['delegado'] = $delegadoString;
			
			
			$tabla[$i]['telefono'] = $row -> telefono;
			$tabla[$i]['ciudad'] = $row -> ciudad;
			$tabla[$i]['provincia'] = $row -> provinciaNombre;
			$tabla[$i]['pais'] = $row -> paisNombre;
			
			if(!$haComprado)
			$actions = '
            <div id="'.$gID.'">
            	<span class="fa fa-lg fa-pencil modifyButton" title="Modificar"></span>
            	<span class="separator">&nbsp;</span>
            	<span class="fa fa-lg fa-trash-o deleteButton" title="Borrar" id="button-delete-'. $gID .'"></span>
            </div>';
			else
				$actions = "Este grupo tiene compras asociadas";
			
			$tabla[$i]['Actions'] = $actions;

			// $viewClients = '
            // <div>
            	// <span class="fa fa-lg fa-group viewGroupClients" title="Ver componentes grupo" group="'. $gID .'" data-target="#ajax" data-toggle="modal"></span>
            // </div>';
			$viewClients = '
            <div>
            	<a class=" fa fa-lg fa-group viewGroupClients" href="/grupos_ajax/viewGroupClients/'. $gID .'" data-target="#ajax" data-toggle="modal">
				</a>
            </div>';
			$tabla[$i]['viewGroupClients'] = $viewClients;
			
			// $tabla[$i]['dataClients'] = $html;
			
			
			$i++;
		}
		
		$this->data['records'] = $tabla;
		
		$this->data['header_title'] = "Hispalia | Grupos - Tabla";
		$this->data['h3'] = "GRUPOS";
		$this->data['breadcrumb'] = "Tabla Grupos";
		$this->data['tableAddButtonHref'] = "grupos";
		$this->data['tableAddButton'] = "Añadir nuevo grupo";
		// $this->data['tableCreateNewGroup'] = "Crea nuevo grupo";
		
		$this->data['tabla_controller'] = "clientes";
		
		// Variables included in php view file
		$visibleColumnsToExport = Array(1, 2, 3, 4, 5, 6, 7);
		$this->data['visibleColumnsToExport'] = json_encode($visibleColumnsToExport);
		$orderableTargets = Array(0, 1);
		$this->data['orderableTargets'] = json_encode($orderableTargets);		
		$searchableTargets = Array(0, 7, 8);
		$this->data['searchableTargets'] = json_encode($searchableTargets);		
		$this->data['confirmDelete'] = "Borrar grupo?";
		$this->data['deleteRowURL'] = 'grupos_ajax/deleteGrupo';
		$this->data['modifyItemURL'] = 'grupos/modificar/';
		$this->data['deleteSelectedRowsURL'] = 'grupos_ajax/deleteSelectedGrupos';
		$this->data['viewGroupClientsRowURL'] = 'grupos_ajax/viewGroupClients';
		
		$this->load->view("grupos/general_table", $this->data);

	}		

	
		
	function nuevo() {
		
        
        $delegados = array();
        $delegados[0] = '-- No tiene delegado --';		
        if($query = $this->general_model->getDelegados()) {
            foreach ($query as $row) {
                $delegados[$row->cliente_id] = $row->nombre.' '.$row->apellido;
            }
        }
        $this->data['delegados'] = $delegados;
		
        if($query3 = $this->general_model->getPaises()) {
            if ($query3 != -1) {
                $this->data['paises'] = $query3;
            } else {
                $this->data['paises'] = NULL;
            }
        }

        // Mandamos los tipos de eventos
        $eventos = array();
        $eventos[] = '-- Ninguno --';
        if($query = $this->general_model->getEventos()) {
            foreach ($query as $row) {
                $eventos[$row->evento_id] = $row->nombre;
            }
        }
       	$this->data['eventos'] = $eventos;
		
		
 		// if($query = $this->clientes_model->getPaises_2()) {
			// foreach ($query as $row) {
				// $paises[$row->pais_id] = $row->nombre;
			// }
			// $this->data['paises'] = $paises;
		// } 
		
		$paisDefault = 15;
		$this->data['paisDefault'] = $paisDefault;
		$provincias = Array();

		$this->data['provincias'] = $provincias;
		
		$this->data['header_title'] = "Hispalia | Grupos - Nuevo";
		$this->data['h3'] = "GRUPOS";
		$this->data['breadcrumb'] = "Nuevo Grupo";
		$this->data['portlet_caption'] = "Completar el formulario del nuevo Grupo";

		//Variables php que se cargaran en grupos.js
		$this->data['autocompleteModifcarURL'] = "/grupos/modificar";

		//Variables php que se cargaran en form-validation.js
		// $this->data['buttonAddNew'] = "Añadir otro grupo nuevo";
		// $this->data['buttonModifyCurrent'] = "Modificar este grupo";
		// $this->data['buttonViewAll'] = "Ver tabla con todos los grupos";
		// $this->data['buttonAddNewURL'] ="grupo/nuevo";
		// $this->data['buttonModifyCurrentURL'] ="grupos/modificar/";
		// $this->data['buttonControllerURL'] ="grupos";
		
		
		// $this->load->view("grupos/nuevo_2", $this->data);
		
		
//-------------------------------------------------------		
		// Start 2ond part of New group process.
		
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

		$this -> table -> set_heading( 'Apellido', 'Nombre', 'Address', 'City', 'Region', 'Country', 'Tlf', 'e-mail', 'Talla Camiseta');

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
		$this -> db -> order_by('clientes.apellido', 'asc');
		//$query = $this->db->get('clientes', $config['per_page'], $this->uri->segment(3));
		$query = $this -> db -> get('clientes');
		
		$medidas_camiseta = eval(CAMISETAS);
		
		foreach ($query->result() as $row) {
			$cID = $row -> cliente_id;
			$row -> cliente_id = anchor('modificar/cliente/' . $row -> cliente_id, $row -> cliente_id);
			// $tabla[$i]['checkbox'] = '<input type="checkbox" class="checkboxes" value="1" id="'.$cID.'">';
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
            <div id="'.$cID.'">
            	<span class="fa fa-lg fa-pencil modifyButton" title="Modificar"></span>
            	<span class="separator">&nbsp;</span>
            	<span class="fa fa-lg fa-trash-o deleteButton" title="Borrar" id="button-delete-'. $cID .'"></span>
            </div>';
			// $tabla[$i]['Actions'] = $actions;
			// $tabla[$i]['Actions'] = '';
			
			// Esta modificacion permite añadir atributos a la fila.
			// Añadido el fichero MY_Table.php en application/libraries
			// https://github.com/dalehurley/codeigniter-table-rows
		    $rows[]=array('data'=>$tabla[$i], 'id'=>$cID);
			
			$i++;
		}
		
		// $this->data['records'] = $tabla;
		$this->data['records'] = $rows;
		
		$this->data['header_title'] = "Hispalia | Clientes - Tabla";
		$this->data['h3'] = "CLIENTES";
		$this->data['breadcrumb'] = "Tabla Clientes";
		// $this->data['tableAddButtonHref'] = "clientes";
		// $this->data['tableAddButton'] = "Añadir nuevo cliente";
		// $this->data['tableCreateNewGroup'] = "Crea nuevo grupo";
		
		$this->data['tabla_controller'] = "clientes";
		
		// Variables included in php view file
		$visibleColumnsToExport = Array(8);
		$this->data['visibleColumnsToExport'] = json_encode($visibleColumnsToExport);
		$orderableTargets = Array(8);
		$this->data['orderableTargets'] = json_encode($orderableTargets);		
		$searchableTargets = Array(0,8);
		$this->data['searchableTargets'] = json_encode($searchableTargets);		
		// $this->data['confirmDelete'] = "Borrar cliente?";
		// $this->data['deleteRowURL'] = 'clientes_ajax/deleteCliente';
		// $this->data['modifyItemURL'] = 'clientes/modificar/';
		$this->data['deleteSelectedRowsURL'] = 'grupos_ajax/deleteSelectedGrupos';
		
		//Variables php que se cargaran en grupos.js
		$this->data['buttonAddNew'] = "Añadir otro grupo nuevo";
		$this->data['buttonModifyCurrent'] = "Modificar este grupo";
		$this->data['buttonViewAll'] = "Ver tabla con todos los grupos";
		$this->data['buttonAddNewURL'] ="grupos/nuevo";
		$this->data['buttonModifyCurrentURL'] ="grupos/modificar/";
		$this->data['buttonControllerURL'] ="grupos";		
		
		// $this->load->view("general_views/general_table1", $this->data);
		$this->load->view("grupos/nuevo_2", $this->data);

//-------------------------------------------------------		
		
		
		
		
	}

	function salvar_grupo() {
		
		$data_grupo = array(
			'nombre'	=>	$this->input->post('nombre'),
			'telefono'	=>	$this->input->post('telefono'),
			'evento_id'	=>	!empty($this->input->post('evento')) ? $this->input->post('evento'): NULL,
			'delegado_id'	=>	!empty($this->input->post('delegado')) ? $this->input->post('delegado'): NULL,
			'fecha_creacion'=>	date('YYYY-MM-DD', time()),
		);
		$data_direccion = array (
			'ciudad'			=> !empty($this->input->post('ciudad')) ? $this->input->post('ciudad') : NULL,
			'cp'				=> !empty($this->input->post('cp')) ? $this->input->post('cp') : NULL,
			'grupo_id'			=> NULL    			
			);
		$rows = $this->clientes_model->getProvinciaID($this->input->post('provincias'));
		$data_direccion['provincia_id'] = $this->input->post('provincias');

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
		
		$clientes = $this->input->post('clients_id');
		// print_r($clientes); exit;
		
		//NEW group
		// if (!empty($this->input->post('action'))) {
		if ($this->input->post('action') != "modify") {
			$data['grupoID'] = $this->grupos_model->addGrupo($data_grupo, $data_direccion, $data_valoracion, $_POST['clients_id']);
			$data['dialogInfoResponse'] = "Grupo registrado.";
		// MODIFY and UPDATE group
		}else {
			$data['grupoID'] = $this->input->post('grupo_id');
			$data['dialogInfoResponse'] = "Grupo actualizado correctamente.";
			$this->grupos_model->updateTablaGrupo($data['grupoID'], $data_grupo, $data_direccion, $data_valoracion, $_POST['clientes_id']);
		}
		
		echo json_encode($data);			
	} 

	function modificar() {
			
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
			base_url().BOOTSTRAP_WIZARD_JS,
			// begin view all users
			base_url().SELECT2_MIN,
			base_url().JQUERY_DATATABLES_MIN,
			base_url().DATATABLES_TABLETOOLS_MIN,
			base_url().DATATABLES_BOOTSTRAP_JS,
			
		// BEGIN PAGE LEVEL SCRIPTS	
			base_url().METRONIC,
			base_url().LAYOUT_JS,
			base_url().QUICK_SIDEBAR,
			base_url().DEMO,
			// base_url().FORM_VALIDATION,
			base_url().GRUPOS,
			base_url().TABLE_NEW_GRUPO,
			base_url().TABLE_GENERAL_GRUPOS
			
		);	
	}

	function getGroups(){
		echo "hola";
	}

}
		