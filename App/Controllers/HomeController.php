<?php

namespace App\Controllers;
use Core\Status;

class HomeController {
	
	public static function index() {
		$data =  [
			'heading' => 'Home',
		];

		// return response()->json(Status::OK, $data);
		return response()->view('index', $data);
	}
}