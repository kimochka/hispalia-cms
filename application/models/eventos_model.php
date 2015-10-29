<?php

class Eventos_model extends CI_Model {
	

	function getTiposEventos() {
				
		$this->db->select('tipo_id');
		$this->db->select('nombre');
		$query = $this->db->get('tipos');
		return $query->result();
	}
	
	function addEvento($info, $precios) {
		$this->db->insert('eventos', $info);
		$id = $this->db->insert_id();
		// print_r($id); exit;
		
		$precios['evento_id'] = $id;
		
		$this->db->insert('precios', $precios);
        if ($this->db->affected_rows() > 0)
            return $id;
        return -1;
	}
	
	function updateTablaEvento($evento_id, $info, $precios) {
		
		// Update tabla Hotel
		$this->db->where('evento_id', $evento_id);
		$this->db->update('eventos', $info);

		// Update tabla precios
		$this->db->where('evento_id', $evento_id);
		$this->db->update('precios', $precios);			

		return;
	}		
}