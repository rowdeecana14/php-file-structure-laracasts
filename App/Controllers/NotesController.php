<?php

namespace App\Controllers;

use Core\Database;
use Core\Validator;

class NotesController {
	public function index() {
		$config = require base_path('config.php');
		$db = new Database($config['database']);
		$notes = $db->query('select * from notes where user_id = 1')->get();

		$data =  [
			'heading' => 'Home',
			'notes' =>  $notes
		];

		return view("notes/index", $data);
	}

	public function show($id) {

		$config = require base_path('config.php');
		$db = new Database($config['database']);
		$note = $db->query('select * from notes where id = :id', [
			'id' => $id
		])->findOrFail();

		$data = [
			'heading' => 'Note',
			'note' => $note
		];
	
		return view("notes/show", $data);
	}

	public function create() {
		$data = [
			'heading' => 'Create Note',
		];

		return view("notes/create", $data);
	}

	public function store() {
		$config = require base_path('config.php');
		$db = new Database($config['database']);
		$errors = [];

		if (! Validator::string($_POST['body'], 1, 1000)) {
			$errors['body'] = 'A body of no more than 1,000 characters is required.';
		}
	
		if (!empty($errors)) {
			$data = [
				'heading' => 'Create Note',
				'errors' => $errors
			];
	
			return view("notes/create", $data);
		}

		$db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
			'body' => $_POST['body'],
			'user_id' => 1
		]);

		return redirect('/notes');
	}

	public function edit($id) {

		$config = require base_path('config.php');
		$db = new Database($config['database']);
		$note = $db->query('select * from notes where id = :id', [
			'id' => $id
		])->findOrFail();

		$data = [
			'heading' => 'Edit Note',
			'note' => $note
		];
	
		return view("notes/edit", $data);
	}

	public function update($id) {
		$config = require base_path('config.php');
		$db = new Database($config['database']);
		$errors = [];

		if (! Validator::string($_POST['body'], 1, 1000)) {
			$errors['body'] = 'A body of no more than 1,000 characters is required.';
		}
	
		if (!empty($errors)) {
			$note = $db->query('select * from notes where id = :id', [
				'id' => (int) $id
			])->findOrFail();

			$data = [
				'heading' => 'Edit Note',
				'errors' => $errors,
				'note' => $note
			];
	
			return view("notes/edit", $data);
		}

		$db->query('UPDATE notes SET body=:body where id=:id', [
			'body' => $_POST['body'],
			'id' =>  (int) $id
		]);

		return redirect('/notes');
	}

	public function delete($id) {
		$config = require base_path('config.php');
		$db = new Database($config['database']);

		$db->query('DELETE FROM notes where id = :id', [
			'id' => $id
		]);

		return redirect('/notes');
	}
}