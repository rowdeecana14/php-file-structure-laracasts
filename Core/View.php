<?php

namespace Core;

class View {
	private $data;

	public function assign($key, $value) {
		self::$data[$key] = $value;
	}

	public function render($current, $data) {
		$current =  base_path('views/' . $current.'.view.php');

		if(file_exists($current)) {
			$default = $this->default();
			$current = file_get_contents($current);
			$page = str_replace("@yield('content')", $current , $default);

			preg_match_all("/\@yield\('[a-zA-Z0-9]+'\)/", $default, $yields);

			extract($data);
			eval('?>'.$page.'<?php');
		}
		else {
			echo '<strong>Template error: Path '.$current.' not found';
		}
	}

	public function default($page = 'app') {
		$page =  base_path('views/' . $page.'.view.php');

		if(file_exists($page)) {
			$content = file_get_contents($page);
			return $content;
		}
		else {
			echo '<strong>Template error: Path '.$page.' not found';
		}
	}
}