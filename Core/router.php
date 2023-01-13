<?php

namespace Core;

class Router
{
    protected $routes = [];

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

    public function route($uri, $method)
    {
        $match = false;
        $params = [];
        $uri = $this->getUri($uri);

        foreach ($this->routes as $route) {
            $regex =  $this->regex($route['uri']) ;

            if (preg_match($regex, $uri, $matches))  {
                $params = array_intersect_key(
                    $matches,
                    array_flip(array_filter(array_keys($matches), 'is_string'))
                );

                // echo $route['method']. " = route['method'] "."<br>";
                // echo $method. ' = method'."<br>";

                if ($route['method'] === strtoupper($method)) {
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
