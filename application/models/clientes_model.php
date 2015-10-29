<?php

class Clientes_model extends CI_Model {
	
	function getProvinciaID($nombreProvincia) {
		$this->db->select('provincia_id');
		$this->db->like('nombre', $nombreProvincia);
		$query = $this->db->get('provincias');
		return $query->result();
	}
	
	function addCliente($info, $direccion, $valoracion) {
				
		$this->db->insert('clientes', $info);
		$id = $this->db->insert_id();
		$direccion['cliente_id'] = $id;
		$valoracion['cliente_id'] = $id;		
		$this->db->insert('valoraciones', $valoracion);
		$this->db->insert('direcciones', $direccion);
        if ($this->db->affected_rows() > 0)
            return $id;
        return -1;
	}	
	
	function getCliente($id) {
		$this->db->select('*');
		$this->db->where('cliente_id', $id);
		$query = $this->db->get('clientes');
		return $query->result_array();
	}

	function getClienteAddress($id){
		$this->db->select('*');
		$this->db->where('cliente_id', $id);
		$query = $this->db->get('direcciones');
		return $query->result_array();
	}
	
	function getProvincia($provincia_id) {
		$this->db->select('*');
		$this->db->where('provincia_id', $provincia_id);
		$query = $this->db->get('provincias');
		return $query->result();
	}
	
	function getProvinciasID($pais_id) {
		$this->db->select('nombre');
		$this->db->select('provincia_id');
		$this->db->where('pais_id', $pais_id);
		$query = $this->db->get('provincias');	
		return $query->result();
	}	
	
	function getPais($pais) {
		$this->db->select('*');
		$this->db->where('pais_id', $pais);
		$query = $this->db->get('paises');
		return $query->result();
	}

    function getPais2($pais) {
        $this->db->select('*');
        $this->db->where('pais_id', $pais);
        $query = $this->db->get('paises');
        return $query->result_array();
    }
	
	function getValoraciones($cliente_id) {
		$this->db->select('*');
		$this->db->where('cliente_id', $cliente_id);
		$query = $this->db->get('valoraciones');
		return $query->result();
	}		

	function getPaises() {
		$this->db->select('nombre');
		$query = $this->db->get('paises');
		$i = 0;
		foreach ($query->result() as $row) {
			$paises[$i] = $row->nombre;
			$i++;
		}
		return $paises;
	}
	
	function getPaises_2() {
		$this->db->select('nombre');
		$this->db->select('pais_id');
		$query = $this->db->get('paises');
		return $query->result();
	}	

	function updateTablaCliente($cliente_id, $info, $direccion, $valoracion) {
		
		// Update tabla cliente
		$this->db->where('cliente_id', $cliente_id);
		$this->db->update('clientes', $info);
		
		// Update tabla direcciones
		$this->db->where('cliente_id', $cliente_id);
		$this->db->update('direcciones', $direccion);
		
		// Update tabla valoraciones
		$this->db->where('cliente_id', $cliente_id);
		$this->db->update('valoraciones', $valoracion);			

		return;
	}
	
}