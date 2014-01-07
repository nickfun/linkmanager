<?php

session_start();

abstract class Controller {
	
	public $data = array();
	public $view;
	public $PATH = '/framework/';
	
	abstract public function main($GET, $POST);
	
	public static function run( \Controller $c ) {
		
		$action = 'main';
		
		if( isset( $_GET['a']) && method_exists($c,$_GET['a']) ) {
			$action = $_GET['a'];
		}
		
		$c->$action( $_GET, $_POST );
		
		if( isset($c->view) && isset($c->data) ) {
			extract($c->data, EXTR_OVERWRITE);
			include $c->view;
		}
	}

	public function location($url) {
		header('location: ' . $url);
		die();
	}

	public function json($data) {
		header('content-type: application/json');
		echo json_encode($data);
		die();
	}

	public function debug() {
		echo '<pre>';
		var_dump($_GET,$_POST);
		echo '</pre>';
	}

	public function redirect($controller, $action) {
		$url = sprintf("%s%s.php?a=%s", $this->PATH, $controller, $action);
		$this->location($url);
	}
		
}

