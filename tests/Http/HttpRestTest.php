<?php

class HttpRestTest extends \PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client(['base_url' => 'http://myframework.conf']);
        $this->client->setDefaultOption('debug', false);
    }

    /**
     * @test method GET API
     */
    public function testApiRest()
    {
        $index = $this->client->get('student');
        $create = $this->client->get('student/create');
        $show = $this->client->get('student/1');
        $edit = $this->client->get('student/1/edit');

        $this->assertEquals('index', $index->getBody());
        $this->assertEquals(200, $index->getStatusCode());

        $this->assertEquals('create', $create->getBody());
        $this->assertEquals(200, $create->getStatusCode());

        $this->assertEquals('show: 1', $show->getBody());
        $this->assertEquals(200, $show->getStatusCode());

        $this->assertEquals('edit: 1', $edit->getBody());
        $this->assertEquals(200, $edit->getStatusCode());

    }

    /**
     * @test store
     */
    public function testStore()
    {
        $store = $this->client->post('student', [
            'body' =>[
                'username' => 'tony'
            ]
        ]);

        $this->assertEquals('store: tony', $store->getBody());
        $this->assertEquals(200, $store->getStatusCode());
    }


    /**
     * @test update
     */
    public function testUpdate()
    {

        $delete = $this->client->post('student/2378675', [
            'body'    => ['_method' => 'PUT']
        ]);

        $this->assertEquals(200, $delete->getStatusCode());
        $this->assertEquals('update: 2378675', $delete->getBody());
    }

    /**
     * @test delete
     */
    public function testDelete()
    {
        $delete = $this->client->post('student/23', [
            'body'    => ['_method' => 'DELETE']
        ]);

        $this->assertEquals(200, $delete->getStatusCode());
        $this->assertEquals('destroy: 23', $delete->getBody());
    }
}