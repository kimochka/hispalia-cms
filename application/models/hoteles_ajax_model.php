<?php

class Hoteles_ajax_model extends CI_Model {
	

	function checkIfHotelExistsByName($options = array()) {
		$this->db->select('hotel_id');
		$this->db->select('nombre');
		$this->db->where('(nombre LIKE \'%'.$options['nombre'].'%\')');
		$query = $this->db->get('hoteles');
		return $query->result();
	}	
	
}