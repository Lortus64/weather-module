<?php

return [

    "services" => [
        "weathercnfg" => [
            "shared" => true,
            "active" => false,
            "callback" => function () {
                $Weather = new \Anax\Weather\Weather();

                $cnfg = $this->get("configuration");
                $config = $cnfg->load("apikey.php");
                $settings = $config["config"] ?? null;

                if ($settings["openweathermap"] ?? null) {
                    $Weather->setApi($settings["openweathermap"]["url"], $settings["openweathermap"]["key"]);
                }
                return $Weather;
            }
        ],
    ],
];
