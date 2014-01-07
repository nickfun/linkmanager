<?php

require_once 'Controller.php';

class LinkSaver extends Controller {
	
	private $file = 'save.data';
	private $list = array();
	public $view = 'view-list.php';
	
	public function main($GET,$POST) {
		$this->load();

		$this->data = array(
			'title' => 'i am the title',
			'list' => $this->list
		);
		if( isset($_SESSION['msg']) ) {
			$this->data['msg'] = $_SESSION['msg'];
			$_SESSION['msg'] = false;
		} else {
			$this->data['msg'] = false;
		}
	}

	public function post_save($GET,$POST) {
		if( !isset($POST['url']) || empty($POST['url']) ) {
			$_SESSION['msg'] = 'Must provide a URL';
			return $this->main(array(),array());
		}
		$this->load();
		$this->list[] = $POST['url'];
		$this->save();
		$_SESSION['msg'] = 'URL was saved!';
		//$this->location('/framework/index.php?a=main');
		$this->redirect('LinkSaver','main');
	}

	public function ajax_save($GET,$POST) {
		if( !isset($GET['url']) ) {
			$this->debug();
			die('must provide url');
		}
		$this->load();
		$this->list[] = $GET['url'];
		$this->save();
		$this->json(array('success'=>true));
	}

	public function ajax_delete($GET,$POST) {
		if(!isset($GET['index'])) {
			$this->debug();
			die("must provide index");
		}
		$id = $GET['index'];
		$this->load();
		unset( $this->list[ $id ] );
		$this->save();
		$this->json(array('success'=>true));
	}

	public function post_submit($GET,$POST) {
		$this->debug();
		die();
	}
	
	private function load() {
		$this->list = unserialize(file_get_contents($this->file));
		if( !is_array($this->list) ) {
			$this->list = array();
		}
	}
	
	private function save() {
		file_put_contents($this->file, serialize($this->list));
	}

	public function version() {
		phpinfo();
	}
}

Controller::run( new LinkSaver() );