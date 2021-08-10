<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Weather\Weather;

//use Anax\Route\Exception\NotFoundException;

/**
 * A controller to ease with development and debugging information.
 */
class WeatherRestController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function indexActionPost() : array
    {
        // Deal with the action and return a response.
        try {
            $ip = $this->di->request->getPost("ip");
            $lon = $this->di->request->getPost("lon");
            $lat = $this->di->request->getPost("lat");
        } catch (\Exeption $e) {
            $info = "Body is missing!";
        }

        $ipinfo = $this->di->get("ipcnfg");
        $weatherinfo = $this->di->get("weathercnfg");


        $result = $ipinfo -> valid($ip);

        if ($result["ip4"] == "Valid") {
            $location = $ipinfo -> location($ip);
            $lon = $location["longitude"];
            $lat = $location["latitude"];
        }

        $result = $weatherinfo -> weatherForcast($lon, $lat);

        return [$result];
    }
}