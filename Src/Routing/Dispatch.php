<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 15/09/2019
 * Time: 16:22
 */
declare(strict_types=1);

namespace Mariska\Router\Routing;


use Mariska\Router\Exceptions\NotFoundException;
use Mariska\Router\Interfaces\RouteInterface;

class Dispatch
{

    protected $path;

    protected $base_path;

    protected $method;

    protected $routes;

    public function __construct(?Uri $uri, RouteInterface $route)
    {
        $url = parse_url(filter_var( $_SERVER['REQUEST_URI'],FILTER_SANITIZE_URL));
        $method = filter_var( $_SERVER['REQUEST_METHOD'],FILTER_SANITIZE_URL);
        $this->path = empty($uri)? ltrim($url['path'],"/"): $uri;
        $this->base_path = explode("/", ltrim($this->path,"/"))[0];
        $this->method = $method;
        $this->routes = $route;
    }


    public function dispatch()
    {
        try{
            return self::route();
        }catch (NotFoundException $notFoundException){
            echo $notFoundException->getMessage();
            die();
        }
    }

    /**
     * @return mixed
     * @throws NotFoundException
     */
    public function route()
    {

        $route = null;
        $path = explode("/",$this->path);
        $result = null;
        $array_keys = null;
        $dynamic = null;

        try{
            $routes = $this->routes->getRoute($this->method,$this->base_path,false);
            $keys = $this->routes->getRoute($this->method,$this->base_path,true);
        }catch (NotFoundException $notFoundException){
            echo $notFoundException->getMessage();
            die();
        }

        for ($i = 0; count($keys) > $i; $i++){
            $key = explode("/", ltrim($keys[$i],"/"));
            if(count($key) == count($path)){
                for ($p = 0; count($path) > $p; $p++){
                   if ($key[$p] == $path[$p]){
                       $result[] = $path[$p];
                   }else{
                       break;
                   }
                }
                $array_keys[] = $key;
            }
        }

       if (!empty($result)){
        $unique = array_values(array_unique($result));
        $operation = count($path) - count($unique);

        for ($i = 0; count($array_keys) > $i; $i++) {
            for ($a = 0; count($unique)> $a; $a++){
                if (in_array($unique[$a], $array_keys[$i])){
                    unset($array_keys[$i][$a]) ;
                }else{
                    break;
                }
            }
        }

        foreach ($array_keys as $v){
            if (count($v) == $operation && substr_count(implode(" ", $v),":") == $operation){
                $dynamic = $v;
            }
        }
           $route = $unique;
       }
       if (!empty($dynamic)){
           $route = array_merge($route,$dynamic);
       }

       if ($route !== null && count($route) !== count($path)){
           throw new NotFoundException();
       }

        $route = !empty($route)? implode("/",$route): $route;
        $route = $route === ""? "/" : $route ;
        if (!key_exists($route,$routes)){
            throw new NotFoundException();
        }

        return $routes[$route];
    }

}