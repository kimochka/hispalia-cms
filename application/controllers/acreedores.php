<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Acreedores extends CI_Controller {
		
	public $data;
		
	function __construct(){		
		parent::__construct();

		$this->intialize_css();
		$this->intialize_js();
		
		$this->data['mainMenu'] =& buildMainMenu();	
		$this->data['footer'] = eval(FOOTER);
		
	}

	function index()
	{
		
	}
	
	function initialize_css()
	{
		
	}

	function initialize_js()
	{
		
	}	
}