<?php

class Clientes_ajax_model extends CI_Model {
	

	function checkIfClienteExistsByName($options = array()) {
		$this->db->select('cliente_id');
		$this->db->select('nombre');
		$this->db->select('apellido');
		$this->db->where('(nombre LIKE \'%'.$options['nombre'].'%\')');
		empty($options['isDelegado']) ? $this->db->where('es_delegado', '0'): $this->db->where('es_delegado', '0');
		$query = $this->db->get('clientes');
		return $query->result();
	}
	
	function checkIfClienteExistsBySurname($options = array()) {
		$this->db->select('cliente_id');
		$this->db->select('nombre');
		$this->db->select('apellido');
		$this->db->where('(apellido LIKE \'%'.$options['apellido'].'%\')');
		empty($options['isDelegado']) ? $this->db->where('es_delegado', '0'): $this->db->where('es_delegado', '0');
		$query = $this->db->get('clientes');
		return $query->result();
	}
	
	function getProvincias_2($pais_id) {
		$this->db->select('nombre');
		$this->db->select('provincia_id');
		$this->db->where('pais_id', $pais_id);
		$query = $this->db->get('provincias');
		return $query->result();
	}	
	
    function deleteCliente($cliente_id) {
        $this->db->where('cliente_id', $cliente_id);
        $this->db->delete('clientes');
        if ($this->db->affected_rows() > 0)
            return TRUE;
        return FALSE;     
    }	
	
}