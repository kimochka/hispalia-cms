<?php

class Grupos_model extends CI_Model {
	

	
	function addGrupo($info, $direccion, $valoracion, $clientes) {
		
		$this->db->insert('grupos', $info);
		$grupo_id = $this->db->insert_id();
		
		// print_r($direccion);exit;
		$direccion['provincia_id'] = !empty($direccion['provincia_id']) ? $direccion['provincia_id'] : NULL;
		$direccion['grupo_id'] = $grupo_id;
		$this->db->insert('direcciones', $direccion);

		$valoracion['cliente_id'] = NULL;		
		$valoracion['grupo_id'] = $grupo_id;		
		$this->db->insert('valoraciones', $valoracion);
		
		if(!empty($clientes)) {
			$data['grupo_id'] = $grupo_id;
			$data['fecha_incorporacion'] = date('YYYY-MM-DD', time());
			foreach($clientes as $cliente_id) {
				$data['cliente_id'] = $cliente_id;
				// $this->db->where('grupo_id', $id);
				$this->db->insert('grupos_contienen_clientes', $data);
			}
		}
		
        if ($this->db->affected_rows() > 0)
            return $grupo_id;
        return -1;
	}	

	function updateTablaGrupo($grupo_id, $info, $direccion, $valoracion, $clientes = Array()) {
		
		// Update tabla cliente
		$this->db->where('grupo_id', $grupo_id);
		$this->db->update('grupos', $info);
		
		// Update tabla direcciones
		$this->db->where('grupo_id', $grupo_id);
		$this->db->update('direcciones', $direccion);
		
		// Update tabla valoraciones
		$this->db->where('grupo_id', $grupo_id);
		$this->db->update('valoraciones', $valoracion);			
		
		// Delete records of grupo_id to update
		$this->db->where('grupo_id', $grupo_id);
		foreach($clientes as $cliente){
			$this->db->where('cliente_id', $cliente_id);
			$this->db->where('grupo_id', $grupo_id);
			$clientRequested = $this->db->get('grupos_contienen_clientes')->result_array();
			if(empty($clientRequested)) {
				print_r($cliente);
				echo "<br>";
				$this->db->insert('grupos_contienen_clientes', $cliente);
			} else{
				// ya presente en el grupo del DB
			}
		}
		
		$this->db->where('grupo_id', $grupo_id);
		$clientsInDb = $this->db->get('grupos_contienen_clientes')->result_array();
		foreach($clientsInDb as $cDb) {
			if(!in_array($clientes, $cDb)){
				$this->db->where('cliente_id', $cDb);
				$this->db->where('grupo_id', $grupo_id);
				$this->db->delete('grupos_contienen_clientes', $cDb);				
			}
		}
		//sustituye el ultimo bloque, haciendo la operacion manualmente.
		// $this->db->where('grupo_id', $grupo_id);
		// $clientsInDb = $this->db->get('grupos_contienen_clientes')->result_array();
		// foreach($clientsInDb as $cDb) {
			// $found = false;
			// foreach($clientes as $cliente) {
				// if($cDb == $cliente) {
					// $found = true;
					// break;
				// }
			// }
			// if(!$found) {
				// $this->db->where('cliente_id', $cDb);
				// $this->db->where('grupo_id', $grupo_id);
				// $this->db->delete('grupos_contienen_clientes', $cDb);
			// }
		// }
		
		return;
	}
	
}