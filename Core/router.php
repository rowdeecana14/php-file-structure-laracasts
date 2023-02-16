<?php

namespace Core;

class Router
{
    protected array $routes = [];
    protected string $uri = "";
    protected string $method = "";

    public function __construct()
    {
		$config = require base_path('config.php');
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->uri = $this->getUri(str_replace($config['BASE_FOLDER'], "", $uri));
        $this->method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    }
    
    public function add($method, $uri, $controller, $function)
    {
        $this->routes[] = [
            'uri' => $this->getUri($uri),
            'controller' => $controller,
            'function' => $function, 
            'method' => $method
        ];
    }

    public function getUri($uri) {
        if(strlen($uri) > 0) {
            return $uri[0] == '/' ?  substr($uri, 1)  : $uri;
        }

        return $uri;
    }

    public function get($uri, $controller, $function='index')
    {
        $this->add('GET', $uri, $controller, $function);
    }

    public function post($uri, $controller, $function)
    {
        $this->add('POST', $uri, $controller, $function);
    }

    public function delete($uri,  $controller, $function)
    {
        $this->add('DELETE', $uri, $controller, $function);
    }

    public function put($uri, $controller, $function)
    {
        $this->add('PUT', $uri, $controller, $function);
    }

    public function patch($uri, $controller, $function)
    {
        $this->add('PATCH', $uri, $controller, $function);
    }

    public function dispatch()
    {
        $match = false;
        $params = [];

        foreach ($this->routes as $route) {
            $regex =  $this->regex($route['uri']) ;

            if (preg_match($regex, $this->uri, $matches))  {
                $params = array_intersect_key(
                    $matches,
                    array_flip(array_filter(array_keys($matches), 'is_string'))
                );

                if ($route['method'] === strtoupper($this->method)) {
                    $match = true;

                    break;
                }
            }
        }

        if(!$match) {
            $this->abort();
        }

        if(count($params) == 0) {
            call_user_func(
                array($route['controller'], $route['function'])
            );
        }
        else {
            call_user_func_array(
                array($route['controller'], $route['function']), $params
            );
        }

        return;
    }

    public static function regex($pattern){
	    if (preg_match('/[^-:\/_{}()a-zA-Z\d]/', $pattern))
	        return false; // Invalid pattern

	    // Turn "(/)" into "/?"
	    $pattern = preg_replace('#\(/\)#', '/?', $pattern);

	    // Create capture group for ":parameter"
	    $allowedParamChars = '[a-zA-Z0-9\_\-]+';
	    $pattern = preg_replace(
	        '/:(' . $allowedParamChars . ')/',   # Replace ":parameter"
	        '(?<$1>' . $allowedParamChars . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
	        $pattern
	    );

	    // Create capture group for '{parameter}'
	    $pattern = preg_replace(
	        '/{('. $allowedParamChars .')}/',    # Replace "{parameter}"
	        '(?<$1>' . $allowedParamChars . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
	        $pattern
	    );

	    // Add start and end matching
	    $patternAsRegex = "@^" . $pattern . "$@D";

	    return $patternAsRegex;
	}

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }
}
