<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Form\EventType;
use App\Form\LieuType;
use App\Repository\CampusRepository;
use App\Repository\SortiesRepository;
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
    public function home(CampusRepository $campusRepository)
    {
        $campus = $campusRepository->findAll();
        //TODO Ecrire la fonction

        return $this->render('event/home.html.twig', ['controller_name' => 'EventController',
            'campus' => $campus
        ]);
    }

    /**
     * @Route("/create", name="create_event")
     */
    public function createEvent(Request $request, EntityManagerInterface $em)
    {
        //créer une entité vide
        $newEvent = new Sorties();

        //créer des formulaire
       // $lieuForm = $this->createForm(LieuType::class,$newLieu);
        $eventForm = $this->createForm(EventType::class, $newEvent);

       // $lieuForm->handleRequest($request);
        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){

            /*
             * btn enregistrer
             * set event's state as created
             * redirect to 'home'
             * stock the event into a bdd
             * */
            if ($eventForm->getClickedButton() === $eventForm->get('enregistrer')){
                //set created state
                $newEvent->setEtat($this->getDoctrine()->getRepository(Etats::class)->find(1));
                $newEvent->setOrganisateur($this->getUser());

                $em->persist($newEvent);
                $em->flush();
                $this->addFlash('success', 'La sortie est bien créée!');

                return $this->redirectToRoute('home');
            }

            /*  btn publier
             * set event's state as open
             * redirect to 'home'
             * stock the event into a bdd
             * */
            if ($eventForm->getClickedButton() === $eventForm->get('publier')){
                //set created state
                $newEvent->setEtat($this->getDoctrine()->getRepository(Etats::class)->find(2));
                $newEvent->setOrganisateur($this->getUser());

                $em->persist($newEvent);
                $em->flush();
                $this->addFlash('success', 'La sortie est bien publiéée!');

                return $this->redirectToRoute('home');
            }

            /*
             * btn annuler
             * redirect to 'home'
             * */
            if ($eventForm->getClickedButton() === $eventForm->get('annuler')){

                $this->addFlash('alert ', 'La sortie est annulée!');
                return $this->redirectToRoute('home');
            }
        }
        return $this->render('event/createEvent.html.twig', [
            'eventForm' => $eventForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event")
     */
    public function event(int $id, SortiesRepository $sortiesRepository)
    {
        $sortie = $sortiesRepository->find($id);
        return $this->render('event/event.html.twig', [
            'controller_name' => 'EventController',
            'sortie' => $sortie
        ]);
    }

    /**
     * @Route("/update/{id}", name="update_event")
     */
    public function updateEvent(int $id, SortiesRepository $sortiesRepository)
    {
        $sortie = $sortiesRepository->find($id);
        return $this->render('event/upevent.html.twig', [
            'controller_name' => 'EventController',
            'sortie' => $sortie
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_event")
     */
    public function deleteEvent(int $id, SortiesRepository $sortiesRepository)
    {
        $sortie = $sortiesRepository->find($id);
        return $this->render('event/delevent.html.twig', [
            'controller_name' => 'EventController',
            'sortie' => $sortie
        ]);
    }
}
