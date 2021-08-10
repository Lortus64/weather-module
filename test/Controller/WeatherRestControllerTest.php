<?php

namespace Anax\Controller;

//use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
//use GuzzleHttp\Client;

use Anax\Response\ResponseUtility;
use Anax\DI\DIMagic;

/**
 * Test the SampleJsonController.
 */
class WeatherRestControllerTest extends TestCase
{
        /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;
        global $controller;

        // Setup di
        //$this->di = new DIFactoryConfig();
        $this->di = new DIMagic();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherRestControllerMock();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();


        

    }


    /**
     * Test the route "index".
     */
    public function testIndexActionPost()
    {
        //test ip
        $this->di->request->setBody("{'ip':'8.8.8.8'}");

        $res = $this->controller->indexActionPost();

        $this->assertIsArray($res);
        var_dump($res);
        $res = count($res[0]);


        $this->assertEquals($res, "5");


        //test cord
        $this->di->request->setBody("{\"lon\": \"56.1616\", \"lat\": \"15.5866\"}");

        $res = $this->controller->indexActionPost();

        $this->assertIsArray($res);
        var_dump($res);
        $res = count($res[0]);

        $this->assertEquals($res, "5");

        //test error
        $this->di->request->setBody("{\"ip\": \"asdasd\", \"lon\": \"asda\", \"lat\": \"asdasd\"}");

        $res = $this->controller->indexActionPost();
        $res = $res;

        var_dump($res[0]);

        $this->assertEquals($res, "400");
    }
}
