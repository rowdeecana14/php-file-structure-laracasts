<?php

namespace App\Controllers;

class HomeController {
	public function index() {
		$data =  [
			'heading' => 'Home',
		];
		return view("index", $data);
	}
}