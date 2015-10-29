<?php

class Hoteles_model extends CI_Model {
	
	function getProvinciaID($nombreProvincia) {
		$this->db->select('provincia_id');
		$this->db->like('nombre', $nombreProvincia);
		$query = $this->db->get('provincias');
		return $query->result();
	}
	
	function addHotel($info, $direccion, $valoracion) {
		// print_r($info);exit;
		// print_r($direccion);exit;
		// print_r($valoracion);exit;
		$this->db->insert('hoteles', $info);
		$id = $this->db->insert_id();
		// print_r($id); exit;
		
		$direccion['hotel_id'] = $id;
		$valoracion['hotel_id'] = $id;
		
		// print_r($valoracion);
		$this->db->insert('valoraciones', $valoracion);
		$this->db->insert('direcciones', $direccion);
        if ($this->db->affected_rows() > 0)
            return $id;
        return -1;
	}	
	
	function getHotel($id) {
		$this->db->select('*');
		$this->db->where('hotel_id', $id);
		$query = $this->db->get('hoteles');
		return $query->result_array();
	}

	function getHotelAddress($id){
		$this->db->select('*');
		$this->db->where('hotel_id', $id);
		$query = $this->db->get('direcciones');
		return $query->result_array();
	}
	
	function getProvincia($provincia_id) {
		$this->db->select('*');
		$this->db->where('provincia_id', $provincia_id);
		$query = $this->db->get('provincias');
		return $query->result();
	}


	function updateTablaHotel($hotel_id, $info, $direccion, $valoracion) {
		
		// Update tabla Hotel
		$this->db->where('hotel_id', $hotel_id);
		$this->db->update('hoteles', $info);
		
		// Update tabla direcciones
		$this->db->where('hotel_id', $hotel_id);
		$this->db->update('direcciones', $direccion);
		
		// Update tabla valoraciones
		$this->db->where('hotel_id', $hotel_id);
		$this->db->update('valoraciones', $valoracion);			

		return;
	}
	
	function getHoteles($pais = null, $provincia = null) {
		$temp_hoteles = Array();
		$hoteles = Array();
		
		if(empty($provincia)) {
			$this->db->select('provincia_id');
			$this->db->where('pais_id', $pais);
			$temp_provincias_con_hoteles = $this->db->get('provincias')->result_array();
			foreach($temp_provincias_con_hoteles as $prov) {
				$provincias_con_hoteles[] = $prov['provincia_id'];
			}
			if(!empty($provincias_con_hoteles)) {
				$this->db->select('hoteles.nombre, hoteles.hotel_id, direcciones.ciudad');
				$this->db->where_in('direcciones.provincia_id', $provincias_con_hoteles);
				$this->db->join('direcciones', 'hoteles.hotel_id = direcciones.hotel_id', 'left');
				$temp_hoteles = $this->db->get('hoteles')->result_array();
			}
		}else {
			$this->db->select('hoteles.nombre, hoteles.hotel_id, direcciones.ciudad');
			$this->db->where('direcciones.provincia_id', $provincia);
			$this->db->join('direcciones', 'hoteles.hotel_id = direcciones.hotel_id', 'left');
			$temp_hoteles = $this->db->get('hoteles')->result_array();
		}
		foreach ($temp_hoteles as $key => $value) {
			$hoteles[$value['hotel_id']] = $value['nombre'] . ' ( ' . $value['ciudad'] . ')';
		}
		
		return($hoteles);
		
	}
	
}