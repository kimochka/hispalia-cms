<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Clientes_ajax extends CI_Controller {
	
	function checkIfClienteExistsByName() {
        $nombre = $this->input->post('nombre', TRUE);
        if (strlen($nombre) < 2) break;

		$isDelegado = !empty($this->input->post('nombre', TRUE)) ? $this->input->post('nombre', TRUE) : null;
		
        $rows = $this->clientes_ajax_model->checkIfClienteExistsByName(array('nombre' => $nombre, 'isDelegado' => $isDelegado));
				
        $nombres = array();
        foreach ($rows as $row) {
            array_push($nombres, $row->cliente_id. '. ' .$row->nombre.' '.$row->apellido);
        }
        echo json_encode($nombres);				
	}

	function checkIfClienteExistsBySurname() {
        $apellido = $this->input->post('apellido', TRUE);
        if (strlen($apellido) < 2) break;

		$isDelegado = !empty($this->input->post('nombre', TRUE)) ? $this->input->post('nombre', TRUE) : null;

        $rows = $this->clientes_ajax_model->checkIfClienteExistsBySurname(array('apellido' => $apellido, 'isDelegado' => $isDelegado));
				
        $nombres = array();
        foreach ($rows as $row) {
            array_push($nombres, $row->cliente_id. '. ' .$row->nombre.' '.$row->apellido);
        }
        echo json_encode($nombres);		
	}



    function getProvincias_3() {
        $provincias = array();
        $pais = $this->input->post('paises');
        if($query = $this->clientes_ajax_model->getProvincias_2($pais)) {
            foreach ($query as $row) {
                $provincias[$row->provincia_id] = $row->nombre;
            }
            $provincias[0] = "-";
        }
        // print_r($provincias);
        echo json_encode($provincias);
    } 

    function deleteCliente() {
        if ( $this->clientes_ajax_model->deleteCliente($this->input->post('id')))
            echo 'Borrado correcto';
        else
            echo 'Error de borrado';         
    } 
	
	function deleteSelectedClientes() {
		foreach($this->input->post('itemsToDelete') as $key => $value) {
        	$this->clientes_ajax_model->deleteCliente($value);
		}
	}

}
