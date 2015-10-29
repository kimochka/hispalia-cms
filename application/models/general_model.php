<?php

class General_model extends CI_Model {

	function getDelegados() {
		$query = $this->db->query("SELECT nombre, apellido, cliente_id FROM `clientes` WHERE `delegado_id` IS NULL AND `es_delegado` = 1");
		return $query->result();
	}	
	
	function getPaises() {
		$this->db->select('nombre');
		$query = $this->db->get('paises');
		$i = 1;
		foreach ($query->result() as $row) {
			$paises[$i] = $row->nombre;
			$i++;
		}
		return $paises;
	}
	
	function getEventos() {
		$query = $this->db->get('eventos');
		return $query->result();
	}	

	
	
}