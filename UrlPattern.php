<?php

require_once 'Controller.php';

class UrlPattern extends Controller {
	
	private $file = 'url.data';
	private $list = array();
	public $view = 'view-url.php';
	public $data = array();
	
	public function main($GET,$POST) {
		$this->load();
		if( isset($_SESSION['msg']) ) {
			$this->data['msg'] = $_SESSION['msg'];
			$_SESSION['msg'] = false;
		} else {
			$this->data['msg'] = false;
		}
	}

	public function post_submit($GET,$POST) {
		$template = $POST['template'];
		$pattern = $POST['pattern'];
		$length = isset($POST['length']) ? $POST['length'] : 3;
		$this->data['list'] = $this->buildUrlList($template, $pattern, $length);
		switch( $POST['render'] ) {
			case 'img':
				$this->data['RENDER_VIEW'] = 'view-url-render-img.php';
				break;
			case 'links':
			default:
				$this->data['RENDER_VIEW'] = 'view-url-render-links.php';
				break;
		}
		return $this->main(array(),array());
	}

	private function buildUrlList($template, $pattern, $length) {
		$length = (int) $length;
		$indexes = $this->buildIndexes($pattern);
		if( strpos($template,'@@') !== false ) {
			$split = explode('@@', $template);
		} else {
			$last = end($indexes);
			reset($indexes);
			$split = explode($last, $template);
		}
		$list = array();
		foreach( $indexes as $i ) {
			$index = $i;
			if( is_numeric($i) ) {
				$index = str_pad($i, $length, '0', STR_PAD_LEFT);
			}
			$list[] = sprintf(
				'%s%s%s', 
				$split[0],
				$index,
				$split[1]
			);
		}
		return $list;
	}

	private function buildIndexes($pattern) {
		$range = array();
		$split = explode(',', $pattern);
		foreach( $split as $part ) {
			// a range
			if( strpos($part, '-') !== false ) {
				$break = explode('-', $part);
				for( $i=$break[0]; $i <= $break[1]; $i++ ) {
					$range[] = $i;
				}
			} else {
				// push what we got
				$range[] = $part;
			}
		}
		return $range;
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
}

Controller::run( new UrlPattern() );
