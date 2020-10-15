<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider() //TODO Tenir à jour
    {
        yield ['/'];
        //yield ['/logout'];
        yield ['/users/1'];
        yield ['/users/update/1'];
        yield ['/event/create'];
        yield ['/event/1'];
        yield ['/event'];
        yield ['/event/update/1'];
        yield ['/event/delete/1'];
        yield ['/admin/villes'];
        yield ['/admin/campus'];
        // ...
    }
}