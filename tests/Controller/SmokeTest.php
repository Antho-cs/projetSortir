<?php

namespace App\Tests\Controller;

use App\Entity\Participants;
use App\Repository\ParticipantsRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = static::createClient();

        //Récupération d'un utilisateur
        $participantsRepository = static::$container->get(ParticipantsRepository::class);
        $testUser = $participantsRepository->findOneBy(['Pseudo'=>'test']); // où test est l'administrateur
        //Connexion de l'utilisateur
        $client->loginUser($testUser);

        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider() //TODO Tenir à jour
    {
        yield ['/'];
//        yield ['/logout'];
        yield ['/users/2'];
        yield ['/users/update/2'];
        yield ['/event/'];
        yield ['/event/3'];
        yield ['/event/create'];
        yield ['/event/update/3'];
        yield ['/event/annuler/3'];
        yield ['/admin/villes'];
        yield ['/admin/villes/delete/1'];
        yield ['/admin/villes/update/1'];
        yield ['/admin/campus'];
        yield ['/admin/campus/delete/1'];
        yield ['/admin/villes/update/1'];
        yield ['/admin/create_User'];
        //yield ['/inscription/3']; //Note Réponse 302
        //yield ['/sedesister/3']; //Note Réponse 302
        //yield ['/publish/3']; //Note Réponse 302
    }
}