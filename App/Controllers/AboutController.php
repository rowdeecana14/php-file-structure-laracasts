<?php

namespace App\Controllers;

class AboutController {
	public function index() {
		$data =  [
			'heading' => 'About Us',
		];
		return view("about", $data);
	}
}