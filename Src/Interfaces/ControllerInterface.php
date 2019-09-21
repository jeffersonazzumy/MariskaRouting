<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 17/09/2019
 * Time: 21:47
 */
declare(strict_types=1);

namespace Mariska\Router\Interfaces;


interface ControllerInterface
{

    /**
     * @param array $args
     * @return mixed
     */
    public function index(array $args);
}