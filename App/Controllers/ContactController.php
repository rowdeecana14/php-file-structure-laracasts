<?php

namespace App\Controllers;

class ContactController {
	public function index() {
		$data =  [
			'heading' => 'Contact Us',
		];
		return view("contact", $data);
	}
}