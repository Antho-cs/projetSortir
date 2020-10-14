<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Form\EventType;
use App\Form\LieuType;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/", name="home")
     */
    public function home()
    {
        //TODO Ecrire la fonction
        return $this->render('event/home.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
     * @Route("/create", name="create_event")
     */
    public function createEvent(Request $request, EntityManagerInterface $em)
    {
        //créer une entité vide
        $newLieu = new Lieux();
        $newEvent = new Sorties();

        //créer des formulaire
       // $lieuForm = $this->createForm(LieuType::class,$newLieu);
        $eventForm = $this->createForm(EventType::class, $newEvent);

       // $lieuForm->handleRequest($request);
        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){

            //todo manage the photo upload

            $em->persist($newEvent);
            $em->flush();
            $this->addFlash('success', 'La sortie est bien créée!');

            return $this->render('event/createEvent.html.twig');

        }
        return $this->render('event/createEvent.html.twig', [
            'eventForm' => $eventForm->createView(),
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
