<?php

namespace App\Controllers;

use Core\Database;
use Core\Status;
use Core\App;

class NotesController {
	
	public static function index() {
		$db = App::resolve(Database::class);
		$notes = $db->query('select * from notes where user_id = 1')->get();

		return response()->json(Status::OK, [
			"message" => "Success",
			"data" => $notes
		]);
	}
}