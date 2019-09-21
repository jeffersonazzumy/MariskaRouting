<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 10/09/2019
 * Time: 22:19
 */
declare(strict_types=1);

namespace Mariska\Router\Routing;


use InvalidArgumentException;
use Mariska\Router\Exceptions\DuplicateException;

/**
 * Class Router
 * @package Mariska\Router\Routing
 */
abstract class Router
{

    /**
     * @var array
     */
    protected $controllers = [
        'controllers' => [],
        'name_space' => []
    ];

    /**
     * @var string
     */
    protected $controller = '';

    /**
     * @var array
     */
    protected $routes = [];

    protected $valid;

    protected $index;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->valid = "/^(\/){1}$|^(\/\w+\-?\w+)+$|^(\/\w+\-?\w+)+(\/:\w+\-?\w+)+$/";

        $this->routes = [
            'route' => [
                'GET' => [],
                'POST' => [],
                'PUT' => [],
                'DELETE' => [],
                'PATH' => [],
                'OPTIONS' => []
            ]
        ];
    }

    /**
     * @param string $controller
     * @param string $name_space
     * @return $this
     * @throws DuplicateException;
     */
    protected function start(string $controller, string $name_space)
    {

        $controller = ucwords(strtolower($controller));
        $key_controller = in_array($controller, $this->controllers['controllers']);
        $key_name_space = in_array($name_space, $this->controllers['name_space']);

        if ($key_controller && $key_name_space) {
            throw new DuplicateException('controller duplicate');
        }

        $this->controllers['controllers'][] = $controller;
        $name_space = str_replace(" ", "\\",  ucwords(strtolower(str_replace("\\"," ",$name_space))));
        $this->controllers['name_space'][] = $name_space;
        $this->controller = "$name_space\\$controller";
        return $this;
    }

    /**
     * @param $method
     * @param $pattern
     * @param callable | string $action
     * @throws InvalidArgumentException
     * @throws DuplicateException
     */
    protected function add_route($method, $pattern, $action = null)
    {

        if (!is_callable($action) && !is_string($action) && !is_null($action)){
            throw new InvalidArgumentException("invalid action, string callable or null");
        }

        if (!preg_match($this->valid, $pattern)) {
            throw new InvalidArgumentException('invalid pattern format! ');
        }

        $search_routes_count = null;
        $search_count = null;
        $this->index = explode("/", ltrim($pattern,"/"));
        $static_pattern = str_replace(strpbrk($pattern, ":"), "", $pattern);
        $search = strpbrk($pattern, ":");

        if ($pattern !== "/"){
            $pattern = ltrim($pattern, "/");
        }

        if (key_exists( $this->index[0], $this->routes['route'][$method])) {
            for ($i = 0; count($this->routes['route'][$method][$this->index[0]]) > $i; $i++) {
                $key_pattern = key_exists($pattern,$this->routes['route'][$method][ $this->index[0]]);

                if ($key_pattern) {
                    throw new DuplicateException('route duplicate');
                }
            }
        }

        if ($static_pattern !== "/"){
            $static_pattern = rtrim($static_pattern,"/");
        }

        $this->routes['route'][$method][ $this->index[0]][$pattern] = [
            'pattern' => $static_pattern,
            'search' => $search,
            'controller' => $this->controller,
            'action' => $action
        ];
    }

}