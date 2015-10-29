<?php

class Reservas_model extends CI_Model {
	

	function getTipoPagos() {
				
		$this->db->select('tipo_pago_id, nombre');
		$query = $this->db->get('tipo_pagos');
		return $query->result();
	}
	
	function getTipoProductos() {
				
		$this->db->select('tipo_producto_id, nombre');
		$query = $this->db->get('tipo_productos');
		return $query->result();
	}
	
	
		
}