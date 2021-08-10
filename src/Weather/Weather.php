<?php

namespace Anax\Weather;

/**
 * get info on ip
 */
class Weather
{

    private $url = "";
    private $key = "";

        /**
     * Set api key and url
     *
     * @return void of sides.
     */
    public function setApi($url, $key) : void
    {
        $this->url = $url;
        $this->key = $key;
    }


    public function times()
    {
        $date = array();
        for ($i=0; $i < 5; $i++) { 
            $time = (time() - (60 * 60 * 11)) - ($i * (60 * 60 * 24));
            array_push($date, $time);
        }

        return $date;
    }


    /**
     * Get ip location
     *
     * @return array of sides.
     */
    public function weatherForcast($lon, $lat)
    {
        $date = $this->times();
        // array of curl handles
        $multiCurl = array();
        // data to be returned
        $result = array();
        // multi handle
        $mh = curl_multi_init();
        foreach ($date as $i => $dt) {
            // URL from which data will be fetched
            //api.openweathermap.org/data/2.5/onecall/timemachine?lat=35&lon=16&dt=1607990400&appid=6790f780b15f4245d888b22c90cf82d5
            $fetchURL = $this->url . "data/2.5/onecall/timemachine?" . "lat=" . $lat . "&lon=" . $lon . "&dt=" . $dt . "&appid=" . $this->key . "&units=metric";
            $multiCurl[$i] = curl_init();
            curl_setopt($multiCurl[$i], CURLOPT_URL,$fetchURL);
            curl_setopt($multiCurl[$i], CURLOPT_HEADER,0);
            curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER,1);
            curl_multi_add_handle($mh, $multiCurl[$i]);
        }
        $index=null;
        do {
            curl_multi_exec($mh,$index);
        } while($index > 0);
        // get content and remove handles
        foreach($multiCurl as $k => $ch) {
            $result[$k] = json_decode(
                curl_multi_getcontent($ch),
                true
            );
            curl_multi_remove_handle($mh, $ch);
        }
        // close
        curl_multi_close($mh);

        return $result;
    }
}
