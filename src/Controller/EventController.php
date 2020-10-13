<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * @package App\Controller
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/create", name="create_event")
     */
    public function createEvent()
    {
        //TODO Ecrire la fonction
        return $this->render('event/createevent.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
     * @Route("/{id}", name="event")
     */
    public function event() //TODO Injecter l'ID
    {
        //TODO Ecrire la fonction
        return $this->render('event/event.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
     * @Route("/update/{id}", name="update_event")
     */
    public function updateEvent() //TODO Injecter l'ID
    {
        //TODO Ecrire la fonction
        return $this->render('event/upevent.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_event")
     */
    public function deleteEvent() //TODO Injecter l'ID
    {
        //TODO Ecrire la fonction
        return $this->render('event/delevent.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
}
