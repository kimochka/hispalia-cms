<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Hoteles_ajax extends CI_Controller {
	
	function checkIfHotelExistsByName() {
        $nombre = $this->input->post('nombre', TRUE);
        if (strlen($nombre) < 2) break;

		$isDelegado = !empty($this->input->post('nombre', TRUE)) ? $this->input->post('nombre', TRUE) : null;
		
        $rows = $this->hoteles_ajax_model->checkIfHotelExistsByName(array('nombre' => $nombre));
				
        $nombres = array();
        foreach ($rows as $row) {
            array_push($nombres, $row->hotel_id. '. ' .$row->nombre);
        }
        echo json_encode($nombres);
	}
	
	function getHoteles()
	{
		$id = $_POST['id'];
		$type = $_POST['type'];
		if(empty($type)) //pais
		$hoteles = $this->hoteles_model->getHoteles($id);
		else //provincia
		$hoteles = $this->hoteles_model->getHoteles(0, $id);
		echo json_encode($hoteles);
	}



}
