<?php
/**
 * Route for ip test
 */

return [
    "routes" => [
        [
            "info" => "location weather.",
            "mount" => "weather",
            "handler" => "\Anax\Controller\WeatherController",
        ],
        [
            "info" => "location weather REST API.",
            "mount" => "weatherREST",
            "handler" => "\Anax\Controller\WeatherRestController",
        ],
    ],
];
