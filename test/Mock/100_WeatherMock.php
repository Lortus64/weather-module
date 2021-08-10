<?php

namespace Anax\Weather;

/**
 * get info on ip
 */
class WeatherMock extends Weather
{

    /**
     * Get ip location
     *
     * @return array of sides.
     */
    public function weatherForcast($lon, $lat)
    {
        var_dump($lon);

        $data = [];
        if(preg_match("/[a-z]/i", $lon) || preg_match("/[a-z]/i", $lat)) {
            $data["/1"] = <<<EOD
            {
                "cod": 400
            }
            EOD;
        } else {
            $data["/1"] = $lon;

            $data["/2"] = $lat;

            $data["/3"] = <<<EOD
            {
                "temp": 10,
                "väder": sun,
            }
            EOD;

            $data["/4"] = <<<EOD
            {
                "temp": 10,
                "väder": sun,
            }
            EOD;

            $data["/5"] = <<<EOD
            {
                "temp": 10,
                "väder": sun,
            }
            EOD;
        }

        return $data;
    }
}
