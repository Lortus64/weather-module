<?php

namespace Anax\Ip;

/**
 * get info on ip
 */
class Ip
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


    public function getClientIp()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }


    /**
     * Get valid ip
     *
     * @return array of sides.
     */
    public function valid($ip)
    {
                // Deal with the action and return a response.

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $ip4 = "Valid";
        } else {
            $ip4 = "Not valid";
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ip6 = "Valid";
        } else {
            $ip6 = "Not valid";
        }

        if ($ip4 == "Valid" || $ip6 == "Valid") {
            $hostname = gethostbyaddr($ip);
        } else {
            $hostname = "No host";
        }


        $result = [
            "ip" => $ip,
            "ip4" => $ip4,
            "ip6" => $ip6,
            "hostname" => $hostname,
        ];

        return $result;
    }

    /**
     * Get ip location
     *
     * @return array of sides.
     */
    public function location($ip)
    {
        $ch = curl_init();

        $url = $this->url . $ip . "?access_key=" . $this->key;

        curl_setopt(
            $ch,
            CURLOPT_URL,
            $url
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        $result = json_decode(
            $result,
            true
        );
        //$result = $this->url . $ip . "?access_key=" . $this->key;

        return $result;
    }
}
