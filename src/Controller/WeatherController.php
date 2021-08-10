<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Weather\Weather;

//use Anax\Route\Exception\NotFoundException;

/**
 * A controller to ease with development and debugging information.
 */
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * Render view ip_validator.
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $page->add(
            "../view/weather/index",
            [
                "result" => "",
                "info" => "",
            ]
        );

        return $page->render([
            "title" => "Weather"
        ]);
    }


    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function indexActionPost() : object
    {
        // Deal with the action and return a response.
        $info = "";
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

        if (isset($result[0]["cod"])) {
            $result = "";
            $info = "Något är fel med inmatad data.";
        }

        $page = $this->di->get("page");
        $page->add(
            "../view/weather/index",
            [
                "result" => $result,
                "info" => $info
            ]
        );

        return $page->render([
            "title" => "Weather"
        ]);
    }
}
