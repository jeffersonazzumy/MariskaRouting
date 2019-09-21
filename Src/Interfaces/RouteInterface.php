<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 17/09/2019
 * Time: 20:37
 */

namespace Mariska\Router\Interfaces;
use Mariska\Router\Exceptions\DuplicateException;
use Mariska\Router\Exceptions\NotFoundException;

interface RouteInterface
{

    public function getRoutes();

    /**
     * @param string $method
     * @param string $base_route
     * @param bool $keys
     * @return mixed
     * @throws NotFoundException
     */
    public function getRoute(string $method, string $base_route, bool $keys);

    /**
     * @param string $pattern
     * @param  callable $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function get(string $pattern, $action);

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function post(string $pattern, $action);

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function put(string $pattern, $action);

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function delete(string $pattern, $action);

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function path(string $pattern, $action);

    /**
     * @param string $pattern
     * @param $action
     * @return mixed|void
     * @throws DuplicateException
     */
    public function options(string $pattern, $action);
}