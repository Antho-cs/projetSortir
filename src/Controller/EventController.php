<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function createEvent(Request $request)
    {
        $newEvent = new Sorties();

        //créer une intité
        $newEvent->setDateDebut(new \DateTime());
        $newEvent->setDateCloture();
        $newEvent->setDuree();
        $newEvent->setDescriptionsInfos();
        $newEvent->setEtat();
        $newEvent->setNbInscriptionsmax();
        $newEvent->setNom();
        $newEvent->setUrlPhoto();
        $newEvent->setEtatSortie();
        $newEvent->setDateCloture();



        $eventForm = $this->createForm(EventType::class, $newEvent);
        $eventForm->handleRequest($request);
        return $this->render('event/createEvent.html.twig', [
            'sortie' => $eventForm->createView()
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
