<?php

namespace App\Controllers;

class ContactController {
	public static function index() {
		$data =  [
			'heading' => 'Contact Us',
		];
		return response()->view("contact", $data);
	}
}