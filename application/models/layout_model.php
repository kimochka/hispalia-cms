<?php

class Layout_model extends CI_Model {

	function loadMenuItems() {
		$this->db->where('level = ', 0);
		$this->db->order_by('menu_item_id', 'ASC');
		$level0Items = $this->db->get('menu_items')->result_array();
		$resultHTML = null;
		foreach ($level0Items as $key0 => $value0) {
			if($level1Items = $this->getLevel1Items($value0['menu_item_id'])) {
				$resultHTML .= 
					'<li>'.
					'<a href="#">'.					
					'<i class="'. $value0['icon_class'] .'"></i>'.					
					'<span class="title">'.	$value0['title'] .'</span>'.				
					'<span class="arrow"></span>'.					
					'</a>';					
				$resultHTML .= '<ul class="sub-menu">';
				foreach ($level1Items as $key1 => $value1) {
					$resultHTML .=
						'<li>'.
						'<a href="'. base_url($value1['href']) .'">'.
						'<i class="'. $value1['icon_class'] .'"></i>'.
						$value1['title'].'</a>'.
						'</li>';
				}
				$resultHTML .= '</ul>';
			} else{
				$resultHTML .= 
					'<li>'.
					'<a href="'. base_url($value0['href']) .'">'.					
					'<i class="'. $value0['icon_class'] .'"></i>'.					
					'<span class="title">'.	$value0['title'] .'</span>'.				
					'</a>';					
			}
			$resultHTML .= '</li>';
		}
		return $resultHTML;
		
	}
	
	function getLevel1Items($id) {
		$this->db->where('level = ', 1);
		$this->db->where('father_item_id', $id);
		$this->db->order_by('menu_item_id', 'ASC');
		$items = $this->db->get('menu_items');
		if(sizeof($items) > 0)
			 return $items->result_array();
		else return false;
		
	}
	
}