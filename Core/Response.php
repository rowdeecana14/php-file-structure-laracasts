<?php

namespace Core;
use Core\View;

class Response {
    const OK = 200;
    const NOT_FOUND = 404;
    const FORBIDDEN = 403;

    public function json($status = 200, $data = []) 
    {
        header('Content-type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }

    public function view($path = "index", $data = [])
    {
        $view = new View;
        $view->render($path, $data);
    }
}