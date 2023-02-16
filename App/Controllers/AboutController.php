<?php

namespace App\Controllers;

class AboutController {
	public static function index() {
		$data =  [
			'heading' => 'About Us',
		];
		return response()->view("about", $data);
	}
}