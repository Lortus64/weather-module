<?php

namespace Anax\Controller;

use Anax\Weather\WeatherMock;

//use Anax\Route\Exception\NotFoundException;

/**
 * A controller to ease with development and debugging information.
 */
class WeatherRestControllerMock extends WeatherRestController
{

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
        $weatherinfo = new WeatherMock();


        $result = $ipinfo -> valid($ip);

        if ($result["ip4"] == "Valid") {
            $location = $ipinfo -> location($ip);
            $lon = $location["longitude"];
            $lat = $location["latitude"];
        }
        var_dump($lon);
        $result = $weatherinfo -> weatherForcast($lon, $lat);

        return [$result];
    }
}
