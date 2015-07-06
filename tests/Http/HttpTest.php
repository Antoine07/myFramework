<?php

class HttpTest extends \PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client(['base_url' => 'http://myframework.conf']);
    }

    public function testIndex()
    {
        $index = $this->client->get('/');
        $this->assertEquals(200, $index->getStatusCode());
    }
}