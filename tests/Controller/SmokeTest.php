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
        yield ['/event'];
        yield ['/event/1'];
        yield ['/event/create'];
        yield ['/event/update/1'];
        yield ['/event/annuler/1'];
        yield ['/admin/villes'];
        yield ['/admin/villes/delete/{id}'];
        yield ['/admin/villes/update/{id}'];
        yield ['/admin/campus'];
        yield ['/admin/campus/delete/{id}'];
        yield ['/admin/villes/update/{id}'];
        yield ['/admin/create_User'];
        yield ['/inscription/{id}'];
        yield ['/sedesister/{id}'];
        yield ['/publish/{id}'];
        // ...
    }
}