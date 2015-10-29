<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function buildMainMenu()
{
	$CI =& get_instance();
	$CI->load->model('layout_model');
	$menuHTML = $CI->layout_model->loadMenuItems();
	
	$menuArray = Array(
		1 => Array(
			'menu_item_id' => 1,
            'title' => 'Home',
            'href' => NULL,
            'level' => 0,
            'icon_class' => 'fa fa-home',
            'father_item_id' => NULL,
            'subMenuItems' => NULL
		),
	  	2 => Array(
            'menu_item_id' => 2,
            'title' => 'Clientes',
            'href' => NULL,
            'level' => 0,
            'icon_class' => 'fa fa-user',
            'father_item_id' => NULL,
            'subMenuItems' => Array(
				20 => Array(
					'menu_item_id' => 20,
		            'title' => 'Nuevo Cliente',
		            'href' => NULL,
		            'level' => 1,
		            'icon_class' => 'fa fa-home',
		            'father_item_id' => 2,
		            'subMenuItems' => NULL
				),
				21 => Array(
					'menu_item_id' => 21,
		            'title' => 'Ver Todos',
		            'href' => NULL,
		            'level' => 1,
		            'icon_class' => 'fa fa-table',
		            'father_item_id' => 2,
		            'subMenuItems' => NULL
				)
			)
		)
	);
	
	return $menuHTML;
}
