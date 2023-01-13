<?php

use App\Controllers\HomeController;
use App\Controllers\AboutController;
use App\Controllers\ContactController;
use App\Controllers\NotesController;

$router->get('/', HomeController::class);
$router->get('/about', AboutController::class);
$router->get('/contact', ContactController::class);
$router->get('/notes', NotesController::class, 'index');
$router->get('/note/:id', NotesController::class, 'show');
$router->get('/note/edit/:id', NotesController::class, 'edit');
$router->put('/note/edit/:id', NotesController::class, 'update');
$router->get('/notes/create', NotesController::class, 'create');
$router->post('/notes/create', NotesController::class, 'store');
$router->delete('/note/:id', NotesController::class, 'delete');
