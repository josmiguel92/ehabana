<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dash');
    }

    public function testInit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dash/init');
    }

}
