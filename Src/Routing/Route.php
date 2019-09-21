<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 17/09/2019
 * Time: 20:26
 */
declare(strict_types=1);

namespace Mariska\Router\Routing;
use Mariska\Router\Exceptions\DuplicateException;
use Mariska\Router\Exceptions\NotFoundException;
use Mariska\Router\Interfaces\RouteInterface;

final class Route extends Router implements RouteInterface
{

    private $dispatch;

    public function __construct(?Uri $uri)
    {

        $this->dispatch = new Dispatch($uri, $this);
        parent::__construct();

    }

    public function init(string $controller, string $name_space)
    {
        try{
            $this->start($controller, $name_space);
        } catch (DuplicateException $exception) {
            echo "Exception:". $exception->getMessage()."<br>";
            echo "Line:". $exception->getLine()."<br>";
            echo "File:".$exception->getFile()."<br>";
            die();
        }

    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function rum()
    {
        var_dump($this->dispatch->dispatch());
    }
    /**
     * @param string $pattern
     * @param  callable $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function get(string $pattern, $action)
    {
        $this->add_route('GET', $pattern, $action);
    }

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function post(string $pattern, $action)
    {
        $this->add_route('POST', $pattern, $action);
    }

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function put(string $pattern, $action)
    {
        $this->add_route('PUT', $pattern, $action);
    }

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function delete(string $pattern, $action)
    {
        $this->add_route('DELETE', $pattern, $action);
    }

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function path(string $pattern, $action)
    {
        $this->add_route('PATH', $pattern, $action);
    }

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function options(string $pattern, $action)
    {
        $this->add_route('OPTIONS', $pattern, $action);
    }

    /**
     * @param string $method
     * @param string $base_route
     * @param bool $keys
     * @return mixed
     * @throws NotFoundException
     */
    public function getRoute(string $method, string $base_route, bool $keys)
    {

        if (!key_exists($base_route, $this->routes['route'][$method])){
            throw new NotFoundException();
        }

        $routes = $this->routes['route'][$method][$base_route];
        if ($keys == false){
            return $routes;
        }

        return array_keys($routes);
    }

}