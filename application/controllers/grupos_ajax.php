<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Grupos_ajax extends CI_Controller {
		
	public $data;
		
	function __construct(){		
		parent::__construct();		
	}	
	
	function deleteGrupo(){
		
		$this->db->where('grupo_id', $this->input->post('id'));
		$this->db->delete('grupos');
		
	}
	
	function viewGroupClients(){
		
		$gID = $this->uri->segment(3);
		// $gID = $_POST['group_id'];
		// exit;
		$this->db->select('grupos_contienen_clientes.cliente_id');
		$this->db->select('grupos_contienen_clientes.fecha_incorporacion');
		$this->db->select('grupos_contienen_clientes.es_delegado');
		$this->db->select('clientes.nombre');
		$this->db->select('clientes.apellido');
		$this->db->select('clientes.nacionalidad');
		$this->db->join('clientes', 'clientes.cliente_id = grupos_contienen_clientes.cliente_id', 'LEFT');
		// $this->db->join('compras', 'compras.cliente_id = grupos_contienen_clientes.cliente_id', 'LEFT');
		$this->db->where('grupos_contienen_clientes.grupo_id', $gID);
		$clientesGrupo = $this->db->get('grupos_contienen_clientes')->result_array();
		
		
		$clientesGroupOut = Array();
		
		if(!empty($clientesGrupo)) {
			// print_r($clientesGrupo);
			foreach($clientesGrupo as $cliente) {
				$temp = $cliente;
				$this->db->distinct();
				$this->db->select('grupo_compra_id');
				$this->db->where('cliente_id', $cliente['cliente_id']);
				$this->db->where('grupo_id', $gID);
				$comprasCliente = $this->db->get('compras')->result_array();
				if(!empty($comprasCliente)) {
					$temp['haComprado'] = 1;
					// $contCompras = 0;
					$arrayCompras = '';
					foreach($comprasCliente as $coms) {
						$arrayCompras .= $coms['grupo_compra_id'] . ", ";
					}
					$temp['comprasConEsteGrupo'] = $arrayCompras;
				}else {
					$temp['haComprado'] = 0;
					$temp['comprasConEsteGrupo'] = '';
				}
				$clientesGroupOut[$cliente['cliente_id']]= $temp;
				
			}
			
		}

		// $html = '<table cellpadding="5" cellspacing="0" border="2" style="padding-left:50px;">';
		$html = '<table class="col-md-12 table table-striped table-bordered table-hover" id="general_table_2">';
		$html .= '<tr class="odd gradeX">';
		$html .= '<td>Nombre</td>';
		$html .= '<td>Apellido</td>';
		$html .= '<td>Nacionalidad</td>';
		$html .= '<td>Es delegado grupo?</td>';
		$html .= '<td>Fecha incorporacion en Grupo</td>';
		$html .= '<td>Cliente ID</td>';
		$html .= '<td>Ha comprado en este grupo</td>';
		$html .= '<td>Compras</td>';
		$html .= '</tr>';
		foreach($clientesGroupOut as $cliente) {
			$html .= '<tr>';
			$html .= '<td>'. $cliente['nombre'] .'</td>';
			$html .= '<td>'. $cliente['apellido'] .'</td>';
			$html .= '<td>'. $cliente['nacionalidad'] .'</td>';
			$html .= '<td>'. $cliente['es_delegado'] .'</td>';
			$html .= '<td>'. $cliente['fecha_incorporacion'] .'</td>';
			$html .= '<td>'. $cliente['cliente_id'] .'</td>';
			$html .= '<td>'. $cliente['haComprado'] .'</td>';
			$html .= '<td>'. $cliente['comprasConEsteGrupo'] .'</td>';
			$html .= '</tr>';
					}
			
			$html .= '</table>';
			
			// echo $html;
		
		// print_r($clientesGroupOut);
		// echo "<br>";
		// print_r($this->db->last_query());
				
		$this->load->helper('file');
		$subject = read_file('./application/views/grupos/ui_modals_ajax.html');
		$search = '<to be replaced>';
		$replace = $html;
		
		$stringOutput = str_replace($search, $replace, $subject);
		echo $stringOutput;
		
	}

	function deleteSelectedGrupos(){
		foreach($this->input->post('itemsToDelete') as $key => $value) {
	        $this->db->where('grupo_id', $value);
	        $this->db->delete('grupos');
		}
	}
	
	
	function viewGroupClientsRowURL(){
		
		return $html;
	}


}
		