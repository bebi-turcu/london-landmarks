<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('London Landmarks', $crawler->filter('header h1')->text());

        // Go to the "list" view
        $crawler = $client->click($crawler->selectLink('See all landmarks in the database')->link());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Id', $crawler->filter('table th')->text());

        // Go to the "show" view; relies on data in a "symfony_test" db
        $crawler = $client->click($crawler->selectLink('show')->link());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('test+name', $crawler->filter('table td')->eq(1)->text());

        // Search the DB
        $client->request('POST', '/landmark/search', array('name' => '**wrong-name**'));
        $this->assertEmpty($client->getResponse()->getContent());
        $client->request('POST', '/landmark/search', array('name' => 'TeSt nAmE'));
        $this->assertContains('*sample_place_id*', $client->getResponse()->getContent());

        // Search by Google API, empty request only
        $client->request('POST', '/landmark/searchnew', array('name' => ''));
        $this->assertEmpty($client->getResponse()->getContent());
    }
}
